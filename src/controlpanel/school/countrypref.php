<?php
$title = "MITMUNC - Control Panel - Country Selection";
require("/var/www/mitmunc/template/header.php"); ?>
<script type="text/javascript">
function editCountries(){
    $("#countriesView").hide();
    $("#countriesEdit").show();
}
function setCountries(){
    // Function to make the form
    var countries = {};
    for(var i=1; i <= $("#numCountries").val(); i++){
        countries[i] = $("#country"+i).val();
    }
    countries = JSON.stringify(countries);
    $.post(
        "/include/ajax/countryPref",
        {
            schoolId:$("#schoolId").val(),
            countries:countries
        },
        function(data){
            if(data==''){
                location.reload();
            }else{
                alert(data);
            }
        }
    );
}
</script>

<h1>Country Selection</h1>

<?php
$notYetReady = FALSE;
if ($notYetReady){
echo "<p>We will be accepting country/committee preferences after our Early Registration closes! You will receive an e-mail as soon as this page becomes available. Thank you!</p>";

echo "<p><a href=\"/controlpanel/\">Back To Control Panel</a></p>";
require("/var/www/mitmunc/template/footer.php");
die();


}
?>

<p>This page will allow you to apply for countries or view your country assignments.  
Please note that the Secretariat can only confirm your country assignment after you make your school's conference fee payment.  </p>

<p>Information detailing which countries send delegates to which committees will be posted shortly.  As this information may affect your country preferences, you are advised to wait to see this information before submitting your preferences.</p>


<p>
The country-committee matrix can be found <a href="/ccmatrix">here</a>.  Each cell denotes whether there is a delegate for a country (row) in the committee (column).  
Blank cells mean no delegate from the country is on the committee.  
</p>

<p>
The triumvirate committees have their own application process that is not part of the country selection process.  
More information about the 
triumvirate committees can be found on its <a href="/committee/TRIUMVIRATE">committee page</a>.
</p>

<br /><br />
<?php
$SESSION->securityCheck(true, array('secretariat', 'school'));

function makeCountries($countryNum, $selectedCountryId){
    global $SESSION;
    if ($SESSION->loginType=='secretariat') {
        $countryList = country::getAllCountries();
    }
    else {
        $countryList = country::getAllCountries(country::UNASSIGNED_ONLY);
    }
    return country::getCountryOptions(
        $optionsArray = array("id" => "country" . $countryNum), // "name" => "country" . $countryNum),
        $defaultCountryId = $selectedCountryId,
        $countries = $countryList);
}

$school = new school($SESSION->schoolId);
echo '<input type="hidden" id="schoolId" value="'.$school->schoolId.'" />';
echo '<input type="hidden" id="numCountries" value="'.school::NUM_COUNTRY_PREFS.'" />';
if($school->countryConfirm=='1'){
    echo 'These are your confirmed country assignments for this conference.  <br />';
}else{
    echo 'These are the choices that we currently have from you.  <br />';
}

// Show the countries
echo '<div id="countriesView">';
for($i=1; $i<=school::NUM_COUNTRY_PREFS; $i++){
    echo ordinalNumber($i).' Country: '.$school->countryName[$i].'<br />';
}
echo '<br />';
if($SESSION->loginType=='secretariat' || $school->countryConfirm=='0'){
    echo '<a href="javascript:editCountries()">Edit Country Preferences</a>';
}
echo '</div>';

// Let the countries be edited
echo '<div id="countriesEdit" style="display:none">';
for($i=1; $i<=school::NUM_COUNTRY_PREFS; $i++) {
    echo '<label for="">'.ordinalNumber($i).' Choice:</label>';
    echo makeCountries($i, $school->countryId[$i]) . "<br/>";
}
echo '<br />';
echo '<input type="submit" value="Change Country Preferences" onclick="javascript:setCountries()">';
echo '</div>';

echo '<br />';

?>

<a href="/controlpanel/">Back To Control Panel</a>
<?php require("/var/www/mitmunc/template/footer.php"); ?>
