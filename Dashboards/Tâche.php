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
                                            <button  id="delete-btn" class= ' flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg' aria-label='Delete' data-task-id='<?php echo $row["id_tache"]; ?>'>
                                                <svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20'>
                                                    <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>
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
$(document).ready(function() {
    // Sélectionnez tous les boutons de suppression
    $('delete-btn').on('click', function() {
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
    </script>
   
</body>
</html>
