<?php
require "../connection.php";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $libelle = $_POST["libelle"];
    $description = $_POST["description"];

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO categories (libelle, description) VALUES (:libelle, :description)";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":libelle", $libelle);
    $stmt->bindParam(":description", $description);

    // Vérifier si l'insertion a réussi
    if ($stmt->execute()) {
        // Retourner une réponse JSON indiquant le succès
        echo json_encode(array("success" => true, "message" => "Category added successfully"));
    } else {
        // Retourner une réponse JSON indiquant l'échec
        echo json_encode(array("success" => false, "message" => "Failed to add category"));
    }
} else {
    // Retourner une réponse JSON indiquant une erreur de méthode
    echo json_encode(array("success" => false, "message" => "Method not allowed"));
}
?>
