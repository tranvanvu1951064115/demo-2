const containerImgForEachTweet = document.querySelectorAll('.content__new-tweet-box-image--uploaded');
[...containerImgForEachTweet].forEach(box => {
    if(box.querySelectorAll('> div').length == 1) {
        Object.assign(box.children.style, {
            'min-width': '100%',
            'min-height': 'unset'
        })
    }
})