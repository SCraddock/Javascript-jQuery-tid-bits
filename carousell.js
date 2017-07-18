$(document).ready(function() {

  setInterval(function(){ // every 6 seconds run this

  var currentSlide = $('.activeslide'); // the active slide
  var nextSlide = $('.activeslide').next(); // the next sibling of active
  var nextSlideLength = $('.activeslide').next().length;

  if(nextSlideLength != 1){ // if there is no next slide!
    nextSlide = $('#slide1'); // set as start slide
  };

  // transition
  currentSlide.removeClass('activeslide'); 
  nextSlide.addClass('activeslide');

  }, 6000);

});
