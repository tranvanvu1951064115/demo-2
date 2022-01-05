export function callAjax(url, method, data = {}, success) {
    $.ajax({
        url,   
        type: method,
        data,
        success                  
    });
}
