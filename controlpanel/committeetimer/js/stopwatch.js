/**
 * This file defines the Stopwatch class.
 * Note that it knows nothing about instances and how those instances are used.
 */
var Stopwatch;
if (!Stopwatch) 
    Stopwatch = {};

/**
 * Constructs a new Stopwatch instance.
 * @param {Object} displayTime the strategy for displaying the time
 */
function Stopwatch(displayTime){
    this.runtime = 0; // milliseconds
    this.timer = null; // nonnull iff runnig
    this.displayTime = displayTime; // not showing runtime anywhere
}

/**
 * The increment in milliseconds.
 * (This is a class variable shared by all Stopwatch instances.)
 */
Stopwatch.INCREMENT = 500

/**
 * Displays the time using the appropriate display strategy.
 */
Stopwatch.prototype.doDisplay = function(){
    this.displayTime(this.runtime);
}

/**
 * Handles an incoming start/stop event.
 */
Stopwatch.prototype.startStop = function(){
    if (!this.timer) {
        var instance = this;
        this.timer = window.setInterval(function(){
            instance.runtime += Stopwatch.INCREMENT;
            instance.doDisplay();
        }, Stopwatch.INCREMENT);
    }
    else {
        window.clearInterval(this.timer);
        this.timer = null;
        this.doDisplay();
    }
}

/**
 * Handles an incoming reset/lap event.
 */
Stopwatch.prototype.resetLap = function(){
    window.clearInterval(this.timer);
    this.timer = null;
    this.runtime = 0;
    this.doDisplay();
}
