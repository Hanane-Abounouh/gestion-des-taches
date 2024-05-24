<?php 
class crud {
    private $con;

    public function __construct($dbname, $host, $user, $password) {
        try {
            $this->con = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }

    public function insertData($name, $email, $password, $id_role) {
        try {
            $con = $this->con->prepare('INSERT INTO users(nom, email, motDePasse, id_role) VALUES(:nom, :email, :motDePasse, :id_role)');
            $con->bindValue(':nom', $name);
            $con->bindValue(':email', $email);
            $con->bindValue(':motDePasse', $password);
            $con->bindValue(':id_role', $id_role);

            if ($con->execute()) {
                echo "User added successfully.";
            } else {
                echo "Error adding user.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    
}
?>

