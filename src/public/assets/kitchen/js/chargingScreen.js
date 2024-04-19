/* Pantalla de carga y manejo de error */
$(document).ready(function () {

    // Funciones para mostrar, ocultar y manejar errores
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

    // Array para almacenar los IDs de las recetas
    var recipeIds = [];

    // Evento de envío para el formulario GET
    $('form').submit(function (event) {
        event.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                showLoading();
                var recipeList = $('.recipe-list');
                recipeList.empty();
                $.each(response.data.detail, function (index, recipe) {
                    recipeList.append('<li>' + recipe.name + '</li>');
                    // Agregar el ID de la receta al array
                    recipeIds.push(recipe.id);
                });

                // Configura los IDs de las recetas en el campo oculto del formulario POST
                $('#recipes-input').val(recipeIds.join(','));

                // Envía el formulario POST
                $('#order-form').submit();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // showError(jqXHR.responseJSON.data.message);
            }
        });
    });

    // Evento de envío para el formulario POST
    $('#order-form').submit(function (event) {
        event.preventDefault();

        // Convertir el valor del campo oculto en un array de IDs
        var recipesArray = $('#recipes-input').val().split(',');

        $.ajax({
            type: 'POST',
            url: kitchenOrdersRoute,
            data: {
                _token: $('input[name="_token"]').val(),
                recipes: recipesArray
            },
            success: function (response) {
                // Ocultar la pantalla de carga y mostrar mensaje de éxito
                hideLoading();
                $('#error-message').removeClass('bg-danger').addClass('bg-success').find('.toast-body').text('¡Listo! Disfrute de su comida 🧑‍🍳').end().fadeIn();
                setTimeout(function () {
                    $('#error-message').fadeOut();
                }, 4000);
                // Limpiar el array de IDs de recetas
                recipeIds = [];
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Limpiar el array de IDs de recetas
                recipeIds = [];
                // Ocultar la pantalla de carga y mostrar mensaje de error
                hideLoading();
                // showError(jqXHR.responseJSON.data.message);
            }
        });
    });

    // Evento de clic para cerrar el mensaje de error
    $('#error-message .btn-close').click(function () {
        $('#error-message').fadeOut();
    });
});
