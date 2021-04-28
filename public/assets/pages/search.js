(function ($) {
    $(document).on('submit', 'form.searchForm', function(e) {
        //Stop default form behavior 
        e.preventDefault();

        // //Log

        //Get form data 
        const formData = $(this).serialize();

        //Ajax request 
        $.ajax(
            'http://localhost/public/ajax/search_results.php',
            {
                type:"GET",
                dataType: "html",
                data: formData
            }).done(function(result) {
                
                //Clear results container 
                $('#search-results-container').html('');

                //Append results to container
                $('#search-results-container').append(result); 
                
                //Push url state
                history.pushState({},'','http://localhost/public/list.php?'+formData); 
            });
    });
}) (jQuery);
