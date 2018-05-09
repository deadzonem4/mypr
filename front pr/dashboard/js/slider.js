function Slider(){

var slider = document.querySelector('.slider-container');
	slides = document.querySelectorAll('.slider-container li');

for (var i = 0; i < slides.length; i ++){
	slides[i].classList.add('fade');
}

var prev = document.createElement('a');
	next = document.createElement('a');
	arrowLeft = document.createElement('i');
	arrowRight = document.createElement('i');

prev.classList.add('prev');
next.classList.add('next');
arrowLeft.classList.add('fa', 'fa-angle-left');
arrowRight.classList.add('fa', 'fa-angle-right');

slider.appendChild(next);
slider.appendChild(prev);
next.appendChild(arrowRight);
prev.appendChild(arrowLeft);

var i = 0;

function nextSlide() {
    i = i + 1;
    i = i % slides.length;
    return slides[i];
}

function prevSlide() {
    if (i === 0) {
        i = slides.length;
    }
    i = i - 1;
    return slides[i];
}

window.addEventListener('load', function () {
    slider.appendChild(slides[0]);

    prev.addEventListener(
        'click',
        function () {
            slider.appendChild(prevSlide());
        }
    );
    
    next.addEventListener('click', 
        function () {
            slider.appendChild(nextSlide());
        }
    );
});

}
Slider();