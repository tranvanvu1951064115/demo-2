
# ========== File .htaccess là kiểu file được đọc bởi các hosting do apache quản lý và 

# ========== cấp quyền

# ========== Nó có thể điều khiển, cấu hình được nhiều thứ với da dạng các thông số.

# ========== Ví dụ triển khai

# RewriteEngine On

# RewriteRule ^(verification|signUp|login|index)/?$ $1.php

# ========== Hai dòng trên khai báo sử dụng và tạo regex cho các trang. Mỗi khi có đuôi cuối file là một trong những kiểu ở trên sẽ được nối thêm đuôi php đằng sau.

# RewriteRule ^verification/([a-zA-Z0-9]+)/?$ verification.php?verify=$1

# Thay thế chuỗi vd: verification/euqgrueqgr7613 thành verification/verification.php/verify=euqgrueqgr7613