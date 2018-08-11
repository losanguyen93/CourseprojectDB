<?php
	 session_start(); 
	 if($_SESSION['status'] != 'manager'):
		header("Location: ../start/index.php");
	 endif;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Manager site</title>
    <script src="https://code.jquery.com/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
  
    <div class="navbar">
      <div class="navbar-inner">
        <a class="brand" href="manager.php">Администратор</a>
        <ul class="nav">
         <li><a href="manager.php">Ввод показателей за день</a></li>
          <li class="active"><a href="add_products.php?a=1">Продукция</a></li>
          <li><a href="add_employees.php">Сотрудники</a></li>
          <li><a href="salary.php?a=1">Подсчет зарплата сотрудника</a></li>
          <!-- выйти с сессии-->
            <li><a href=" ../start/session_destroy.php" style="float:right" name = "y">Выйти</a></li>
          <!-- конец выхода-->
        </ul>
      </div>
    </div>

    <div class="container">
      <div class="row">
          <form class="span12" action="Fuction2.php" method="post">
            <p class="span4" >От: <input type="date" name="befordate"/></p>
            <p class="span4" >  До: <input type="date" name="afterdate"/></p>
            <p><input class="btn btn-primary" type="submit" value="OK" name="BDbtn" onClick="get_data()"/></p>
          </form>
      </div>
      <div class="row">
            <div class="span12">
             
                
 
   
  <?php
 include 'connect.php';
 //include 'auto_fill.php';
 include 'Struct.php';

  if ((int)$_GET["a"] == 2){
    button_BDbtn2_P($_GET["b"], $_GET["c"]);
  }
    function button_BDbtn2_P($product_beforedate, $product_afterdate){
    //echo $product_beforedate;
    if ($product_beforedate == "" or $product_afterdate == ""){
      echo "error - because no data";
    }
    else{
      if ($product_beforedate > $product_afterdate){
      echo "error - because input data not correct";
    }
    else{       
                echo "Продукты сделанные";
                   echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                   //echo "<th>№</th>\n";
                   echo "<th>Дата</th>\n";
                   echo "<th>Название продукта</th>\n";
                   echo "<th>Количество</th>\n";
                  // while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    $arr = auto_fill($product_beforedate, $product_afterdate);
                    foreach ($arr as $item) {
                        echo "<tr>\n";
                          echo "<td>" .$item->date. "</td>\n";
                          echo "<td>" .$item->id_product. "</td>\n";
                          echo "<td>" .$item->counter. "</td>\n";
                        echo "</tr>\n";
                      }
                  
                  
                  echo "</table>\n";
                  echo "</br>";  
        } 
      }
 }
                   
echo "</br>";
echo "</br>";
  echo "Наименование продуктов и цены";
               $stid = oci_parse(connect_db(), 'SELECT * FROM PRODUCT');
                oci_execute($stid);
                   echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                   //echo "<th>№</th>\n";
                   echo "<th>№</th>\n";
                   echo "<th>Наименование</th>\n";
                   echo "<th>Цена</th>\n";
                   echo "<th>Себестоимость</th>\n";
                  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                      echo "<tr>\n";
                      foreach ($row as $item) {
                        echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                      }
                  echo "</tr>\n";
                  }
                  echo "</table>\n";
                  echo "</br>";  


function auto_fill($product_beforedate, $product_afterdate){
  //arr - масств записи
  //arr2 -массив уникального не повтеряющего название продукта
  //arr3 - масств уникального не повтеряющего даты
    $i = 0;
    $j = 0;
    $zap = Struct::factory('date', 'id_product', 'counter');
    $zap2 = Struct::factory('id', 'name_product');
    
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
    $j = 0;
                $stid = oci_parse(connect_db(), 'SELECT DISTINCT ID_PRODUCT, NAME_PRODUCT FROM PRODUCT ORDER BY ID_PRODUCT');
                oci_execute($stid);
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                
                      foreach ($row as $item) {
                          if ($j == 0) $id_product = $item;
                          if ($j == 1) $name_product = $item;
                          $j++;                             
                      }
                      $arr2[$i] = $zap2->create($id_product,$name_product);
                      $i++;
                      $j=0;
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
                      if (($item3 == $item->date) and ($item2->id == $item->id_product)) {
                        $sum = $sum + (int)$item->counter;
                        $flag = true;
                        // echo "date = ".$item3.'   '."name_product = ".$item2.' '."counter = ".$item->counter."</br>";
                      }
                    }
                    if ($flag){
                      $arr4[$i] = $zap->create($item3, $item2->name_product, $sum);
                      $i++;
                      $sum = 0;
                      $flag = false;
                    }
                    
                  }
                }
    return $arr4; 
  }










?>
                                   
        </div>
          Добавление нового продукта.
          <form action="Fuction2.php" method="post">
            <div class="row">
                <div class="span12">              
                  <input type="text" placeholder="Название продукта" name="name" class="span4">
                  <input type="text" placeholder="Цена за 1 шт" name="price" class="span4">
                  <input type="text" placeholder="Себестоимость" name="costing" class="span4">           
                </div>
            </div>
            <div class="row">
               <input class="btn btn-primary btn-large" type="submit" value="Отправить в БД" name="BDbtn" />
            </div>            
          </form>
        </div>
    </div>   

    
  </body>
</html>