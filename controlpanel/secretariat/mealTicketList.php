<?php
$title = "MITMUNC - Control Panel - Meal Ticket List";
require("/var/www/mitmunc/template/header.php"); ?>

<h1>Meal Ticket Information</h1>
<p>Below is a list of meal ticket orders from schools</p>
<br />
<?php
//Check user's credentials
$SESSION->securityCheck(true, array('secretariat'));

$mealIds = mealTicket::mealIds();
$mealNumbers = array();
$schoolIds = school::getAllSchoolIds();
$totalPaid = 0;
echo '<table class="padded bordered">';

// Header
echo '<tr><th></th><th>School</th>';
foreach($mealIds as $mealId){
    $mealDescription = mealTicket::mealDescription($mealId);
    echo '<th>'.$mealDescription.'</th>';
    $mealNumbers[$mealId] = 0;
}
echo '<th>Meal Notes</th>';
echo '<th>Paid</th>';
echo '</tr>';

// Staff & Secretariat
echo '<tr>';
echo '<td></td>';
echo '<th>Secretariat & Chair Meals</th>';
$totalUsers = user::totalUsers();
$staffMeals = $totalUsers['secretariat'] + $totalUsers['chair'];
foreach($mealIds as $mealId){
    echo '<th>'.$staffMeals.'</th>';
    $mealNumbers[$mealId] += $staffMeals;
}
echo '<td></td>';
echo '<th></th>';
echo '</tr>';

// Schools
foreach($schoolIds as $schoolId){
    $mealTicket = new mealTicket($schoolId);
    $school = new school($schoolId);
    echo '<tr>';
    echo '<td><a href="/controlpanel/school/mealTicket?schoolId='.$schoolId.'"><img src="/images/edit.png" /></a></td>';
    echo '<td>'.school::getSchoolName($schoolId).'</td>';
    foreach($mealIds as $mealId){
        echo '<td>'.$mealTicket->meal[$mealId].'</td>';
        $mealNumbers[$mealId] += $mealTicket->meal[$mealId];
    }
    echo '<td>'.$mealTicket->mealNotes.'</td>';
    
    if($school->mealTicketOwed<=0){
        echo '<td>Y</td>';
    }else{
        echo '<td>N</td>';
    }
    $totalPaid += $school->mealTicketPaid;
    echo '</tr>';
}

// Total
echo '<tr>';
echo '<td></td>';
echo '<th>Total Meals Ordered</th>';
foreach($mealIds as $mealId){
    echo '<th>'.$mealNumbers[$mealId].'</th>';
}
echo '<td></td>';
echo '<th></th>';
echo '</tr>';

echo '</table>';
echo '<br />';
echo 'Total Meals: '.array_sum($mealNumbers).'<br />';
echo 'Total Paid: $'.$totalPaid.'<br />';
?>
<br />
<br />
<a href="/controlpanel/">Back to Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
