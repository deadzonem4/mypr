 function autoHeight() {
   $('#content').css('min-height', 0);
   $('#content').css('min-height', (
     $(document).height() 
     - $('#header').height() 
     - $('#footer').height()
   ));
 }

 // onDocumentReady function bind
 $(document).ready(function() {
   autoHeight();
 });

 // onResize bind of the function
 $(window).resize(function() {
   autoHeight();
 });


/*function stickyFooter() {
    // Footer element declaration
    var footerElement = document.querySelector('#footer'),
        headerElement = document.querySelector('#header'),
        contentElement = document.querySelector('#content'),
        windowHeight = window.innerHeight;

    var elementSize = function (el) {
        console.log(el);
        return el.scrollHeight;
    };

    var footerHeight = elementSize(footerElement),
        headerHeight = elementSize(headerElement),
        contentHeight = elementSize(contentElement);

    if (windowHeight > footerHeight + headerHeight + contentHeight) {
        footerElement.style.position = "absolute";
        footerElement.style.bottom = 0;
    }
    else {
        footerElement.style.position = "relative";
        footerElement.style.bottom = 0;
    }
}


document.addEventListener('DOMContentLoaded', function () {
    //noinspection BadExpressionStatementJS
    stickyFooter();
});

document.addEventListener('resize',stickyFooter,false); */