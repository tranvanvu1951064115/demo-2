<?php 
    // Hàm sử dụng để validate chuỗi trong form
    function filterString($input) {
        // Loại bỏ thẻ html và php sau đó trim hai đầu của value input
        $input = trim(strip_tags($input));
        // Loại bỏ kí tự đặc biệt
        $input = htmlspecialchars($input);
        return $input;
    }

    // Hàm sử dụng để validate tên trong form
    function filterName($input) {
        // Loại bỏ thẻ html và php sau đó trim hai đầu của value input
        $input = trim(strip_tags($input));
        // Loại bỏ kí tự đặc biệt
        $input = htmlspecialchars($input);
        // Cho input trở thành kí tự thường
        $input = strtolower($input);
        // Cho input trở thành chữ cái đầu viết hoa
        $input = ucfirst($input);
        return $input;
    }
?>
