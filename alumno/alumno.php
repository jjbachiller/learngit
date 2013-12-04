<div class="span9 offset3">
<?
if (!$_SESSION['id_alumno']) {
?>

<div class="alert-message error">
	<p><strong>Error: </strong>no tiene permisos para acceder a esta sección</p>
</div>

<?
} else {
	if (isset($_GET['accion_alumno'])) {
		$accion=$_GET['accion_alumno'];
	} else {
		$accion='';
	}
}

switch ($accion) {
	case 'ejercicios_asignatura':
		include('alumno/ejercicios_asignatura.php');
		break;
	case 'solucionar_ejercicio':
		include('alumno/solucionar_ejercicio.php');
		break;
	default:
		//Listado de asignaturas.
		include('alumno/asignaturas_alumno.php');
}
?>
</div>