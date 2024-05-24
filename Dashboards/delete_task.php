<?php
// Connexion à la base de données
require "../connection.php";

$response = array("success" => false);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task_id"])) {
    $taskId = $_POST["task_id"];

    // Requête SQL pour supprimer la tâche avec l'ID spécifié
    $sql = "DELETE FROM taches WHERE id_tache = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id", $taskId);

    if ($stmt->execute()) {
        // Répondre avec un statut OK si la suppression réussit
        $response["success"] = true;
    } else {
        // Afficher un message d'erreur si la suppression échoue
        $response["message"] = "Erreur lors de la suppression de la tâche.";
    }
} else {
    // Répondre avec un statut d'erreur si la requête est incorrecte ou si l'ID de la tâche n'est pas défini
    $response["message"] = "Requête invalide.";
}

echo json_encode($response);
$con = null;
?>
