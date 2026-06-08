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

        return $user;
        
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
                "data" => $user,
                "message" => "Acceso autorizado"
            ];
        }else{
            return [
                "success" => false,
                "message" => "Usuario y/o contraseña incorrectos"
            ];
        }
    }

    public function saveCard($idUser, $bin, $last4, $bank, $brand, $alias, $cardType, $creditLimit = null, $closingDate = null, $dueDate = null) {
        $sql = 'INSERT INTO tarjetas (id_usuario, alias, ultimos4, bin, banco, marca, tipo, limite_credito, fecha_corte, fecha_pago) VALUES (
        :idUser, :alias, :last4, :bin, :bank, :brand, :cardType, :creditLimit, :closingDate, :dueDate)';

        $stmt = $this -> conn -> prepare($sql);

        return $stmt -> execute([
            ":idUser" => $idUser,
            ":alias" => $alias,
            ":last4" => $last4,
            ":bin" => $bin,
            ":bank" => $bank,
            ":brand" => $brand,
            ":cardType" => $cardType,
            ":creditLimit" => $creditLimit,
            ":closingDate" => $closingDate,
            ":dueDate" => $dueDate
        ]);
    }

}