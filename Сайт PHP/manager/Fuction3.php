<?php
	 session_start(); 
	 if($_SESSION['status'] != 'manager'):
		header("Location: ../start/index.php");
	 endif;
	include 'connect.php';
    $date_made_wares = htmlspecialchars($_POST['date_made_wares']); 
	$name_employees = htmlspecialchars($_POST['employees']);
	$name_product = htmlspecialchars($_POST['product']);
	$quantity_p = htmlspecialchars($_POST['quantity_p']);
	       
$pos = strpos($name_employees," ");
$id_emp = (int)substr($name_employees,0,$pos);
echo $id_emp;

	
               
$stid = oci_parse(connect_db(), 'SELECT ID_PRODUCT FROM PRODUCT WHERE NAME_PRODUCT = :bind_product');
				oci_bind_by_name($stid, ":bind_product", $name_product);
				oci_execute($stid);
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                  foreach ($row as $item) {
                   	$id_product = $item;
                  }
                }
	
			

$stid = oci_parse(connect_db(), 'INSERT INTO MADE_WARES (ID_PRODUCT, ID_EMPLOYEES, QUANTITY_MW, DATE_MADE_WARES) VALUES (:bind_id_product, :bind_id_employees, :bind_quantity_p, TO_DATE(:bind_date_made_wares, \'YYYY-MM-DD HH24:MI:SS\'))
');

	oci_bind_by_name($stid, ":bind_date_made_wares", $date_made_wares);
	oci_bind_by_name($stid, ":bind_id_employees", $id_emp);
	oci_bind_by_name($stid, ":bind_id_product", $id_product);
	oci_bind_by_name($stid, ":bind_quantity_p", $quantity_p);
	oci_execute($stid);
	header("Location: manager.php");
	//________________________________________________
// Подключается к XE сервису (т.е. к базе данных) на "localhost"
?>
