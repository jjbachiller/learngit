<?
session_start();

include('funciones.php');
$conexion=conectar('localhost', 'root', 'inveslinex', 'ejercicios');
echo "<h1>".mysql_error()."</h1>";
if (!$conexion) {
	die("<h1 style='color: red;'>No se ha podido conetar con la base de datos</h1>");
}

//Antes de mostrar nada en pantalla, comprobamos el usuario.
if (comprobar_usuario()) {
	if (!isset($_GET['accion']) || $_GET['accion'] != 'misdatos') {
		//La única acción común a ambos usuarios es la de modificar sus datos.
		if ($_SESSION['id_profesor']) $accion='profesor';
		else $accion='alumno';
	} else {
		$accion=$_GET['accion'];
	}
} elseif (isset($_GET['accion'])) {
	$accion=$_GET['accion'];
} else $accion='';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Curso de PHP: Gestor de Ejercicios</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="language" content="ES" />
	<meta name="DC.Language" scheme="RFC1766" content="Spanish" />
	<?//http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css --> CSS bootstrap de twitter?>
	<link rel="stylesheet" href="/ejercicios/css/bootstrap.min.css">
	<style type="text/css">
	      /* Override some defaults */
	      html, body {
	        background-color: #eee;
	      }
	      body {
	        padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
	      }
	      .container > footer p {
	        text-align: center; /* center align it with the container */
	      }
	      .container {
	        width: 820px; /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
	      }

	      /* The white background content wrapper */
	      .content {
	        background-color: #fff;
	        padding: 20px;
	        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
	        -webkit-border-radius: 0 0 6px 6px;
	           -moz-border-radius: 0 0 6px 6px;
	                border-radius: 0 0 6px 6px;
	        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
	           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
	                box-shadow: 0 1px 2px rgba(0,0,0,.15);
	      }

	      /* Page header tweaks */
	      .page-header {
	        background-color: #f5f5f5;
	        padding: 20px 20px 10px;
	        margin: -20px -20px 20px;
	      }

	      /* Styles you shouldn't keep as they are for displaying this base example only */
	      .content .span10,
	      .content .span4 {
	        min-height: 500px;
	      }
	      /* Give a quick and non-cross-browser friendly divider */
	      .content .span4 {
	        margin-left: 0;
	        padding-left: 19px;
	        border-left: 1px solid #eee;
	      }

	      .topbar .btn {
	        border: 0;
	      }
	</style>	
	
</head>
<body>
	<?//Barra de título y opciones.?>
	<div class="topbar">
      <div class="fill">
        <div class="container">
          <a href="#" class="brand">Curso de PHP</a>
		  <?include('menu_usuario.php');?>
        </div>
      </div>
    </div>

	<div class="container">
	      <div class="content">
	        <div class="row">
				<?					
				switch ($accion) {
					case 'registro':
						include('registro.php');
						break;
					case 'profesor':
						include('profesor/profesor.php');
						break;
					case 'alumno';
						include('alumno/alumno.php');
						break;
					case 'login':
						include('formulario_login.php');
						break;
					case 'misdatos':
						include('mis_datos.php');
						break;
					default: 
						include('bienvenida.php');
						break;
					
				}
				?>
	        </div>
	      </div>
    </div>
</body>
</html>
