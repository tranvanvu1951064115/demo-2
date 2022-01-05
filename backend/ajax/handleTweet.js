import {enablePostTweet} from '../../frontend/assets/js/home/enablePostTweet.js';
import {getTimePostTweetAgo} from '../../frontend/assets/js/home/getTimePostTweetAgo.js';
import {showDeleteTweet} from '../../frontend/assets/js/home/showDeleteTweet.js';
import {callAjax} from './ajax.js';

function setAndGetPostTweet(form) {
    // GỌI AJAX
    let formData = '';
    if(form?.classList?.contains('content__post-form')) {
        formData = new FormData(form);
        formData.append('status', $('#contentText').val());
        formData.append('tweetSubmit', 1);
        formData.append('amountFile', $('.control-post input[type="file"]')[0].files.length);
    }
    $.ajax({
        url: 'backend/functions/process/handleTweet.php',   
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,               
        cache: false,
        enctype: 'multipart/form-data',
        success(data) {
        const boxData = document.querySelector('.content__tweets');
        if(boxData) {
            // LẤY DỮ LIỆU VỀ VÀ RENDER RA GIAO DIỆN
            boxData.innerHTML = data;
            // THIẾT LẬP ENABLE BUTTON SUBMIT
            enablePostTweet();
            // THIẾT LẬP LẠI THỜI GIAN ĐĂNG BÀI CỦA NGƯỜI DÙNG
            getTimePostTweetAgo();
            // THIẾT LẬP HIỂN THỊ NÚT SUBMIT
            showDeleteTweet();
            // THIẾT LẬP LẠI STATUS CỦA NGƯỜI DÙNG
            $('#contentText').value = '';
            // THIẾT LẬP LẠI FORM
            document.getElementById('postTweetForm').reset();
            // RESET KHUNG DEMO IMAGE
            $('.content__new-tweet-box-image--uploading').html('');
        }}
    });    
}
// XỬ LÝ KHI NGƯỜI DÙNG THÊM TWEET
if($('#postTweetForm')) {
    $('#postTweetForm').submit(function(event) {
        event.preventDefault();
        event.stopPropagation();
        setAndGetPostTweet(this);
    });
}
// XỬ LÝ KHI LOAD LẠI TRANG
$(document).ready(setAndGetPostTweet);

// XỬ LÝ UPLOAD FILE ĐỊNH DẠNG ẢNH
$('.control-post input[type="file"]').change(function() {
    // LỖI UPLOADING
    let errorUpload = '';

    const files = $('.control-post input[type="file"]')[0].files;

    // XỬ LÝ KHI NGƯỜI DÙNG UPLOAD NHIỀU HƠN 4 FILES
    if(files.length > 4) {
        errorUpload = 'Uploading more than 4 files is not allowed';
    } else {
        const arrTypeAllowed = ['jpg','png','jpeg','gif'];
        // HIỂN THỊ TOÀN BỘ NHỮNG FILE NGƯỜI DÙNG ĐÃ UPLOAD
        for(let i=0; i<files.length; i++) {
            // VALIDATE DUNG LƯỢNG FILE
            if(files[i].size > 2_000_000) {
                errorUpload = 'File size too large is not allowed';
                break;
            } else if(!arrTypeAllowed.includes(files[i].name.split('.').pop().toLowerCase())) { // VALIDATE CHO ĐỊNH DẠNG FILE
                errorUpload = 'Only [jpg, png, jpeg, gif] files are allowed';
                break;
            }
        }
    }

    if(errorUpload == '') { 
        // THIẾT LẬP ẨN LỖI
        $('.error-upload-file').html('');
        // ẨN ĐI NHỮNG HÌNH ẢNH CŨ
        $('.content__new-tweet-box-image--uploading').html('');
        // HIỂN THỊ TOÀN BỘ NHỮNG FILE NGƯỜI DÙNG ĐÃ UPLOAD
        for(let i=0; i<files.length; i++) {
            // LẤY RA IMAGE ĐỂ GÁN SRC LÊN TRÊN ĐÓ.
            const image = createImageAndContainer(i);

            // ĐỌC FILE ẢNH LÊN CLIENT
            readURL(files[i], image);

            // PHẦN XỬ LÝ PHỤ
            subHandle(image.parentElement, files);
        }
    } else {
        // ĐẶT GIÁ TRỊ CỦA INPUT BẰNG RỖNG
        $('.control-post input[type="file"]').val('');
        $('.content__new-tweet-box-image--uploading').html(`<span class="text-muted error-upload-file">${errorUpload}</span>`);
    }

    //  ĐÓNG TRẠNG THÁI CỦA SUBMIT BTN NẾU KHÔNG CÒN ẢNH NÀO VÀ GIÁ TRỊ CỦA TEXT AREA RỖNG
    if($('.content__new-tweet-box-image--uploading > div').length == 0 && $('.content__tweet-input[name="contentText"]').val() == '') {
        $('.content__tweet-btn[name="tweetSubmit"]').prop( "disabled", true);
    }
})

