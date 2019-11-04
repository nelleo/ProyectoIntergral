<?php
require_once("usuario.php");
abstract class Db
{
  abstract public function GuardarUsuario(usuario $usuario);

  abstract public function TraerTodos($bd=NULL);

  abstract public function TraerPorUsername($username);
}
//Cuando me trae los datos de un usuario deberia crear un array con ellos y luego crear una variable
//de tipo usuario con la info del array;esto para el metodo TraerPorMail
///////////////////////////////////////////////////////////////////////////////////////
class Relacional extends Db
{
  private $db;

  public function __construct(){
    $dsn = 'mysql:host=localhost;dbname=proweb;
    charset=utf8mb4;port=3306';
    $user ="root";
    $pass = "";

    try {
      $this->db = new PDO($dsn, $user, $pass);
    } catch (Exception $e) {
      echo "La conexion a la base de datos falló: " . $e->getMessage();
    }
  }

   public function GuardarUsuario(usuario $usuario){
     $query = $this->db->prepare("Insert into usuarios values(default, :email, :password,:edad,:pais,:username, :telefono)");

     $query->bindValue(":email", $usuario->getEmail());
     $query->bindValue(":password", $usuario->getPass());
     $query->bindValue(":edad", $usuario->getEdad());
     $query->bindValue(":username", $usuario->getUsername());
     $query->bindValue(":pais", $usuario->getPais());
     $query->bindValue(":telefono", $usuario->getTelefono());

     $id = $this->db->lastInsertId();
     $usuario->setId($id);

     $query->execute();

     return $usuario;
   }

   public function TraerTodos($bd=NULL)
   {
     $query = $this->db->prepare("Select * from usuarios");
     $query->execute();
     $usuariosTraidos=$query->fetchAll();//devuelve un array con todos las filas;fila==array con valores(campos) 
     $usuaruariosFormatoClases=[];
    foreach ($usuariosTraidos as $usuario ) {
      $usuarioTraido = new usuario($informacion["username"],$informacion["email"],$informacion["pass"],$informacion["pais"],$informacion["telefono"],$informacion["id"]);
      $usuaruariosFormatoClases[]=$usuarioTraido;
    }
    return $usuaruariosFormatoClases;
   }

   public function TraerPorUsername($username)
   {
     $query = $this->db->prepare("Select * from usuarios where username = :username");
     $query->bindValue(":username", $username);

     $query->execute();

     $informacion=$query->fetch(PDO::FETCH_ASSOC);
    if ($informacion!=null) {
     
      $usuario = new usuario($informacion["username"],$informacion["email"],$informacion["password"],$informacion["pais"],$informacion["telefo"],$informacion["edad"],$informacion["id"]);
      return $usuario;
    
    }else{
      return null;
    }
   }

   public function TraerPorEmail($email)
   {
     $query = $this->db->prepare("Select * from usuarios where email = :email");
     $query->bindValue(":email", $email);

     $query->execute();

     $informacion=$query->fetch(PDO::FETCH_ASSOC);
    if ($informacion!=null) {
     
      $usuario = new usuario($informacion["username"],$informacion["email"],$informacion["password"],$informacion["pais"],$informacion["telefo"],$informacion["edad"],$informacion["id"]);
      return $usuario;
    
    }else{
      return null;
    }
   }

}

 ?>
