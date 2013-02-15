<?php
	/**
	  * Enumeration describing the status of a given event.
	  * @author (eyas.sharaiha@gmail.com)
	  */
    class TaskStatus {
    	const Unavailable = "Unavailable"; // A step that cannot be started at the given time
    	const Available = "Available"; // A step not required, but can be started
    	const Required = "Not Started"; // A step not started, but is necessary to continue
			const InProgress = "In Progress"; // A step necessary to continue, but in progress
			const Complete = "Done"; // A finished step
			
			public static function getClass($const) {
				switch ($const) {
					case TaskStatus::Unavailable: return "unavailable"; break;
					case TaskStatus::Available: return "can_start"; break;
					case TaskStatus::Complete: return "done"; break;
					case TaskStatus::Required: return "must_start"; break;
					case TaskStatus::InProgress: return "in_progress"; break;
				}
			}
    }
    
    /**
     * A class that represents a single task within a step
		 * @author (eyas.sharaiha@gmail.com)
     */
    class RegistrationTask {
    	private $name; // Label for the step
    	private $link; // The URL for the action
    	private $side_action = array(); // Other links that accompany this task
    	private $availabilityCondition; // A Function class
    	private $necessityCondition; // A Function class
    	private $completionCondition; // A function class
    	private $beginningCondition; // A Function class
    	
    	function __construct($_name, $_link, Closure $condition1,
    	                     Closure $condition2, Closure $condition3,
													 Closure $condition4) {
    		$this->name = $_name;
    		$this->link = $_link;
    		$this->availabilityCondition = $condition1;
				$this->necessityCondition = $condition2;
				$this->completionCondition = $condition3;
				$this->inProgressCondition = $condition4;
    	}
			
    	public function __call($method, $args) {
        if(isset($this->$method) && is_callable($this->$method)) {
          return call_user_func_array(
              $this->$method, 
              $args
              );
        }
      }
    	
    	function addSideAction($link, $name) {
    		$this->side_action[] = array("link"=>$link, "name"=>$name);
    	}
    	
    	function getName() {
    		return $this->name;
    	}
    	
    	function getLink() {
    		return $this->link;
    	}
    	
    	function getAvailability() {
    		return $this->availabilityCondition();
    	}
			
    	function getNecessity() {
    		return $this->necessityCondition();
    	}

    	function getCompletion() {
    		return $this->completionCondition();
    	}
			
			function getProgress() {
				return $this->inProgressCondition();
			}
			
			function getTag() {
				if ($this->getAvailability() == false) {
					return TaskStatus::Unavailable;
				} elseif ($this->getNecessity() == false) {
					return TaskStatus::Available;
				} elseif ($this->getCompletion() == true) {
					return TaskStatus::Complete;
				} elseif ($this->getProgress() == false) {
					return TaskStatus::Required;
				} else {
					return TaskStatus::InProgress;
				}
			}
			
			function displayTask() {
				$tag = $this->getTag();
				$sides = "";
				if ($tag == TaskStatus::Unavailable) {
					$namelink = $this->name;
					foreach ($this->side_action as $side_action) {
						$sides.= " (" . $side_action["name"] . ")";
					}
				} else {
					$namelink = "<a href=\"{$this->link}\">{$this->name}</a>{$sides}";
					foreach ($this->side_action as $side_action) {
						$sides.= " (<a href=\"" . $side_action["link"] . "\">";
						$sides.= $side_action["name"] . "</a>)";
					}
				}
				return "<li><span class=\"tag\">{$tag}</span>{$namelink}{$sides}</li>";
			}
    }
    
		/**
		 * A class that represents a single step in the process.
		 * A step is one or more tasks logically grouped together,
		 * in a roughly sequential order.
		 */
		class RegistrationStep {
			private $tasks = array();
			private $name;
			private $number;
			
			function __construct($number, $name) {
				$this->number = $number;
				$this->name = $name;
			}
			
			function addTask(RegistrationTask $task) {
				$this->tasks[] = $task;
			}
			
			private function partitionTasks() {
				$tasks = array(TaskStatus::Required => array(),
											 TaskStatus::InProgress => array(),
											 TaskStatus::Complete => array(),
											 TaskStatus::Available => array(),
											 TaskStatus::Unavailable => array());
				foreach ($this->tasks as $task) {
					$tasks[$task->getTag()][] = $task;
				}
				return $tasks;
			}
			
			function displayStep() {
				$stepcontent = "";
				foreach ($this->partitionTasks() as $status=>$tasks) {
					if (count($tasks) > 0) {
						$class = TaskStatus::getClass($status);
						$stepcontent .= "<ul class=\"{$class}\">\n";
						foreach ($tasks as $task) {
							$stepcontent .= "\n" . $task->displayTask();
						}
						$stepcontent .= "\n</ul>";
					}
				}
				return "<div class=\"step\">\n<div class=\"stepdef\">\n" .
				    "<span class=\"number\">Step {$this->number}</span>" .
				    "<span class=\"stepname\">{$this->name}</span>\n</div>" .
				    "<div class=\"stepcontent\">\n{$stepcontent}\n</div>\n</div>";
			}

		}
		
    /**
     * Static class that describes the registration page itself
     */
    class RegistrationPage {
    	private static $steps = array();
    	public static function addStep(RegistrationStep $step) {
    		RegistrationPage::$steps[] = $step;
    	}
    	public static function displayPage() {
    		$string = "<div class=\"step_wrapper\">";
				foreach (RegistrationPage::$steps as $step) {
					$string .= $step->displayStep();
				}
				return $string . "</div>";
    	}
    }
?>