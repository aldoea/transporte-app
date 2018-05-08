<?php
	header("Content-Type: text/html;charset=utf-8");
	$tipos=$dreamtour->getTipos();
	echo '<select required="true" class="form-control" name="tipo">';
	foreach ($tipos as $tipo) {
		$tipo_name = ucwords($tipo['nombre']);
		if (isset($id_tipo)) {
			if ($id_tipo == $tipo['id']) {
				echo '<option selected value="'.$tipo['id'].'">'.$tipo_name.'</option>';
			}else{
				echo '<option value="'.$tipo['id'].'">'.$tipo_name.'</option>';
			}			
		}else{
			echo '<option value="'.$tipo['id'].'">'.$tipo_name.'</option>';
		}		
	}	
	echo '</select>';	
?>