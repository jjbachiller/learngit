<div class="span10 offset2">
<?
if (!comprobar_usuario()) {
?>
	<div class="alert-message error">
		<p><strong>ERROR: </strong>Usuario o contraseña incorrectos.</p>
	</div>
<?
}
?>	
	<form action="/ejercicios/index.php?accion=login" method="POST">
		<div class="clearfix">
			<label>Usuario:</label>
			<div class="input">
	  			<input type="text" name="usuario" placeholder="Usuario" class="input-small">
			</div>
		</div>
	
		<div class="cleafix">
			<label>Contraseña</label>
			<div class="input">
	  			<input type="password" name="password" placeholder="Contraseña" class="input-small">
			</div>
		</div>
	
		<div class="actions">
	  		<button class="btn primary" type="submit" name="acceder" class="btn">Acceder</button>
			<a class="btn error" href="/ejercicios">Cancelar</a>
		</div>
	</form>
</div>