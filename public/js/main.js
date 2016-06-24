/* Hashbang code */
$(window).on('hashchange', function() {
  var hash = location.hash;
  if(page == 'manager') {
    LoadManagerPage(hash.substr(1));
  }
  if(page == 'dashboard') {
    LoadDashboard();
  }
});

$(function() {
  $(window).trigger('hashchange');
});

var onLoad = {
  projects: LoadProjectsPage,
  tasks: LoadTasksPage,
  timesheet: LoadTimesheetPage,
  chart: LoadChartPage,
  feed: LoadFeedPage
};

var $body = $('body');
$body.on('click', '#page-state-button', function() {
  if(page == 'manager') {
    LoadManagerPage('projects');
  }
});

var $manager_page = $('#manager-page');
$('#manager-tabs')
  .find('> div').click(function() {
    $(this).find('a')[0].click();
    if($(this).hasClass('selected')) { //Simply clicking doesn't work, we have to trigger hashchange
      $(window).trigger('hashchange');
    }
  }).end()
  .find('> div a').click(function(e) {
    e.stopPropagation();
  }).end()
  .find('div').removeClass('selected').end()
  .find('a').each(function () {
    if($(this).attr('href') === '#' + page) $(this).parent().addClass('selected');
  }).end();

function LoadDashboard() {
  var tabScroll = function($tab) {
    var $content = $($tab.find('a').attr('href'));
    var $frame = $content.find('.vertical-feed-wrapper');
    var $scrollbar = $frame.parent().find('.scrollbar');

    DefaultSly($frame, $scrollbar);
  };

  $('.tabs').on('toggled', function(e, tab) {
    tabScroll($(tab));
  });
  tabScroll($('.tabs .tab-title.active'));

  //Dashboard projects
  $('.tasks-list-wrapper').each(function() {
    var $frame = $(this);
    var $scrollbar = $frame.parent().find('.scrollbar');

    var first = true;
    $frame.sly({
      horizontal: 1,
      itemNav: 'centered',
      smart: 1,
      activateOn: 'click',
      mouseDragging: 1,
      touchDragging: 1,
      releaseSwing: 1,
      startAt: 0,
      scrollBy: 1,
      speed: 300,
      elasticBounds: true,
      easing: 'linear',
      dragHandle: 1,
      dynamicHandle: 1,
      clickBar: 1
    });
  });

  //Cannot rely on sly.js event here.
  $('.dashboard-project').on('click', 'li .task', function() {
    var $task = $(this),
      $frame = $task.closest('.frame'),
      $project = $frame.closest('.dashboard-project'),
      $overview = $frame.parent().siblings('.overview');

    $task.siblings('.active').removeClass('active');
    if(!$task.hasClass('active')) {
      $frame.find('.task').removeClass('active');
      $task.addClass('active');

      state.change({
        id: $project.data('id'),
        color: $project.find('.banner').data('color'),
        project_name: $project.find('.header .name').text(),
        task_id: $task.data('id')
      });

      $overview.slideUp(100);
      $overview.find('.task').hide();
      $overview.find('.task[data-id=' + $task.data('id') + ']').show();
      $overview.slideDown(300);
    } else {
      $task.removeClass('active');
      $overview.slideUp(100);
    }
  });

  //Task/notif filter
  var $filter = $('.filter');
  var $bars = $filter.find('.project-bar');
  var $picker = $('.project-picker');
  $filter.click(function() {
    if(!$picker.is(':visible')) { //Hide irrelevant pickers
      $picker.find('.project-label').each(function() {
        var $this = $(this);
        $this.show();
        var project_id = $this.data('id');
        var $notifs = $('#notifications').find('div[data-project-id][data-project-id=' + project_id + ']');
        if($notifs.length == 0) {
          $this.hide();
        }
      });
    }
    $picker.slideToggle(175);
    return false;
  });

  $('.project-picker .project-label').click(function() {
    var $this = $(this);
    var project_id = $this.data('id');
    $picker.slideUp(175);

    $bars.addClass('hide');
    if(!$this.hasClass('active')) {
      $this.addClass('active');
      $bars.filter('[data-id=' + project_id + ']').removeClass('hide');
      $filter.addClass('filtered');
      FilterNotifications(project_id);
    } else {
      $this.removeClass('active');
      $filter.removeClass('filtered');
      FilterNotifications();
    }
  });
}

