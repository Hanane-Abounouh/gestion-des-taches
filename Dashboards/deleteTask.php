<?php
session_start();

// Connexion à la base de données
require "../connection.php";

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $task_id = $_POST['task_id'];

        $sql = "DELETE FROM taches WHERE id_tache = :task_id"; // Assurez-vous de remplacer 'taches' par le nom correct de votre table
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':task_id', $task_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete task']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
