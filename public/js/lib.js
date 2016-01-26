//User dropdown functionality
$(document).on('click', '.f-dropdown.treabar-control li', function() {
  var $this = $(this),
    id = $this.data('id'),
    parent = $this.closest('.f-dropdown'),
    data_field = $this.closest('form').find('input[name=' + parent.data('field') + ']'),
    contents = $this.children().first().html();

  data_field.val(id);
  parent.prev().html(contents);
  $this.closest('.f-dropdown').removeClass('open').removeClass('f-open-dropdown');
});

function CloseSlider() {
  $('#slider').html('').hide('blind', { direction: 'left', duration: 400});
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