function FilterNotifications(project_id) {
  var $notifications = $('#notifications');
  $notifications.find('[data-project-id]').show();
  $('style.notifications').remove();
  if (project_id) {
    var selector = '#notifications div[data-project-id][data-project-id!=' + project_id + ']';
    $(selector).slideUp(100);
    $('body').append('<style>' + selector + '{ display: none; }</style>');
  }

  setTimeout(function() {
    $notifications.find('.vertical-feed-wrapper').sly('reload');
  }, 150);
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
      state.change({
        id: id,
        color: $project.find('.banner').data('color'),
        project_name: $project.find('.name').text()
      });

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
  $manager_page.hide();

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

    $manager_page.html(data).show();
    $('#manage').removeClass('loading');

    $('.custom-buttons').hide().css('visibility', 'hidden');
    $('.custom-buttons' + '.' + window.page + '-' + page).show().css('visibility', 'visible');

    jsPlumb.detachEveryConnection();
    jsPlumb.deleteEveryEndpoint();
    onLoad[page] && onLoad[page]();
  });
}

/* Tasks page */
function LoadTasksPage() {
  jsPlumb.importDefaults({
    PaintStyle:{
      strokeStyle: '#3794dd',
      fillStyle: '#3794dd',
      lineWidth: 4
    },
    Connector: ['Flowchart', { stub: 5 }],
    Endpoint: 'Blank',
    Anchor: [[1, 0.5, 1, 0, 2, 0], [0, 0.5, -1, 0, 2, 0]]
  });
  jsPlumb.setContainer($manager_page);

  //Show relevant task
  if(state.task_id) {
    var chain = [];
    chain.push(state.task_id);

    var parent_id = $('.task[data-id=' + state.task_id + ']').data('parent-id');
    while(parent_id) {
      chain.push(parent_id);
      var $parent = $('.task[data-id=' + parent_id + ']');
      parent_id = $parent.data('parent-id');
    }
    chain.reverse();

    for(var i = 0; i < chain.length; i++) {
      var $task = $('.task[data-id=' + chain[i] + ']');
      SelectTask(chain[i]);
    }
  }
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

function LoadChartPage() {
  $('.gantt .frame').sly({
    horizontal: 1,
    itemNav: 'basic',
    smart: 1,
    activateOn: 'click',
    mouseDragging: 1,
    touchDragging: 0,
    releaseSwing: 1,
    startAt: 0,
    scrollBar: $('.gantt .scrollbar'),
    scrollBy: 1,
    speed: 300,
    elasticBounds: true,
    easing: 'linear',
    dragHandle: 1,
    dynamicHandle: 1,
    clickBar: 1
  });

  jsPlumb.importDefaults({
    PaintStyle:{
      strokeStyle: '#7125a9',
      fillStyle: '#7125a9',
      lineWidth: 2
    },
    Connector: ['Flowchart', { stub: 5 }],
    Endpoint: 'Blank',
    MaxConnections: -1,
    Anchor: [[1, 0.5, 1, 0, 2, 0], [0, 0.5, -1, 0, 2, 0]]
  });
  jsPlumb.setContainer($('.gantt .slidee'));

  var PlaceTask = function(task, $task, $divisions, height, width) {
    $task = $task.clone().removeAttr('id');
    var $division;

    if(task.from && task.to) {
      $task.find('.date').text(task.from + ' - ' + task.to);
      $division = $divisions.filter('[data-date=' + task.from + ']');
    } else {
      $task.find('.date').text('No date specified.');
      $division = $divisions.first();
    }

    $task.css('top', height * task.level + 35)
      .css('left', $division.index() * 30)
      .css('width', task.span * width - 50)
      .find('.name').text(task.name).end()
      .appendTo('.gantt .slidee');
    $task.find('.slack')
      .css('width', width * task.slack).attr('data-slack', task.slack)
      .text('Slack: ' + task.slack + ' days');

    for(var i in task.slaves) {
      $child = PlaceTask(task.slaves[i], $task, $divisions, height, width);
      jsPlumb.connect({
        source: $task,
        target: $child
      });
    }

    return $task;
  };

  var $gantt = $('.gantt');
  var tasks = $gantt.data('tasks');
  var $divisions = $gantt.find('.division');

  var $pattern = $('#task-pattern').clone().removeAttr('id');
  var height = $('#task-pattern').outerHeight(true);
  var width = $divisions.width();

  for(var i in tasks) {
    var task = tasks[i];
    PlaceTask(task, $pattern, $divisions, height, width);
  }
}

/* Feed */
function LoadFeedPage() {
  var $frame = $('#feed-wrapper');
  var $scrollbar = $frame.parent().find('.scrollbar');

  DefaultSly($frame, $scrollbar);
  $scrollbar.addClass('large-offset-1'); //Sly deleted all other classes so we have to apply it manually
}