<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <section class="flex flex-col justify-center">
        <div class="w-full">
            <h1 class="text-2xl font-semibold text-left">Liste des tâches</h1>
        </div>
        <div class="border border-[#8e6396] bg-[#ffff] h-[70vh] p-8 mr-20 mt-5 overflow-y-auto">
         
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 ">
                <?php
                require "../connection.php";

                $sql = "SELECT * FROM taches";
                $result = $con->query($sql);

                if ($result->rowCount() > 0) {
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <div class="task-item flex flex-col bg-white w-96 justify-center border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-900 dark:shadow-neutral-800/70" data-task-id="<?php echo $row['id_tache']; ?>">
                            <div class="bg-gray-100 border-b rounded-t-xl py-3 px-4 md:py-4 md:px-5 dark:bg-neutral-900 dark:border-neutral-900">
                                <p class="mt-1 text-sm text-gray-600 dark:text-neutral-500">Tâche</p>
                            </div>
                            <div class="p-4 md:p-5">
                                <h3 class="text-lg font-bold text-gray-800 dark:text-white"><?php echo $row["titre"]; ?></h3>
                                <p class="mt-2 text-gray-500 dark:text-neutral-400"><?php echo $row["dateEcheance"]; ?></p>
                                <p class="mt-2 text-gray-500 dark:text-neutral-400"><?php echo $row["description"]; ?></p>
                                <p class="mt-2 text-gray-500 dark:text-neutral-400"><?php echo $row["statut"]; ?></p>
                                <div class="flex justify-between items-center mt-8">
                                    <div class="flex items-center gap-10">
                                        <div class="flex gap-3">
                                        <button class="delete-task-btn text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400" aria-label="Supprimer la tâche" data-task-id="<?php echo $row['id_tache']; ?>">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                               </button>
                                            <a href="edit_task.php?id=<?php echo htmlspecialchars($row['id_tache']); ?>" class="text-green-600 hover:text-green-800 dark:text-green-500 dark:hover:text-green-400" aria-label="Modifier la tâche" >
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536-10.607 10.607H4.625v-4.536l10.607-10.607zM19 3.75l1.25 1.25-2.536 2.536-1.25-1.25L19 3.75z"/>
                                   </svg>
                                    </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "0 résultats";
                }

                $con = null;
                ?>
            </div>
        </div>
    </section>
    






    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

      //script taches 
// Fonction pour supprimer un utilisateur
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    var row = document.querySelector('[data-user-id="' + userId + '"]').closest('tr');
                    if (row) {
                        row.remove();
                    } else {
                        console.error('User row not found.');
                    }
                } else {
                    console.error(response.message);
                }
            } else if (xhr.readyState === XMLHttpRequest.DONE) {
                console.error('An error occurred while deleting the user.');
            }
        };

        // Envoyer les données JSON avec l'ID de l'utilisateur
        xhr.send(JSON.stringify({ id_user: userId }));
    }
}

// Gestion des clics sur les boutons de suppression
document.addEventListener('click', function (e) {
    if (e.target && e.target.matches('.delete-btn')) {
        var userId = e.target.closest('.delete-btn').dataset.userId;
        deleteUser(userId);
    }
});

//edit
// JavaScript (jQuery)
$(document).ready(function() {
    $('.update-task-btn').click(function() {
        var taskId = $(this).data('task-id');

        // Ici, vous pouvez ajouter le code pour récupérer les données de la tâche à modifier,
        // puis les envoyer au serveur via une requête Ajax.

        // Exemple de requête Ajax (à adapter selon vos besoins) :
        $.ajax({
            url: 'edit_task.php',
            type: 'POST',
            data: { task_id: taskId },
            success: function(response) {
                // Traitez la réponse du serveur ici
            },
            error: function() {
                alert('Error updating task');
            }
        });
    });
});


 
// Ajoutez un gestionnaire d'événements pour les clics sur les boutons de delet
$(document).ready(function() {
    $('.delete-task-btn').click(function() {
        // Désactiver le bouton de suppression
        $(this).prop('disabled', true);

        var taskId = $(this).data('task-id');
        var taskDiv = $(this).closest('.flex.flex-col');

        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: 'deleteTask.php',
                type: 'POST',
                data: { task_id: taskId },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        taskDiv.remove();
                    } else {
                        alert(data.message || 'Failed to delete task');
                    }
                },
                error: function() {
                    alert('Error deleting task');
                }
            });
        } else {
            // Réactiver le bouton de suppression si la boîte de confirmation est annulée
            $(this).prop('disabled', false);
        }
    });
});

    </script>
   
</body>
</html>
