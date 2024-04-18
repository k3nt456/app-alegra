/* Pantalla de carga y manejo de error */
$(document).ready(function () {
    function showLoading() {
        $('.overlay').fadeIn();
        $('.loading-message').fadeIn();
    }

    function hideLoading() {
        $('.overlay').fadeOut();
        $('.loading-message').fadeOut();
    }

    function showError(message) {
        $('#error-message').text(message).fadeIn();
        setTimeout(function () {
            $('#error-message').fadeOut();
        }, 4000);
    }

    $('form').submit(function (event) {
        event.preventDefault();
        showLoading();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                hideLoading();
                $('#error-message').removeClass('bg-danger').addClass('bg-success').find('.toast-body').text('¡Listo! Disfrute de su comida 🧑‍🍳').end().fadeIn();
                setTimeout(function () {
                    $('#error-message').fadeOut();
                }, 4000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                hideLoading();
                showError(jqXHR.responseJSON.data.message);
            }
        });
    });

     $('#error-message .btn-close').click(function () {
        $('#error-message').fadeOut();
    });
});
