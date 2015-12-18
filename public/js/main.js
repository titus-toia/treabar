state = {
};

$('body').on('click', '#manager-tabs div', function() {
  $('#manager-tabs div').removeClass('selected');
  $(this).addClass('selected');

  var page = $(this).find('a').attr('href').substr(1);
  $('#manager-projects').hide();
  $('#manager-page').hide();
  $('#manage').addClass('loading');
  $.get(BASE_URL + '/manage/' + state.id + '/' + page, function (data) {
    $('#manager-page').html(data);
    $('#manager-page').show();
    $('#manage').removeClass('loading');
  });
});



var $frame = $('#manager-projects-list-wrapper');
var $scrollbar = $frame.parent().find('.scrollbar');
function deselect() {
  $frame.find('.slidee > li > div.manager-project').css('border-width', '2px');
  $frame.find('.slidee > li.active').removeClass('active');
  $('#bridge').hide();
}

$(document).ready(function() {


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
      deselect();
      var $project = $frame.find('.slidee > li:nth(' + pos + ') > div.manager-project');
      var $bridge = $('#bridge');
      var id = $project.data('id');
      state.id = id;

      //Select upper box and position bridge
      setTimeout(function() {
        $project.css('border-width', '2px 2px 0px 2px');
        var offset = $project.position();
        $bridge[0].style.top = (offset.top + $project.outerHeight() + 5) + 'px';
        $bridge[0].style.left = offset.left + 'px';
        $bridge.show(200);
      }, 400);

      //Select lower box
      $('.current-project-listing').hide();
      $('.current-project-listing[data-id=' + id + ']').show(300);
    },
    moveStart: function(ev) {
      deselect();
    }
  });
});

