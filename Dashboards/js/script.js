//script Dashboard
const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent default link behavior
                const url = event.target.href; // Get URL of clicked link
                loadContent(url); // Load content of the clicked link
            });
        });

        // Function to load content from URL
        function loadContent(url) {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    // Insert the loaded HTML into the main-content div
                    document.getElementById('main-content').innerHTML = html;


                })
                .catch(error => console.error('Error loading content:', error));
        }
        function showAddUserForm() {
        // Affiche le formulaire pour ajouter un utilisateur
        document.getElementById('addUserForm').classList.remove('hidden');
    }



//script categorie 
document.addEventListener('DOMContentLoaded', function() {
    // Sélection de tous les boutons de suppression et ajout des écouteurs d'événements
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            if (confirm('Are you sure you want to delete this category?')) {
                fetch('delete_category.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id_category: categoryId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        this.closest('tr').remove();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });

    // Afficher le formulaire d'ajout de catégorie
    function showAddCategoryForm() {
        document.getElementById('addCategoryForm').classList.remove('hidden');
    }

    // Masquer le formulaire d'ajout de catégorie
    function hideAddCategoryForm() {
        document.getElementById('addCategoryForm').classList.add('hidden');
    }

    // Ajouter une catégorie
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
                // Rafraîchir la page pour afficher la nouvelle catégorie
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error adding category:', error);
        });
    }

    // Ajout des écouteurs d'événements aux boutons d'ajout et d'annulation
    document.getElementById('addCategoryBtn').addEventListener('click', showAddCategoryForm);
    document.getElementById('cancelAddCategoryBtn').addEventListener('click', hideAddCategoryForm);
    document.getElementById('submitAddCategoryBtn').addEventListener('click', addCategory);
});
$(document).ready(function() {
    $('.edit-btn').click(function() {
        var categoryId = $(this).data('category-id');
        
        // Récupérer les détails de la catégorie à modifier en utilisant une requête AJAX
        $.ajax({
            url: 'get_category_details.php',
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






//script taches 
$(document).ready(function() {
    // Sélectionnez tous les boutons de suppression
    $('.delete-btn').on('click', function() {
        // Récupérez l'identifiant de la tâche à partir de l'attribut data-task-id
        var taskId = $(this).data('task-id');
        var taskItem = $(this).closest('.task-item');

        // Confirmer la suppression
        if (confirm('Voulez-vous vraiment supprimer cette tâche ?')) {
            // Envoyez une requête AJAX pour supprimer la tâche avec l'identifiant spécifié
            $.ajax({
                url: 'delete_task.php',
                type: 'POST',
                data: { task_id: taskId },
                success: function(response) {
                    var res = JSON.parse(response);
                    // Vérifiez si la requête a réussi
                    if (res.success) {
                        // Supprimer l'élément tâche du DOM
                        taskItem.remove();
                    } else {
                        // Affichez un message d'erreur si la suppression a échoué
                        console.error('La suppression de la tâche a échoué.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Une erreur s\'est produite lors de la suppression de la tâche :', error);
                }
            });
        }
    });
});
