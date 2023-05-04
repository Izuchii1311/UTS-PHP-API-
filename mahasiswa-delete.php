<?php

    include 'connection.php';

    // define parameter from url
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);

    #default response
    $response = [];
    $response['success'] = false;
    $response['message'] = 'Delete data failed';
    $response['data'] = [];

    if (isset($uri_segments[3]) and $uri_segments[3] !=null){
        // Start Query
        $sql_get = "SELECT * FROM mahasiswa WHERE id=$uri_segments[3]";
        $result_get = $conn->query($sql_get);

        if ($result_get->num_rows > 0){
            # Start Query
            $sql_delete = "DELETE FROM mahasiswa WHERE id=$uri_segments[3]";
            $result_delete = $conn->query($sql_delete);

            $response['success'] = true;
            $response['message'] = 'Delete data success';
            $response['data'] = [];
        } else {
            $response['success'] = true;
            $response['message'] = 'Data not found';
            $response['data'] = [];
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Parameter data not found!';
        $response['data'] = [];
    }

    // Close mysql connection
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
    

?>