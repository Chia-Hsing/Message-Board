<?php
    session_start();    
    require_once("../api/conn.php");

    $_SESSION["username"] = $_POST["currentUsername"];
    $_SESSION["password"] = $_POST["currentPassword"];
    $confirmpsw = $_POST["confirm_password"];

    $stmt = $conn->prepare("SELECT * FROM `toast` WHERE `username` = :username");
    $stmt->bindParam(":username", $_SESSION["username"]);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $row = $stmt->fetch();

    if ($stmt->rowCount() === 0) {

        if ($_SESSION["password"] === $confirmpsw) {

            $hash = password_hash ($_SESSION["password"], PASSWORD_DEFAULT);
            // password_word，自動將 password轉為 hash值。
            // PASSWORD_DEFAULT，每次處理時，都會在背後產生隨機的 SALT。
    
            $sign_up_stmt = $conn->prepare("INSERT INTO `toast`(`username`, `password`) VALUES (:username, :password)");
            $param = [":username" => $_SESSION["username"], ":password" => $hash];
            $sign_up_stmt -> execute($param);
           
            $_SESSION["user_id"] = $conn -> lastInsertId();
            // 最新新增的一筆資料的 AUTO_INCREMENT (user id)。
            echo json_encode(array("success"=>"create_account_OK"));
        } else {
            echo json_encode(array("success"=>"psw_confirm_ERROR"));
        }

    } else if ($stmt->rowCount() === 1) {
         {
             echo json_encode(array("success"=>"same_username_ERROR"));
             
            }  
    }

?>




