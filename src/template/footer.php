</div> <!-- id="body" !-->
</div> <!-- id="container" !-->
<footer>
    <div id="footerstripe">
        <p>Questions? Contact us at 
        <?php echo obfuscateEmail("info@mitmunc.org"); ?>
        </p>
    </div> <!-- id="footerstripe" !-->

    <nav id="sitenav">
      <a class="footerlogo" href="http://mit.edu/"><img src="/images/mitfooterlogo.gif" width="195" height="70" alt="MIT" /></a>
      <ul>
      <li style="width: 80px;">
        <a href="/">Home</a>
      </li>
      
      <li>
        <a href="/about">About us</a>
        <ul>
          <li><a href="/about">about</a></li>
          <li><a href="/letter">invitation</a></li>
          <li><a href="/secretariat">secretariat</a></li>
          <li><a href="/boston">boston</a></li>
          <li><a href="/faq">faq</a></li>
          <li><a href="/contact">contact</a></li>
        </ul>
      </li>
  
      <li>
        <a href="/conference">Conference</a>
        <ul>
          <li><a href="/schedule">schedule</a></li>
          <li><a href="/df">deadlines/fees</a></li>
          <li><a href="/accommodations">accommodations</a></li>
          <li><a href="/preparation">preparation</a></li>
        </ul>
      </li>
      
      <li>
        <a href="/committee">Committees</a>
        <ul>
          <?php
          $committeeShortNames = committee::getAllCommitteeShortNames();
          foreach($committeeShortNames as $committeeId => $committeeShortName){
              echo '<a href="/committee/'.$committeeShortName.'">'.strtolower($committeeShortName).'</a><br />';
          }
          ?>
        </ul>
      </li>
      <li>
      <?php
      if($SESSION->login){ ?>
          <a href="/controlpanel/">Control</a>
      </li>
      <li style="width:80px">
          <a href="/logout">Logout</a>
      <? }else{ ?>
          <a href="/registration">Registration</a>
          <ul>
            <li><a href="/registration">conference</a></li>
            <li><a href="/registration_timer">timer</a></li>
          </ul>
      </li>
      <li style="width:80px">
          <a href="/login">Login</a>
      <? } ?>
      </li>
      </ul>
    </nav>

    <div id="footerBottomLink">
        <a href="/tos">Terms of Service</a>  <a href="/privacy">Privacy Policy</a><br />
        &copy; 2012 Massachusetts Institute of Technology Model United Nations Conference
    </div> <!-- id="footerlink" -->
</footer>


</body>
</html>
