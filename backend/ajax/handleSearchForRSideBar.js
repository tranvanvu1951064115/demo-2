$('.searchTwitter').on("keyup", function(e) {
    const valueInput = $(this).val();
    // XỬ LÝ AJAX
    $.ajax({
        url: 'backend/functions/process/processPrintUserWhenSearch.php',
        type: 'POST',
        data: {
            valueInput,
        },
        success: function(result) {
            if(result) {
                $('.r-sidebar__boxResultSearch').css('display', 'block');
                $('.r-sidebar__boxResultSearch').html(result);
                $('.r-sidebar__boxResultSearch').append("<button class='hide-box-search-btn btn btn--secondary'>Hide box</button>");
                
                // HANDLE HIDDEN BOX SEARCH
                $('.hide-box-search-btn').click(function(e) {
                    $('#searchTwitter').val('');
                    $('.r-sidebar__boxResultSearch').css('display', 'none');
                })
            }
        }                    
    });
})

