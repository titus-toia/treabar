$('body').on('click', '#manager-tabs div', function() {
  $('#manager-tabs div').removeClass('selected');
  $(this).addClass('selected');
});


$(document).ready(function() {
  var $frame = $('#manager-projects-list-wrapper');
  var $scrollbar = $frame.parent().find('.scrollbar');

  $frame.sly({
    horizontal: 1,
    itemNav: 'centered',
    smart: 1,
    activateOn: 'click',
    mouseDragging: 1,
    touchDragging: 1,
    releaseSwing: 1,
    startAt: 0,
    scrollBar: $scrollbar,
    scrollBy: 1,
    speed: 300,
    elasticBounds: true,
    easing: 'linear',
    dragHandle: 1,
    dynamicHandle: 1,
    clickBar: 1

    // Buttons
    //prev: $wrap.find('.prev'),
    //next: $wrap.find('.next')
  });
});