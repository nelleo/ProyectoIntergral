<?php 
class Jaison extends Db
{

  private $nombreArchivo;

  public function __construct($nombreArchivo){
      $this->nombreArchivo = $nombreArchivo;
  }

  public function getNombreArchivo(){
      return $this->nombreArchivo;
  }

  public function setNombreArchivo($nombreArchivo){
      $this->nombreArchivo = $nombreArchivo;
  }

  public function GuardarUsuario(Usuario $usuario){
    if (file_exists($this->nombreArchivo )) {
        $usuariosJson=file_get_contents('usuarios.json');
		$usuarios=json_decode($usuariosJson,true);
		$posUltUser=count($usuarios["usuarios"]);
		if (is_null($posUltUser)|| $posUltUser==0) {
			$usuarios["id"]=0;
		}else{
			$ultId=$usuarios["usuarios"][$posUltUser-1]["id"];
			$usuarios["id"]=$ultId+1;
		}
      $registro=["email"=>$usuario->getEmail(),"password" => $usuario->getPass(),"edad"=>$usuario->getEdad(),
      "username"=>$usuario->getUsername(), "pais"=>$usuario->getPais(),"telefono"=>$usuario->getTelefono(),"id"=>$usuarios["id"]];
      $jsusuario = json_encode($registro,JSON_PRETTY_PRINT);
      
      file_put_contents($this->nombreArchivo ,$jsusuario. PHP_EOL, FILE_APPEND);
    }else {
        $usuarios["id"]=0;
        $registro=["email"=>$usuario->getEmail(),"password" => $usuario->getPass(),"edad"=>$usuario->getEdad(),
      "username"=>$usuario->getUsername(), "pais"=>$usuario->getPais(),"telefono"=>$usuario->getTelefono(),"id"=>$usuarios["id"]];

      $jsusuario = json_encode($registro,JSON_PRETTY_PRINT);
      
      file_put_contents($this->nombreArchivo ,$jsusuario. PHP_EOL, FILE_APPEND);
	}
//PHP_OEL encuentra el caracter de nueva linea de manera compatible con platarfomas cruzadas (DOS/UNIX)
}
public function TraerPorUsername($username){
     
      $usuariosCodificados = $this->abrirBaseDatos();
      $usuarios= $this->TraerTodos($usuariosCodificados);
     
    if($usuarios!==null){
          foreach ($usuarios as $usuario) {
              if($username == $usuario["username"]){
                  $usuarioTraido = new Usuario($usuario["username"],$usuario["email"],$usuario["password"],
                  $usuario["pais"],"",$usuario["edad"],$usuario["id"]);
                  return $usuarioTraido;
              }
          }
      return null;
    }
}
  public function abrirBaseDatos(){
      if(file_exists($this->getNombreArchivo())){
          $baseDatosJson= file_get_contents($this->getNombreArchivo());    
          $baseDatosJson = explode(PHP_EOL,$baseDatosJson);//divide un string en varios strings (aguja,pajar) 
          //en este caso por salto de linea
          //Aquí saco el ultimo registro, el cual está en blanco
          array_pop($baseDatosJson);
          return $baseDatosJson;
      }else{
          return null;
      }    
  }

  public function TraerTodos($baseDatosJson=null){
    $arrayUsuarios=[];
    //Aquí recorro el array y creo mi array con todos los usuarios 
    foreach ($baseDatosJson as  $usuarios) {
      $arrayUsuarios[]= json_decode($usuarios,true);
    }
    //Aquí retorno el array de usuarios con todos sus datos
    return $arrayUsuarios;
  }
  
  public function jsonRegistroOlvide($email,$password){

      $usuariosCodificados = $this->abrirBaseDatos();
      $usuarios= $this->TraerTodos($usuariosCodificados);
      foreach ($usuarios as $key=>$usuario) {
          
          if($email==$usuario["email"]){
              //Esta línea se las comente para que a futuro puedan probar si la clave nueva la van a grabar 
              //correctamente, la idea es verla antes de hashearla. le pueden aplicar un dd() y verificar que les trae
              //$usuario["password"]= $datos["password"];
              //dd()----->dump and die ,es de laravel ,sirve para depurar y ver variables rapido en el navegador
              $usuario["password"]= Encriptar::hashPassword($password);
              //Aquí guardamos el registro del usuario, pero con el password hasheado
              $usuarios[$key] = $usuario;    
          }
          //Si no es el usuario, entonces va de igual forma a guardar todo los usuarios
          $usuarios[$key] = $usuario;    
      }
      //Esto se los coloque para que sepan que con esta función podemos borrar un archivo
      unlink($this->nombreArchivo);
      //Aquí vuelvo a recorrer el array para poder guardar un registro bajo el otro, haciendo uso de la constante de php PHP_EOL
      foreach ($usuarios as  $usuario) {
          $jsusuario = json_encode($usuario);
          file_put_contents($this->nombreArchivo,$jsusuario. PHP_EOL,FILE_APPEND);
      }
      //Esta función no retorna nada, ya que su  responsabilidad es guardar al usuario, pero con su nueva
      // contraseña
  }
      
  public function actualizar(){
      //A futuro trabajaremos en esto
  }
  public function borrar(){
      //A futuro trabajaremos en esto
  }
}
 ?>