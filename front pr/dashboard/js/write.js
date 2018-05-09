function WriteTest(){
	var Elements = {
		originalText: document.querySelector(config.component).innerHTML,
		timer: document.querySelector("#timer"),
		reset: document.querySelector("#reset-test"),
		textArea: document.querySelector("#entered-text"),
		time: 0,
		interval
	};

	function start(){
		var textLength = textArea.value.length;
		if (textLength === 0) {
			interval = setInterval(runTimer, 10);
		}
	};

	function runTimer(){
		timer.innerHTML = "Your time is: " + time;
		time++; 
	};

	function stopTimer(){
		clearInterval(interval);
		textArea.style.cssText = "border: solid 1px #46c146;";
	};

	function spellCheck(){
		var textEntered =  textArea.value;
		if (textEntered == originalText) {
			stopTimer();
		}
	};

	function resetTimer(e){
		e.preventDefault();
		
	};

	function Events(){
		textArea.addEventListener("keypress", start);
		textArea.addEventListener("keyup", spellCheck);
		reset.addEventListener("click", resetTimer);
	};

	return {
		run: function(){
			Events();
		}
	};
};
WriteTest.run();

var typeSpeedTester = TypeSpeedTester({
	component: '#entered-text',
	timer: {
		component: '#timer',
		template: '<div>{timer}</div>',
	},
	text: 'Enter this, here',
});

typeSpeedTester.run();
typeSpeedTester.reset();

function TypeSpeedTester(config){
	var cuurentConfig = Object.assign({
		component: 'body',
		timer: {
			component: 'body',
			template: '<div>{timer}</div>'
		},
		text: '',
	}, config);

	return {
		run: function(){

		},
		reset: function(){

		}
	};
}