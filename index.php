<?php
    const DATABASE_HOST = 'localhost';
    const DATABASE_USER = 'testuser';
    const DATABASE_PASS = 'password';
    const DATABASE_NAME = 'mydb';
 
    $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
    if (mysqli_connect_errno()) {
        die("cannnot connect database :" . mysqli_connect_error() . "\n");
    }

    $result = $conn->query("SELECT * FROM users");

    
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = array_map('mb_convert_encoding', $row, array_fill(0, count($row), 'UTF-8'));
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    header('Access-Control-Allow-Origin: *');
    $conn->close();
?>
