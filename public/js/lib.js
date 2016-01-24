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