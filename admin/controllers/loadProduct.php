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
   $searchQuery = " and (products.name like '%".$searchValue."%' or 
        brands.name like '%".$searchValue."%' or 
        products.id like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from products");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from products join brands on brands.id = products.id_brands where 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select products.id as id, products.name as name, brands.name as brand, products.berat as berat, products.stock as stock, products.harga as harga from products join brands on brands.id = products.id_brands where 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array( 
      "id"=>$row['id'],
      "name"=>$row['name'],
      "brand"=>$row['brand'],
      "berat"=>$row['berat'],
      "stock"=>$row['stock'],
      "harga"=>number_format($row['harga']),
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