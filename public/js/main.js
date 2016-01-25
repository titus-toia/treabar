/* Hashbang code */
$(window).on('hashchange', function() {
  var hash = location.hash;
  $('#manager-tabs').find('div').removeClass('selected');
  $('#manager-tabs').find('a').each(function() {
    if($(this).attr('href') === hash) $(this).parent().addClass('selected');
  });

  LoadManagerPage(hash.substr(1));
});

$(function() {
  $(window).trigger('hashchange');
});

var onLoad = {
  projects: LoadProjectsPage,
  tasks: LoadTasksPage
};

var $body = $('body');
$body.on('click', '#page-state-button', function() {
  LoadManagerPage('projects');
});

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

/* Slider */
function SummonSlider(url, data) {
  data = data || {}
  $slider = $('#slider');
  $slider.html('').addClass('loading');
  if($slider.is(':hidden')) $slider.show('blind', { direction: 'left', duration: 400});

  $.get(url, data, function (html) {
    $slider.html(html);
    $(document).foundation('dropdown', 'reflow');
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

/* Tasks page */
function LoadTasksPage() {
  jsPlumb.setContainer($('#manager-page'));
}

function ShowChildren(parent_id) {
  var $tasks = $('.task[data-id=' + parent_id + ']').closest('.tasks'),
    $next_level = $tasks.next('.tasks'),
    $children = $next_level.find('.task[data-parent-id=' + parent_id  + ']');

  //Hide everything else
  $tasks.nextAll().find('> *').hide();

  if($children.length > 0) {
    $children.show();
    $next_level.find('.task.new').attr('data-parent-id', parent_id).show();
  } else {
    console.log(parent_id)
    $next_level.find('.callout').attr('data-parent-id', parent_id).show(300);
  }
}

function SelectTask(id) {
  var $task = $('.task[data-id=' + id + ']'),
    $tasks = $task.closest('.tasks'), //Current stack
    $previousTasks = $('.tasks.active'); //Previous stack
  if($task.hasClass('active')) return;

  $previousTasks.removeClass('active');
  $tasks.addClass('active');
  $tasks.find('.task.active .content').hide('blind', { duration: 350, queue: false });
  $tasks.find('.task.active').removeClass('active');
  $tasks.nextAll().find('.task.active .content').hide();
  $tasks.nextAll().find('.task.active').removeClass('active');
  $task.addClass('active');
  $task.find('.content').show('blind', { duration: 350, queue: false });

  if($tasks.prevAll().index($previousTasks) === -1) jsPlumb.detachEveryConnection();
  var $parent = $('.task[data-id=' + $task.data('parent-id') + ']');
  if($parent.length > 0) {
    setTimeout(function () {
      jsPlumb.connect({
        source: $parent.find('.title'),
        target: $task.find('.title')
      });
    }, 355);
  }

  ShowChildren(id);
}

$body.on('click', '.task:not(.new) .title', function() {
  var id = $(this).closest('.task').data('id');
  SelectTask(id);
});

$body.on('click','.task .title a.edit, .task .title a.comments, ' +
  '.task.new .title, .tasks .callout.new ', function() {
  var data;
  if($(this).hasClass('new')) { //Callout
    data = { parent_id: $(this).data('parent-id') };
  } else if($(this).closest('.task').hasClass('new')) { //'New task'
    data = { parent_id: $(this).closest('.task').data('parent-id') };
  }

  SummonSlider($(this).data('ajax'), data);
  return false;
});