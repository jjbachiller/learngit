<?
include('funciones.php');
$conexion=conectar('localhost', 'ejercicios', 'cursophp', 'ejercicios');

function asignatura() {

	$randoms = array(
		'sa', 'pe', 're', 'al', 'ez', 'ex', 'te', 'me', 'fa', 'mi', 'le', 'fe', 'mo', 'di', 'en', 'po'
	);

	$n = rand(3, 6);
	$asignatura = '';
	for ($j = 1; $j < $n; $j++) {
		$asignatura .= $randoms[rand(0, count($randoms) - 1)];
	}
	
	return $asignatura;
}

function nombre() {
	$nombres = array(
		'Germán',
		'Juan',
		'Manuel',
		'David',
		'María',
		'Sara',
		'Raquel',
		'Pedro',
		'Rafael',
		'Ana',
		'Isabel',
		'Alfonso',
		'Ricardo'
	);

	return $nombres[rand(0, count($nombres) - 1)];
}

function apellidos() {

	$apellidos = array(
		'Moreno',
		'Galeano',
		'Rodríguez',
		'Domínguez',
		'Alfónsez',
		'Nieto',
		'Hernández',
		'Rubial',
		'Casaus',
		'López',
		'Bachiller',
		'Méndez',
		'Rubio'
	);

	return $apellidos[rand(0, count($apellidos) - 1)] . ' ' . $apellidos[rand(0, count($apellidos) - 1)];
}

//Borrar los datos de las tablas:
$sql="TRUNCATE TABLE alumnos";
mysql_query($sql, $conexion);
$sql="TRUNCATE TABLE asignaturas";
mysql_query($sql, $conexion);
$sql="TRUNCATE TABLE cursos";
mysql_query($sql, $conexion);
$sql="TRUNCATE TABLE ejercicios";
mysql_query($sql, $conexion);
$sql="TRUNCATE TABLE profesores";
mysql_query($sql, $conexion);
$sql="TRUNCATE TABLE soluciones";
mysql_query($sql, $conexion);
$sql="TRUNCATE TABLE usuarios";
mysql_query($sql, $conexion);

//Insertar los cursos
$sql="INSERT INTO cursos (id_curso, nombre) VALUES	(1, 'PRIMERO ESO')";
mysql_query($sql, $conexion);
$sql="INSERT INTO cursos (id_curso, nombre) VALUES	(2, 'SEGUNDO ESO')";
mysql_query($sql, $conexion);
$sql="INSERT INTO cursos (id_curso, nombre) VALUES	(3, 'TERCERO ESO')";
mysql_query($sql, $conexion);
$sql="INSERT INTO cursos (id_curso, nombre) VALUES	(4, 'CUARTO ESO')";
mysql_query($sql, $conexion);
$sql="INSERT INTO cursos (id_curso, nombre) VALUES	(5, 'PRIMERO BACHILLER')";
mysql_query($sql, $conexion);
$sql="INSERT INTO cursos (id_curso, nombre) VALUES	(6, 'SEGUNDO BACHILLER')";
mysql_query($sql, $conexion);

//Insertar profesores, alumnos y asignatura por curso:
$num_cursos=6;
$max_profesores_curso=2;
$max_asignaturas_profesor=2;
$max_alumnos_curso=5;
$randoms = array(
	'sa', 'pe', 're', 'al', 'ez', 'ex', 'te', 'me', 'fa', 'mi', 'le', 'fe', 'mo', 'di', 'en', 'po'
);

for ($i=1; $i<=$num_cursos; $i++) {
	//Generamos los profesores del curso;
	for ($j=1; $j<=$max_profesores_curso; $j++) {
		//Profesor
		$nombre = nombre()." ".apellidos();
		$sql="INSERT INTO profesores (nombre) VALUES ('".$nombre."')";
		mysql_query($sql, $conexion);
		$id_profesor=mysql_insert_id($conexion);
		
		//Usuario.
		$login='profesor'.$id_profesor;
		$password=md5('1234');
		$email=$login.'@cursophp.com';
		$sql="INSERT INTO usuarios (id_profesor, login, password, email) VALUES 
			  (".$id_profesor.", '".$login."', '".$password."', '".$email."')";
		mysql_query($sql, $conexion);
		
		//Asignaturas.
		for ($k=1; $k<=$max_asignaturas_profesor; $k++) {
			$asignatura=asignatura();
			$sql="INSERT INTO asignaturas (id_curso, id_profesor, nombre) VALUES
				  (".$i.", ".$id_profesor.", '".$asignatura."')";
			mysql_query($sql, $conexion);				
		}
	}
	
	//Generamos los alumnos del curso.
	for ($j=1; $j<=$max_alumnos_curso; $j++) {
		//Alumno
		$nombre = nombre()." ".apellidos();
		$sql="INSERT INTO alumnos (id_curso, nombre) VALUES (".$i.", '".$nombre."')";
		mysql_query($sql, $conexion);
		$id_alumno=mysql_insert_id($conexion);
		
		//Usuario.
		$login='alumno'.$id_alumno;
		$password=md5('1234');
		$email=$login.'@cursophp.com';
		$sql="INSERT INTO usuarios (id_alumno, login, password, email) VALUES 
			  (".$id_alumno.", '".$login."', '".$password."', '".$email."')";	
		mysql_query($sql, $conexion);
	}
}

echo "<h3>Se han insertado <strong>".$num_cursos."</strong> cursos</h3>";
echo "<h3>Se han insertado <strong>".($num_cursos*$max_profesores_curso)."</strong> profesores</h3>";
echo "<h3>Se han insertado <strong>".($num_cursos*$max_profesores_curso*$max_asignaturas_profesor)."</strong> asignaturas</h3>";
echo "<h3>Se han insertado <strong>".($num_cursos*$max_alumnos_curso)."</strong> alumnos</h3>";
?>