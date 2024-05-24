<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Tâche</title>
</head>
<body>
<?php
// Inclure le fichier qui contient la classe Crud et initialiser une instance
require "connection.php";
$con = new Crud('gestion-des-taches', 'localhost', 'root', '');

// Récupérer les catégories depuis la base de données
$categories = $con->getCategories();
?>
<div class="container mx-auto p-4">
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
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="creer-tache">
                Créer Tâche
            </button>
        </div>
    </form>
</div>
</body>
</html>
