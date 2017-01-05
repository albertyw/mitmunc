<?php
include_once("/var/www/mitmunc/include/functions_controlpanel.php");

// Read school data from mySQL DB once, then use it as a global variable
$result = mysql_query("SELECT * FROM school, users WHERE school.id='$SESSION->schoolId' AND school.id=users.schoolId AND users.loginType='school'") or die(mysql_error());
$row = mysql_fetch_array($result);
$school = new school($SESSION->schoolId);

// Make Tasks
$changestatus = new RegistrationTask("Review/Change Registration Status", "/controlpanel/school/school",
    function() { // Availability
        return true;
    },
    function() { // Necessity
        return false;
    },
    function() { // Completion
        return false;
    },
    function() { // Progress
        return false;
    });
$finaid = new RegistrationTask("Submit Financial Aid Application", "/controlpanel/school/finaid",
    function() { // Availability
        return true;
    },
    function() { // Necessity
      global $school;
        return ($school->finAid);
    },
    function() { // Completion
      global $school;
        return ($school->totalFinAid != 0);
    },
    function() { // Progress
      global $school;
        return ($school->finaidQuestion[1] != "");
    });
$lunch = new RegistrationTask("Buy Meal Tickets", "/controlpanel/school/mealTicket",
function() { // Availability
  global $school;
  return true;
},
function() { // Necessity
  return false;
},
function() { // Completion
    global $school;
  return ($school->mealTicketOwed == 0 && $school->mealTicketTotal !=0);
},
function() { // Progress
  global $school;
  return ($school->mealTicketTotal != 0);
  
});
$pay = new RegistrationTask("Make Payment", "/controlpanel/school/payment",
    function() { // Availability
        return true;
    },
    function() { // Necessity
        return true;
    },
    function() { // Completion
      global $row;
      global $school;
      return ($school->totalOwed <= 0);
    },
    function() { // Progress
      global $row;
      global $school;
  return ($school->totalPaid > 0);
    });
$pay->addSideAction("/controlpanel/school/invoice", "See Invoice");
$countries = new RegistrationTask("Apply for Countries", "/controlpanel/school/countrypref",
    function() { // Availability
        //CHANGED;
        //return false;
        return true;
    },
    function() { // Necessity
        global $pay;
        return $pay->getCompletion();
    },
    function() { // Completion
      global $row;
        return ($row["countryConfirm"] == 1);
    },
    function() { // Progress
      global $row;
        return ($row["country1"] != 0);
    });
$specialCommitteePosition = new RegistrationTask("Apply for Special Committee Positions", "/controlpanel/school/specialCommitteePosition",
    function() { // Availability
        return true;
    },
    function() { // Necessity
        global $pay;
        return $pay->getCompletion();
    },
    function() { // Completion
      global $row;
        return ($row["countryConfirm"] == 1);
    },
    function() { // Progress
      global $row;
        return ($row["country1"] != 0);
    });
$delegateinfo = new RegistrationTask("Delegate and Adviser Information", "/controlpanel/school/delegateinfo",
    function() { // Availability
        global $countries;
        return $countries->getCompletion();
    },
    function() { // Necessity
        global $countries;
        return $countries->getCompletion();
    },
    function() { // Completion
      global $row, $SESSION;
      $numstudents = $row["numStudents"];
      $numAdvisers = $row["numAdvisers"];

      $result = mysql_query("SELECT name, committee, country, logintype FROM `school_$SESSION->schoolId`");
      $advisers_count = 0;
      $delegates_count = 0;
      while ($row_ = mysql_fetch_array($result)) {
        if ($row_["logintype"] == "school") {
          if ($row_["name"] != "") {
            $advisers_count += 1;
          }
        } elseif ($row_["logintype"] == "delegate") {
          if ($row_["name"] != "" and $row_["committee"] != 0 and $row_["country"] != 0) {
            $delegates_count += 1;
          }
        } elseif($row['loginType']==0) {
            continue;
        }else {
          error_log("logintype {$row_['logintype']} of row not recognized}.");
        }
      }

      $advisers_complete = ($numAdvisers == $advisers_count);
      $students_complete = ($numstudents == $delegates_count);

      return ($advisers_complete && $students_complete);
      },
    function() {
    // Progress
      global $SESSION;
      $result = mysql_query("SELECT COUNT(*) FROM `school_{$SESSION->schoolId}`");
      $row = mysql_fetch_array($result);
        return ($row[0] > 0);
    });

$accommodations = new RegistrationTask("Hotel and Transportation Information", "/accommodations",
    function() { // Availability
        return true;
    },
    function() { // Necessity
        return false;
    },
    function() { // Completion
        return false;
    },
    function() { // Progress
        return false;
    });
$liability_medical = new RegistrationTask("MITMUNC Liability &amp; Medical Forms", "/controlpanel/school/liability",
    function() { // Availability
        return true;
    },
    function() { // Necessity
        return false;
    },
    function() { // Completion
        return false;
    },
    function() { // Progress
        return false;
    });
        
        $step1 = new RegistrationStep(1, "Billing &amp; Payment");
        $step2 = new RegistrationStep(2, "Select Countries");
        $step3 = new RegistrationStep(3, "Submit Contact Information");
        $step4 = new RegistrationStep(4, "Hotel and Transportation");
        $step5 = new RegistrationStep(5, "Supply Forms");

        $step1->addTask($pay);        
        $step1->addTask($finaid);
        $step1->addTask($changestatus);
        #$step1->addTask($lunch);

        $step2->addTask($countries);
        $step2->addTask($specialCommitteePosition);
        $step3->addTask($delegateinfo);
        $step4->addTask($accommodations);
        $step5->addTask($liability_medical);
        
        RegistrationPage::addStep($step1);
        RegistrationPage::addStep($step2);
        RegistrationPage::addStep($step3);
        RegistrationPage::addStep($step4);
        RegistrationPage::addStep($step5);
        
        echo RegistrationPage::displayPage();
echo '<h2>Mitmunc.org Account</h2>';
