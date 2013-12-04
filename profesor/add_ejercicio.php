<?
if (isset($_POST['enunciado'])) {
	if (!empty($_POST['enunciado'])) {
		$sql="INSERT INTO ejercicios (id_asignatura, ejercicio) VALUES (".$_GET['asignatura'].", '".$_POST['enunciado']."')";
		if (mysql_query($sql, $conexion)) {
?>
		<div class="alert-message success">
			<p><strong>Enhorabuena</strong>, el ejercicio se ha creado con éxito</p>
		</div>
<?
		} else {
?>		
		<div class="alert-message error">
			<p><strong>ERROR: </strong>Ocurrió un error al crear el ejercicio</p>
		</div>
<?
		}
	} else {
?>
	<div class="alert-message error">
		<p><strong>ERROR: </strong>Introduzca un texto para el enunciado</p>
	</div>
<?		
	}
}
?>
<h2>Añadir ejercicio:
<form action="http://localhost/ejercicios/index.php?accion=profesor&accion_profesor=add_ejercicio&asignatura=<?=$_GET['asignatura']?>" method="POST">
	<div class="clearfix">
		<label>Enunciado:</label>
		<div class="input">
			<textarea name="enunciado" class="xlarge" rows="5"></textarea>
		</div>
	</div>
	<div class="actions">
		<input class="btn primary" type="submit" name="crear_ejercicio" value="Crear ejercicio">
		<a class="btn error" href="/ejercicios/index.php?accion_profesor=ejercicios_asignatura_profesor&asignatura=<?=$_GET['asignatura']?>">Cancelar</a>
	</div>
</form>