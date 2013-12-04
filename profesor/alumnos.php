<?
$alumnos=obtener_alumnos_asignatura($_GET['asignatura']);
if (mysql_num_rows($alumnos) == 0) {
?>
<div class="alert-message warning">
	<p>Aún no hay ningún alumnos en este curso</p>
</div>
<?
} else {
?>
	<table class="bordered-table zebra-stripped">
		<thead>
			<tr>
				<th>Nombre</th>
			</tr>
		</thead>
		<tbody>
<?
	while ($alumno=mysql_fetch_array($alumnos)) {
?>
			<tr>
				<td><?=$alumno['nombre']?></td>
			</tr>
<?
	}
?>
		</tbody>
	</table>
	
	<a href="/ejercicios" class="btn info">&lt; Volver</a>
<?
}
?>