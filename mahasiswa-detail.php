<?php
    include 'connection.php';

    # define parameter from url
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/',  $uri_path);

    #default response
    $response = [];
    $response['success'] = false;
    $response['message'] = 'Get Data Failed';
    $response['data'] = [];

    if (isset($uri_segments[3]) && $uri_segments[3] != null) {
        #start query
        $sql = "SELECT * from mahasiswa where id = $uri_segments[3]";

        #echo $sql
        $result = $conn->query($sql);

        $data = [];
        while($row = $result->fetch_assoc()){
            $temp = $row;
            $temp['id'] = (int)$row['id'];
            $temp['is_active'] = (int)$row['is_active'];
            $tanggal_lahir_lama = new DateTime($temp['tanggal_lahir']);
            $tanggal_lahir_baru = $tanggal_lahir_lama->format('d F Y');
            $temp['tanggal lahir'] = $tanggal_lahir_baru;
            array_push($data, $temp);
        }

        if (count($data) > 0){
            
            $data = $data[0];
            $response['success'] = true;
            $response['message'] = 'Get Data Success';
            $response['data'] = $data;
        } else {
            $response['success'] = true;
            $response['message'] = 'Data Not Found';
            $response['data'] = []  ;
        }

    } else {
        $response['success'] = false;
        $response['message'] = 'Parameter Data Not Found';
        $response['data'] = [];
    }

    $conn->close();

    #Response Code
    if($response['success'] == true){
        header("HTTP/1.1 200");
    } else {
        header("HTTP/1.1 500");
    }

    #Response data to json
    header('Content-Type: application/json');
    echo json_encode($response);