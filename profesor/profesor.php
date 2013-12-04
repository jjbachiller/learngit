<div class="span12 offset1">
<?
if (!$_SESSION['id_profesor']) {
?>

<div class="alert-message error">
	<p><strong>Error: </strong>no tiene permisos para acceder a esta sección</p>
</div>

<?
} else {
	if (isset($_GET['accion_profesor'])) {
		$accion=$_GET['accion_profesor'];
	} else {
		$accion='';
	}
}

switch ($accion) {
	case 'insertar_asignatura':
		include('profesor/insertar_asignatura.php');
		break;
	case 'alumnos':
		include('profesor/alumnos.php');
		break;		
	case 'ejercicios_asignatura_profesor':
		include('profesor/ejercicios_asignatura.php');
		break;
	case 'add_ejercicio':
		include('profesor/add_ejercicio.php');
		break;
	case 'soluciones_ejercicio':
		include('profesor/soluciones_ejercicio.php');
		break;
	case 'ver_solucion':
		include('profesor/ver_solucion.php');
		break;
	default:
		//Listado de asignaturas.
		include('profesor/asignaturas_profesor.php');
}
?>
</div>