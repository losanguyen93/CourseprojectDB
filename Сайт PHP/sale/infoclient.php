<?php

    $stid = oci_parse(connect_db(), 'SELECT ID_CLIENTS, SURNAME_C, NAME_C, PATRONYMIC_C FROM CLIENTS ORDER BY CLIENTS.ID_CLIENTS');
	oci_execute($stid);

	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

		echo'<div class="tab-pane fade" style="margin-left:30px;" id="dropdown'.$row['ID_CLIENTS'].'">';
			echo'<div >';
				$pr = $row['ID_CLIENTS'];
			    echo'<p>';
			    echo'Информация по клиенту '.$row['SURNAME_C'].' '.$row['NAME_C'].' '.$row['PATRONYMIC_C'].':';
			    echo'</br>';
			    echo'</p>';
			    echo'<p></p>';
			echo'</div>';
	
	$stid1 = oci_parse(connect_db(), 'SELECT CLIENTS.ID_CLIENTS, CLIENTS.SURNAME_C, CLIENTS.NAME_C, CLIENTS.PATRONYMIC_C, PRODUCT.NAME_PRODUCT, PRODUCT.PRICE, SALES.QUANTITY_SALE, SALES.REC_MONEY FROM (SALES LEFT JOIN PRODUCT ON SALES.ID_PRODUCT = PRODUCT.ID_PRODUCT) LEFT JOIN CLIENTS ON SALES.ID_CLIENTS = CLIENTS.ID_CLIENTS');
             oci_execute($stid1);
             while ($row1 = oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){

             if ($pr == $row1['ID_CLIENTS']){
             	echo'Наименование купленного продукта: '.$row1['NAME_PRODUCT'];
	            echo '</br>';
	            echo'Количество продуктов: '.$row1['QUANTITY_SALE'];
	            echo '</br>';
	            echo'Цена за 1 продукт: '.$row1['PRICE'];
	            echo '</br>';
	            $proizv = $row1['PRICE']*$row1['QUANTITY_SALE'];
	            echo'Общая цена: '.$proizv;
	            echo '</br>';
	            echo'Получено денег от клиента: '.$row1['REC_MONEY'];
	            echo '</br>';
	    		
	    		$razn = $proizv-$row1['REC_MONEY'];
	            echo'Долг клиента: '.$razn;
	            echo '</br>';
	          }
			}
        echo'</div>';
    }
?>