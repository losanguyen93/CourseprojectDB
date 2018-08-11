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
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
         <li class="active"><a href="manager.php">Ввод показателей за день</a></li>
          <li><a href="add_products.php?a=1">Продукция</a></li>
          <li><a href="add_employees.php">Сотрудники</a></li>
          <li><a href="salary.php?a=1">Подсчет зарплата сотрудника</a></li>
          <!-- выйти с сессии-->
            <li><a href=" ../start/session_destroy.php" style="float:right">Выйти</a></li>
          <!-- конец выхода-->
        </ul>
      </div>
    </div>
 
 </br>
 </br>
 </br>
 
 <?php 
    include 'connect.php';
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

    function outlist_product(){
   
   
                $stid = oci_parse(connect_db(), 'SELECT NAME_PRODUCT FROM PRODUCT');
                  oci_execute($stid);
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                  foreach ($row as $item) {
                      echo"<option>".$item."</option>";
                  }
                }
               
    }    
 ?>

 <div class="container outline">
 <h4>   Ввод количесво выданных материалов за день для каждого рабочего</h4>
 </br>

           <div class="row span12">
              <p class="span2"> Дата </p>
              <p class="span4"> ФИО Сотрудника И ID </p>
              <p class="span3"> Наименование материала</p>
              <p class="span2"> Количество </p>        
            </div>   
     
          <form action="Fuction4.php" method="post" class="span12">
            <div class="row my_span ">
              <input type="date" name="date_materials" class="span2">
              <select class="span4" name="employees"><?php outlist_employees(); ?> </select>
              <input type="text" name="materials" class="span3">
              <input type="text" name="quantity_m" class="span2">        
            </div>   
            <div class="row my_span">
              <input class="btn btn-primary btn-large span3" type="submit" value="Отправить в БД" name="BDbtn1" />
            </div>     
          </form>
  </br>
 </div>

</br>
</br>



 <div class="container outline">
  <h4>  Ввод успеваемости рабочих за день </h4>
 </br>

           <div class="row span12">
              <p class="span2"> Дата </p>
              <p class="span4"> ФИО Сотрудника И ID </p>
              <p class="span3"> Наименование товара </p>
              <p class="span2"> Количество </p>        
            </div>   
     
          <form action="Fuction3.php" method="post" class="span12">
            <div class="row my_span ">
              <input type="date" name="date_made_wares" class="span2">
              <select class="span4" name="employees"><?php outlist_employees(); ?> </select>
              <select class="span3" name="product"><?php outlist_product(); ?> </select>
              <input type="text" name="quantity_p" class="span2">        
            </div>   
            <div class="row my_span">
              <input class="btn btn-primary btn-large span3" type="submit" value="Отправить в БД" name="BDbtn" />
            </div>     
          </form>
  </br>
 </div>
 
  


    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>