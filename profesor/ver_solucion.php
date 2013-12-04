<?

if (isset($_POST['calificacion']) && $_POST['calificacion'] != '') {
	$sql="UPDATE soluciones SET calificacion=".$_POST['calificacion']." WHERE id_solucion=".$_GET['solucion'];
	
	if (mysql_query($sql, $conexion)) {
?>
		<div class="alert-message success">
			<p>Calificación de la solución actualizada con éxito</p>
		</div>
<?
	} else {
?>
		<div class="alert-message error">
			<p><strong>ERROR: </strong>No se pudo asignar la calificación</p>
		</div>
<?
	}
}

$res_solucion=obtener_solucion($_GET['solucion']);

if (mysql_num_rows($res_solucion) == 0) {
?>
	<div class="alert-message error">
		<p><strong>ERROR: </strong>No se ha encontrado la solución</p>
	</div>
<?
} else {
	$solucion=mysql_fetch_array($res_solucion);
	
	if (is_null($solucion['calificacion'])) {
		$color="warning";
	} elseif ($solucion['calificacion'] >= 5) {
		$color="success";
	} else {
		$color="error";
	}
?>
	<div class="alert-message block-message <?=$color?>">
		<?=$solucion['solucion']?>

<?
	//Si tiene adjunto, mostramos el enlace para descargarlo.
	if ($solucion['archivo'] != '') {
?>
		<a class="btn success" href="/ejercicios/adjuntos/<?=$solucion['archivo']?>" target="_blank">Descargar adjunto</a><br/>
<?
	}
?>
	</div>

	<form action="/ejercicios/index.php?accion_profesor=ver_solucion&solucion=<?=$_GET['solucion']?>" method="POST">
		<div class="clearfix">
			<label>Calificación:</label>
			<div class="input">
				<select name="calificacion">
					<option value="">-- Califica este ejercicio --</option>
<?
					for ($i=0; $i <= 10; $i++) {
						if (!is_null($solucion['calificacion']) && $solucion['calificacion'] == $i) {
							$seleccionada="selected='selected'";
						} else {
							$seleccionada="";
						}
?>
					<option value="<?=$i?>" <?=$seleccionada?>><?=$i?></option>
<?
					}
?>
				</select>
			</div>
		</div>
		
		<div class="clearfix">
			<input class="btn primary" type="submit" name="calificar" value="Califica esta solución"/>
			<a class="btn error" href="/ejercicios/index.php?accion_profesor=soluciones_ejercicio&ejercicio=<?=$solucion['id_ejercicio']?>">Cancelar</a>
		</div>
	</form>
<?
}
?>