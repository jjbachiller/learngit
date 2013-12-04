<h3>Antes de continuar debes indicar a que curso perteneces:</h3>

<form action="/ejercicios/index.php?accion=alumno" method="POST">
	Curso: 
	<select name="mi_curso">
		<option value='0'>-- Elige tu curso --</option>
		<?
			$cursos=obtener_cursos();
			while ($curso=mysql_fetch_array($cursos)) {
		?>
		<option value="<?=$curso['id_curso']?>"><?=$curso['nombre']?></option>
		<?
			}
		?>
	</select>		
	<input type="submit" name="asociar_curso" value="Asociar curso"/>
</form>