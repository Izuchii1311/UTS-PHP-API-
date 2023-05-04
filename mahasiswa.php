<?php
include 'connection.php';

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
$detail = false;

if (isset($uri_segments[3])) {
    $detail = true;
}
// Start Query
$sql = 'SELECT * from mahasiswa';

if ($detail == true) {
    $sql .= " where id = $uri_segments[3]";
}
// Echo SQL
$result = $conn->query($sql);

$response = [];
$response['success'] = false;
$response['message'] = 'Get Data Failed';
$response['data'] = [];
if ($result) {

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $temp = $row;
        $temp['id'] = (int)$row['id'];
        $temp['is_active'] = (int)$row['is_active'];
        $tanggal_lahir_lama = new DateTime($temp['tanggal_lahir']);
        $tanggal_lahir_baru = $tanggal_lahir_lama->format('d F Y');
        $temp['tanggal_lahir'] = $tanggal_lahir_baru;
        array_push($data, $temp);
    }
    if ($detail == true) {
        $data = $data[0];
    }
    $response['success'] = true;
    $response['message'] = 'Get Data Success';
    $response['data'] = $data;
} else {
    $response['success'] = false;
    $response['message'] = 'Internal Server Error ' . mysqli_error($conn);
    $response['data'] = [];
}
$conn->close();

// Response Code
if ($response['success'] == true) {
    header("HTTP/1.1 200");
} else {
    header("HTTP/1.1 500");
}

// Response Data to JSON
header('Content-Type: application/json');
echo json_encode($response);