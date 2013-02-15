<?php
/**
 * Most public pages should require() this file.  
 * This file uses header_basic to make the <head></head> code
 * Therefore, only changes to the top navigation toolbar should be in this file.  
 **/
if(!isset($headerCode)) $headerCode = '';
$headerCode .= '
<link rel="stylesheet" type="text/css" href="/template/default.css" />
<script type="text/javascript" src="/template/header.js"></script>
';
require("/var/www/mitmunc/template/header_basic.php");
?>
<div id="container">
<header>

<nav id="header1">
  <div class="logo"><a href="/"><img src="/images/header/Header_Logo.gif" width="306" height="94" alt="MITMUNC Logo"/></a></div>
  <ul><?php /* Keep these on one line. HTML converts whitespace and newlines into spaces between the links and causes them to space up and paginate. */ ?>
  <?php
  echo '<li><a href="/"><img src="/images/header/navbar1.gif" id="navbar1" width="71" height="51" alt="Home"/></a></li>';
  echo '<li><a href="/about"><img src="/images/header/navbar2.gif" id="navbar2" width="91" height="51" alt="About"/></a></li>';
  echo '<li><a href="/conference"><img src="/images/header/navbar3.gif" id="navbar3" width="141" height="51" alt="Conference"/></a></li>';
  echo '<li><a href="/committee"><img src="/images/header/navbar4.gif" id="navbar4" width="142" height="51" alt="Committees"/></a></li>';
  if($SESSION->login){
    echo '<li><a href="/controlpanel/"><img src="/images/header/navbar5_loggedin.gif" id="navbar5" width="115" height="51" alt="Control Panel"/></a></li>';
    echo '<li><a href="/logout" ><img src="/images/header/navbar6_loggedin.gif" id="navbar6" width="117" height="51" alt="Log Out"/></a></li>';
  }else{
    echo '<li><a href="/registration"><img src="/images/header/navbar5.gif" id="navbar5" width="147" height="51" alt="registration"/></a></li>';
    echo '<li><img src="/images/header/navbar6.gif" id="navbar6" width="93" height="51" alt="Login"/></li>';
  }
  ?>
  </ul>
</nav>

<div id="header2">
    <div class="main_logo"></div>
    <div class="dynamic_menu" id="header2logo">
      <div class="menu_item" id="header2_home">
        <div class="text1">
          Massachusetts Institute of Technology<br />
          Model United Nations Conference
        </div>
        <div class="text2">
          <?php
          echo date('F j-', generalInfoReader('conferenceStartDate'));
          echo date('j, Y', generalInfoReader('conferenceEndDate'));
          ?>
        </div>
      </div>
      <nav class="menu_item sublink" id="header2_link2">
        <a href="/about">About</a> &middot; <a href="/letter">Invitation</a> &middot; <a href="/secretariat">Secretariat</a> &middot; <a href="/boston">Boston</a> &middot; <a href="/faq">FAQ</a> &middot; <a href="/contact">Contact</a>
      </nav>
      <nav class="menu_item sublink" id="header2_link3">
        <a href="/schedule">Schedule</a> &middot; <a href="/df">Deadlines/Fees</a> &middot; <a href="/accommodations">Accommodations</a> &middot; <a href="/preparation">Preparation</a>
      </nav>
      <nav class="menu_item sublink" id="header2_link4">
      <?php
      $committeeShortNames = committee::getAllCommitteeShortNames();
      $i = 1;
      foreach($committeeShortNames as $committeeId => $committeeShortName){
          echo '<a href="/committee/'.$committeeShortName.'">'.$committeeShortName.'</a>';
	  //Also consider using $i%7==0, for auto-handling over 14 committees
          if($i==7 || $i == 13){
              echo '<br />';
          }elseif($i!=count($committeeShortNames)){
               echo ' &middot; ';
          }
          $i++;
      }
      ?>
      </nav>
      <nav class="menu_item sublink" id="header2_link5">
        <?php if ($SESSION->login){ ?>
        <a href="/controlpanel/">Control Panel</a>
        <? }else{ ?>
        <a href="/registration">Conference Registration</a> &middot;
        <a href="/registration_timer">Committee Timer Registration</a>
        <? } ?>
      </nav>
      <nav class="menu_item sublink login" id="header2_link6">
      <?php if (!$SESSION->login){ ?>
          <form action="https://www.mitmunc.org/login" method="POST">
              Username:
              <input type="text" name="username">
              &nbsp;&nbsp;&nbsp;
              Password:
              <input type="password" name="password">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="submit" value="Log In">
          </form>
          <span class="login_link"><a href="https://airmun.mit.edu:444/MITMUNC/readcert.php">Staff Login</a></span>
          <? } ?>
        </nav>
    </div>
  </div>

</header>
<div id="preloadimage" style="display:none">
</div>
<div id="body">
