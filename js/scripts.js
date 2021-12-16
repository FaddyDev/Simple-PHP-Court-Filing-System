function renderTime(){
	//Date
  var mydate = new Date();
  var year = mydate.getYear();
  if(year < 1000){
	  year+=1900;
	  }
   var day =  mydate.getDay();
    var month = mydate.getMonth();
	var daym = mydate.getDate();
	var dayarray = new Array("Sun,","Mon,","Tue,","Wed,","Thur,","Fri,","Sat,");
	var montharray = new Array("Jan","Feb","March","April","May","June","July","August","Sep","October","Nov","Dec");
	//Date Section ends here
	
	//Time
	
	var currentTime = new Date();
	var h = currentTime.getHours();
	var m = currentTime.getMinutes();
    var s = currentTime.getSeconds();
	
	
    if(h == 24){
	 h = 0;
	}else if(h > 12){
		h = h - 0;
		}
	if(h < 10){
		h = "0" + h;
		}
		
	if(m < 10){
		m = "0" + m;
		}
	if(s < 10){
		s = "0" + s;
		}	
		
		var myClock = document.getElementById("clockDisplay");
		myClock.textContent = ""+dayarray[day]+ " " +daym+ " " +montharray[month]+ " " +year+ " | " +h+ ":" +m+ ":" +s;
		
		myClock.innerText = ""+dayarray[day]+ " " +daym+ " " +montharray[month]+ " " +year+ " | " +h+ ":" +m+ ":" +s;
		
		setTimeout("renderTime()",1000);
}
renderTime();



//AM,PM time to be called if needed, just altered finction name
 function renderTimee(){
  var currentTime = new Date();
  var diem = "AM";
  var h = currentTime.getHours();
  var m = currentTime.getMinutes();
  var s = currentTime.getSeconds();
  
  if(h==0){
    h = 12;
  } else if(h>12){
   h=h-12;
   diem="PM";
  }
    if(h<10){
	 h="0"+h;
	}
	
    if(h<10){
	 m="0"+m;
	}
	
    if(h<10){
	 s="0"+s;
	}
	
	var myClock=document.getElementById('session');
	myClock.textContent = h + ":" + m + ":" + s +" "+diem;
	//myClock.innerHTML = "wait";
  setTimeout('renderTime()',1000);
 }
 renderTimee();
 
 
//Function to show countdown time till session destruction
function CountDown(secs,elem){
var element = document.getElementById(elem);
element.innerHTML = "Session expires in "+secs+" seconds ";
 if(secs<1){
clearTimeout(timer);
element.innerHTML = "Session expired";
 }
secs--;
var timer = setTimeout('CountDown('+secs+',"'+elem+'")',1000);
}

//Getting the current year then display in an option selection list wherever called
function thisYear(){
  var myDate = new Date();
  var year = myDate.getFullYear();
  var myClock=document.getElementById('main');
	  document.write('<option value="'+year+'">'+year+'</option>');
	}
//Getting the current month then display in an option selection list wherever called
function thisMonth(){
  var myDate = new Date();
  var mon = myDate.getMonth();
  var montharray = new Array("January","February","March","April","May","June","July","August","September","October","November","December");
	  document.write('<option value="'+montharray[mon]+'">'+montharray[mon]+'</option>');
}

//Limiting input to integers only
function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8 & unicode!=46 & unicode!=37 & unicode!=39 ){ //if the key isn't the backspace,delete,left and right arrow keys (which we should allow)
        if (unicode<48||unicode>57) //if not a number
            return false //disable key press
    }
}

