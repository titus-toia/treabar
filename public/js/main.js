/* Hashbang code */
$(function() {
  $(window).on('hashchange', function() {
    var hash = location.hash;
    $('#manager-tabs').find('div').removeClass('selected');
    $('#manager-tabs').find('a').each(function() {
      if($(this).attr('href') === hash) $(this).parent().addClass('selected');
    });

    LoadManagerPage(hash.substr(1));
  });

  $(window).trigger('hashchange');
});

state = {
};

var onLoad = {
  projects: LoadProjectsPage
};

var $body = $('body');
$body.on('click', '#page-state-button', function() {
  LoadManagerPage('projects');
});

/* Manager navigation */
function LoadManagerPage(page) {
  page = page || 'projects';
  $('#manage').addClass('loading');
  $('#manager-page').hide();

  var url;
  if(page != 'projects')
    url = [BASE_URL, 'manage', state.id || 1, page].join('/');
  else
    url = [BASE_URL, 'manage', page].join('/');

  $.get(url, function (data) {
    var $pstate = $('#page-state-button');
    if(page != 'projects') {
      $pstate.attr('class', state.color).show(200);
      $pstate.find('a').text(state.project_name + ' - ' + $.camelCase('-' + page))
    } else {
      $pstate.hide(200);
    }

    $('#manager-page').html(data).show();
    $('#manage').removeClass('loading');

    onLoad[page] && onLoad[page]();
  });
}

/* Project page */
function LoadProjectsPage() {
  var $frame = $('#manager-projects-list-wrapper');
  var $scrollbar = $frame.parent().find('.scrollbar');
  var deselect = function() {
    $frame.find('.slidee > li > div.manager-project').css('border-width', '2px');
    $frame.find('.slidee > li.active').removeClass('active');
    $('#bridge').hide();
  };

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

      //Update state
      state.id = id;
      state.color = $project.find('.banner').data('color');
      state.project_name = $project.find('.name').text();

      //Select upper box and position bridge
      setTimeout(function() {
        $project.css('border-width', '2px 2px 0px 2px');
        var offset = $project.position();
        $bridge[0].style.top = (offset.top + $project.outerHeight() + 5) + 'px';
        $bridge[0].style.left = offset.left + 'px';
        $bridge.show(200);
      }, 400);

      //Select lower box
      $('.project-listing').hide();
      $('.project-listing[data-id=' + id + ']').show(300);
    },
    moveStart: function(ev) {
      deselect();
    }
  });
}

/* Tasks page */
$body.on('click', '.task:not(.new) .title', function() {
  var $task = $(this).closest('.task');
  if($task.hasClass('active')) return;

  $('.task.active .content').hide('blind', { duration: 350, queue: false});
  $('.task.active').removeClass('active');
  $task.addClass('active');
  //$task.find('.content').show(100);
  $task.find('.content').show('blind', { duration: 350, queue: false});
});

$body.on('click', '.task .title a.edit, .task.new .title', function() {
  LoadSlider($(this).data('ajax'));
  return false;
});

function LoadSlider(url) {
  $slider = $('#slider');
  $slider.html('').addClass('loading');
  if($slider.is(':hidden')) $slider.show('blind', { direction: 'left', duration: 400});

  $.get(url, function (data) {
    $slider.html(data);
    $slider.removeClass('loading');
  });
}
function CloseSlider() {
  $('#slider').html('').hide('blind', { direction: 'left', duration: 400});
}

$body.on('click', '#slider .form-buttons .submit', function() {
  var $form = $(this).closest('form');
  $.post($form.attr('action'), $form.serialize(), function() {
    CloseSlider();
  });
});

$body.on('click', '#slider .form-buttons .cancel', function() {
  CloseSlider();
});