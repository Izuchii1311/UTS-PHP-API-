<?php

    include 'connection.php';

    # define parameter from url
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/',  $uri_path);

    // get JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // default data
    $nim = '';
    $nik = '';
    $nama = '';
    $tanggal_lahir = '';
    $jenis_kelamin = '';
    $alamat = '';
    $is_active = '1';

    #get data from JSON
    if (isset($data['nim'])) {
        $nim = $data['nim'];
    }
    if (isset($data['nik'])) {
        $nik = $data['nik'];
    }
    if (isset($data['nama'])) {
        $nama = $data['nama'];
    }
    if (isset($data['tanggal_lahir'])) {
        $tanggal_lahir = $data['tanggal_lahir'];
    }
    if (isset($data['jenis_kelamin'])) {
        $jenis_kelamin = $data['jenis_kelamin'];
    }
    if (isset($data['alamat'])) {
        $alamat = $data['alamat'];
    }
    if (isset($data['is_active'])) {
        $is_active = $data['is_active'];
    }

    #default response
    $response = [];
    $response['success'] = false;
    $response['message'] = 'Update data failed';
    $response['data'] = [];

    if (isset($uri_segments[3]) and $uri_segments[3] !=null){
        if ($nim != '' and $nama != ''){
            // Start Query
            $sql = "UPDATE mahasiswa SET nim='$nim', nik='$nik', nama='$nama', tanggal_lahir='$tanggal_lahir', jenis_kelamin='$jenis_kelamin', alamat='$alamat', is_active='$is_active' WHERE id=$uri_segments[3]";

            $result = $conn->query($sql);

            if($result) {
                // get Data after update
                $sql_get = "SELECT * FROM mahasiswa WHERE id = $uri_segments[3]";
                $result_get = $conn->query($sql_get);
    
                $data_get = [];
                while ($row = $result_get->fetch_assoc()){
                    $temp = $row;
                    $temp['id'] = (int)$row['id'];
                    $temp['is_active'] = (int)$row['is_active'];
                    $tanggal_lahir_lama = new DateTime($temp['tanggal_lahir']);
                    $tanggal_lahir_baru = $tanggal_lahir_lama->format('d F Y');
                    $temp['tanggal lahir'] = $tanggal_lahir_baru;
                    array_push($data_get, $temp);
                } 
                $data_get = $data_get[0];

                $response['success'] = true;
                $response['message'] = 'Insert Data Success';
                $response['data'] = $data_get;
            } else {
                $response['success'] = false;
                $response['message'] = 'Internal Server Error' . mysqli_error($conn)    ;
                $response['data'] = [];
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Tidak ada data yang dikirim.';
            $response['data'] = [];
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Parameter Data Not Found';
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