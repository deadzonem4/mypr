function Car(make, year, color, type, view){
	this.make = make;
	this.year = year;
	this.color = color;
	this.type = type;
	this.view = view;
	this.updateView = function(){
		return ++this.view;
	};
}

var sum = 0,
	peshko = 0;

var cars = [
	new Car("Audi", 2001, "red", "Van", 0),
	new Car("Opel", 2005, "black", "Sedan", 0),
	new Car("Vw", 2002, "blue", "Sedan", 0),
	new Car("Danio e pedal", 2002, "blue", "Sedan", 0)
]
for(var i = 0; i < cars.length; i++){
	sum += cars[i].year;
}
console.log(sum);




peshko = sum / cars.length;

console.log(peshko);

function Person(name, gender, years){

	this.name = name;
	this.gender = gender;
	this.years = years;
}

var people = [
	new Person("Rosen", "Male", 23),
	new Person("Daniel", "Male", 25),
	new Person("Vulko", "Male", 24),
	new Person("Katq", "Female", 24)
];

for (var i = 0; i < people.length; i++){
	if (people[i].name == "Rosen") {
		console.log(people[i]);
	}
}




function inEms(pixels){
	
	var baseValue = 16;
	
	function doMath(){
		return pixels/baseValue;
	}
	return doMath();

}

var small = inEms(12);

console.log(small);




var dolphin = new Object(),
	lion = new Object(),
	eagle = new Object(),
	bee = new Object();

var dolphin = {
	age: 20,
	sleep : function(){
		console.log("zzzzz");
	},
	swim : function(){
		console.log("splash");
	}
}
var lion = {
	age: 20,
	roar : function(){
		console.log("wrrr");
	},
	sleep : function(){
		console.log("zzzzz");
	},
	eat : function(){
		console.log("yuuumiii");
	}
}
var eagle = {
	age: 20,
	fly : function(){
		console.log("wooohooo");
	},
	sleep : function(){
		console.log("zzzzz");
	},
	eat : function(){
		console.log("yuuumiii");

	}
}
var bee = {
	age: 20,
	sleep : function(){
		console.log("wooohooo");
	},
	fly : function(){
		console.log("wooohooo");

	}
}

console.log(bee.fly());



// function Animal(make, year, color, type, view){
// 	this.year = year;
// 	this.fly = function(){
// 		var a = "asd";
// 		return a;
// 	};
// 	this.sleep = function(){
// 		var a = "zzzzz";
// 		return a;
// 	};
// }

// var animals = [
// 	Dolphin = new Animal(20),
// 	Lion = new Animal(20)
// ]
// console.log(animals);







// var list = document.querySelectorAll('#list li');
// console.log(list);

// function addClass(){
// 	for (var i = 0; i < list.length; i++) {
// 		list[i].classList.remove("active");
// 		this.classList.add("active");
// 	}
// }
// for (var i = 0; i < list.length; i++) {
// 	list[i].addEventListener("click", addClass);
// }


// var link = document.querySelector('main a');

// console.log(link.attributes);
// if (link.hasAttribute ("target")) {
// 	console.log(link.getAttribute("target"));
// }
// else{
// 	link.setAttribute("target", "_blank");
// }






var list = document.querySelectorAll('#list li');

function addClass(){
	for (var i = 0; i < list.length; i++) {
		list[i].classList.remove("active");
		this.classList.add("active");
		if (list[i].className =="active") {
			console.log(list[i]);
		}
	}
}

for (var i = 0; i < list.length; i++) {
	list[i].addEventListener("click", addClass);
}


var blank = document.querySelector('main a');
if (blank.hasAttribute("target")) {
	console.log(blank.getAttribute("target"));
}
else{
	blank.setAttribute("target", "_blank");
}



function Person(age, name, gender){
	this.age = age;
	this.name = name;
	this.gender = gender;
}
 var people = [
 	new Person(20, "Pesho", "male"),
 	new Person(25, "Vasil", "male"),
 	new Person(23, "Vulko", "male"),
 	new Person(25, "Daniel", "male"),
 	new Person(26, "Vasilka", "female")
 ];

var sum = 0;
var length = people.length;
var average;

 for (var i = 0; i < length; i++) {
 	sum += people[i].age;
 	if (people[i].gender == "female") {
 		console.log(people[i]);
 	}
 	if (people[i].age == "25") {
 		console.log(people[i]);
 	}
 	
 }
 console.log(sum);
 average = sum/length;
 console.log(average);

