(function ($) {
    $popIn = $('#pop-in');

    $popIn.on('click', '.mask', function(event) {
        if (event.target == this) {
            $('#pop-in').hide();
        }
    });

    $popIn.on('click', '.close-on-click', function(event) {
        if (event.target == this) {
            $('#pop-in').hide();
        }
    });
})(jQuery);