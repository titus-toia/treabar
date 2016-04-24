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
      self.select($(this));
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
    this.$elem.find('.head .display').text(name);
    this.close();
  }

})(jQuery);

//Auto-update plugin
(function() {

})(jQuery);

//User dropdown functionality
$(document).on('click', '.f-dropdown.treabar-control li', function() {
  var $this = $(this),
    id = $this.data('id'),
    parent = $this.closest('.f-dropdown'),
    data_field = $this.closest('form').find('input[name=' + parent.data('field') + ']'),
    contents = $this.children().first().html();
  console.warn(contents);

  data_field.val(id);
  parent.prev().html(contents);
  $this.closest('.f-dropdown').removeClass('open').removeClass('f-open-dropdown');
});

function CloseSlider() {
  $('#slider').html('').hide('blind', { direction: 'left', duration: 400});
}

function DefaultSly($frame, $scrollbar) {
  $frame.sly({
    speed: 300,
    easing: 'linear',
    scrollBar: $scrollbar,
    scrollBy: 100,
    dragHandle: 1,
    dynamicHandle: 1,
    clickBar: 1
  });
}

//Ajax link functionality
function AjaxHandler(self) {
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
  var $form = $(this).closest('form');
  $.post($form.attr('action'), $form.serialize(), function() {
    CloseSlider();
  });
});

$(document).on('click', '#slider .form-buttons .cancel', function() {
  CloseSlider();
});