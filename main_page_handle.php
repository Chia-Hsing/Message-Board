<?php
    session_start();
    require_once("../api/conn.php");

    $username = $_POST["username"];
    $content = $_POST["content"];
    $parent_id = $_POST["parent_id"];

    $stmt = $conn->prepare("INSERT INTO `black_coffee`(`username`, `message`, `parent_id`, `user_id`) VALUES (:username, :content, :parent_id, :user_id)");

    $param = [":username" => $username , ":content" => $content, ":parent_id" => $parent_id, ":user_id" => $_SESSION['user_id']];
    $stmt->execute($param);

    $current_id = $conn->lastInsertId();


    $stmt = $conn->prepare("SELECT * FROM `black_coffee` WHERE `id` = :current_id ORDER BY `time` DESC LIMIT 1");
    // 將剛存進資料庫的最新一筆留言資料拿出來回應。
    $stmt->bindParam(":current_id", $current_id);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $row = $stmt->fetch();

    $arr = array("message" => $row['message'], "username" => $row['username'], "time" => $row['time'], "id" => $current_id);


    
    echo json_encode($arr); 
?>
