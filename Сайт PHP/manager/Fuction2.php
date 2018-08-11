<?php

	 session_start(); 
	 if($_SESSION['status'] != 'manager'):
		 header("Location: index.php");
	 endif;
	
	include 'connect.php';
	$action = $_POST['BDbtn'];
	switch ($action) {
		case 'OK':
			buttonBDbtn2();
			break;
		case 'Отправить в БД':
			buttonBDbtn1();
			break;
		}
   
	
	function buttonBDbtn1(){
		 
		$product_name = htmlspecialchars($_POST['name']); 
		$product_price = (int)htmlspecialchars($_POST['price']);
		$product_costing = (int)htmlspecialchars($_POST['costing']);
		
		
		echo $date;

		// Подключается к XE сервису (т.е. к базе данных) на "localhost"
		
		
		$stid = oci_parse(connect_db(), "INSERT INTO \"PRODUCT\" (NAME_PRODUCT, PRICE, COST_PRICE) VALUES (:bind_product_name, :bind_product_price, :bind_product_costing)
");
		
		oci_bind_by_name($stid, ":bind_product_name", $product_name);
		oci_bind_by_name($stid, ":bind_product_price", $product_price);
		oci_bind_by_name($stid, ":bind_product_costing", $product_costing);
		
		oci_execute($stid);
		header("Location: add_products.php?a=1");
		
	}
    function buttonBDbtn2(){
    	$product_beforedate = htmlspecialchars($_POST['befordate']);
		$product_afterdate = htmlspecialchars($_POST['afterdate']);
		$get_flag='2';
		header("Location: add_products.php?a=".$get_flag."&b=".$product_beforedate."&c=".$product_afterdate);
    }
   
  
?>