function createImageAndContainer(index) {
    const image = document.createElement('img');
    const containerImg = document.createElement('div');
    containerImg.innerHTML = `<span class='close' data-close=${index}>
                                <i class="bi bi-x-lg fs-5 fw-bold"></i>
                             </span>`;
    containerImg.classList.add('container-post-image');
    containerImg.appendChild(image);
    return image;
}

function subHandle(containerImg) {
    // XỬ LÝ MỘT SỐ THỨ VỀ STYLE :V
    $('.content__new-tweet-box-image--uploading').append(containerImg);
    $('.content__new-tweet-box-image--uploading').css('margin', '0');
    $('.content__tweet-btn[name="tweetSubmit"]').prop( "disabled", false);

    //  GÁN SỰ KIỆN CHO BUTTON CLOSE
    containerImg.querySelector('.close').onclick = function(e) {

        // LOẠI BỎ ĐI TỆP TIN ĐÓ TRONG FILES
        const indexDelete = this.getAttribute('data-close');
        // XÓA PHẦN TỬ
        this.parentElement.remove();

        $('.content__new-tweet-box-image--uploading').css('margin-bottom', '0');

        // CẬP NHẬT LẠI FILE 
        const arrFile = [];
        const files = $('.control-post input[type="file"]')[0].files;

        if(files.length == 1) {
            $('.control-post input[type="file"]').val('');
        } else {
            for(let i=0; i<files.length; i++) {
                if(i != indexDelete) {
                    arrFile.push(files[i]);
                }
            }
            updateFile($('.control-post input[type="file"]')[0],arrFile);
        }
        console.log($('.control-post input[type="file"]')[0].files);

        //  ĐÓNG TRẠNG THÁI CỦA SUBMIT BTN NẾU KHÔNG CÒN ẢNH NÀO VÀ GIÁ TRỊ CỦA TEXT AREA RỖNG
        if($('.content__new-tweet-box-image--uploading > div').length == 0 && $('.content__tweet-input[name="contentText"]').val() == '') {
            $('.content__tweet-btn[name="tweetSubmit"]').prop( "disabled", true);
        }
    }

}

// ĐỌC FILE LÊN CLIENT
function readURL(file, image) {
    if (file) {
        var reader = new FileReader();

        reader.onload = function (e) {
            image.setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
}

function updateFile(input, arrFile) {
    // TẠO RA BIẾN LIST
    let listFile = new DataTransfer();
    arrFile.forEach(file => {
        // TẠO RA BIẾN OBJ FILE
        let newFile = new File([file], file.name);
    
        // THÊM FILE VÀO TRANSFER
        listFile.items.add(newFile);
    })

    let myFileList = listFile.files;
    // Sau đó, bạn có thể đặt nó làm thuộc tính tệp của nút DOM:
    
    // LẤY DỮ LIỆU RỒI CHÈN NGƯỢC LẠI INPUT
    input.files = myFileList;
}



