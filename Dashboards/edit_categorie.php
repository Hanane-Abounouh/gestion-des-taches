<?php
// Script PHP pour la modification d'une catégorie

// Vérifiez si la requête est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez si les données du formulaire ont été reçues et sont non vides
    if (isset($_POST['editCategoryId'], $_POST['editLibelle'], $_POST['editDescription']) && !empty($_POST['editLibelle']) && !empty($_POST['editDescription'])) {
        // Récupérez les données du formulaire
        $categoryId = $_POST['editCategoryId'];
        $libelle = $_POST['editLibelle'];
        $description = $_POST['editDescription'];

        // Effectuez vos opérations de mise à jour de la catégorie dans la base de données
        // Assurez-vous d'utiliser des requêtes préparées pour éviter les injections SQL

        // Exemple de code pour une mise à jour de la catégorie dans une base de données MySQL avec PDO
        require "../connection.php";

        // Préparez la requête SQL
        $sql = "UPDATE categories SET libelle = :libelle, description = :description WHERE id_categorie = :id";

        // Préparez et exécutez la requête
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':libelle', $libelle);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $categoryId);
        
        if ($stmt->execute()) {
            // La mise à jour de la catégorie a réussi
            $response = array(
                'success' => true,
                'message' => 'Category updated successfully.'
            );
        } else {
            // La mise à jour de la catégorie a échoué
            $response = array(
                'success' => false,
                'message' => 'Failed to update category.'
            );
        }
    } else {
        // Les données du formulaire sont manquantes ou vides
        $response = array(
            'success' => false,
            'message' => 'Please provide both libelle and description.'
        );
    }
} else {
    // La requête n'est pas une requête POST
    $response = array(
        'success' => false,
        'message' => 'Invalid request method.'
    );
}

// Envoyer la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
