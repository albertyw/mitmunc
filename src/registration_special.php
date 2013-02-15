<?php
$title = "MITMUNC - Registration";
include ("/var/www/mitmunc/template/header.php");
?>
<script type="text/javascript" src="include/registration.js"></script>
<h1>Registration</h1>
<p>Registration is a six step process:</p>
<ol style="list-style-position: inside;">
  <li>
     Read the information on the <a href="df">Registration Deadlines and Fees</a> page.
  </li>
  <li>
    Fill out the registration form with basic school and adviser information.
    <ul>
      <li>Please note that, due to space requirements, we ask that every school register for no more than 30 delegates.</li>
    </ul>
  </li>
  <li>
    Apply for preferred country/countries through the website login.  A committee/country matrix will be provided.
  </li>
  <li>
    Mail a check for registration fees to confirm delegation size and country application.
  </li>
  <li>
    The secretariat will contact you about which countries your school has been assigned.  You may change your countries again if you prefer.
  </li>
  <li>
    Submit delegate names and country/committee positions and adviser contact information.
  </li>
</ol>
<p>You will receive a login for the website to complete steps 3, 5, and 6.</p>
<p>Please <a href="contact">Contact Us</a> if you have any questions.</p>
<p>Please note that this is a conference for high school/secondary school students.  Due to space requirements, we cannot accept college students.</p>

<div id="regform">
  <table border="0">
    <tr>
      <td colspan="2"><h2>General Information</h2></td>
    </tr>
    <tr>
      <td>School Name:</td><td>
      <input type="text" id="schoolName" size="40"/>
      <span id="schoolNameError"></span>
      </td>
    </tr>
    <tr>
      <td># of Students:</td><td>
      <input type="text" id="numStudents" size="2" />
      <span id="numStudentsError"></span><span id="tooManyStudentsError"></span>
      </td>
    </tr>
    <tr>
      <td># of Faculty Advisers:</td><td>
      <input type="text" id="numAdvisers" size="2" />
      <span id="numAdvisersError"></span>
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
      <input type="text" id="contactName" />
      </td>
    </tr>
    <tr>
      <td>E-mail:</td><td>
      <input type="text" id="email" />
      <span id="emailError"></span>
      </td>
    </tr>
    <tr>
      <td>Address 1:</td><td>
      <input type="text" id="address1" />
      </td>
    </tr>
    <tr>
      <td>Address 2:</td><td>
      <input type="text" id="address2" />
      </td>
    </tr>
    <tr>
      <td>City:</td><td>
      <input type="text" id="city" />
      </td>
    </tr>
    <tr>
      <td>State:</td><td>
      <input type="text" id="state" />
      </td>
    </tr>
    <tr>
      <td>ZIP/Postal Code:</td><td>
      <input type="text" id="zip" />
      </td>
    </tr>
    <tr>
      <td>Country:</td><td>
        <?=country::getCountryOptions($optionsArray=array("id" => "countryId"), $defaultCountryId = 233)?>
      </td>
    </tr>
    <tr>
      <td>Phone Number:</td><td>
      <input type="text" id="phoneNumber" size="20" />
      </td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr>
      <td colspan="2"><h2>Other Information</h2></td>
    </tr>
    <tr>
      <td>Website Login Username:</td><td>
      <input type="text" id="username" />
      <span id="usernameError"></span><span id="usernameTakenError"></span>
      </td>
    </tr>
    <tr>
      <td>How did you hear about us?</td><td>
      <input type="text" id="hearAboutUs" size="40"/>
      </td>
    </tr>
  </table>
  Would you like to apply for financial aid?
  <br />
  <input type="radio" name="finAid" value="0" />
  No
  <br />
  <input type="radio" name="finAid" value="1" />
  Yes
  <br />
  The financial aid process is described on the <a href="/df">Deadlines and Fees</a> page.
  <br />
  <br />
  
  <input type="button" onclick="javascript:registrationSubmit()" value="Register" id="submitButton"/>
  <br />
  A password will be emailed to you when you register.
</div>
<?php
  include ("/var/www/mitmunc/template/footer.php");
?>
