<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./style.css" rel="stylesheet">
</head>

<body>
<?php include 'navbar.php'; ?>
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
            $stmt = $this->con->prepare('INSERT INTO taches (titre, description, dateEcheance, priorite, id_categorie, id_user) VALUES (:titre, :description, :dateEcheance, :priorite, :id_categorie, :id_user)');
            $stmt->bindValue(':titre', $titre);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':dateEcheance', $dateEcheance);
            $stmt->bindValue(':priorite', $priorite);
            $stmt->bindValue(':id_categorie', $id_categorie);
            $stmt->bindValue(':id_user', $id_user);

            if ($stmt->execute()) {
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
            $stmt = $this->con->prepare('SELECT id_categorie, libelle FROM categories');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }
}

$con = new Crud('gestion-des-taches', 'localhost', 'root', '');

// Démarrer la session et vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les catégories depuis la base de données
$categories = $con->getCategories();

if (isset($_POST['creer-tache'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $dateEcheance = $_POST['dateEcheance'];
    $priorite = $_POST['priorite'];
    $id_categorie = $_POST['id_categorie'];
    $id_user = $_SESSION['id_user']; // Utiliser l'ID utilisateur de la session

    if (!empty($titre) && !empty($description) && !empty($dateEcheance) && !empty($priorite) && !empty($id_categorie)) {
        $con->insertTache($titre, $description, $dateEcheance, $priorite, $id_categorie, $id_user);
    } else {
        echo "Veuillez remplir tous les champs!";
    }
}
?>

<div class="container mx-auto p-4 mt-20">
    <h1 class="text-2xl font-bold mb-4">Créer une Tâche</h1>
    <form action="AddTache.php" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
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
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="priorite" type="text" name="priorite" placeholder="Priorité de la tâche">
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
            <button class="bg-[#7a4a82]  text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="creer-tache">
                Créer Tâche
            </button>
        </div>
    </form>
</div>

    <div class="mt-10">

                </div>
<?php include 'footer.php'; ?>
</body>
</html>
