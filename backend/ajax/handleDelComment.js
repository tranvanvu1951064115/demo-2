function handleDelComment(event, commentId) {
    event.preventDefault();
    event.stopPropagation();
    $.ajax({
        url: 'backend/functions/process/processDelComment.php',
        type: 'POST',
        data: {
            commentId
        },
        success: function(result) {
            location.reload();
        }                    
    });
}



