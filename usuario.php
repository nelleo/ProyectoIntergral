<?php

class Usuario
{
  private $id;
  private $username;
  private $email;
  private $pass;
  private $pais;
  private $telefono;
  private $edad;

  public function __construct($username,$email,$pass,$pais,$telefono=null,$edad,$id=null){
    if ($id==null) {
      $this->pass=md5($pass);
    }else{
      $this->pass = $pass;
    }
    $this->username = $username;
    $this->email = $email;
    $this->pais = $pais;
    $this->telefono = $telefono;
    $this->edad = $edad;
    $this->id=$id;
  }
  public function guardarImagen()
  {
    //validar que hayan subido una img
    if ($_FILES["imagen"]["error"] == UPLOAD_ERR_OK)
    {

      $nombre=$_FILES["imagen"]["name"];
      $archivo=$_FILES["imagen"]["tmp_name"];

      $ext = pathinfo($nombre, PATHINFO_EXTENSION);

      if ($ext != "jpg" && $ext != "png" && $ext != "jpeg") {
        return "Error";
      }

      $miArchivo = dirname(__FILE__);
      $miArchivo = $miArchivo . "/subidas/";
      $miArchivo = $miArchivo . $this->getUsername() . "." . $ext;

      move_uploaded_file($archivo, $miArchivo);

    }else {

      echo "no se a subido ninguna imagen de perfil,se pondra una por defecto";
      $nombre=$_FILES["imgDefecto"]["name"];
      $archivo=$_FILES["imgDefecto"]["tmp_name"];


      $ext = "jpg";
      $miArchivo = dirname(__FILE__);
      $miArchivo = $miArchivo . "/subidas/";
      $miArchivo = $miArchivo . $this->username . "." . $ext;
      move_uploaded_file($archivo, $miArchivo);

    }
  }
  public function setId($id){
    $this->id = $id;
  }
  public function getId(){
    return $this->id;
  }
  public function setEmail($email){
    $this->email = $email;
  }
  public function getEmail(){
    return $this->email;
  }
  public function setPass($pass){
    $this->pass = $pass;
  }
  public function getPass(){
    return $this->pass;
  }
  public function setUsername($username){
    $this->username = $username;
  }
  public function getUsername(){
    return $this->username;
  }
  public function setEdad($edad){
    $this->edad = $edad;
  }
  public function getEdad(){
    return $this->edad;
  }
  public function setPais($pais){
    $this->pais = $pais;
  }
  public function getPais(){
    return $this->pais;
  }
  public function setTelefono($telefono){
    $this->telefono = $telefono;
  }
  public function getTelefono(){
    return $this->telefono;
  }

}

 ?>
