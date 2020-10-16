<?php
    require_once("../api/conn.php");
    session_start();    

    $_SESSION["username"] = $_POST["currentUsername"];
    $_SESSION["password"] = $_POST["currentPassword"];

    
        $stmt = $conn->prepare("SELECT * FROM `toast` WHERE `username` = :username");
        $stmt->bindParam(":username", $_SESSION["username"]);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        /* PDO::FETCH_ASSOC 返回以欄位名稱作為索引鍵(key)的陣列(array)
        PDO::FETCH_NUM 返回以數字作為索引鍵(key)的陣列(array)，由0開始編號
        PDO::FETCH_BOTH 返回 FETCH_ASSOC 和 FETCH_NUM 的結果，兩個都會列出 */
        $row = $stmt->fetch();


        if ($stmt->rowCount() === 1) {
            // rowCount() 返回每一次更動的行數數量
            
            if (password_verify($_SESSION["password"], $row['password'])) { 
                // 確認輸入的 password跟資料庫該 username的 hash值是否相同。
                $_SESSION['user_id'] = $row['user_id'];
                // 若密碼成功認證就將該行的 user id 存入 session。
                echo json_encode(array("success"=>"sign_in_OK"));
                // 將 array轉為 JSON。
            } else {
                echo json_encode(array("success"=>"sign_in_ERROR"));
            }
            
        } else {
            echo json_encode(array("success"=>"sign_in_ERROR"));
        }
?>
