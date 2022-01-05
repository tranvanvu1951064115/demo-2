// Popup message error
$('input[type="file"]').change(function() {
    $('.errorMessage').css('display', 'none');
    readURL(this, this.nextElementSibling);
    console.log(this.nextElementSibling);
})

function readURL(input, image) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            image.setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}