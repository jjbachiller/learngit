<?
//Asociamos el curso si se indica.
asociar_curso($_SESSION['id_alumno']);

$sql="SELECT * FROM alumnos WHERE id_alumno=".$_SESSION['id_alumno'];
$resultado=mysql_query($sql, $conexion);
$curso=mysql_fetch_array($resultado);
//Si no se ha definido el curso del alumno.
if (!$curso['id_curso']) {
	include('indica_curso.php');
} else {
	$asignaturas=obtener_asignaturas_curso($curso['id_curso']);
	if (!mysql_num_rows($asignaturas)) {
?>
	<div class="alert-message warning">
		<p>Aún no se han añadido asignaturas para tu curso</p>
	</div>
<?
	} else {
?>
		<table class="bordered-table zebra-stripped">
			<thead>
				<tr>
					<th>Asignatura</th>
					<th>Profesor</th>
					<th>Ejercicios</th>
				</tr>
			</thead>
			<tbody>
<?
		while ($asignatura=mysql_fetch_array($asignaturas)) {
			$res_profesor=obtener_profesor($asignatura['id_profesor']);
			$profesor=mysql_fetch_array($res_profesor);
?>			
				<tr>
					<td><?=$asignatura['nombre']?></td>
					<td><?=$profesor['nombre']?></td>
					<td><a class="btn info" href="/ejercicios/index.php?accion_alumno=ejercicios_asignatura&asignatura=<?=$asignatura['id_asignatura']?>">Ver ejercicios</a></td>
				</tr>
<?
		}
?>
			</tbody>
<?
	}
?>

<?
}
?>