<?
if (isset($_GET['borrar'])) {
	//Si han pedido borrar algún ejercicio.
	if (borrar_ejercicio($_GET['asignatura'], $_GET['borrar'])) {
?>
	<div class="alert-message success">
		<p><strong>Enhorabuena: </strong>El ejercicio se ha borrado con éxito</p>
	</div>
<?
	} else {
?>
	<div class="alert-message error">
		<p><strong>ERROR: </strong>Ocurrió un error al borrar el ejercicio</p>
	</div>
<?		
	}
}

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
				<th>Ver soluciones</th>
				<th>Eliminar</th>				
			</tr>
		</thead>
		<tbody>
<?
	while ($ejercicio=mysql_fetch_array($ejercicios)) {
?>
		<tr>
			<td><?=$ejercicio['ejercicio']?></td>
			<td><a class="btn info" href="/ejercicios/index.php?accion_profesor=soluciones_ejercicio&ejercicio=<?=$ejercicio['id_ejercicio']?>">Ver soluciones</a></td>
			<td><a class="btn error" href="/ejercicios/index.php?accion_profesor=ejercicios_asignatura_profesor&asignatura=<?=$_GET['asignatura']?>&borrar=<?=$ejercicio['id_ejercicio']?>" onclick="javascript:if (!confirm('¿Seguro que desea borrar este ejercicio y todas su soluciones?')) return false;">Eliminar</a></td>			
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
<a class="btn success" href="/ejercicios/index.php?accion_profesor=add_ejercicio&asignatura=<?=$_GET['asignatura']?>">Añadir ejercicio</a>