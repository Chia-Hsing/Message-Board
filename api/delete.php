<?php
require_once("./conn.php");
session_start();


$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM `black_coffee` WHERE `id` = :id OR `parent_id` = :id");
$stmt->bindParam(":id", $id);

if ($stmt->execute()) {
    echo json_encode(array("success"=>"OK"));
} else {
    echo json_encode(array("error"=>"failed:$conn->error"));
}


?>
