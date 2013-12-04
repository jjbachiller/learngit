<?
//Obtenemos las asignaturas del profesor:
$asignaturas=asignaturas_profesor($_SESSION['id_profesor']);
if (mysql_num_rows($asignaturas) == 0) {
?>
<div class="alert-message warning">
	<p>Aún no tiene ninguna asignatura asociada</p>
</div>
<?
} else {
?>
	<table class="bordered-table zebra-stripped">
		<thead>
			<tr>
				<th>Asignatura</th>
				<th>Curso</th>
				<th>Alumnos</th>				
				<th>Ejercicios</th>								
			</tr>
		</thead>
		<tbody>
<?
	while ($asignatura=mysql_fetch_array($asignaturas)) {
		$res_curso=obtener_curso($asignatura['id_curso']);
		$curso=mysql_fetch_array($res_curso);
?>
		<tr>
			<td><?=$asignatura['nombre']?></td>
			<td><?=$curso['nombre']?></td>
			<td><a class="btn info" href="/ejercicios/index.php?accion_profesor=alumnos&asignatura=<?=$asignatura['id_asignatura']?>">Ver alumnos</a></td>
			<td><a class="btn primary" href="/ejercicios/index.php?accion_profesor=ejercicios_asignatura_profesor&asignatura=<?=$asignatura['id_asignatura']?>">Ejercicios</a></td>
		</tr>
<?
	}
?>
		</tbody>
	</table>
<?
}
?>
<a class="btn success" href="/ejercicios/index.php?accion_profesor=insertar_asignatura">Añadir asignatura</a>