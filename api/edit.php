<?php
require_once("./conn.php");
session_start();

$message = $_POST['changedMessage'];
$id = $_POST['id'];

$stmt = $conn->prepare("UPDATE `black_coffee` SET `message`= :message WHERE `id` = :id");
$param = [":message" => $message, "id" => $id];
$result = $stmt->execute($param);

if ($result) {
    echo json_encode(array("success"=>"OK"));
} else {
    echo json_encode(array("error"=>"failed:$conn->error"));
}
?>
