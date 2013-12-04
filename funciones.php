<?

//Función para conectar con la base de datos.

function conectar($host='localhost', $usuario, $password, $db) {
	$conexion = mysql_connect($host, $usuario, $password);
	if (!$conexion) return FALSE;
    mysql_select_db($db, $conexion);

	return $conexion;
}

//Funciones de login.


function session_defaults() {
	$_SESSION['id_usuario'] = 0;
	$_SESSION['id_profesor'] = 0;
	$_SESSIOM['id_alumno'] = 0;
	$_SESSION['nombre'] = '';
}

function acceder($usuario, $password) {
	global $conexion;
	
	$sql="SELECT * FROM usuarios WHERE login='".$usuario."' AND password='".$password."'";
	$resultado=mysql_query($sql, $conexion);
	if (mysql_num_rows($resultado) == 0) {
		return FALSE;
	} else {
		$usuario=mysql_fetch_array($resultado);
		$_SESSION['id_usuario']=$usuario['id_usuario'];
		$_SESSION['id_profesor']=$usuario['id_profesor'];
		$_SESSION['id_alumno']=$usuario['id_alumno'];		
		if ($usuario['id_profesor']) {
			//Es un profesor.
			$sql="SELECT nombre FROM profesores WHERE id_profesor=".$usuario['id_profesor'];
			$resultado=mysql_query($sql, $conexion);
			$profesor=mysql_fetch_array($resultado);
			$_SESSION['nombre']=$profesor['nombre'];			
			header('Location:http://localhost/ejercicios/index.php?accion=profesor');
		} else {
			//Es un alumno.
			$sql="SELECT nombre FROM alumnos WHERE id_alumno=".$usuario['id_alumno'];
			$resultado=mysql_query($sql, $conexion);
			$alumno=mysql_fetch_array($resultado);
			$_SESSION['nombre']=$alumno['nombre'];			
			header('Location:http://localhost/ejercicios/index.php?accion=alumno');
		}
	}
}


function comprobar_usuario() {
	if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario']) {
		//Salir
		if (isset($_GET['accion']) && $_GET['accion']=='logout') {
			session_defaults();
			return FALSE;
		}
		return TRUE;
	} elseif (count($_POST) && isset($_POST['acceder'])) {
		if (!isset($_POST['usuario']) || count($_POST['usuario']) == 0) {
			return FALSE;
		} elseif (!isset($_POST['password']) || count($_POST['password']) == 0) {
			return FALSE;
		} else {
			//Encriptamos la contraseña.
			$pass=md5($_POST['password']);
			if (!acceder($_POST['usuario'], $pass)) {
				return FALSE;
			}
		}
	}
	
	return FALSE;
}

//Registro

function existe_usuario($usuario) {
	global $conexion;
	
	$sql="SELECT * FROM usuarios WHERE login='".$usuario."'";
	$resultado=mysql_query($sql, $conexion);
	if (mysql_num_rows($resultado) > 0) return TRUE;//El usuario existe.
	return FALSE;//El usuario no existe.
}

function registrar_alumno($nombre) {
	global $conexion;
	$sql="INSERT INTO alumnos (nombre) VALUES ('".$nombre."')";
	
	$resultado=mysql_query($sql, $conexion);
	if ($resultado) return mysql_insert_id($conexion);
	return FALSE;
}

function registrar_profesor($nombre) {
	global $conexion;
	$sql="INSERT INTO profesores (nombre) VALUES ('".$nombre."')";
	
	$resultado=mysql_query($sql, $conexion);
	if ($resultado) return mysql_insert_id($conexion);
	return FALSE;	
}

function registrar_usuario() {
	global $conexion;
	
	if ($_POST['tipo'] == 'alumno') {
		//Vamos a insertar un alumno.
		$id_alumno=registrar_alumno($_POST['nombre']);
		$id_profesor=0;		
		if (!$id_alumno) return FALSE;
	} else {
		//Vamos a insertar un profesor.
		$id_alumno=0;
		$id_profesor=registrar_profesor($_POST['nombre']);
		if (!$id_profesor) return FALSE;
	}
	
	//Ciframos la clave.
	$pass=md5($_POST['password']);
	
	$sql="INSERT INTO usuarios (id_profesor, id_alumno,  login, password, email)
		  VALUES (".$id_profesor.", ".$id_alumno.", '".$_POST['usuario']."', '".$pass."', '".$_POST['email']."')";

	return mysql_query($sql, $conexion);
}

function obtener_usuario($id_usuario) {
	global $conexion;
	$sql="SELECT * FROM usuarios WHERE id_usuario=".$id_usuario;
	$resultado=mysql_query($sql, $conexion);
	
	return $resultado;
}

//Funciones para la gestión por parte de un alumno

function asociar_curso($id_alumno) {
	global $conexion;
	if (isset($_POST['mi_curso'])) {
		//Controlar que no tenga un curso ya asociado???
		$sql="UPDATE alumnos SET id_curso=".$_POST['mi_curso']." WHERE id_alumno=".$id_alumno;
		return mysql_query($sql, $conexion);
	}
	return FALSE;
}

