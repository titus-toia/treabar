$('body').on('click', '#manager-tabs div', function() {
  $('#manager-tabs div').removeClass('selected');
  $(this).addClass('selected');
});