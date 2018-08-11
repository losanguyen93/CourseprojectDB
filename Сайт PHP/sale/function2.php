<?php
include 'connect.php';
$date_sale = htmlspecialchars($_POST['date_sale']); 
$name_clients = htmlspecialchars($_POST['clients']);
$name_product = htmlspecialchars($_POST['product']);
$quantity_sale = htmlspecialchars($_POST['quantity_sale']);
$rec_money = htmlspecialchars($_POST['rec_money']);
	       
$pos = strpos($name_clients," ");
$id_cl = (int)substr($name_clients,0,$pos);
// echo $id_cl;
               
$stid = oci_parse(connect_db(), 'SELECT ID_PRODUCT FROM PRODUCT WHERE NAME_PRODUCT = :bind_product');
				oci_bind_by_name($stid, ":bind_product", $name_product);
				oci_execute($stid);
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                  foreach ($row as $item) {
                   	$id_product = $item;
                  }
                }			

$stid = oci_parse(connect_db(), 'INSERT INTO SALES (ID_PRODUCT, ID_CLIENTS, DATE_S, QUANTITY_SALE, REC_MONEY) VALUES (:bind_id_product, :bind_id_clients, TO_DATE(:bind_date_sale, \'YYYY-MM-DD HH24:MI:SS\'), :bind_quantity_sale, :bind_rec_money)');
	// var_dump($id_cl);
	oci_bind_by_name($stid, ":bind_date_sale", 		$date_sale);
	oci_bind_by_name($stid, ":bind_id_clients", 	$id_cl);
	oci_bind_by_name($stid, ":bind_id_product", 	$id_product);
	oci_bind_by_name($stid, ":bind_quantity_sale", 	$quantity_sale);
	oci_bind_by_name($stid, ":bind_rec_money", 		$rec_money);
	oci_execute($stid);
	header("Location: sale.php");
	//________________________________________________
// Подключается к XE сервису (т.е. к базе данных) на "localhost"
?>
