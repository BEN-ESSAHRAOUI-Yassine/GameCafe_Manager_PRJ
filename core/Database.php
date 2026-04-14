<?php
require_once '../app/config/database.php';
class Database{
private static $instance = null ;
private $pdo;


private function __construct(){
    try{
        $this ->pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
                DB_USER,
                DB_PASS
        );
        $this ->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

       //echo "correct";
    }catch(PDOException $e){
        die ('Erreur de connexion : ' . $e->getMessage());
    }
}

public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
}

public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
}
}
// test la connection ou bien la laison 
Database::getInstance();