//--------------------------------------------Put objects in array
var dog = new Object();
var cat = new Object();
var arr = [];
var dog = {
	age: 10,
	name: "Leo",
	color: "black",
	activity: function(){
		console.log("baubau");
	}
}
var cat = {
	age: 8,
	name: "Rex",
	color: "gray",
	activity: function(){
		console.log("miaumiau");
	}
}
arr.push('dog', 'cat');
console.log(dog);
console.log(dog.activity);
console.log(dog.activity());
console.log(arr);




 // var modal = document.getElementById('myModal');
 // // Get the <span> element that closes the modal
 // var span = document.getElementsByClassName("btn-13")[0];
 // // When the user clicks the button, open the modal
 // window.onload = function() {
 //   modal.style.display = "block";
 //   selectFunc();
 //   var test = getCookie('_jwt');
 //   if(test){
 //     $('#myModal').hide();
 //     $('#myModal2').show();
 //   }
 //   console.log("neneenen");
 // }
 // // When the user clicks anywhere outside of the modal, close it
 // window.onclick = function(event) {
 //    if (event.target == modal) {
 //        modal.style.display = "block";
 //    }
 // }
 // const setCookie=(cname,cvalue,exdays) => {
 //     console.log('here 1')
 //     var d = new Date();
 //       d.setTime(d.getTime() + (exdays*24*60*60*1000));
 //       var expires = "expires=" + d.toGMTString();
 //       console.log(expires)
 //       console.log('wwwww',document)
 //       document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
 // }
 // const getCookie= (cname) => {
 //       var name = cname + "=";
 //       var decodedCookie = decodeURIComponent(document.cookie);
 //       var ca = decodedCookie.split(';');
 //       for(var i = 0; i < ca.length; i++) {
 //           var c = ca[i];
 //           while (c.charAt(0) == ' ') {
 //               c = c.substring(1);
 //           }
 //           if (c.indexOf(name) == 0) {
 //               return c.substring(name.length, c.length);
 //           }
 //       }
 //       return "";
 //     }

 

 // function validateOnSelect(){
 //     var monthval = document.getElementById('month');
 //     var dateval = document.getElementById('day');
 //     var yearval = document.getElementById('year');
 //     if (monthval.value.length > 0 && monthval.value != 'Month'
 //       && dateval.value.length > 0 && dateval.value != 0
 //       && yearval.value.length > 0 && yearval.value != 1939) {
 //          document.getElementById("submit").disabled = false;
 //    }
 // }

 // function selectFunc(){
 // //--------------------------------------------Month---------------------------
 //     var productArray = ['Month', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
 //     $( '#month' )
 //     .html( '<option>' + productArray.join( '</option><option>' ) + '</option>' );
 // //---------------------------------------------------DAY---------------------
 //     var startday = 0;
 //     var endday = 31;
 //     var options = "";
 //     for(var day = startday; day <=endday; day++){
 //       options += "<option value="+day+">"+ day +"</option>";
 //     }
 //     document.getElementById("day").innerHTML = options;
 //     document.getElementById("day").childNodes[0].innerHTML = "DD";
 // //-----------------------------------------------------YEAR------------------
 //     var start = 1939;
 //     var end = new Date().getFullYear()-1;
 //     var options = "";
 //     for(var year = start ; year <=end; year++){
 //       options += "<option value="+year+">"+ year +"</option>";
 //     }
 //     document.getElementById("year").innerHTML = options;
 //     document.getElementById("year").childNodes[0].innerHTML = "YYYY";
 // };

 // document.getElementById('myform').addEventListener('submit', sendValues);
       
 //  function sendValues(event){
 //  event.preventDefault();
 //   var error = false;
 //   var child = false;
 //   var monthval = document.getElementById('month');
 //   var dateval = document.getElementById('day');
 //   var yearval = document.getElementById('year');
 //   var today = new Date();
 //   var yyyy = today.getFullYear();
 //   console.log("darabara");
 //    modal.style.display = "none";

 //    if (yyyy - yearval.value < 13 ) {
 //        $('#myModal2').show();
 //    setCookie('_jwt',"wwwwwww",1)
 //    }
 //  };

//---------------------------------------------------Sort element in array------------
var fruits = ["Banana", "Orange", "Apple", "Mango"];
document.getElementById("sort").innerHTML = fruits;

document.getElementById("click-to-sort").addEventListener("click", sortArray);
	
	function sortArray(event) {
		event.preventDefault();
    
	    fruits.sort();
	    document.getElementById("sort").innerHTML = fruits;

	};
