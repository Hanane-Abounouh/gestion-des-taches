<?php
require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données JSON envoyées par la requête AJAX
    $input = json_decode(file_get_contents('php://input'), true);
    $id_user = $input['id_user'];

    if (!empty($id_user)) {
        // Préparer et exécuter la requête de suppression
        $stmt = $con->prepare("DELETE FROM users WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user);

        if ($stmt->execute()) {
            // Répondre avec succès
            echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
        } else {
            // Répondre en cas d'échec
            echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
        }
    } else {
        // Répondre en cas d'ID utilisateur manquant
        echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
    }
} else {
    // Répondre en cas de requête non valide
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
