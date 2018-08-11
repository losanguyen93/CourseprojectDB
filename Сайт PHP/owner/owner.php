<?php
     session_start(); 
     if($_SESSION['status'] != 'owner'):
        header("Location: ../start/index.php");
     endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Владелец</title>
    <link href="http://bootstrap-3.ru/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
     include 'connect.php';
?>       
<ul id="myTab" class="nav nav-tabs">
    <li><a>Владелец</a></li>
    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Вывести список <b class="caret"></b></a><p></p>
        <ul class="dropdown-menu">
            <li class=""><a href="#sotrudnik" data-toggle="tab">Сотрудников</a></li>
            <li class=""><a href="#client" data-toggle="tab">Клиентов</a></li>
            <li class=""><a href="#product" data-toggle="tab">Продуктов</a></li>
            <li class=""><a href="#matrial" data-toggle="tab">Материалов</a></li>
        </ul>
    </li>
    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Сформировать отчет<b class="caret"></b></a><p></p>
    <ul class="dropdown-menu">
        <li class=""><a href="#doxod" data-toggle="tab">По доходам</a></li>
        <li class=""><a href="#rasxod" data-toggle="tab">По расходам</a></li>
        <li class=""><a href="#zp" data-toggle="tab">По зароботной плате</a></li>
    </ul>
    </li>
    <?php 
    if($_SESSION['status'] == 'owner'):
        if(isset($_POST['y'])){
        }
    ?>
    <li> <a href="../start/session_destroy.php" class="btn btn-large">Выйти</a></li>    
    <?php endif; ?> 
