(function ($) {
    
    $(document).on('submit', 'form.favoriteForm', function(e) {
        //Stop default form behavior 
        e.preventDefault();

        // //Log

        //Get form data 
        const formData = $(this).serialize();

        //Ajax request 
        $.ajax(
            'http://localhost/public/ajax/room_favorite.php',
            {
                type:"POST",
                dataType: "json",
                data: formData
            }).done(function(result) {
                if (result.status) {
                    $('input[name=is_favorite]').val(result.is_favorite ? 1 : 0);
                } else {
                    console.log('error');
                    $('.heart').toggleClass('selected' , !result.is_favorite);
                }
            });
    });

    $(document).on('submit', 'form.reviewForm', function(e) {
        //Stop default form behavior 
        e.preventDefault();

        //Get form data 
        const formData = $(this).serialize();

        //Ajax request 
        $.ajax(
            'http://localhost/public/ajax/room_review.php',
            {
                type:"POST",
                dataType: "html",
                data: formData
            }).done(function(result) {
                //To disable the form when button is pressed many times 
                $('form.reviewForm input, form.reviewForm textarea, form.reviewForm button').attr('disabled', true);

                //Append review to list
                $('#room-reviews-container').append(result);

                //Reset review form 
                $('form.reviewForm').trigger('reset');
                
            }).error(function(result) {
            }).always(function(result) {
                //to enable the form always with result ... 
                $('form.reviewForm input, form.reviewForm textarea, form.reviewForm button').attr('disabled', false);
            });  
    });

}) (jQuery);