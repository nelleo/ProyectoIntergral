
<?php
require_once "soporte.php";
require_once "usuario.php";

class Validador
{

  public function ValidarInformacion($informacion,Db $db) {
    $errores = [];

    foreach ($informacion as $clave => $valor) {
      $informacion[$clave] = trim($valor);
    }

    if (strlen($informacion["username"]) <= 3) {
      $errores["username"] = "Tenes que poner más de 3 caracteres en tu nombre de usuario";
    }

    if ($informacion["edad"] < 18) {
      $errores["edad"] = "Tenes que tener más de 18 años";
    }

    /*if (is_numeric($informacion["telefono"]) == false) {
      $errores["telefono"] = "El telefono debe ser un numero";
    }*/


    if ($informacion["username"] == "") {
      $errores["username"] = "Che, dejaste el mail incompleto";
    }
    else if (filter_var($informacion["email"], FILTER_VALIDATE_EMAIL) == false) {

      $errores["mail"] = "El mail tiene que ser un mail";
    
    } else if ($db->TraerPorUsername($informacion["username"]) != NULL) {
     
      $errores["username"] = "El usuario ya existe";
    
    } else if ($db->TraerPorEMail($informacion["email"]) != NULL) {
     
      $errores["email"] = "El email ya existe";
    }

    if ($informacion["password"] == "") {
      $errores["password"] = "No llenaste la contraseña";
    }

    if ($informacion["cpassword"] == "") {
      $errores["cpassword"] = "No llenaste completar contraseña";
    }

    if ($informacion["password"] != "" && $informacion["cpassword"] != "" && $informacion["password"] != $informacion["cpassword"]) {
      $errores["password"] = "Las contraseñas no coinciden";
    }
    if (is_Null($_POST["country"])){
      $errores["country"] = "debes seleccionar un pais";
    //}else{
    //  return $_POST["country"];
    }

    return $errores;
  }

  public function ValidarLogin($informacion,Db $db) {
  		$errores = [];

  		foreach ($informacion as $clave => $valor) {
  			$informacion[$clave] = trim($valor);
  		}

  		if ($informacion["username"] == "") {
  			$errores["username"] = "dejaste el username incompleto";
  		}
  		/*else if (filter_var($informacion["username"], FILTER_VALIDATE_EMAIL) == false) {
  			$errores["username"] = "El username tiene que cumplir con el formatode un username";
      } */
      $usuario=$db->TraerPorUsername($informacion["username"]);
      if ( $usuario== NULL) {
        $errores["username"] = "El usuario no esta en nuestra base";
        return $errores;
  		}

  		if ($informacion["password"] == "") {
  			$errores["password"] = "No llenaste la contraseña";
  		} else {
  			//El usuario existe y puso contraseña
        // Tengo que validar que la contraseña que ingreso sea valida
        $pass=md5($informacion["password"]);
  			if ($usuario->getPass()!==$pass) {
  				$errores["password"] = "La contraseña no verifica";
  			}
  		}

  		return $errores;
  	}
}

 ?>
