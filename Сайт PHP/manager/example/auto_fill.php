<?php
	
	function auto_fill($product_beforedate, $product_afterdate){
	//arr - масств записи
	//arr2 -массив уникального не повтеряющего название продукта
	//arr3 - масств уникального не повтеряющего даты
	include 'connect.php';
	include 'Struct.php';
    $i = 0;
    $j = 0;
    $zap = Struct::factory('date', 'name_product', 'counter');
    
          		$stid = oci_parse(connect_db(), 'SELECT DATE_MADE_WARES, ID_PRODUCT, QUANTITY_MW FROM MADE_WARES WHERE (DATE_MADE_WARES >= TO_DATE(:bind_product_beforedate, \'YYYY-MM-DD HH24:MI:SS\') AND DATE_MADE_WARES <= TO_DATE(:bind_product_afterdate, \'YYYY-MM-DD HH24:MI:SS\')) ORDER BY DATE_MADE_WARES');
                oci_bind_by_name($stid, ":bind_product_beforedate", $product_beforedate);
                oci_bind_by_name($stid, ":bind_product_afterdate", $product_afterdate);
                oci_execute($stid);
            		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                                  		
                  		foreach ($row as $item) {
                   			
                   				if ($j == 0) $cur_date = $item;
                   				if ($j == 1) $id_product = $item;
                   				if ($j == 2) $quantity_mw= $item;
                   				$j++;
                   				// echo "/ ok = ".$item;              				               
                  		}
                  	// echo "</br>";
                  	$arr[$i] = $zap->create($cur_date, $id_product, $quantity_mw);
                   	$i++;
                   	$j=0;
                	}
    $i = 0;
                $stid = oci_parse(connect_db(), 'SELECT DISTINCT ID_PRODUCT FROM PRODUCT ORDER BY ID_PRODUCT');
                oci_execute($stid);
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            		
                  		foreach ($row as $item) {
                   			$arr2[$i] = $item;        				               
                  		}
                  		$i++;
                }

    // echo "</br>";

   	$i = 0;
    $arr3[0] = $arr[0]->date;           
      foreach ($arr as $item) {
      	if ($arr3[$i] != $item->date){
      		$i++;
      		$arr3[$i] = $item->date;
      	}
      }
     $i = 0;
     $flag = false;
     $sum = 0;
     foreach ($arr3 as $item3) {
                	foreach ($arr2 as $item2) {
                		foreach ($arr as $item) {
                			if (($item3 == $item->date) and ($item2 == $item->name_product)) {
                				$sum = $sum + (int)$item->counter;
                				$flag = true;
                				// echo "date = ".$item3.'   '."name_product = ".$item2.'	'."counter = ".$item->counter."</br>";
                			}
                		}
                		if ($flag){
                			$arr4[$i] = $zap->create($item3, $item2, $sum);
                			$i++;
                			$sum = 0;
                			$flag = false;
                		}
                		
                	}
                }
    return $arr4; 
 	}
 echo "____________________________________________________</br>";


  foreach ($arr3 as $key) {
  	echo $key."</br>";
  }
 echo "</br>";
  foreach ($arr2 as $key) {
  	echo $key."</br>";
  }
  foreach ($arr as $key) {
      	echo "date = ".$key->date.'   '."name_product = ".$key->name_product.'	'."counter = ".$key->counter."</br>";
       }
 echo "</br>";
       foreach ($arr4 as $key) {
       	echo "date = ".$key->date.'   '."name_product = ".$key->name_product.'	'."counter = ".$key->counter."</br>";
       }
?>