function obtener_asignaturas_curso($id_curso) {
	global $conexion;
	$sql="SELECT * FROM asignaturas WHERE id_curso=".$id_curso;
	$resultado=mysql_query($sql, $conexion);
	
	return $resultado;
}

function obtener_profesor($id_profesor) {
	global $conexion;
	$sql="SELECT * FROM profesores WHERE id_profesor=".$id_profesor;
	$resultado=mysql_query($sql, $conexion);
	
	return $resultado;
}

function obtener_ejercicios_asignatura($id_asignatura) {
	global $conexion;
	$sql="SELECT * FROM ejercicios WHERE id_asignatura=".$id_asignatura;
	
	$resultado=mysql_query($sql, $conexion);
	return $resultado;
}

function obtener_solucion_ejercicio($id_ejercicio, $id_alumno) {
	global $conexion;
	$sql="SELECT * FROM soluciones WHERE id_ejercicio=".$id_ejercicio." AND id_alumno=".$id_alumno;

	$resultado=mysql_query($sql, $conexion);
	return $resultado;
}

function obtener_cursos() {
	global $conexion;
	$sql="SELECT * FROM cursos";
	
	$resultado=mysql_query($sql, $conexion);
	return $resultado;
}

function obtener_asignatura_ejercicio($id_ejercicio) {
	global $conexion;
	$sql="SELECT id_asignatura FROM ejercicios WHERE id_ejercicio=".$id_ejercicio;
	$resultado=mysql_query($sql, $conexion);
	
	return $resultado;
}


//Funciones para la gestión por parte de un profesor.

function obtener_alumnos_asignatura($id_asignatura) {
	global $conexion;
	$sql="SELECT id_curso FROM asignaturas WHERE id_asignatura=".$id_asignatura;

	$resultado=mysql_query($sql, $conexion);
	if (!mysql_num_rows($resultado)) return FALSE;
	
	$curso=mysql_fetch_array($resultado);
	$sql="SELECT * FROM alumnos WHERE id_curso=".$curso['id_curso'];
	$resultado=mysql_query($sql, $conexion);
	return $resultado;
}

function obtener_alumno($id_alumno) {
	global $conexion;
	$sql="SELECT * FROM alumnos WHERE id_alumno=".$id_alumno;
	$resultado=mysql_query($sql, $conexion);
	
	return $resultado;
}

function asignaturas_profesor($id_profesor) {
	global $conexion;
	$sql="SELECT * FROM asignaturas WHERE id_profesor=".$id_profesor;
	
	$resultado=mysql_query($sql, $conexion);
	return $resultado;
}

function obtener_curso($id_curso) {
	global $conexion;
	$sql="SELECT * FROM cursos WHERE id_curso=".$id_curso;
	
	$resultado=mysql_query($sql, $conexion);

	return $resultado;
}


function borrar_ejercicio($id_asignatura, $id_ejercicio) {
	global $conexion;
	
	//Borramos las soluciones asociadas.
	$sql="DELETE FROM soluciones WHERE id_ejercicio=".$id_ejercicio;
	mysql_query($sql, $conexion);
	
	$sql="DELETE FROM ejercicios WHERE id_asignatura=".$id_asignatura." AND id_ejercicio=".$id_ejercicio;
	mysql_query($sql, $conexion);
	
	//Devolvemos el número de ejercicios borrados.
	return mysql_affected_rows($conexion);
}

function insertar_asignatura($id_curso, $id_profesor, $asignatura) {
	global $conexion;
	$sql="INSERT INTO asignaturas (id_curso, id_profesor, nombre)
		  VALUES (".$id_curso.", ".$id_profesor.", '".$asignatura."')";

	return mysql_query($sql, $conexion);
}

function obtener_soluciones_ejercicio($id_ejercicio) {
	global $conexion;
	$sql="SELECT * FROM soluciones WHERE id_ejercicio=".$id_ejercicio;
	$resultado=mysql_query($sql, $conexion);
	
	return $resultado;
}

function obtener_solucion($id_solucion) {
	global $conexion;
	$sql="SELECT * FROM soluciones WHERE id_solucion=".$id_solucion;
	$resultado=mysql_query($sql, $conexion);
	
	return $resultado;
}


///
function actualizar_datos_usuario() {
	global $conexion;
	if ($_SESSION['id_alumno'] == 0) {
		$sql="UPDATE profesores SET nombre='".$_POST['nombre']."' WHERE id_profesor=".$_SESSION['id_profesor'];
	} else {
		$sql="UPDATE alumnos SET nombre='".$_POST['nombre']."' WHERE id_alumno=".$_SESSION['id_alumno'];		
	}
	$resultado=mysql_query($sql, $conexion);
	if (!$resultado) {
		return FALSE;
	}
	
	$sql="UPDATE usuarios SET email='".$_POST['email']."', login='".$_POST['usuario']."'";
	//La contraseña solo la actualizamos si viene rellena.
	if ($_POST['password'] != '') {
		$pass=md5($_POST['password']);
		$sql.=", password='".$pass."'";
	}
	$sql.=" WHERE id_usuario=".$_SESSION['id_usuario'];
	$resultado=mysql_query($sql, $conexion);

	if (!$resultado) {
		return FALSE;
	}
	return TRUE;
}
?>