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

    $name = $_REQUEST['nama'];
    $kode = $_REQUEST['kode'];
    $potongan = $_REQUEST['potongan'];

    $q = $conn->prepare("INSERT INTO discounts(name, kode, potongan) VALUES(?,?,?)");
    $q->bind_param("ssi",$name, $kode, $potongan);
    $result =$q->execute();

?>

    <tr>
        <td><?php echo $conn->insert_id ?></td>
        <td><?php echo $name ?></td>
        <td><?php echo $kode ?></td>
        <td><?php echo $potongan ?> %</td>
    </tr>