<?php
		$product_beforedate = htmlspecialchars($_POST['befordate']);
		$product_afterdate = htmlspecialchars($_POST['afterdate']);
    	$name_employees_m = htmlspecialchars($_POST['employees']);
    
        $pos = strpos($name_employees_m," ");
        $id_emp = (int)substr($name_employees_m,0,$pos);
		$get_flag='2';
		header("Location: salary.php?a=".$get_flag."&b=".$product_beforedate."&c=".$product_afterdate."&d=".$id_emp);
?>