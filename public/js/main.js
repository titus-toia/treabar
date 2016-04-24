/* Hashbang code */
$(window).on('hashchange', function() {
  var hash = location.hash;
  if(page == 'manager') {
    $('#manager-tabs').find('div').removeClass('selected');
    $('#manager-tabs').find('a').each(function () {
      if ($(this).attr('href') === hash) $(this).parent().addClass('selected');
    });

    LoadManagerPage(hash.substr(1));
  }
});

$(function() {
  $(window).trigger('hashchange');

  var tabScroll = function($tab) {
    var $content = $($tab.find('a').attr('href'));
    var $frame = $content.find('.vertical-feed-wrapper');
    var $scrollbar = $frame.parent().find('.scrollbar');

    DefaultSly($frame, $scrollbar);
  };

  if(page == 'dashboard') {
    $('.tabs').on('toggled', function(e, tab) {
      tabScroll($(tab));
    });
    tabScroll($('.tabs .tab-title.active'));
  }
});

var onLoad = {
  projects: LoadProjectsPage,
  tasks: LoadTasksPage,
  timesheet: LoadTimesheetPage,
  feed: LoadFeedPage
};

var $body = $('body');
$body.on('click', '#page-state-button', function() {
  if(page == 'manager') {
    LoadManagerPage('projects');
  }
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
    if(page != 'projects') { //Show project name
      $pstate.attr('class', state.color).show(200);
      $pstate.find('a').text(state.project_name + ' - ' + $.camelCase('-' + page))
    } else {
      $pstate.hide(200);
    }

    $('#manager-page').html(data).show();
    $('#manage').removeClass('loading');

    $('.custom-buttons').hide().css('visibility', 'hidden');
    $('.custom-buttons' + '.' + window.page + '-' + page).show().css('visibility', 'visible');

    onLoad[page] && onLoad[page]();
  });
}

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
    $next_level.find('.task.new').attr('data-payload', JSON.stringify({ parent_id: parent_id })).show();
  } else {
    $next_level.find('.callout').attr('data-payload', JSON.stringify({ parent_id: parent_id })).show(300);
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

/* Timesheet */
function LoadTimesheetPage() {
  var $frame = $('#timesheet-wrapper');
  var $scrollbar = $frame.parent().find('.scrollbar');

  DefaultSly($frame, $scrollbar);
  $scrollbar.addClass('large-offset-1'); //Sly deleted all other classes so we have to apply it manually
}

/* Feed */
function LoadFeedPage() {
  var $frame = $('#feed-wrapper');
  var $scrollbar = $frame.parent().find('.scrollbar');

  DefaultSly($frame, $scrollbar);
  $scrollbar.addClass('large-offset-1'); //Sly deleted all other classes so we have to apply it manually
}