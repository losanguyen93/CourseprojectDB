<?php
function connect_db(){
    $host = "localhost";
    $db_name = "kurwork";
    $login = "kurwork";
    $pswrd = "kurwork";
                 
                $conn = oci_connect("$login", "$pswrd", "$host");
                if (!$conn) {
                    $e = oci_error();
                  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                }
                else {
                  return $conn;
             }     

    }




?>