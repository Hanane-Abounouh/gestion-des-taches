<?php
require "../connection.php";

// Vérifie si la requête est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère l'ID de la catégorie à supprimer depuis les données POST
    $id_categorie = $_POST["id_categorie"];

    // Prépare et exécute la requête de suppression de la catégorie
    $sql = "DELETE FROM categories WHERE id_categorie = :id_categorie";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_categorie", $id_categorie);

    // Vérifie si la suppression a réussi
    if ($stmt->execute()) {
        // Retourne une réponse JSON indiquant le succès
        echo json_encode(array("success" => true, "message" => "Category deleted successfully"));
    } else {
        // Retourne une réponse JSON indiquant l'échec
        echo json_encode(array("success" => false, "message" => "Failed to delete category"));
    }
} else {
    // Retourne une réponse JSON indiquant une erreur de méthode
    echo json_encode(array("success" => false, "message" => "Method not allowed"));
}
?>
