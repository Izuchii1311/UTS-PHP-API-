<?php
    include 'connection.php';

    #define parameter from url
    $count = false;
    $per_page = 10;
    $page = 1;
    $sort = 'id:asc';
    $sorted =['id', 'asc'];
    $where = [];
    $search = null;
    $search_column = ['nim', 'nama', 'alamat'];

    if ( isset($_GET['count']) ){
        $count = true;
    }

    if ( isset($_GET['per_page']) ){
        $per_page = $_GET['per_page'];
    }

    if ( isset($_GET['page']) ){
        $page = $_GET['page'];
    }

    if ( isset($_GET['sort']) ){
        $sort = $_GET['sort'];
        $sorted = explode(":", $sort);
    }

    if ( isset($_GET['where']) ){
        $where = json_decode(html_entity_decode($_GET['where']), true);
    }

    if ( isset($_GET['search']) ){
        $search = $_GET['search'];
    }

    #default response
    $response = [];
    $response['success'] = false;
    $response['message'] = 'Get Data Failed';
    $response['data'] = [];

    #start query
    $sql = "SELECT * FROM mahasiswa";
    $sql .= " where 1=1 ";

    if ($where){
        $i = 0;
        $sql .= " and ";
        foreach ($where as $key => $value){
            $sql .= " $key = '$value' ";
            $i += 1;
            if ($i < count($where)){
                $sql .= " and ";
            }
        }
    }

    if ($search)    {
        $i = 0;
        $sql .= " and ";
        foreach ($search_column as $column){
            $sql .= " $column like '%$search%' ";
            $i += 1;
            if ($i < count($search_column)){
                $sql .= " or ";
            }
        }
    }

    $sql .= " order by " . $sorted[0] . " " . $sorted[1] ;
    $sql .= " limit $per_page ";
    $sql .= " offset " . ($page-1) * $per_page;

    #Echo SQL
    $result = $conn -> query($sql);

    if ($count == true){
        if($result){
            $response['success'] = true;
            $response['message'] = 'Get Data Success';
            $response['data'] = [];
            $response['data']['count'] = $result->num_rows;
        } else {
            $response['success'] = false;
            $response['message'] = 'Internal Server Error ' . mysqli_error($conn);
            $response['data'] = [];
        }
    } else {
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
            $response['success'] = true;
            $response['message'] = 'Get Data Success';
            $response['data'] = $data;
        } else {
            $response['success'] = false;
            $response['message'] = 'Internal Server Error ' . mysqli_error($conn);
            $response['data'] = [];
        }
        $conn->close();
    }

        // Response Code
    if ($response['success'] == true) {
        header("HTTP/1.1 200");
    } else {
        header("HTTP/1.1 500");
    }

    // Response Data to JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>