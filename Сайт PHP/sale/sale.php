<?php
     session_start(); 
     if($_SESSION['status'] != 'sale'):
        header("Location: ../start/index.php");
     endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Отдел продаж</title>
    <link href="http://bootstrap-3.ru/dist/css/bootstrap.min.css" rel="stylesheet">
 </head>
<body>
<?php
     include 'connect.php';
?>       
<ul id="myTab" class="nav nav-tabs">
    <li><a>Отдел продаж</a></li>
    <li class="active"><a href="#home" data-toggle="tab">Ввести клиента</a></li>
    <li class=""><a href="#add" data-toggle="tab">Ввести данные о покупках</a></li>
    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Выбрать клиента <b class="caret"></b></a><p></p>
        <ul class="dropdown-menu">
            <?php
            $stid = oci_parse(connect_db(), 'SELECT ID_CLIENTS, SURNAME_C, NAME_C, PATRONYMIC_C FROM CLIENTS ORDER BY CLIENTS.ID_CLIENTS');
            oci_execute($stid);  
            while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                echo '<li class=""><a href="#dropdown'.$row['ID_CLIENTS'].'" data-toggle="tab">'.$row['SURNAME_C'].' '.$row['NAME_C'].' '.$row['PATRONYMIC_C'].'</li>';

                }
            ?>
            <li class=""><a href="#" data-toggle="tab"></a></li>
        </ul>
    </li>
    <?php 
    if($_SESSION['status'] == 'sale'):
        if(isset($_POST['y'])){
        }
    ?>
    <li> <a href="../start/session_destroy.php" name = "y" class="btn btn-large">Выйти</a></li> 
    <?php endif; ?> 
</ul>
<div id="myTabContent" class="tab-content">
    <div>
        <p>
            <center>    Сегодня
                <script language="javascript" type="text/javascript">
                    var d = new Date();
                    var day=new Array("воскресенье","понедельник","вторник","среда","четверг","пятница","суббота");
                    var month=new Array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
                    document.write(day[d.getDay()]+" " +d.getDate()+ " " + month[d.getMonth()]+ " " + d.getFullYear() + " г.");
                </script>
            </center>
        </p>
    </div>
    <div class="tab-pane fade active in" id="home">
        <div style="margin-left:30px";>
            <form action="function1.php" method="post" class="span12">
                <p>
                    Введите двнные о новом клиенте: 
                </p>
                <p>
                    <input type="text" placeholder="Фамилия" name="surname" class="span4">
                    <input type="text" placeholder="Имя" name="name" class="span4"> 
                    <input type="text" placeholder="Очество" name="patronymic" class="span4">
                </p>
                <p>
                    <input class="btn btn-primary btn-large span3" type="submit">
                </p>
                <center>
                    <p>
                        Список клиентов 
                    </p>
                </center>
            </form>
        </div>
        <div style="text-align: center;">
            <?php
                $z = 1;
                $stid = oci_parse(connect_db(), 'SELECT ID_CLIENTS, SURNAME_C, NAME_C, PATRONYMIC_C FROM CLIENTS ORDER BY CLIENTS.ID_CLIENTS');
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
        </div>
    </div>
<?php 
    function outlist_clients(){         
        $stid = oci_parse(connect_db(), 'SELECT ID_CLIENTS, SURNAME_C, NAME_C, PATRONYMIC_C FROM CLIENTS ORDER BY ID_CLIENTS');
          oci_execute($stid);
      while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $st = "";      
        foreach ($row as $item) {
                $st = $st.$item." ";
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

    <div class="tab-pane fade" id="add">
        <div style="margin-left:30px";>
            <form action="function2.php" method="post" class="span12">
                <p>
                    Введите двнные о покупках: 
                </p>
                <p>
                    <select class="span4" name="clients"><?php outlist_clients(); ?> </select>
                    <select class="span3" name="product"><?php outlist_product(); ?> </select>
                    <input type="text" placeholder="Количество" name="quantity_sale" class="span4"> 
                    <input type="text" placeholder="Заплачено" name="rec_money" class="span4">
                    <input type="date" name="date_sale" class="span4">
                </p>
                <p>
                    <input class="btn btn-primary btn-large span3" type="submit">
                </p>
            </form>
        </div>
        <div style="text-align: center;">
            <center>
                <p>
                    Стоимость продуктов
                </p>
            </center>
            <?php
                $z = 1;
                $stid = oci_parse(connect_db(), 'SELECT ID_PRODUCT, NAME_PRODUCT, PRICE FROM PRODUCT ORDER BY PRODUCT.ID_PRODUCT');
                oci_execute($stid);
                echo "<table border= \"2\" class=\'\"table\" width=\"100%\" cellpadding=\"5\">\n";
                echo "<th><center>№</center></th>\n";
                echo "<th><center>Продукт</center></th>\n";
                echo "<th><center>Стоимость</center></th>\n";
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
        </div>
    </div>
    <?php
        include "infoclient.php";
    ?>
    <p></p>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://bootstrap-3.ru/dist/js/bootstrap.min.js"></script>
    <script src="http://bootstrap-3.ru/assets/js/docs.min.js"></script>
  </body>
</html>