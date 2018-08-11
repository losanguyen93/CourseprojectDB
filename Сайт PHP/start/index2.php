<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Авторизация</title>
    <link href="http://bootstrap-3.ru/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
<body>
  <div style="margin-left:20px;">
  	<font size = "2">
  	</br>Здравствуйте, авторизуйтесь в системе пожалуйста.
     <?php
        $stid=$_GET['b'];
        if ($stid==0){
          echo '</br>';
          echo 'Вы ввели неверные данные!!!';
        }
    ?>
    	<form  action="authorize.php" method="POST">
    		</br>
        <table  cellspacing="0" cellpadding="4">
      		<tr>
      			<td align="left">Логин:</td>
      		 	<td><input type="text" placeholder="Логин" name="user_name" class="span4"></td>
      		</tr>
      		<tr>
      			<td align="left">Пароль:</td>
      			<td><input type="password" placeholder="Пароль" name="user_pass" class="span4"></td>
      		</tr>
      		<tr>
      			<td></br><input class="btn btn-primary btn-large span3" type="submit"></td>
      		</tr>
    		</table>
    	</form>
    </font>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    	<script src="http://bootstrap-3.ru/dist/js/bootstrap.min.js"></script>
    	<script src="http://bootstrap-3.ru/assets/js/docs.min.js"></script>

	</body>
</html>
