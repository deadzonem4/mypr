$(".button").on('click', function(){
     window.location = "#";    
});

(function tableOne(){
	var list = document.querySelectorAll('#table-one li strong');

	function addClass(){
		for (var i = 0; i < list.length; i++) {
			list[i].classList.remove("active");
			this.classList.add("active");
		}
	};

	for (var i = 0; i < list.length; i++) {
		list[i].addEventListener("click", addClass);
	};
})();


(function tableTwo(){
	var list = document.querySelectorAll('#table-two li strong');

	function addClass(){
		for (var i = 0; i < list.length; i++) {
			list[i].classList.remove("active");
			this.classList.add("active");
		}
	};

	for (var i = 0; i < list.length; i++) {
		list[i].addEventListener("click", addClass);
	};
})();

(function tableThree(){
	var list = document.querySelectorAll('#table-three li strong');

	function addClass(){
		for (var i = 0; i < list.length; i++) {
			list[i].classList.remove("active");
			this.classList.add("active");
		}
	};
	for (var i = 0; i < list.length; i++) {
		list[i].addEventListener("click", addClass);
	};
})();

(function tableFour(){
	var list = document.querySelectorAll('#table-four li strong');

	function addClass(){
		for (var i = 0; i < list.length; i++) {
			list[i].classList.remove("active");
			this.classList.add("active");
		}
	};

	for (var i = 0; i < list.length; i++) {
		list[i].addEventListener("click", addClass);
	};
})();

function defaultEnter(){
	
	var enter = document.querySelector('input[name="entered"]').defaultValue = "10";
	var fullArea = document.querySelector('main');
	fullArea.addEventListener('click', multiplication);
	multiplication();
	function multiplication(){
		var result = document.querySelector('#result');
		var choosen = document.querySelectorAll(".active");
		var sum = 1; 
		for (var i = 0; i < choosen.length; i++) {
				var odd = parseFloat(choosen[i].innerHTML);
				sum *= odd;
			}


	var enter = document.querySelector('input[name="entered"]').value;
	result.innerHTML = (enter * sum).toFixed(2) + "лв";	


	};
}
defaultEnter();