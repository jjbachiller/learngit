<?
$ejercicios=obtener_ejercicios_asignatura($_GET['asignatura']);

if (!mysql_num_rows($ejercicios)) {
?>
	<div class="alert-message warning">
		<p>No hay ejercicios para esta asignatura</p>
	</div>
<?
} else {
?>
	<table class="bordered-table zebra-stripped">
		<thead>
			<tr>
				<th>Ejercicio</th>
				<th>Solucionar</th>
				<th>Calificación</th>
			</tr>
		</thead>
		<tbody>
<?
	while ($ejercicio=mysql_fetch_array($ejercicios)) {
		$res_solucion=obtener_solucion_ejercicio($ejercicio['id_ejercicio'], $_SESSION['id_alumno']);
		if (mysql_num_rows($res_solucion)) {
			$solucion=mysql_fetch_array($res_solucion);
			//Si ya está resuelto:
			$solucionar="<span class='label notice'>Ya está resuelto</span>";
			if (is_null($solucion['calificacion'])) {
				$calificacion="<span class='label warning'>Pendiente de calificación</span>";
			} else {
				if ($solucion['calificacion'] >= 5) {
					$calificacion="<span class='label success'>".$solucion['calificacion']." Aprobado</span>";
				} else {
					$calificacion="<span class='label important'>".$solucion['calificacion']." Suspenso</span>";
				}
			}
		} else {
			$solucionar="<a class='btn success' href='/ejercicios/index.php?accion_alumno=solucionar_ejercicio&ejercicio=".$ejercicio['id_ejercicio']."'>Solucionar</a>";
			$calificacion="<span class='label warning'>Pendiente de calificación</span>";
		}
?>
		<tr>
			<td><?=$ejercicio['ejercicio']?></td>
			<td><?=$solucionar?></td>
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
<a class="btn info" href="/ejercicios">&lt; Volver</a>