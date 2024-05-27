<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="../style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <section>
        <div class="w-[85%] overflow-hidden rounded-lg shadow-xs">
            <div class="flex gap-5 items-center text-gray-600 mt-5 hover:text-gray-900">
                <img src="https://icons.veryicon.com/png/o/miscellaneous/management-console-icon-update-0318/users-84.png" class="sFlh5c pT0Scc iPVvYb" style="max-width: 30px; height: 30px; width: 30px;" alt="User Icon">
                <span class="text-2xl text-blue-600 font-bold">Categorie</span>
                <button id="addCategoryBtn" class="text-green-500 hover:text-blue-500 py-1 px-2 rounded-full text-xl flex items-center justify-center">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="w-full overflow-x-auto mt-10">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-800 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">id_categorie</th>
                            <th class="px-4 py-3">libelle</th>
                            <th class="px-4 py-3">description</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" class="bg-white divide-y">
                    <?php
                    require "../connection.php";

                    $sql =  $sql = "SELECT * from categories";
                    $result = $con->query($sql);

                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr class='text-gray-800'>";
                            echo "<td class='px-4 py-3 text-sm'>{$row['id_categorie']}</td>";
                            echo "<td class='px-4 py-3 text-xs'>{$row['libelle']}</td>";
                            echo "<td class='px-4 py-3 text-sm'>{$row['description']}</td>";
                            echo "<td class='px-4 py-3'>";
                            echo "<div class='flex items-center space-x-4 text-sm'>";
                            echo "<button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg edit-btn' aria-label='Edit'>";
                            echo "<svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20'><path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path></svg>";
                            echo "</button>";

                            echo "<button class='delete-btn flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg' aria-label='Delete' data-user-id='{$row['id_categorie']}'>";
                            echo "<svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path></svg>";
                            echo "</button>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='py-4 px-6 text-center border-b'>No users found.</td></tr>";
                    }
                    $result->closeCursor();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div id="addCategoryForm" class="hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Add category</h2>
            <form id="categoryForm">
                <div class="mb-4">
                    <label for="libelle" class="block text-gray-700 font-bold mb-2">Libelle:</label>
                    <input type="text" id="libelle" name="libelle" class="border rounded-lg px-4 py-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Description:</label>
                    <input type="text" id="description" name="description" class="border rounded-lg px-4 py-2
                    w-full">
                </div>
               
                <div class="flex justify-end">
                    <button type="button" id="submitAddCategoryBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add</button>
                    <button type="button" id="cancelAddCategoryBtn" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>
   
   <script>
   document.addEventListener('DOMContentLoaded', function() {
        // Fonction pour afficher le formulaire d'ajout de catégorie
        function showAddCategoryForm() {
            document.getElementById('addCategoryForm').classList.remove('hidden');
        }

        // Fonction pour masquer le formulaire d'ajout de catégorie
        function hideAddCategoryForm() {
            document.getElementById('addCategoryForm').classList.add('hidden');
        }

        // Fonction pour ajouter une catégorie
        function addCategory() {
            const formData = new FormData(document.getElementById('categoryForm'));
            fetch('add_category.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload(); // Rafraîchir la page pour afficher la nouvelle catégorie
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error adding category:', error);
            });
        }

        // Ajout des écouteurs d'événements pour le bouton "Ajouter"
        document.getElementById('addCategoryBtn').addEventListener('click', showAddCategoryForm);
        document.getElementById('cancelAddCategoryBtn').addEventListener('click', hideAddCategoryForm);
        document.getElementById('submitAddCategoryBtn').addEventListener('click', addCategory);

        // Script jQuery pour gérer le bouton "Modifier"
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                var categoryId = $(this).data('category-id');
                
                // Récupérer les détails de la catégorie à modifier en utilisant une requête AJAX
                $.ajax({
                    url: 'edit_categorie.php',
                    type: 'POST',
                    data: { category_id: categoryId },
                    success: function(response) {
                        // Pré-remplir les champs du formulaire avec les détails de la catégorie
                        var categoryDetails = JSON.parse(response);
                        $('#libelle').val(categoryDetails.libelle);
                        $('#description').val(categoryDetails.description);
                        
                        // Afficher le formulaire de modification
                        $('#editCategoryForm').show();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    });
    // Gestionnaire d'événements pour le clic sur les boutons de suppression de catégorie
$(document).on('click', '.delete-btn', function() {
    if (confirm('Are you sure you want to delete this category?')) {
        var categoryId = $(this).data('category-id');
        
        // Envoi de la requête AJAX pour supprimer la catégorie
        $.ajax({
            url: 'delete_category.php',
            type: 'POST',
            data: { id_categorie: categoryId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Supprimez visuellement la ligne de catégorie supprimée de l'interface utilisateur
                    $('[data-category-id="' + categoryId + '"]').closest('tr').remove();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('An error occurred while deleting the category.');
            }
        });
    }
});

   </script>
</body>
</html>
