<?php
// Connexion à la base de données
require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Requête SQL pour récupérer la tâche à modifier
    $sql = "SELECT * FROM taches WHERE id_tache = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST["titre"];
    $dateEcheance = $_POST["dateEcheance"];
    $description = $_POST["description"];
    $statut = $_POST["statut"];

    // Requête SQL pour mettre à jour la tâche
    $sql = "UPDATE taches SET titre = :titre, dateEcheance = :dateEcheance, description = :description, statut = :statut WHERE id_tache = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":titre", $titre);
    $stmt->bindParam(":dateEcheance", $dateEcheance);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":statut", $statut);
    $stmt->bindParam(":id", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur lors de la modification de la tâche.";
    }
}

$con = null;
?>
