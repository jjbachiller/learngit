<div class="span12 offset1">
<?

//Actualizar datos.
if (isset($_POST['actualizar'])) {
	if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
?>
		<div class="alert-message error">
			<p><strong>ERROR: </strong>El campo nombre no puede estar vacío</p>
		</div>
<?		
	} elseif (!isset($_POST['email']) || empty($_POST['email'])) {
?>
	<div class="alert-message error">
		<p><strong>ERROR: </strong>El campo email no puede estar vacío</p>
	</div>
<?
	} elseif (!isset($_POST['usuario']) || empty($_POST['usuario'])) {
?>
	<div class="alert-message error">
		<p><strong>ERROR: </strong>El campo usuario no puede estar vacío</p>
	</div>
<?
	} else {
		if (!actualizar_datos_usuario()) {
?>
		<div class="alert-message error">
			<p><strong>ERROR: </strong>Se produjo un error al actualizar sus datos</p>
		</div>
<?
		} else {
?>
		<div class="alert-message success">
			<p><strong>Enhorabuena: </strong>Sus datos se han actualizado correctamente</p>
		</div>
<?			
		}
	}
}

$res_usuario=obtener_usuario($_SESSION['id_usuario']);
if (mysql_num_rows($res_usuario) == 0) {
?>
	<div class="alert-message error">
		<p><strong>ERROR: </strong>Se produjo un error al acceder a sus datos.</p>
	</div>
	
	<a class="btn info" href="/ejercicios">&lt; Volver</a>
<?
} else {
	if ($_SESSION['id_alumno'] == 0) {
		$res_nombre=obtener_profesor($_SESSION['id_profesor']);
	} else {
		$res_nombre=obtener_alumno($_SESSION['id_alumno']);
	}
	
	if (mysql_num_rows($res_nombre) == 0) {
?>
		<div class="alert-message error">
			<p><strong>ERROR: </strong>Se produjo un error al acceder a sus datos.</p>
		</div>
		
		<a class="btn info" href="/ejercicios">&lt; Volver</a>
<?
	} else {
		$usuario=mysql_fetch_array($res_usuario);
		$array_nombre=mysql_fetch_array($res_nombre);
		$usuario['nombre']=$array_nombre['nombre'];
?>
	<form action="/ejercicios/index.php?accion=misdatos" method="POST">
		<div class="clearfix">
			<label>Nombre:</label>
			<div class="input">
				<input type="text" name="nombre" value="<?=$usuario['nombre']?>"/>
			</div>
		</div>
		
		<div class="clearfix">
			<label>eMail:</label>
			<div class="input">
				<input type="text" name="email" value="<?=$usuario['email']?>"/>
			</div>
		</div>

		<div class="clearfix">
			<label>Usuario:</label>
			<div class="input">
				<input type="text" name="usuario" value="<?=$usuario['login']?>"/>
			</div>
		</div>

		<div class="clearfix">
			<label>Contraseña:</label>
			<div class="input">
				<input type="password" name="password" value=""/>
			</div>
		</div>
		
		<div class="actions">
				<input class="btn primary" type="submit" name="actualizar" value="Actualizar mis datos"/>
				<a class="btn error" href="/ejercicios">Cancelar</a>
		</div>
	</form>
<?
	}
}
?>
</div>