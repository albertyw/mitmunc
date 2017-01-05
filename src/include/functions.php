<?php
// Add classes and functions
require('/var/www/mitmunc/include/phpxssfilter.php');
require('/var/www/mitmunc/include/functions_ccMatrix.php');
require('/var/www/mitmunc/include/functions_committee.php');
require('/var/www/mitmunc/include/functions_country.php');
require('/var/www/mitmunc/include/functions_mealTicket.php');
require('/var/www/mitmunc/include/functions_payment.php');
require('/var/www/mitmunc/include/functions_resolution.php');
require('/var/www/mitmunc/include/functions_school.php');
require('/var/www/mitmunc/include/functions_user.php');


// Add child classes and functions
require('/var/www/mitmunc/include/functions_session.php');

/**
 * Makes a connection to the database
 **/
function connectDatabase(){
    mysql_connect("localhost", 'username','password') or die(mysql_error());
    mysql_select_db('mitmunc') or die(mysql_error());
}


/**
 * Reads information from the generalInfo table
 **/
function generalInfoReader($infoKey){
    $result = mysql_query("SELECT infoValue FROM generalInfo WHERE infoKey='$infoKey'") or die(mysql_error());
    $row = mysql_fetch_array($result);
    return $row['infoValue'];
}

/**
 * Obfuscate Email
 **/
function obfuscateEmail($email, $text=''){
    $email = str_rot13($email);
    if($text == ''){
        $text = $email;
    }else{
        $text = str_rot13($text);
    }
    return '<script type="text/javascript">
	document.write("<n uers=\"znvygb:'.$email.'\" ery=\"absbyybj\">'.$text.'</n>".replace(/[a-zA-Z]/g, 
	function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));
	</script>';
}

/**
 * Converts an int into a string ordinal Number
 **/
function ordinalNumber($num){
    if($num == 1){ return 'First';
    }elseif($num == 2){ return 'Second';
    }elseif($num == 3){ return 'Third';
    }elseif($num == 4){ return 'Fourth';
    }elseif($num == 5){ return 'Fifth';
    }elseif($num == 6){ return 'Sixth';
    }elseif($num == 7){ return 'Seventh';
    }elseif($num == 8){ return 'Eigth';
    }elseif($num == 9){ return 'Ninth';
    }elseif($num == 10){ return 'Tenth';
    }elseif($num == 11){ return 'Eleventh';}

}

/**
 * Converts a mysql datetime into a date
 **/
function extractDate($dateTime){
    return date("M j, Y", strtotime($dateTime));
}
/**
 * Converts values of a list into a comma separated string
 **/
function commaSeparate($array){
    $returnString = '';
    foreach($array as $item){
        $returnString .= $item.', ';
    }
    return substr($returnString, 0, -2);
}

/**
 * Get the IP of the current client
 **/
function getIP(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){   //check ip from share internet
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 * Run a sanitization script on each variable in an array.  Useful for 
 * sanitizing $_POST and $_GET
 **/
function sanitizeArray($array){
    $keys = array_keys($array);
    $i = 0;
    while($i < sizeof($keys)){
        $key = $keys[$i];
        $array[$key] = sanitizeValue($array[$key]);
        $i += 1;
    }
    return $array;
}
function sanitizeValue($string){
    $string = RemoveXSS($string);
    $string = stripslashes($string); // Remove Magic Slashes
    $string = strip_tags($string); // Remove HTML
    $string = htmlspecialchars($string); // Convert characters
    $string = trim(rtrim(ltrim($string))); // Remove spaces
    $string = mysql_real_escape_string($string); // Prevent SQL Injection
    return $string;
}

/**
 * Sanitize input for latex formatting
 **/
function sanitizeLatex($string){
    $replacements = array();
    $replacements['\\'] = '\\textbackslash{}';
    $replacements['{'] = '\\{';
    $replacements['}'] = '\\}';
    $replacements['$'] = '\\$';
    $replacements['&'] = '\\&';
    $replacements['#'] = '\\#';
    $replacements['^'] = '\\textasciicircum{}';
    $replacements['_'] = '\\_';
    $replacements['~'] = '\\textasciitilde{}';
    $replacements['%'] = '\\%';
    $replacements['<'] = '\\textless{}';
    $replacements['>'] = '\\textgreater{}';
    $replacements['|'] = '\\textbar{}';
    $replacements['"'] = '\\textquotedbl{}';
    //$replacements['\''] = '\\textquotesingle{}';
    $replacements['`'] = '\\textasciigrave{}';
    foreach($replacements as $find => $replace){
        $string = str_replace($find, $replace, $string);
    }
    return $string;
}

/**
 * Validate an email address.
 * Provide email address (raw input)
 * Returns true if the email address has the email 
 * address format and the domain exists.
 **/
function validEmail($email){
    $pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])' .
'(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';
    if(preg_match($pattern,$email)==1) return true;
    return false;
}

/**
 * Send email.  This function also archives old messages into the database
 * This function also cc's info-mimtunc@mit.edu with every email
 * Defaults to HTML mail
 **/
function sendEmail($to, $subject, $message, $from='MITMUNC <info-mitmunc@mit.edu>'){
    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "From: $from\n";
    
    $accessCode = '';
    for($i=0; $i<20; $i++){
        if(rand(0,1)==0){
            $accessCode .= chr(rand(65,90));
        }else{
            $accessCode .= chr(rand(97,122));
        }
    }
    
    $fromEscaped = mysql_real_escape_string($from);
    $toEscaped = mysql_escape_string($to);
    $subjectEscaped = mysql_escape_string($subject);
    $messageEscaped = mysql_escape_string($message);
    mysql_query("INSERT INTO emails (`accessCode`, `from`, `to`, `subject`, `message`) 
        VALUES('$accessCode', '$fromEscaped', '$toEscaped', '$subjectEscaped', '$messageEscaped')") or die(mysql_error());
    
    $handle = fopen("http://mitmunc.mit.edu/template/email?accessCode=".$accessCode, "rb");
    $formattedMessage = stream_get_contents($handle);
    fclose($handle);
    
     mail($to, $subject, $formattedMessage, $headers);
      if($to != 'info-mitmunc@mit.edu'){
        mail('info-mitmunc@mit.edu', $subject, $formattedMessage, $headers);
    }
}
?>
