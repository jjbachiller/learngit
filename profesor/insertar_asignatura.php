<?
if (count($_POST)) {
	if (!isset($_POST['asignatura']) || count($_POST['asignatura'])==0) {
?>
	<div class="alert-message error span7 offset3">
		<p><strong>ERROR: </strong> Debe introducir un nombre para la asignatura</p>
	</div>
<?
	} elseif (!isset($_POST['curso']) || $_POST['curso']==0) {
?>
	<div class="alert-message error span7 offset3">
		<p><strong>ERROR: </strong> Debe un curso para la asignatura</p>
	</div>
<?
	} else {
		if (insertar_asignatura($_POST['curso'], $_SESSION['id_profesor'], $_POST['asignatura'])) {
?>
	<div class="alert-message success span7 offset3">
		<p><strong>Enhorabuena: </strong>La asignatura se ha añadido correctamente</p>
	</div>
<?
		} else {
?>
	<div class="alert-message error span7 offset3">
		<p><strong>ERROR: </strong> Ocurrió un erro al insertar la asignatura</p>
	</div>
<?
		}
	}
}
?>
<h2>Añadir asignatura</h2>
<br/>
<form action="/ejercicios/index.php?&accion_profesor=insertar_asignatura" method="POST">
	<div class="clearfix">
		<label>Asignatura:</label>
		<div class="input"><input type="text" name="asignatura"/></div>
	</div>
	
	<div class="clearfix">
		<label>Curso:</label>
		<div class="input">
			<select name="curso">
				<option value="0">-- Elige un curso --</option>
	<?
				$cursos=obtener_cursos();
				while ($curso=mysql_fetch_array($cursos)) {
	?>
				<option value="<?=$curso['id_curso']?>"><?=$curso['nombre']?></option>
	<?
				}
	?>
			</select>
		</div>
	</div>
	
	<div class="actions">
		<input class="btn primary" type="submit" name="insertar" value="Insertar Asignatura"/>
		<a class="btn error" href="http://localhost/ejercicios/index.php?accion=profesor">Cancelar</a>	
	</div>
</form>