<?
$res_asignatura=obtener_asignatura_ejercicio($_GET['ejercicio']);
if (mysql_num_rows($res_asignatura) ==0 ) {
?>
	<div class="alert-message error">
		<p><strong>ERROR: </strong>No se encuentra la asignatura para este ejercicio</p>
	</div>
<?
} else {
	$asignatura=mysql_fetch_array($res_asignatura);
	
	$soluciones=obtener_soluciones_ejercicio($_GET['ejercicio']);
	if (mysql_num_rows($soluciones) == 0) {
?>
		<div class="alert-message warning">
			<p>Aún no se han añadido soluciones a este ejercicio</p>
		</div>
<?
	} else {
?>
		<table class="bordered-table zebra-stripped">
			<thead>
				<tr>
					<th>Alumno</th>
					<th>Ver solución</th>
					<th>Calificación</th>
				</tr>
			</thead>
			<tbody>
<?
		while ($solucion=mysql_fetch_array($soluciones)) {
			$sql="SELECT * FROM alumnos WHERE id_alumno=".$solucion['id_alumno'];
			$res_alumno=mysql_query($sql, $conexion);
			$alumno=mysql_fetch_array($res_alumno);
			
			if (is_null($solucion['calificacion'])) {
				$calificacion="<span class='label warning'>Pendiente de calificación</span>";				
			} elseif ($solucion['calificacion'] >= 5) {
				$calificacion="<span class='label success'>".$solucion['calificacion']." Aprobado</span>";
			} else {
				$calificacion="<span class='label important'>".$solucion['calificacion']." Suspenso</span>";
			}
			
?>
				<tr>
					<td><?=$alumno['nombre']?></td>
					<td><a class="btn info" href="/ejercicios/index.php?accion_profesor=ver_solucion&solucion=<?=$solucion['id_solucion']?>">Ver solución</a></td>
					<td><?=$calificacion?></td>
				</tr>
<?
		}
?>
			</tbody>
		</table>
<?
	}
?>
	<a class="btn info" href="/ejercicios/index.php?accion_profesor=ejercicios_asignatura_profesor&asignatura=<?=$asignatura['id_asignatura']?>">&lt; Volver</a>
<?
}
?>