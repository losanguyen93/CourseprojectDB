<?php
	 session_start(); 
	 if($_SESSION['status'] != 'manager'):
		header("Location: ../start/index.php");
	 endif;
	include 'connect.php';
    $date_materials = htmlspecialchars($_POST['date_materials']); 
	$name_employees_m = htmlspecialchars($_POST['employees']);
	$name_materials = htmlspecialchars($_POST['materials']);
	$quantity_m = htmlspecialchars($_POST['quantity_m']);
	       
$pos = strpos($name_employees_m," ");
$id_emp = (int)substr($name_employees_m,0,$pos);
echo $id_emp;
		

$stid = oci_parse(connect_db(), 'INSERT INTO MATERIALS (ID_EMPLOYEES, DATE_M, MATERIALS, QUANTITY_M) VALUES (:bind_id_employees_m, TO_DATE(:bind_date_materials, \'YYYY-MM-DD HH24:MI:SS\'), :bind_name_materials, :bind_quantity_m)');

	oci_bind_by_name($stid, ":bind_date_materials", $date_materials);
	oci_bind_by_name($stid, ":bind_id_employees_m", $id_emp);
	oci_bind_by_name($stid, ":bind_name_materials", $name_materials);
	oci_bind_by_name($stid, ":bind_quantity_m", $quantity_m);
	oci_execute($stid);
	header("Location: manager.php");
	//________________________________________________
// Подключается к XE сервису (т.е. к базе данных) на "localhost"
?>
