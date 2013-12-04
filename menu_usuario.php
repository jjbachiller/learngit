<?
if (!comprobar_usuario()) {
?>
<ul class="nav secondary-nav">
	<form class="pull-right" action="/ejercicios/index.php?accion=login" method="POST">
	  <input type="text" name="usuario" placeholder="Usuario" class="input-small">
	  <input type="password" name="password" placeholder="Contraseña" class="input-small">
	  <button type="submit" name="acceder" class="btn">Acceder</button>
	</form>
</ul>
<?
} else {
?>
<ul class="nav">
<?
	if (isset($_GET['accion']) && $_GET['accion'] == 'misdatos') {
		$clase_inicio='';
		$clase_datos='active';
	} else {
		$clase_inicio='active';
		$clase_datos='';
	}
?>
	<li class="<?=$clase_inicio?>"><a href="/ejercicios/">Inicio</a></li>
	<li class="<?=$clase_datos?>"><a href="/ejercicios/index.php?accion=misdatos">Mis Datos</a></li>		
</ul>

<ul class="nav secondary-nav">
	<li><a href="#">Bienvenido <strong><?=$_SESSION['nombre']?></strong></a></li>
	<li><a style="margin: 5px 0;" class="btn small success" href="/ejercicios/index.php?accion=logout">Salir</a></li>
</ul>
<?
}
?>