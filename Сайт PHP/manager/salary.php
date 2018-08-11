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

   <style>
  .outline {
    width: 1000px; height: 200px; /* Размеры */
    background: #c0c0c0; /* Цвет фона */
    outline: 2px solid #000; /* Чёрная рамка */
    border: 3px solid #fff; /* Белая рамка */
    border-radius: 10px; /* Радиус скругления */
   }
  .my_span{
    font-size: 30px;
  }
  </style>


  <body>

   <div class="navbar">
      <div class="navbar-inner">
        <a class="brand" href="manager.php">Администратор</a>
        <ul class="nav">
         <li><a href="manager.php">Ввод показателей за день</a></li>
          <li><a href="add_products.php?a=1">Продукция</a></li>
          <li><a href="add_employees.php">Сотрудники</a></li>
          <li class="active"><a href="salary.php?a=1">Подсчет зарплата сотрудника</a></li>
          <!-- выйти с сессии-->
            <li><a href=" ../start/session_destroy.php" style="float:right" name = "y">Выйти</a></li>
          <!-- конец выхода-->
        </ul>
      </div>
    </div>
<div class="container">
<?php 
  include 'connect.php';
  include 'Struct.php';
  if ((int)$_GET["a"] == 2){
    $product_beforedate = $_GET["b"];
    $product_afterdate = $_GET["c"];

     //echo $product_beforedate;
    if ($product_beforedate == "" or $product_afterdate == ""){
      echo "error - because no data";
    }
    else{
      if ($product_beforedate > $product_afterdate){
      echo "error - because input data not correct";
     }
      else{ $sum = 0;      
            $arr2 = calculator($product_beforedate, $product_afterdate, $_GET["d"]); 
            echo "Зарплата за каждой выполненной модели сотрудника (15% от цены)";
                   echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                   //echo "<th>№</th>\n";
                   echo "<th>Дата</th>\n";
                   echo "<th>Название продукта</th>\n";
                   echo "<th>Количество</th>\n";
                   echo "<th>Цена</th>\n";
                   echo "<th>Зарплата</th>\n";
                  // while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    foreach ($arr2 as $item) {
                        echo "<tr>\n";
                          echo "<td>" .$item->date. "</td>\n";
                          echo "<td>" .$item->name_product. "</td>\n";
                          echo "<td>" .$item->quantity_mw. "</td>\n";
                          echo "<td>" .$item->price. "</td>\n";
                          echo "<td>" .$item->salary. "</td>\n";
                          $sum = $sum + (int)$item->salary;
                        echo "</tr>\n";
                      }
                  
                  
                  echo "</table>\n";
                  echo "</br>";
            
           
            echo "<h3>Итого зарлата = ".$sum."</h3>";        
        } 
      }   
  }




    function outlist_employees(){
   
                $stid = oci_parse(connect_db(), 'SELECT ID_EMPLOYEES, SURNAME_E, NAME_E, PATRONYMIC_E FROM EMPLOYEES ORDER BY ID_EMPLOYEES');
                  oci_execute($stid);
      while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $st = "";
        foreach ($row as $item) {
            $st = $st.$item."  ";   
        }
        echo"<option>".$st."</option>";
      }
    }
    function calculator($product_beforedate, $product_afterdate, $id_emp){
    $zap = Struct::factory('date', 'id_product', 'quantity_mw');
    $zap2 = Struct::factory('date','name_product', 'quantity_mw', 'price', 'salary');
   
   

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
return $arr2;

}

  
?>







 <div class="container outline">
 <h4>Ввод параметров для подчета</h4>
 </br>

           <div class="row span12">
              
              <p class="span4"> ФИО Сотрудника И ID </p>
              <p class="span3">От</p>
              <p class="span3">До </p>        
            </div>   
     
           <form action="Help_salary.php" method="post" class="span12">
            <div class="row my_span ">
             
              <select class="span4" name="employees" id="name"><?php outlist_employees(); ?> </select>
              <input type="date" name="befordate" class="span3" id="befordate"/>
              <input type="date" name="afterdate" class="span3" id="afterdate"/>      
            </div>   
            <div class="row my_span">
             
              <input class="btn btn-primary btn-large span3" type="submit" value="Отправить в запрос" name="BDbtn1"/>
            </div>     
          </form>
  </br>
 </div>

    
  </body>
</html>