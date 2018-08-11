<?php
			$cur_date = "10.12.16";
			$pos_day = strpos($cur_date,".",0);
			$num_day = substr($cur_date,0,$pos_day);

			$pos_month = strpos($cur_date,".",3);
			$num_month = substr($cur_date, $pos_day+1, 2);

			$pos_year = strpos($cur_date,".",5);
			$num_year = substr($cur_date, $pos_year+1, 2);

			echo '20'.;
			

?>