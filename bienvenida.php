<?
if (isset($_GET['accion']) && $_GET['accion'] == 'logout') {
?>
<div class="alert-message info span12 offset1">
	<p>Te has desconectado con éxito</p>
</div>
<?
}
?>

<div class="span12 offset1">
  <h2>Bienvenido al gestor de ejercicios del curso de PHP</h2>
 Accede como alumno o como profesor. Si no tienes una cuenta, puedes registrarte haciendo clic aquí: <a class="btn small info" href="/ejercicios/index.php?accion=registro" >Registarme</a>
</div>
