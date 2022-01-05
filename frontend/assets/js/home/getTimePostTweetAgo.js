export function getTimePostTweetAgo() {
    const timer = [
        365 * 24 * 60 * 60, 
        31 * 24 * 60 * 60, 
        7 * 24 * 60 * 60, 
        1 * 24 * 60 * 60, 
        60 * 60, 
        60
      ];
    const range = ['years', 'months', 'weeks', 'days', 'hours', 'minutes', 'seconds'];
    
    function getPeriod(seconds) {
        let i = 0;
        while(true) {
            const period = Math.floor(seconds / timer[i]);
            if(period >= 1) {
                return `${period} ${range[i]} ago`;
            }
            if(i == 5) {
                return `${Math.floor(seconds)} ${range[i + 1]} ago`;
            }
            i++;
        }
    }
    
    function getTimeOnline(offTime) {
        offTime = new Date(offTime).getTime();
        const currentTime = new Date().getTime();
        const seconds = (currentTime - offTime) / 1000;
        if(seconds > 0) {
            return getPeriod(seconds);
        } else {
            window.location = 'https://localhost/twitter/error.php';
        }
    }
    
    const timeTweets = document.querySelectorAll('.time-post-tweet');
    [...timeTweets].forEach(time => {
        time.innerHTML = `<i class='fas fa-circle'></i>${getTimeOnline(time.textContent.trim())}`;
    });
}