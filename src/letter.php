<?php
$title = "MITMUNC - Invitation to MITMUNC 2016";
require("/var/www/mitmunc/template/header.php");
?>

<div style="font-size:large;text-align:center">
Invitation to MITMUNC <?php echo generalInfoReader('conferenceYear'); ?>
</div>

<p>Dear Delegates and Faculty Advisers,</p>

<p>
It gives me great pleasure and distinct honor to invite you to the sixth annual 
Massachusetts Institute of Technology Model United Nations Conference (MITMUNC), held on the weekend of 
 <?php echo date('F j-',  generalInfoReader('conferenceStartDate')); 
 echo date('j, Y', generalInfoReader('conferenceEndDate')); 
 ?>.
 </p>

<p>
MITMUNC is a growing, innovative Model United Nations conference, exclusively for high school students. At MIT, we make an effort to give students the opportunity to engage in debate on UN and special committees that have a scientific or technological basis. The high school students attending need not be especially knowledgeable in science, but rather interested in international policy and the role that science plays in many of the current international issues we deal with today.</p>
  
<p>
Our chairs, all current MIT students, combine their scientific expertise with their passion for international politics and relations to make scientific issues accessible to the students in the MUN format. We aim for all student delegates to improve their debate and public speaking skills, while simultaneously gaining a reverence for the scientific basis behind their arguments.</p>

<p>
In past years, our committees have included the UNSC with topics such as "Cyber Security" and "Bioterrorism", chaired by a computer science student; as well as the WHO with topics including "Medical Device Technologies" and "Maternal Mortality", chaired by a biology student. Small committee sizes (our rules stipulate committees cannot be larger than 55 delegates total) and knowledgeable chairs across the board encourage every student to get involved in the process. </p>
  
<p>
MIT has long championed the intersection of academic knowledge and practical skills, in sync with our school's motto, "Mens et manus" ("Mind and hand"), and we aim to bring that same spirit to our conference.</p>
 
<p>
Now in our eighth year, MITMUNC staff will be more experienced than ever before. Many of our Staff and Secretariat members have MUN experience at the high school and college levels. They have chaired and participated as delegates at several conferences--locally and internationally. We are excited to have grown so quickly with the help of schools like yours, and we hope you will join us in making the history of MITMUNC.</p>

<p>The deadline and fees for MITMUNC 2016 registration are outlined below:</p>

<p>
<b>Registration--due November 24, 2015</b>
<ul>
<li>$60 per delegate</li>
<li>$80 for the school</li>
</ul>
</p>

<p>
Registration for the conference will open on October 15th, 2015. This year, MITMUNC will only have one registration deadline. All schools that register after our deadline will be automatically placed on our waitlist, as we cannot guarantee spots thereafter.
Also note that we allow schools and/or organizations to bring up to 30 delegates--no exceptions will be made to this rule. Delegations under 5 students, including single delegations, need not pay the school fee.</p>
 
<p>
Also note that we allow schools and/or organizations to bring up to 30 delegates--no 
exceptions will be made to this rule. Delegations under 5 students, including single 
delegations, need not pay the school fee.</p>

<p>
You can register your delegation and view additional information about our conference by visiting http://mitmunc.mit.edu/. If you have any questions about MITMUNC, we encourage you to email mun-exec@mit.edu for more information.</p>

<p>
We look forward to hearing from you soon!</p>

Aofei Liu<br/>
Charg&eacute;e d'Affaires<br/>
MITMUNC VII <?php echo generalInfoReader('conferenceYear'); ?><br/>
<a href="<?php echo "mailt"."o:mun-exec@"."m"."it.edu"; ?>">mun-exec@mit.edu</a><br/>
(601) 5-MITMUN<br/>

<?php   require("/var/www/mitmunc/template/footer.php" );?>