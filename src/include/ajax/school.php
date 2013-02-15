<?php
require("/var/www/mitmunc/template/header_very_basic.php");

$SESSION->securityCheck(true, array('secretariat', 'school'));

$school = new school($SESSION->schoolId);
$school->getUsers();
?>

<div id="regform">
  <table border="0">
    <tr>
      <td colspan="2"><h2>General Information</h2></td>
    </tr>
    <tr>
      <td>School Name:</td><td>
      <input type="text" id="schoolName" size="40" value="<?=$school->schoolName;?>" />
      <span id="schoolNameError"></span>
      </td>
    </tr>
    <tr>
      <td># of Students:</td><td>
      <input type="text" id="numStudents" size="2" value="<?=$school->numStudents;?>" />
      <span id="numStudentsError"></span><span id="tooManyStudentsError"></span>
      </td>
    </tr>
    <tr>
      <td># of Faculty Advisers:</td><td>
      <input type="text" id="numAdvisers" size="2" value="<?=$school->numAdvisers;?>" />
      <span id="numAdvisersError"></span>
      </td>
    </tr>
    <tr>
      <td>Registration Time:</td><td>
        <?=$school->regTime;?>
      </td>
    </tr>
    <tr>
      <td></td><td></td>
    </tr>
    <tr>
      <td colspan="2"><h2>Primary Contact Information</h2></td>
    </tr>
    <tr>
      <td>Name:</td><td>
      <input type="hidden" id="userId" value="<?=$school->users[0]->userId;?>">
      <input type="text" id="contactName" value="<?=$school->users[0]->realName;?>" />
      </td>
    </tr>
    <tr>
      <td>E-mail:</td><td>
      <input type="text" id="email" value="<?=$school->users[0]->email;?>" />
      <span id="emailError"></span>
      </td>
    </tr>
    <tr>
      <td>Address 1:</td><td>
      <input type="text" id="address1" value="<?=$school->address['1'];?>" />
      </td>
    </tr>
    <tr>
      <td>Address 2:</td><td>
      <input type="text" id="address2" value="<?=$school->address['2'];?>" />
      </td>
    </tr>
    <tr>
      <td>City:</td><td>
      <input type="text" id="city" value="<?=$school->address['city'];?>" />
      </td>
    </tr>
    <tr>
      <td>State:</td><td>
      <input type="text" id="state" value="<?=$school->address['state'];?>" />
      </td>
    </tr>
    <tr>
      <td>ZIP/Postal Code:</td><td>
      <input type="text" id="zip" value="<?=$school->address['zip'];?>" />
      </td>
    </tr>
    <tr>
      <td>Country:</td><td>
        <?=country::getCountryOptions($optionsArray=array("id" => "countryId"), $defaultCountryId = $school->address['countryId'])?>
      </td>
    </tr>
    <tr>
      <td>Phone Number:</td><td>
      <input type="text" id="phoneNumber" size="20" value="<?=$school->users[0]->phoneNumber;?>" />
      </td>
    </tr>
    <tr>
      <td></td>
    </tr>
  </table>
  <input type="submit" onclick="javascript:changeRegistrationSubmit(<?=$school->schoolId;?>)" value="Change Registration Information" id="submitButton"/>
</div>

<script type="text/javascript">
function changeRegistrationSubmit(schoolId){
    runErrorChecking(errorChecking);
    if($("#submitButton").attr('disabled')!=null) return;
    $.post(
    "/include/ajax/registration2",
    {
            schoolId: schoolId,
            schoolName: $("#schoolName").val(),
            numStudents: $("#numStudents").val(),
            numAdvisers: $("#numAdvisers").val(),
            contactName: $("#contactName").val(),
            email: $("#email").val(),
            address1: $("#address1").val(),
            address2: $("#address2").val(),
            city: $("#city").val(),
            state: $("#state").val(),
            zip: $("#zip").val(),
            countryId: $("#countryId").val(),
            userId: $("#userId").val(),
            phoneNumber: $("#phoneNumber").val(),
    },
    function(txt){
            if(txt != "") {
              text = txt;
            } else {
              text = '<b>Your registration has been updated.';
            }
            $("#regform").html(text);
    }
  )
}
</script>
