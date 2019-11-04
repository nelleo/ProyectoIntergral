<?php
require_once("abstracDB.php");
require_once("usuario.php");
require_once("Validador.php");
require_once("Autorizador.php");
require_once("BdJson.php");

$dbType = "mysql";
switch ($dbType) {
  case 'mysql':
    $db=new Relacional();
    break;
  case 'jaison':
    $db=new Jaison("usuarios.json");
    break;
}
$auth=new Autorizador();
$validador = new Validador();
