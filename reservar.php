<?php 
	include "header.php";
	if (isset($_GET['reservar'])) {
		if (is_numeric($_GET['reservar'])) {
			if ($_GET['reservar'] == 1) {
				$dreamtour->reservar();
			}
		}
	}
 ?>