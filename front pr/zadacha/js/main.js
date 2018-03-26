var countDownDate = new Date("Sep 5, 2018 23:59:59").getTime();

var x = setInterval(function() {

    var now = new Date().getTime();
    
    var distance = countDownDate - now;
    
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
        minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
        seconds = Math.floor((distance % (1000 * 60)) / 1000),
        hoursTen = Math.floor(hours/10),
        hoursOne = hours % 10,
        minutesTen = Math.floor(minutes/10),
        minutesOne = minutes % 10,
        secondsTen = Math.floor(seconds/10),
        secondsOne = seconds % 10;

    document.getElementById("hoursTen").innerHTML = hoursTen;
    document.getElementById("hoursOne").innerHTML = hoursOne;
    document.getElementById("minutesTen").innerHTML = minutesTen;
    document.getElementById("minutesOne").innerHTML = minutesOne;
    document.getElementById("secondsTen").innerHTML = secondsTen;
    document.getElementById("secondsOne").innerHTML = secondsOne;
     
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "EXPIRED";
    }
}, 1000);
