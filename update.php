<?php
// Connexion à la base de données
include 'connection.php';

function getCategories($con) {
    $stmt = $con->query("SELECT id_categorie, libelle FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$categories = getCategories($con);

// Vérification si l'article existe avant de le charger pour la modification
if(isset($_GET['id'])) {
    $id_article = $_GET['id'];
    $stmt = $con->prepare("SELECT * FROM taches WHERE id_tache = :id_tache");
    $stmt->bindParam(':id_tache', $id_article);
    $stmt->execute();
    $tache = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$tache) {
        echo "Tâche non trouvée.";
        exit;
    } else {
        $editId = $tache['id_tache'];
        $editTitre = $tache['titre'];
        $editDescription = $tache['description'];
        $editDateEcheance = $tache['dateEcheance'];
        $editStatut = $tache['statut'];
  
        $editIdCategorie = $tache['id_categorie'];
    }
} else {
    echo "ID de tâche non spécifié.";
    exit;
}

// Traitement de la soumission du formulaire de mise à jour
if(isset($_POST['modifier-tache'])) {
    $id_tache = $_POST['taskId'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $dateEcheance = $_POST['dateEcheance'];
    $statut = $_POST['statut'];

    $id_categorie = $_POST['id_categorie'];

    // Préparation et exécution de la requête SQL pour mettre à jour l'article dans la base de données
    $query = "UPDATE taches SET titre = :titre, description = :description, dateEcheance = :dateEcheance, statut = :statut, id_categorie = :id_categorie WHERE id_tache = :id_tache";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':dateEcheance', $dateEcheance);
    $stmt->bindParam(':statut', $statut);

    $stmt->bindParam(':id_categorie', $id_categorie);
    $stmt->bindParam(':id_tache', $id_tache);

    // Exécution de la requête
    if ($stmt->execute()) {
        header("Location: Home.php");
                exit(); 
    } else {
        echo "Erreur lors de la mise à jour de la tâche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Tâche</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assurez-vous d'inclure le fichier CSS correspondant -->
    <link href="./style.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    <!-- Formulaire de modification -->
    <div class="container mx-auto p-20 mt-10">
        <h1 class="text-2xl font-bold mb-6">Modifier une Tâche</h1>
        <form action="update.php?id=<?php echo $editId; ?>" method="POST" class="bg-white p-6 mt-10 rounded-lg shadow-md">
            <input type="hidden" name="taskId" value="<?php echo $editId; ?>" >

            <div class="mb-4">
                <label for="titre" class="block text-gray-700">Titre :</label>
                <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($editTitre); ?>" class="w-full px-3 py-2 border rounded-md" required="">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description :</label>
                <textarea id="description" name="description" class="w-full px-3 py-2 border rounded-md" required=""><?php echo htmlspecialchars($editDescription); ?></textarea>
            </div>

            <div class="mb-4">
                <label for="dateEcheance" class="block text-gray-700">Date d'Échéance :</label>
                <input type="date" id="dateEcheance" name="dateEcheance" value="<?php echo htmlspecialchars($editDateEcheance); ?>" class="w-full px-3 py-2 border rounded-md" required="">
            </div>

            <div class="mb-4">
                <label for="statut" class="block text-gray-700">Statut :</label>
                <input type="text" id="statut" name="statut" value="<?php echo htmlspecialchars($editStatut); ?>" class="w-full px-3 py-2 border rounded-md" required="">
            </div>

            

            <div class="mb-4">
                <label for="id_categorie" class="block text-gray-700">Catégorie :</label>
                <select id="id_categorie" name="id_categorie" class="w-full px-3 py-2 border rounded-md" required="">
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?php echo $categorie['id_categorie']; ?>" <?php if ($categorie['id_categorie'] == $editIdCategorie) echo 'selected'; ?>><?php echo htmlspecialchars($categorie['libelle']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" name="modifier-tache" class="w-full bg-gray-300 text-black py-2 rounded-md hover:bg-gray-600">Modifier Tâche</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
