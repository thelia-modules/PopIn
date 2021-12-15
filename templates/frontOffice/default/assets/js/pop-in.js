(function ($) {
  $popIn = $('#pop-in');

  $popIn.on('click', '.mask', function ({ target, currentTarget }) {
    if (target == this) {
      $.ajax({
        type: 'POST',
        url: `/popin/${currentTarget.dataset.popinId}/dismiss`,
      });
      $('#pop-in').hide();
    }
  });

  $popIn.on('click', '.close-on-click', function ({ target, currentTarget }) {
    if (target == this) {
      $.ajax({
        type: 'POST',
        url: `/popin/${currentTarget.dataset.popinId}/dismiss`,
      });
      $('#pop-in').hide();
    }
  });
})(jQuery);
