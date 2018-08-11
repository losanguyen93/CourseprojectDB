<?php
		
	include 'Struct.php';
  include 'connect.php';
  $product_beforedate = "2016-12-02";
  $product_afterdate = "2016-12-06";
    $zap = Struct::factory('date', 'id_product', 'quantity_mw');
    $zap2 = Struct::factory('date','name_product', 'quantity_mw', 'price', 'salary');
   
    $id_emp = '1';
    
              //$pos = strpos($name_employees_m," ");
              //$id_emp = (int)substr($name_employees_m,0,$pos);

    $i = 0;
    $j = 0;


          		$stid = oci_parse(connect_db(), 'SELECT DATE_MADE_WARES, ID_PRODUCT, QUANTITY_MW FROM MADE_WARES WHERE (DATE_MADE_WARES >= TO_DATE(:bind_product_beforedate, \'YYYY-MM-DD HH24:MI:SS\') AND DATE_MADE_WARES <= TO_DATE(:bind_product_afterdate, \'YYYY-MM-DD HH24:MI:SS\')) AND (:bind_id_emp = ID_EMPLOYEES) ORDER BY DATE_MADE_WARES');
                oci_bind_by_name($stid, ":bind_id_emp", $id_emp);
                oci_bind_by_name($stid, ":bind_product_beforedate", $product_beforedate);
                oci_bind_by_name($stid, ":bind_product_afterdate", $product_afterdate);
                oci_execute($stid);
            		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                                  		
                  		foreach ($row as $item) {
                   			
                   				if ($j == 0) $date = $item;
                   				if ($j == 1) $id_product = $item;
                   				if ($j == 2) $quantity_mw = $item;
                   			
                        $j++;
 
                  		}
                    
                  	 $arr[$i] = $zap->create($date, $id_product, $quantity_mw);
                      // echo "date = ".$arr[$i]->date."  "."id_product = ".$arr[$i]->id_product."  "."quantity_mw = ".$arr[$i]->quantity_mw."</br>";
                      $i++;
                   	  $j = 0;
                      
                	}
                  // echo "</br>";
                  // echo "</br>";

                 
              
      $i = 0;
      $j = 0;
          foreach ($arr as $item2) {

              //echo  $item2->id_product;
              $stid = oci_parse(connect_db(), 'SELECT NAME_PRODUCT, PRICE FROM PRODUCT WHERE ID_PRODUCT = :bind_id_product');
                oci_bind_by_name($stid, ":bind_id_product", $item2->id_product);
                oci_execute($stid);
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                                      
                      foreach ($row as $item) {
                          if ($j == 0) $name_product = $item;
                          if ($j == 1) $price = $item;
                          $j++;                                                       
                      }
                   // echo "date = ".$item2->date."  "."id_product = ".$name_product."  "."quantity_mw = ".$item2->quantity_mw."  "."price = ".$price."  "." salary = ". (string)((((int)$item2->quantity_mw*(int)$price)/100)*15)."</br>";

                    $salary = (string)((((int)$item2->quantity_mw*(int)$price)/100)*15);
                  
                  
                     $arr2[$i] = $zap2->create($item2->date, $name_product,$item2->quantity_mw, $price, $salary);
                    $i++;
                    $j=0;
                  }
          }

          // foreach ($arr2 as $key ) {
          //   echo "date = ".$key->date."  "."id_product = ".$key->name_product."  "."quantity_mw = ".$key->quantity_mw."  "."price = ".$key->price."  "." salary = ".$key->salary."</br>";
          // }
              


?>