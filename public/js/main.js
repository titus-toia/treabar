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
  }, {
    active: function(ev, pos) {
      setTimeout(function() {
        $frame.find('.slidee > li > div.manager-project').css('border-width', '2px');
        var $project = $frame.find('.slidee > li:nth(' + pos + ') > div.manager-project');
        var $bridge = $('#bridge');

        $project.css('border-width', '2px 2px 0px 2px');
        var offset = $project.position();
        $bridge[0].style.top = (offset.top + $project.outerHeight() + 5) + 'px';
        $bridge[0].style.left = offset.left + 'px';
        $bridge.show(200);
      }, 400);
    },
    moveStart: function(ev) {
      $frame.find('.slidee > li > div.manager-project').css('border-width', '2px');
      $('#bridge').hide();
    }
  });
});