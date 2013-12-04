<?
$mostrar_formulario=TRUE;
$res_asignatura=obtener_asignatura_ejercicio($_GET['ejercicio']);
if (mysql_num_rows($res_asignatura) == 0 ) {
	$mostrar_formulario=FALSE;
?>
	<div class="alert-message error">
		<p><strong>ERROR: </strong>No se encuentra la asignatura para este ejercicio</p>
	</div>
<?
} else {
	$asignatura=mysql_fetch_array($res_asignatura);
	if (isset($_POST['solucion'])) {
		if (empty($_POST['solucion'])) {
?>
			<div class="alert-message error">
				<p><strong>ERROR: </strong>Debe escribir algún texto en la solución</p>
			</div>
<?			
		} else {
			$adjunto=FALSE;
			//Guardar solución
			if ($_FILES["adjunto"]["error"] > 0) 
			{
				//El error 4 indica que no se subió ningún archivo.
				if ($_FILES["adjunto"]["error"] == 4) {
					$adjunto='';
				} else {
?>
				<div class="alert-message error">
					<p><strong>ERROR: </strong>No se pudo adjuntar el archivo</p>
				</div>
<?
				}
			 } else {
				/*
				echo "Nombre: " . $_FILES["adjunto"]["name"] . "<br />";
				echo "Tipo: " . $_FILES["adjunto"]["type"] . "<br />";
				echo "Tamaño: " . ($_FILES["adjunto"]["size"] / 1024) . " Kb<br />";
				echo "Está guardado en: " . $_FILES["adjunto"]["tmp_name"];
				*/
				//Permitimos como máximo archivos de 5Mb: 5x1024x1024.
				if ($_FILES["adjunto"]["size"] > 5242880) {
?>
					<div class="alert-message error">
						<p><strong>ERROR: </strong>el archivo adjunto excede el tamaño máximo permitido (<strong>5Mb</strong>)</p>
					</div>
<?
				} else {
					move_uploaded_file($_FILES["adjunto"]["tmp_name"], "adjuntos/" . $_FILES["adjunto"]["name"]);
					$adjunto=$_FILES["adjunto"]["name"];
				}
			}
			
			if ($adjunto !== FALSE) {
				$sql="INSERT INTO soluciones (id_ejercicio, id_alumno, solucion, archivo)
					  VALUES (".$_GET['ejercicio'].", ".$_SESSION['id_alumno'].", '".$_POST['solucion']."', '".$adjunto."')";
			
				if (mysql_query($sql, $conexion)) {
					$mostrar_formulario=FALSE;					
?>
					<div class="alert-message success">
						<p><strong>Enhorabuena: </strong>Solución enviada con éxito</p>
					</div>
<?
				} else {
?>
					<div class="alert-message error">
						<p><strong>ERROR: </strong>Ocurrió un error al enviar su solución</p>
					</div>
<?
				}
			}
		}
	} 
}

if ($mostrar_formulario) {
	$sql="SELECT * FROM ejercicios WHERE id_ejercicio=".$_GET['ejercicio'];
	$res_ejercicio=mysql_query($sql, $conexion);
	$ejercicio=mysql_fetch_array($res_ejercicio);
	?>

	<div class="alert-message block-message info">
	<h4>Ejercicio:</h4>
	<br/>
	<?=$ejercicio['ejercicio']?>
	</div>
	<br/>
	<form action="/ejercicios/index.php?accion_alumno=solucionar_ejercicio&ejercicio=<?=$_GET['ejercicio']?>" enctype="multipart/form-data" method="POST">
		<div class="clearfix">
			<label>Solución:</label>
			<div class="input">
				<textarea name='solucion' class="xlarge"></textarea>
			</div>
		</div>

		<div class="clearfix">
			<label>Adjuntar:</label>
			<div class="input">
				<input type="file" name="adjunto"/>
			</div>
		</div>

		<div class="actions">
			<input class="btn primary" type="submit" name="solucionar" value="Enviar solución"/>
			<a class="btn error" href="/ejercicios/index.php?accion_alumno=ejercicios_asignatura&asignatura=<?=$asignatura['id_asignatura']?>">Cancelar</a>
		</div>
	</form>
<?
} else {
?>
	<a class="btn info" href="/ejercicios/index.php?accion_alumno=ejercicios_asignatura&asignatura=<?=$asignatura['id_asignatura']?>">Volver</a>	
<?
}
?>