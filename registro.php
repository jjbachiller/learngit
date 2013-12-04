<?

//Validamos el formulario
$valido=FALSE;
$error='';
	
if (count($_POST)) {//Se ha enviado el formulario.
	
	if ((!isset($_POST['nombre'])) || (strlen($_POST['nombre']) == 0)) {		
		$valido=FALSE;
		$error="Debe rellenar todos los campos.";
	} elseif (!isset($_POST['email']) || strlen($_POST['email']) == 0) {
		$valido=FALSE;
		$error="Debe rellenar todos los campos.";
	} elseif (!isset($_POST['usuario']) || strlen($_POST['usuario']) == 0) {
		$valido=FALSE;
		$error="Debe rellenar todos los campos.";
	} elseif (existe_usuario($_POST['usuario'])) {
		$valido=FALSE;
		$error="El nombre de usuario seleccionado ya ha sido registrado por otro usuario.";
	} elseif (!isset($_POST['password']) || strlen($_POST['password']) == 0) {
		$valido=FALSE;
		$error="Debe rellenar todos los campos.";
	} else {
		$valido=TRUE;
	}
}

if ($valido) {
	if (registrar_usuario()) {		
?>
	<div class="alert-message success span12 offset1">
		<p>
			<strong>Enhorabuena</strong>, te has registrado con éxito;
		</p>
	</div>

	<div class="span12 offset1">
		<a href="/ejercicios" class="btn primary large">Volver al inicio</a>
	</div>
<?
	} else {
?>
		<div class="alert-message error span12 offset1">
			<p>
				<strong>ERRROR: </strong>Ocurrió un error al crear el usuario;
			</p>
		</div>

		<div class="span12 offset1">
			<a href="/ejercicios/index.php?accion=registro" class="btn success large">Volver a intentarlo</a>	
			<a href="/ejercicios" class="btn primary large">Volver al inicio</a>
		</div>
<?
	}
} else {
	//Repopular el formulario?
?>
	<div class="span12 offset1">
<?
		if ($error != '') {
?>
		<div class="alert-message error">
			<p>
				<strong>ERROR: </strong><?=$error?>;
			</p>
		</div>
<?		
		}
?>		
		<h3>Registrate:</h3>
		<form action='/ejercicios/index.php?accion=registro' method='post'>
			<div class="clearfix">
				<label>Nombre:</label>
				<div class="input"><input type="text" name="nombre"/></div>
			</div>			
			
			<div class="clearfix">			
				<label>eMail:</label>
				<div class="input"><input type="text" name="email"/></div>	
			</div>			

			<div class="clearfix">			
				<label>Usuario:</label>
				<div class="input"><input type="text" name="usuario"/></div>
			</div>			

			<div class="clearfix">			
				<label>Password:</label>
				<div class="input"><input type="password" name="password"/></div>
			</div>			

			<div class="clearfix">		
				<label id="tipo">¿Eres alumno o profesor?</label>
				<div class="input">
					<ul class="inputs-list">
						<li><label><input type="radio" name="tipo" value="alumno"> <span>Alumno</span></label>
						<li><label><input type="radio" name="tipo" value="profesor" checked> <span>Profesor</span></label>
					</ul>
				</div>
			</div>
		
			<div class="actions">
				<input type="submit" class="btn primary" name="registro" value="Resgistrarse"/>
				<a class="btn error" href="/ejercicios">Cancelar</a>			
			</div>
		</form>
	</div>
<?
}
?>