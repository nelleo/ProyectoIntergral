<?php

	require_once("soporte.php");
	if ($auth->EstaLogueado()) {
		header("Location:index.html");exit;
	}
	$username="";
	$email="";
	$edad="";
	$pais_enviado="";
	$emailDefault = "";
	$edadDefault = "";
	$usernameDefault = "";
	$telefonoDefault = "";

	$paises = [
		"Ar" => "Argentina",
		"Br" => "Brasil",
		"Co" => "Colombia",
		"Fr" => "Francia",
		"Bo"=>"Bolivia",
		"Ch"=>"Chile",
		"Par"=>"Paraguay",
		"Pe"=>"Perú",
		"Ve"=>"Venezuela",
		"Ur"=>"Uruguay",
		"Ec"=>"Ecuador"
	];

	$errores = [];
	if ($_POST) {
		$errores = $validador->validarInformacion($_POST,$db);
		//$pais_enviado=$errores;
		if (/*!strlen($errores)>=2 ||*/ count($errores) == 0) {

			$usuario = new Usuario($_POST["username"],$_POST["email"],$_POST["password"],$_POST["country"],"",$_POST["edad"]);
			$usuario->guardarImagen();
			$_SESSION["usuarioLogueado"]= $db->guardarUsuario($usuario);
			header("Location:index.html");exit;
		}
	}

	include("header.php");
?>

<!-- formulario -->
<div class="container-fluid">
	<div class="container">
		<h1 id="h1">ProWeb</h1>
		<div class="login-page">
			<div class="main-icon">
				<span class="fa fa-eercast"></span>
			</div>
			<p id="subTitulo">Registrate</p>
			<div class="header-left-bottom">
				<form action="" method="post" enctype="multipart/form-data">
					<ul id="errores">
						<?php foreach ($errores as $error) : ?>
							<li >
								<?=$error?>
							</li>
					<?php endforeach; ?>
					</ul>
					<div class="icon1">						
						<span class="fa fa-user"></span>
						<input type="text" name="username" placeholder="Nombre de usuario" value="<?= $username?>"required=""/>
					</div>
					<div class="icon1">						
						<span class="fa fa-user"></span>
						<input type="email" name="email" placeholder="Email" value="<?= $email?>" required=""/>
					</div>
					<div class="icon1">
						<span class="fa fa-user"></span>
						<input type="number" name="edad" placeholder="Edad" value="<?= $edad ?>"required=""/>
					</div>
					<div class="form-group">
    				<label class="comentarios" for="exampleFormControlTextarea1">Que cosas espera encontrar aqui?</label>
    				<textarea name="interes" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  				</div>
					<div class="">
						<label class="comentarios" for="country">Pais : </label>
						<select class="" name="country">
						<?php foreach ($paises as $llave => $pais):?>
							<option value="<?=$llave;?>" <?= ($pais_enviado == $pais) ? "selected" : "" ; ?>><?=$pais;?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<div class="">
							<label class="comentarios" for="imagen">foto de perfil : </label><br>
							<input id="img" type="file" name="imagen" style="border:solid 1px;"><br>
					</div>
					<div class="icon1">
						<span class="fa fa-lock"></span>
						<input type="password"	name="password" placeholder="Contraseña" required=""/>
					</div>
					<div class="icon1">
						<span class="fa fa-lock"></span>
						<input type="password" name="cpassword" placeholder="Confirmar contraseña" required=""/>
					</div>
					<div class="bottom">
						<button name="submit" type="submit" class="btn">Listo!</button>
					</div>
				</form>
			</div>
			<div class="social">
				<ul class="redes">
					<li>Visitanos en : </li>
					<li><a href="#" class="facebook"><span class="fa fa-facebook"></span></a></li>
					<li><a href="#" class="twitter"><span class="fa fa-twitter"></span></a></li>
					<li><a href="#" class="google"><span class="fa fa-google-plus"></span></a></li>
				</ul>
			</div>
		</div>

<?php include("footer.php"); ?>
