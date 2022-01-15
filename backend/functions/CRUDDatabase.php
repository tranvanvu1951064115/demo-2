<?php 
        // LẤY THÔNG TIN NGƯỜI DÙNG VỪA ĐĂNG KÍ VỚI THAM SỐ ĐẦU VÀO LÀ USER_ID ĐƯỢC TRUYỀN TỪ TRANG SIGN_UP
        // Hàm dùng để lấy thông tin người dùng trong bảng USER 
        function userData($user_id) {
            global $conn;
            // Lấy thông tin người dùng
            $statement = $conn->prepare("SELECT * FROM tb_users WHERE user_id=:userid AND user_isAdmin = '0'");
            // Truyền dữ liệu vào prepare statement
            $statement->bindParam(":userid", $user_id, PDO::PARAM_INT);
            $statement->execute();
            // Trả về danh sách đã lấy về khi truy vấn
            $user = $statement->fetch(PDO::FETCH_OBJ);
            // Hàm đếm số lượng dòng đã truy vấn
            // Nếu > 0 tức là select thành công
            // Ngược lại không có bản ghi trong csdl
            if($statement->rowCount() > 0) {
                return $user;
            } else {
                return false;
            }
        }
        
        // Hàm tạo và thực thi insert vào cơ sở dữ liêu
        function insert($tableName, $fields = array()) {
            global $conn;
            // Tạo chuỗi để truyền vào query insert
            $columns = implode(', ',array_keys($fields));
            // Tạo chuỗi để chuyền vào values
            $values = ':'.implode(', :', array_keys($fields));
            // Tạo câu lệnh truy vấn sql
            $sqlquery = 'INSERT INTO ' .$tableName. '(' .$columns.')' . ' VALUES(' . $values . ')';
            // Tạo prepare statement
            $stmt = $conn->prepare($sqlquery);
            foreach($fields as $key => $value) {
                // Truyền dữ liệu vào trong prepare statement
                $stmt->bindValue(':'.$key, $value);
            }
            // Thực thi sql
            $stmt->execute();
            // Lấy ra vị trí vừa mới chèn vào
            return $conn->lastInsertId();
        }

        // Hàm lấy dữ liệu về từ trong cơ sở dữ liệu
        // Return giá trị trả về
        function getInfo($tableName, $columnNames, $fields = array(), $order, $orderColumn) {
            global $conn;
            $targetColumns  = implode(', ', array_values($columnNames));
            $columns = "";
            $i = 1;
            foreach($fields as $name => $value) {
                $columns .= "{$name}=:{$name}";
                if($i < count($fields)) {
                    $columns .= " AND ";
                }
                $i++;
            }
            $sql = "SELECT $targetColumns FROM $tableName WHERE $columns";
            if($order == 'DESC') {
                $sql .= " ORDER BY $orderColumn DESC";
            } else if($order == 'ASC'){
                $sql .= " ORDER BY $orderColumn ASC";
            }
            $stmt = $conn->prepare($sql);
            foreach($fields as $key => $value) {
                // Truyền dữ liệu vào trong prepare statement
                $stmt->bindValue(':'.$key, $value);
            }
            // Thực thi sql
            $stmt->execute();
            // Lấy ra vị trí vừa mới chèn vào
            return $stmt->fetchAll(PDO::FETCH_ASSOC);    
        }

        function update($tableName, $user_id, $fields = array()) {
            global $conn;
            $columns = "";
            $i = 1;
            foreach($fields as $name => $value) {
                $columns.= "{$name}=:{$name}";
                if($i < count($fields)) {
                    $columns .= " , ";
                }
                $i++;
            }
            $sql = "UPDATE $tableName SET $columns WHERE user_id = $user_id";
            $stmt = $conn->prepare($sql);
            foreach($fields as $key => $value) {
                // Truyền dữ liệu vào trong prepare statement
                $stmt->bindValue(':'.$key, $value);
            }
            // Thực thi sql
            $stmt->execute();
            return true;
        }

        function delete($tableName, $fields = array()) {
            global $conn;
            $columns = "";
            $i = 1;
            foreach($fields as $name => $value) {
                $columns .= "{$name}=:{$name}";
                if($i < count($fields)) {
                    $columns .= " AND ";
                }
                $i++;
            }
            $sql = "DELETE FROM $tableName WHERE $columns";
            $stmt = $conn->prepare($sql);
            foreach($fields as $key => $value) {
                // Truyền dữ liệu vào trong prepare statement
                $stmt->bindValue(':'.$key, $value);
            }
            // Thực thi sql
            $stmt->execute();
            return true;
        }
?>