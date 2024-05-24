<?php
class Crud {
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

    public function insertTache($titre, $description, $dateEcheance, $priorite, $id_categorie, $id_user) {
        try {
            $con = $this->con->prepare('INSERT INTO taches (titre, description, dateEcheance, priorite, id_categorie, id_user) VALUES (:titre, :description, :dateEcheance, :priorite, :id_categorie, :id_user)');
            $con->bindValue(':titre', $titre);
            $con->bindValue(':description', $description);
            $con->bindValue(':dateEcheance', $dateEcheance);
            $con->bindValue(':priorite', $priorite);
            $con->bindValue(':id_categorie', $id_categorie);
            $con->bindValue(':id_user', $id_user);

            if ($con->execute()) {
                echo "Tâche créée avec succès.";
            } else {
                echo "Erreur lors de la création de la tâche.";
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function getCategories() {
        try {
            $con = $this->con->prepare('SELECT id_categorie, libelle FROM categories');
            $con->execute();
            return $con->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }
}

$con = new Crud('gestion-des-taches', 'localhost', 'root', '');

// Récupérer les catégories depuis la base de données
$categories = $con->getCategories();

if (isset($_POST['creer-tache'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $dateEcheance = $_POST['dateEcheance'];
    $priorite = $_POST['priorite'];
    $id_categorie = $_POST['id_categorie'];
    $id_user = 1; // Assuming a fixed user ID for now. In a real application, you would fetch this from the session

    if (!empty($titre) && !empty($description) && !empty($dateEcheance) && !empty($priorite) && !empty($id_categorie) && !empty($id_user)) {
        $con->insertTache($titre, $description, $dateEcheance, $priorite, $id_categorie, $id_user);
        echo "Tâche créée avec succès!";
    } else {
        echo "Veuillez remplir tous les champs!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Tâche</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Créer une Tâche</h1>
        <form action="tache.php" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="titre">
                    Titre
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="titre" type="text" name="titre" placeholder="Titre de la tâche">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" placeholder="Description de la tâche"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="dateEcheance">
                    Date d'Échéance
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="dateEcheance" type="date" name="dateEcheance">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="priorite">
                    Priorité
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="priorite" name="priorite">
                    <option value="faible">Faible</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="haute">Haute</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="id_categorie">
                    Catégorie
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="id_categorie" name="id_categorie">
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= $categorie['id_categorie'] ?>"><?= $categorie['libelle'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="creer-tache">
                    Créer Tâche
                </button>
            </div>
        </form>
    </div>
</body>
</html>
