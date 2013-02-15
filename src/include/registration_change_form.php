<div id="reginfo">
  <table border="0">
    <tr>
      <td colspan="2"><h2>General Information</h2></td>
    </tr>
    <tr>
      <td>School Name:</td><td><?=$school->schoolName;?></td>
    </tr>
    <tr>
      <td># of Students:</td><td><?=$school->numStudents;?></td>
    </tr>
    <tr>
      <td># of Faculty Advisers:</td><td><?=$school->numAdvisers;?></td>
    </tr>
    <tr>
      <td>Registration Time:</td><td><?=$school->regTime;?></td>
    </tr>
    <tr>
      <td></td><td></td>
    </tr>
    <tr>
      <td colspan="2"><h2>Primary Contact Information</h2></td>
    </tr>
    <tr>
      <td>Name:</td><td><?=$school->users[0]->realName;?></td>
    </tr>
    <tr>
      <td>E-mail:</td><td><?=$school->users[0]->email;?></td>
    </tr>
    <tr>
      <td>Address 1:</td><td><?=$school->address['1'];?></td>
    </tr>
    <tr>
      <td>Address 2:</td><td><?=$school->address['2'];?></td>
    </tr>
    <tr>
      <td>City:</td><td><?=$school->address['city'];?></td>
    </tr>
    <tr>
      <td>State:</td><td><?=$school->address['state'];?></td>
    </tr>
    <tr>
      <td>ZIP/Postal Code:</td><td><?=$school->address['zip'];?></td>
    </tr>
    <tr>
      <td>Country:</td><td><?=$school->address['country'];?></td>
    </tr>
    <tr>
      <td>Phone Number:</td><td><?=$school->users[0]->phoneNumber;?></td>
    </tr>
    <tr>
      <td></td>
    </tr>
  </table>
</div>
<input type="submit" id="changeRegistrationSubmit" onclick="javascript:changeRegistration()" value="Change Registration Information">
<br/>
</br/>