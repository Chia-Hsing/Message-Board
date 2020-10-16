<?php
    // require('config.php');

    $servername = getenv('servername');
    $dbname = getenv('dbname');
    $username = getenv('username');
    $password = getenv('password');

try {
    $conn = new PDO ("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn -> setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // ERRMODE_EXCEPTION: 拋出 exceptions 異常。ATTR_ERRMODE：錯誤報告。
} catch (PDOException $e){

	echo "Connected Failed: " . $e->getMessage();
}

?>
