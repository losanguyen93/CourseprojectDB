<?php
	 session_start(); 
	 if($_SESSION['status'] != 'user'):
		header("Location: ../start/index.php");
	 endif;
	include 'connect.php';
	
    $user_surname = htmlspecialchars($_POST['surname']); 
	$user_name = htmlspecialchars($_POST['name']);
	$user_patronymic = htmlspecialchars($_POST['patronymic']);
	$user_sex = htmlspecialchars($_POST['sex']);
	$user_birt = htmlspecialchars($_POST['birth']);    

	$stid = oci_parse(connect_db(), 'INSERT INTO EMPLOYEES (SURNAME_E, NAME_E, PATRONYMIC_E, SEX, BIRTH) VALUES (:bind_surname, :bind_name, :bind_patronymic, :bind_sex, TO_DATE(:bind_birt, \'YYYY-MM-DD HH24:MI:SS\'))');
	oci_bind_by_name($stid, ":bind_surname", $user_surname);
	oci_bind_by_name($stid, ":bind_name", $user_name);
	oci_bind_by_name($stid, ":bind_patronymic", $user_patronymic);
	oci_bind_by_name($stid, ":bind_sex", $user_sex);
	oci_bind_by_name($stid, ":bind_birt", $user_birt);
	oci_execute($stid);
	header("Location: add_employees.php");
	//________________________________________________
?>

