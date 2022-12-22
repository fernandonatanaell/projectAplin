<?php
    session_start();

    $connectionName = "bgiktzigtizcg5etbmcu-mysql.services.clever-cloud.com";
    $username = "ufzmbdhbnlbtliyj";
    $password = "6NEFoFcVMbxcLXAy5PS3";
    $db = "bgiktzigtizcg5etbmcu";
	
	$conn = new mysqli($connectionName, $username, $password, $db);
	if ($conn->connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (users.name like '%".$searchValue."%' or 
        discounts.kode like '%".$searchValue."%' or 
        history.id like'%".$searchValue."%' or
        history.created_at like'%".$searchValue."%' or
        history.updated_at like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from history");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from history join discounts on discounts.id = history.id_discount join users on users.id = history.id_user where 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select history.id as id, users.name as user, history.total as total, ifnull(discounts.kode, '-') as discount, history.created_at as beli, ifnull(history.updated_at, '-') as diterima, history.status as status from history left join discounts on discounts.id = history.id_discount join users on users.id = history.id_user where 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array( 
      "id"=>$row['id'],
      "user"=>$row['user'],
      "total"=>number_format($row['total']),
      "discount"=>$row['discount'],
      "beli"=>date("F j, Y, g:i a", strtotime($row['beli'])),
      "diterima"=>$row['diterima'] == '-' ? $row['diterima'] : date("F j, Y, g:i a", strtotime($row['diterima'])),
      "status"=>$row['status'],
   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>