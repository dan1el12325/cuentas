<?php 

//Database Conection

class Connection{
    private $dbname = "gap";
    private $host = '127.0.0.1';
    private $user = 'root';
    private $password = "";

    public $conn;

    public function __construct(){
        try{
            $this -> conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);

            $this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch (PDOException $e){
            die(json_encode([
                "success" => false,
                "message" => "Error de conexion",
                "error" => $e->getMessage()
            ]));
        }
    }

    public function userExists($username){
        $sql = 'SELECT * FROM usuarios WHERE username = :username';

        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute([
            ':username' => $username
        ]);

        $user = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $user ? true : false;
        
    }

    public function createUser($username, $fullname, $password, $creationDate){
        $sql = 'INSERT INTO usuarios (username, nombre, password, fecha_creacion) VALUES (:username, :fullname, :password, :creationDate)';

        $stmt = $this -> conn -> prepare($sql);

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $result = $stmt -> execute([
            ":username" => $username,
            ":fullname" => $fullname,
            ":password" => $passwordHash,
            ":creationDate" => $creationDate
        ]);

        if($result){
            echo json_encode([
                "success" => true,
                "id" => $this -> conn -> lastInsertId()
            ]);
        }else{
            echo json_encode([
                "success" => false,
            ]);
        }
    }

    public function getPassword($username){
        $sql = 'SELECT password FROM usuarios WHERE username = :username';

        $stmt = $this->conn->prepare($sql);

        $stmt -> execute([
            ":username" => $username
        ]);

        $password = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $password['password'] ?? null;
    }

    public function login($username, $password){
        $user = $this->userExists($username);
        $hash = $this -> getPassword($username);

        if($user && password_verify($password, $hash)){
            return [
                "success" => true,
                "message" => "Acceso autorizado"
            ];
        }else{
            return [
                "success" => false,
                "message" => "Usuario y/o contraseña incorrectos"
            ];
        }
    }

}