//-------------------------------------------------Sort element smallest to largest
var points = [40, 100, 1, 5, 25, 10];
document.getElementById("sort-number").innerHTML = points;

document.getElementById("click-to-sort-number").addEventListener("click", sortNumber);
	
	function sortNumber(event) {
		event.preventDefault();
    
	    points.sort(function(a, b){return b-a});
	    document.getElementById("sort-number").innerHTML = points;

	};
//------------------------------------------------Put all elems of array in list smallest to largest
document.getElementById("array").addEventListener("click", sortNewArray);

function sortNewArray(event){
	event.preventDefault();
	arr = [];
	console.log(arr);
	var li = "";
	ul = document.getElementById("new-array");
	for (var i = 0; i <= 30; i++) {
		arr.push(i);
		li += "<li>" + i + "</li>";
		ul.innerHTML = li;
	}
//------------------------------------------------Put all elems of array in list largest to smallest
		console.log('first'+arr)
		arr.sort(function(a, b){return b-a});
		console.log('second'+arr)
		$( '#list-from-array' )
    	.html( '<li>' + arr.join( '</li><li>' ) + '</li>' );
}
//------------------------------------------------------Min elem----------
var arr = [14, 58, 20, 77, 66, 82, 42, 67, 42];
var min = Math.min.apply(Math, arr);
console.log(min)
//------------------------------------------------------Max elem----------
var arr = [14, 58, 20, 77, 66, 82, 42, 67, 42];
var max = Math.max.apply(Math, arr);
console.log(max)

//------------------------------------------------------Min elem loop----------
var n = [43,54,23,32,56,67,5,3,4,778,678,456,456];
var min = Math.min.apply(Math, n);
console.log(min)
var minarr = Infinity;
for (var i = 0; i < n.length; i++) {
	if (n[i] < minarr) {
		minarr = n[i];
	}
}
console.log(minarr)


//------------------------------------------------------Max elem loop----------
var num = [1, 2, 101, 45, 55, 1443];
var max = -Infinity;
var i;
for (i = 0; i < num.length; i++) {

    if (num[i] > max) {

        max = num[i];

    }

}
console.info(max);


//-------------------------------------All ex----------------
function Car(make,model, year, color){
	this.make = make;
	this.model = model;
	this.year = year;
	this.color = color;
};

var cars = [
	
	new Car("Lada", "Niva", 1990, "white"),
	new Car("Audi", "Q7", 2002, "black"),
	new Car("Audi", "A3", 2004, "gray"),
	new Car("Audi", "S4", 2006, "white"),
	new Car("BMW", "M3", 2003, "black"),
	new Car("BMW", "320", 2008, "red"),
	new Car("Opel", "Corsa", 2010, "white"),
	new Car("VW", "Passat", 2012, "black"),
	new Car("VW", "Polo", 2013, "blue")
];

console.log(cars)
//--------------------------------------------------All cars with make Audi---------
for (var i = 0; i < cars.length; i++) {
	
	if (cars[i].make == "Audi") {
		console.log(cars[i])	
	}

};

var sum = 0;
var average = 0;
//--------------------------------------------------All cars averrage years---------
for (var i = 0; i < cars.length; i++) {

	sum += cars[i].year;

};
console.log(sum)

average = sum / cars.length;

console.log(average);
//--------------------------------------------------Put all makes in new array---------
var make = [];

for (var i = 0; i < cars.length; i++) {
	make.push(cars[i].make)
}
console.log(make)

var makeList = document.getElementById("make");
var makeInput = document.getElementById("makelist");

//--------------------------------------------------On click show list with all makes and sort it---------
makeInput.addEventListener("click", makeUl);

function makeUl(event){
	event.preventDefault();

	var li = "";
	make.sort();
	for (var i = 0; i < make.length; i++) {

		li += "<li>" + make[i] + "</li>";
	}

	makelist.innerHTML = li;
};
//--------------------------------------------------Array with all models-----------------------

model = [];


for (var i = 0; i < cars.length; i++) {
	
	model.push(cars[i].model);
}

var modelInput = document.getElementById("modellist");
var modelList = document.getElementById("model");


modelInput.addEventListener("click", modelDisplay);

function modelDisplay(event){

	event.preventDefault();
	var li = "";
	model.sort();
	for (var i = 0; i < model.length; i++) {

		li += "<li>" + model[i] + "</li>";
	}

	modelList.innerHTML = li;

}
//-----------------------------------------------------All Makes and Models in table