</ul>
<div id="myTabContent" style="text-align: center;" class="tab-content">
    Сегодня
    <script language="javascript" type="text/javascript">
        var d = new Date();
        var day=new Array("воскресенье","понедельник","вторник","среда","четверг","пятница","суббота");
        var month=new Array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
        document.write(day[d.getDay()]+" " +d.getDate()+ " " + month[d.getMonth()]+ " " + d.getFullYear() + " г.");
    </script>
 <div class="tab-pane fade"  id="sotrudnik">
        <p>
            Список сотрудников
             <?php
             $z = 1;
                $stid = oci_parse(connect_db(), 'SELECT ID_EMPLOYEES, SURNAME_E, NAME_E, PATRONYMIC_E, SEX, BIRTH FROM EMPLOYEES ORDER BY EMPLOYEES.ID_EMPLOYEES ');
                oci_execute($stid);
                echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                echo "<th><center>№</center></th>\n";
                echo "<th><center>Фамилия</center></th>\n";
                echo "<th><center>Имя</center></th>\n";
                echo "<th><center>Очество</center></th>\n";
                echo "<th><center>Пол</center></th>\n";
                echo "<th><center>Дата рождения</center></th>\n";
                  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                      echo "<tr>\n";
                      foreach ($row as $item) {
                            if ($item==$row['ID_EMPLOYEES']){
                                echo "<td>" . $z . "</td>\n";
                                $z = $z+1;
                            }
                            else{
                                echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                            }
                        }
                  echo "</tr>\n";
                  }
                  echo "</table>\n";
                  echo "</br>";
            ?>
        </p>
        <p></p>
    </div>
    <div class="tab-pane fade" id="client">
        <p>
            Список клиентов  
            <?php
                $z = 1;
                $stid = oci_parse(connect_db(), 'SELECT ID_CLIENTS, SURNAME_C, NAME_C, PATRONYMIC_C FROM CLIENTS ORDER BY ID_CLIENTS');
                oci_execute($stid);
                echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                echo "<th><center>№</center></th>\n";
                echo "<th><center>Фамилия</center></th>\n";
                echo "<th><center>Имя</center></th>\n";
                echo "<th><center>Очество</center></th>\n";
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                        foreach ($row as $item) {
                            if ($item==$row['ID_CLIENTS']){
                                echo "<td>" . $z . "</td>\n";
                                $z = $z+1;
                            }
                            else{
                                echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                            }
                        }
                    echo "</tr>\n";
                }
                echo "</table>\n";
            ?>     
        </p>
        <p></p>
    </div>
    <div class="tab-pane fade" id="product">
        <p>
            Список продуктов
            <?php
            $z = 1;
                $stid = oci_parse(connect_db(), 'SELECT PRODUCT.ID_PRODUCT, PRODUCT.NAME_PRODUCT, PRODUCT.PRICE, PRODUCT.COST_PRICE FROM PRODUCT ORDER BY PRODUCT.ID_PRODUCT');
                oci_execute($stid);
                echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                echo "<th><center>№</center></th>\n";
                echo "<th><center>Наименование продукта</center></th>\n";
                echo "<th><center>Стоимость 1 продукта</center></th>\n";
                // echo "<th><center>Количество</center></th>\n";
                echo "<th><center>Себестоимость</center></th>\n";
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                        foreach ($row as $item) {
                            if ($item==$row['ID_PRODUCT']){
                                echo "<td>" . $z . "</td>\n";
                                $z = $z+1;
                            }
                            else{
                                echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                            }
                        }
                    echo "</tr>\n";
                }
                echo "</table>\n";
            ?>        
        </p>
        <p></p>
    </div>
    <div class="tab-pane fade" id="matrial">
        <p>
            Список материалов
            <?php
                $stid = oci_parse(connect_db(), 'SELECT MATERIALS.DATE_M, EMPLOYEES.SURNAME_E, EMPLOYEES.NAME_E, EMPLOYEES.PATRONYMIC_E, MATERIALS.MATERIALS, MATERIALS.QUANTITY_M FROM EMPLOYEES LEFT JOIN MATERIALS ON EMPLOYEES.ID_EMPLOYEES = MATERIALS.ID_EMPLOYEES ORDER BY EMPLOYEES.SURNAME_E');
                oci_execute($stid);
                echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                echo "<th><center>Дата</center></th>\n";
                echo "<th><center>Фамилия</center></th>\n";
                echo "<th><center>Имя</center></th>\n";
                echo "<th><center>Очество</center></th>\n";
                echo "<th><center>Вид выданного материала</center></th>\n";
                echo "<th><center>Количество</center></th>\n";
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                        foreach ($row as $item) {
                            if ($item==$row['DATE_M']){
                                if($row['DATE_M']==null){
                                  break; 
                                }
                            }
                            echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n"; 
                        }
                    echo "</tr>\n";
                }
                echo "</table>\n";
            ?>        
        </p>
        <p></p>
    </div>
    <div class="tab-pane fade" id="doxod">
        <p>
            Отчет по доходам
            <?php
                $z = 1;
                $stid = oci_parse(connect_db(), 'SELECT CLIENTS.ID_CLIENTS, CLIENTS.SURNAME_C, CLIENTS.NAME_C, CLIENTS.PATRONYMIC_C, PRODUCT.NAME_PRODUCT, PRODUCT.PRICE, SALES.QUANTITY_SALE, SALES.REC_MONEY FROM (SALES LEFT JOIN PRODUCT ON SALES.ID_PRODUCT = PRODUCT.ID_PRODUCT) LEFT JOIN CLIENTS ON SALES.ID_CLIENTS = CLIENTS.ID_CLIENTS');
                oci_execute($stid);
                echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                echo "<th><center>№</center></th>\n";
                echo "<th><center>Фамилия клиента</center></th>\n";
                echo "<th><center>Имя клиента</center></th>\n";
                echo "<th><center>Очество клиента</center></th>\n";
                echo "<th><center>Наименование продукта</center></th>\n";
                echo "<th><center>Цена за 1 продукт</center></th>\n";
                echo "<th><center>Количество купленных продуктов</center></th>\n";
                echo "<th><center>Получено денег от клиента</center></th>\n";
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                        foreach ($row as $item) {
                            if ($item==$row['ID_CLIENTS']){
                                echo "<td>" . $z . "</td>\n";
                                $z = $z+1;
                            }
                            else{
                                echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                            }
                        }
                    echo "</tr>\n";
                }
                echo "</table>\n";
                 
            ?>    
        </p>
        <p></p>
    </div>
    <div class="tab-pane fade" id="rasxod">
        <p>
            Отчет по расходам 
            </br>
            <p>
            #1 Долги клиентов
            </p>
            <?php
                $z = 1;
                $stid = oci_parse(connect_db(), 'SELECT CLIENTS.ID_CLIENTS, CLIENTS.SURNAME_C, CLIENTS.NAME_C, CLIENTS.PATRONYMIC_C, PRODUCT.NAME_PRODUCT, PRODUCT.PRICE, SALES.QUANTITY_SALE, SALES.REC_MONEY FROM (SALES LEFT JOIN PRODUCT ON SALES.ID_PRODUCT = PRODUCT.ID_PRODUCT) LEFT JOIN CLIENTS ON SALES.ID_CLIENTS = CLIENTS.ID_CLIENTS');
                oci_execute($stid);
                echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                echo "<th><center>№</center></th>\n";
                echo "<th><center>Фамилия клиента</center></th>\n";
                echo "<th><center>Имя клиента</center></th>\n";
                echo "<th><center>Очество клиента</center></th>\n";
                echo "<th><center>Наименование продукта</center></th>\n";
                echo "<th><center>Цена за 1 продукт</center></th>\n";
                echo "<th><center>Количество купленных продуктов</center></th>\n";
                echo "<th><center>Клиент должен оплатить</center></th>\n";
                echo "<th><center>Долг клиента</center></th>\n";
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                        foreach ($row as $item) {
                            if ($item==$row['ID_CLIENTS']){
                                echo "<td>" . $z . "</td>\n";
                                $z = $z+1;
                            }
                            elseif ($item==$row['REC_MONEY']){
                                $rec_money = $row['REC_MONEY'];
                                $debt = $rez-$rec_money;
                                echo "<td>" . $debt . "</td>\n";
                            }
                            elseif($item==$row['QUANTITY_SALE']){
                                $price = $row['PRICE'];
                                $quantity = $row['QUANTITY_SALE'];
                                $rez = $price*$quantity;
                                echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                                echo "<td>" . $rez . "</td>\n";
                             }
                            else{
                                echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                                   
                            }
                        }
                    echo "</tr>\n";
                }
                echo "</table>\n";
            ?>  
            </br> 
            #2 Заработная плата сотрудников
            <?php
                $stid = oci_parse(connect_db(), 'SELECT SALARY.DATE_SALARY, EMPLOYEES.SURNAME_E, EMPLOYEES.NAME_E, EMPLOYEES.PATRONYMIC_E, SALARY.REC_SALARY FROM SALARY LEFT JOIN EMPLOYEES ON EMPLOYEES.ID_EMPLOYEES = SALARY.ID_SALARY ORDER BY SALARY.DATE_SALARY');
                oci_execute($stid);
                echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                echo "<th><center>Дата</center></th>\n";
                echo "<th><center>Фамилия</center></th>\n";
                echo "<th><center>Имя</center></th>\n";
                echo "<th><center>Очество</center></th>\n";
                echo "<th><center>Зароботная плата</center></th>\n";
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                        foreach ($row as $item) {
                            echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                        }
                    echo "</tr>\n";
                }
                echo "</table>\n";
            ?> 

        </p>
        <p></p>
    </div>
    <div class="tab-pane fade" id="zp">
        <p>
            Заработная плата 
            <?php
                $stid = oci_parse(connect_db(), 'SELECT SALARY.DATE_SALARY, EMPLOYEES.SURNAME_E, EMPLOYEES.NAME_E, EMPLOYEES.PATRONYMIC_E, SALARY.REC_SALARY FROM SALARY LEFT JOIN EMPLOYEES ON EMPLOYEES.ID_EMPLOYEES = SALARY.ID_SALARY ORDER BY SALARY.DATE_SALARY');
                oci_execute($stid);
                echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                echo "<th><center>Дата</center></th>\n";
                echo "<th><center>Фамилия</center></th>\n";
                echo "<th><center>Имя</center></th>\n";
                echo "<th><center>Очество</center></th>\n";
                echo "<th><center>Зароботная плата</center></th>\n";
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr>\n";
                        foreach ($row as $item) {
                            echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
                        }
                    echo "</tr>\n";
                }
                echo "</table>\n";
            ?>
        </p>
        <p></p>
    </div>
    <p></p>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://bootstrap-3.ru/dist/js/bootstrap.min.js"></script>
    <script src="http://bootstrap-3.ru/assets/js/docs.min.js"></script>
  </body>
</html>
