<?php
    $user_surname = htmlspecialchars($_POST['surname']); 
	$user_name = htmlspecialchars($_POST['name']);
	$user_patronymic = htmlspecialchars($_POST['patronymic']);

	include 'connect.php';

	$stid = oci_parse(connect_db(), 'INSERT INTO CLIENTS (SURNAME_C, NAME_C, PATRONYMIC_C) VALUES (:bind_surname, :bind_name, :bind_patronymic)');
	oci_bind_by_name($stid, ":bind_surname", $user_surname);
	oci_bind_by_name($stid, ":bind_name", $user_name);
	oci_bind_by_name($stid, ":bind_patronymic", $user_patronymic);
	oci_execute($stid);
	header("Location: sale.php");
?>