//Task hierarchy browser plugin
(function($) {
  $.fn.faceter = function(settings) {
    return this.each(function () {
      var $elem = $(this);
      var _settings = $.extend($.fn.faceter.default, settings || {});
      var plugin = new Faceter(_settings, $elem);
      plugin.init();
    });
  };
  $.fn.faceter.default = {};

  function Faceter(settings, $elem) {
    this.settings = settings;
    this.$elem = $elem;
    this.$control = $elem.find('.facets-control');
    this.$facets = $elem.find('.facets:first');
    this.open = false;

    return this;
  }

  Faceter.prototype.init = function() {
    var self = this;
    var $head = this.$elem.find('div.head');

    $head.on('click', function() {
      !self.open? self.openTopLevel(): self.close();
    });

    this.$elem.on('click', '.facet .name', function() {
      self.select($(this).closest('.facet'));
    });
    this.$elem.on('click', '.handle-prev i', function() {
      var parent_id = $(this).closest('.facet').data('parent-id'),
        $siblingFacets = $(this).closest('.faceter').find('.facets[data-parent-id=' + parent_id + ']'),
        $parentFacets = $siblingFacets.closest('.facet').closest('.facets');
      self.openFacets($parentFacets);
    });
    this.$elem.on('click', '.handle-next i', function() {
      var id = $(this).closest('.facet').data('id'),
        $facet = $(this).closest('.faceter').find('.facet[data-id=' + id + ']'),
        $childFacets = $facet.find('.children');
      self.openFacets($childFacets);
    });

  };

  Faceter.prototype.openTopLevel = function() {
    var $facets = this.$elem.find('div.facets:first');
    this.openFacets($facets);
  };
  Faceter.prototype.openFacets = function(facets) {
    this.$control.html(facets.html());
    this.$control.show();
    this.open = true;
  };
  Faceter.prototype.close = function() {
    this.$control.html('');
    this.$control.hide();
    this.open = false;
  };
  Faceter.prototype.select = function($item) {
    var name = $item.text();
    this.$elem.find('input[type=hidden]').val($item.data('id'));
    console.warn($item[0], $item.data('id'));
    this.$elem.find('.head .display').text(name);
    this.close();
  }

})(jQuery);

//Auto-update plugin
(function() {

})(jQuery);

//User dropdown functionality
$(document).on('click', '.f-dropdown.treabar-single-dropdown li', function() {
  var $this = $(this),
    id = $this.data('id'),
    parent = $this.closest('.f-dropdown'),
    data_field = $this.closest('form').find('input[name=' + parent.data('field') + ']'),
    contents = $this.children().first().html();

  data_field.val(id);
  parent.prev().html(contents);
  $this.closest('.f-dropdown').removeClass('open').removeClass('f-open-dropdown');
});

$(document).on('click', '.f-dropdown.treabar-multi-dropdown li', function() {
  var $this = $(this),
    parent = $this.closest('.f-dropdown'),
    fields = $this.closest('form').find('#' + parent.data('container')),
    contents = $this.children().first().clone();

  var $input = contents.find('input');
  $input.removeAttr('disabled');
  if(!fields.find('input[value=' + $input.val() + ']').length) {
    fields.append(contents);
  }
  $this.closest('.f-dropdown').removeClass('open').removeClass('f-open-dropdown');
});

//


function CloseSlider() {
  $('#slider').html('').hide('blind', { direction: 'right', duration: 400});
}

function DefaultSly($frame, $scrollbar) {
  var events = {};

  //Dynamic update for this slider
  if($frame.hasClass('update')) {
    events.moveEnd = function(ev) {
      var pos = this.pos;
      if(pos.cur != pos.end) return; //We are at the bottom, start loading

      $.get($frame.data('url'), {
        created: $frame.data('before')
      }, function(html) {
        var created = $(html).last().data('created');
        $frame.data('before', created);
        $frame.find('.slidee').append(html);
        $frame.sly('reload');
      });
    };

    $frame[0].fetch = function() {
      $.get($frame.data('url'), {
        created: $frame.data('after'),
        direction: 'after'
      }, function(html) {
        var created = $(html).first().data('created');
        $frame.data('after', created);
        $frame.find('.slidee').prepend(html);
        $frame.sly('reload');
      });
    }
  }

  $frame.sly({
    speed: 300,
    easing: 'linear',
    scrollBar: $scrollbar,
    scrollBy: 100,
    dragHandle: 1,
    dynamicHandle: 1,
    clickBar: 1
  }, events);
}

//Ajax link functionality
function AjaxHandler(self) {console.log('here');
  var url = self.data('url'),
    method = self.data('method') || 'get',
    payload = self.data('payload') || { _method: method },
    display = self.data('display') || 'console',
    $slider = $('#slider');

  if(display == 'slider') {
    $slider.html('').addClass('loading');
    $slider.is(':hidden') && $slider.show('blind', { direction: 'left', duration: 400});
  } else if(display) {
    //$(display).html('').addClass('loading');
  }

  $.ajax(url, {
    data: payload,
    type: method,
    success: function (response) {
      if(display == 'slider') {
        $slider.html(response);
        $slider.removeClass('loading');
      } else {
        console.log(response);
      }
      $(document).foundation('dropdown', 'reflow');
    },
    error: function(response) {

    }
  });
}

$(document).on('click', '[data-ajax-interact]', function() {
  var self = $(this),
    confirm_msg = self.data('confirm');
  if(confirm_msg) {
    if(confirm(confirm_msg)) {
      AjaxHandler(self);
    }
  } else if(!confirm_msg) {
    AjaxHandler(self);
  }

  return false;
});

$(document).on('click', '#slider .form-buttons .submit', function() {
  var url = $(this).data('url');
  var $form = $(this).closest('form');
  $.post(url || $form.attr('action'), $form.serialize(), function() {
    if(!$form.data('dont-close')) CloseSlider();

    if($form.data('submit') == 'refresh') {
      $(window).trigger('hashchange');
    } else if($form.data('submit') == 'sly') {
      if($form.data('sly')) {
        $($form.data('sly'))[0].fetch();
      } else {
        $form.find('.vertical-feed-wrapper')[0].fetch();
      }
    }
  });
});

$(document).on('click', '#slider .form-buttons .cancel', function() {
  CloseSlider();
});