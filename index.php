<?php

require __DIR__ . '/vendor/index.php';

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$databaseHost = $_ENV['DATABASE_HOST'];
$databaseUser = $_ENV['DATABASE_USER'];
$databasePass = $_ENV['DATABASE_PASS'];
$databaseName = $_ENV['DATABASE_NAME'];

$conn = mysqli_connect($databaseHost, $databaseUser, $databasePass, $databaseName);

if ($conn->connect_error) {
    die("データベースへの接続に失敗しました: " . $conn->connect_error);
}

$sql = "SELECT Id, Name, Email, Image_url FROM customer";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
