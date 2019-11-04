<?php
require_once "usuario.php";
require_once "abstracDB.php";
class Autorizador
{
  function __construct()
  {
    if(!isset($_SESSION))
    {
      session_start();
    }
    if (!isset($_SESSION["logueado"]) && isset($_COOKIE["logueado"]))
    {
   		 $_SESSION["logueado"] = $_COOKIE["logueado"];
    }
  }
  function Loguear(usuario $usuario)
  {
    $_SESSION["logueado"] = $usuario->getEmail();
  }

  function EstaLogueado()
  {
   return isset($_SESSION["logueado"]);
  }

  function UsuarioLogueado(db $db)
  {
    if ($this->estaLogueado()) {
      $email = $_SESSION["logueado"];
      return $db->traerPorMail($email);
    } else {
      return NULL;
    }
  }

  function Logout()
  {
    session_destroy();
    setcookie("logueado", "", -1);
  }

  function Recordarme(usuario $usuario)
  {
    setcookie("logueado", $usuario->getMail(), time() + 3600 * 2);
  }
}

 ?>
