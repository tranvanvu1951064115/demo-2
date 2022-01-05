$('.follow-button').click(function() {
    const followUser = this.getAttribute('data-follow-user');
    const followingUser = this.getAttribute('data-following-user');
    const _this = this;
    $.ajax({
        url: 'backend/functions/process/processFollow.php',
        type: 'POST',
        data: {
            followUser,
            followingUser
        },
        success: function(result) {
            $(`.follow-button[data-following-user='${followingUser}']`).text(result);
        }                    
    });
})