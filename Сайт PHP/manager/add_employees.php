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

  <body>
  
    <div class="navbar">
      <div class="navbar-inner">
        <a class="brand" href="manager.php">Администратор</a>
        <ul class="nav">
         <li><a href="manager.php">Ввод показателей за день</a></li>
           <li><a href="add_products.php?a=1">Продукция</a></li>
          <li class="active"><a href="add_employees.php">Содтрудники</a></li>
          <li><a href="salary.php?a=1">Подсчет зарплата сотрудника</a></li>
          <!-- выйти с сессии-->
             <li><a href="../start/session_destroy.php" style="float:right" name = "y">Выйти</a></li>
          <!-- конец выхода-->
        </ul>
      </div>
    </div>

    <div class="container">
      <div class="row">
    
        <div class="span12">
              <?php
                  include 'connect.php';
                  $stid = oci_parse(connect_db(), 'SELECT SURNAME_E, NAME_E, PATRONYMIC_E, SEX, BIRTH FROM EMPLOYEES ORDER BY ID_EMPLOYEES');
                  oci_execute($stid);
                  echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                   //echo "<th>№</th>\n";
                   echo "<th>Фамилия</th>\n";
                   echo "<th>Имя</th>\n";
                   echo "<th>Очество</th>\n";
                   echo "<th>Пол</th>\n";
                   echo "<th>Дата рождения</th>\n";
                  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                      echo "<tr>\n";
                      foreach ($row as $item) {
                        echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                      }
                  echo "</tr>\n";
                  }
                  echo "</table>\n";
                  echo "</br>";
              ?>
                                   
        </div>

        <div class="row">
          <form action="Fuction.php" method="post" class="span12">
              <input type="text" placeholder="Фамилия" name="surname" class="span4">
              <input type="text" placeholder="Очество" name="name" class="span4">
              <input type="text" placeholder="Имя" name="patronymic" class="span4">
             <div class="row">
              <p class="span1">Пол :</p>
              <input class="span1" type="radio" name="sex" value= "m">М<br>
              <input class="span1" type="radio" name="sex" checked value= "f">Ж<br> 
             </div>            
            <p>Дата Рождения: <input type="date" name="birth" class="span4" /></p>
            
            <p><input class="btn btn-primary btn-large span3" type="submit" value=" Отправить в БД "/></p>
          </form>
        </div>

        
      </div>
    </div>
  
   
  


    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>