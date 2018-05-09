( function(){
	var elems = {
		main : document.querySelector("main"),
		ul : document.createElement("ul"),
		ulName : document.createTextNode("Click to List item to change color")
	};
	
	function createUl(){
		elems.main.appendChild(elems.ul)
		elems.ul.appendChild(elems.ulName);
		elems.ul.setAttribute("id", "my-list");
	};
	
	function addLists(){
		for (var i = 0; i < 10; i++) {
			var list = document.createElement("li");
			elems.ul.appendChild(list);
			list.setAttribute("class", "list-item");
			listText = document.createTextNode("This is list item")
			list.appendChild(listText);
		}
		return list;
	};

	function addClassEvent(){
		var allList = document.querySelectorAll("#my-list li");

		for (var i = 0; i < allList.length; i++) {
			allList[i].addEventListener("click", addClass);
		}
		return allList;
	};

	function addClass(){
		
		for (var i = 0; i < allList.length; i++) {
			allList[i].classList.remove("active");
			this.classList.add("active");
			
			if (allList[i].classList.contains("active")) {
				console.log(allList[i]);
			}
		};
	};

	createUl();
	var list = addLists();
	var allList = addClassEvent();
	
})();

function myMove() {
  var elem = document.getElementById("myAnimation");   
  var pos = 0;
  var id = setInterval(frame, 10);
  function frame() {
    if (pos == 350) {
      clearInterval(id);
    } else {
      pos++; 
      elem.style.top = pos + 'px'; 
      elem.style.left = pos + 'px'; 
    }
  }
}
