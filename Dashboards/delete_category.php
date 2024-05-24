<?php
require "../connection.php";

// Vérifier si la requête est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'ID de la catégorie à supprimer
    $id_categorie = $_POST["id_categorie"];

    // Préparer et exécuter la requête de suppression
    $sql = "DELETE FROM categories WHERE id_categorie = :id_categorie";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_categorie", $id_categorie);

    // Vérifier si la suppression a réussi
    if ($stmt->execute()) {
        // Retourner une réponse JSON indiquant le succès
        echo json_encode(array("success" => true, "message" => "Category deleted successfully"));
    } else {
        // Retourner une réponse JSON indiquant l'échec
        echo json_encode(array("success" => false, "message" => "Failed to delete category"));
    }
} else {
    // Retourner une réponse JSON indiquant une erreur de méthode
    echo json_encode(array("success" => false, "message" => "Method not allowed"));
}
?>
