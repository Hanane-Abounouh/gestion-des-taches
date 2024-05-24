<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./style.css" rel="stylesheet">
</head>
<body>
<?php
// Connexion à la base de données (assurez-vous de remplacer les valeurs par les vôtres)
require "connection.php";

// Requête SQL pour récupérer les tâches
$sql = "SELECT titre, id_tache, dateEcheance FROM taches";
$result = $con->query($sql);

// Si des tâches sont trouvées, les afficher
if ($result->rowCount() > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
?>
 


 <div class="flex flex-col bg-white w-96 justify-center border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
<div class="bg-gray-100 border-b rounded-t-xl py-3 px-4 md:py-4 md:px-5 dark:bg-neutral-900 dark:border-neutral-700">
    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-500">
      Tâche
    </p>
  </div>
  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
    <?php echo $row["titre"]; ?>
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
    <?php echo $row["dateEcheance"]; ?>
    </p>
    <div class=" flex justify-between items-center mt-8">
      <a class="inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400" href="#">
        détaillée
        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </a>
      <div class="flex items-center gap-10">
      <div class="flex gap-3">
      <button class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400" aria-label="Supprimer la tâche">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
        <button class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-500 dark:hover:text-yellow-400" aria-label="Modifier la tâche">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536-10.607 10.607H4.625v-4.536l10.607-10.607zM19 3.75l1.25 1.25-2.536 2.536-1.25-1.25L19 3.75z"/>
          </svg>
        </button>
      </div>
        <button class="text-gray-600 hover:text-gray-800 dark:text-gray-500 dark:hover:text-gray-400" aria-label="Marquer la tâche comme en cours ou terminée" onclick="toggleTaskStatus(this)">
          <!-- Texte du bouton -->
          <span class="ml-2">En cours</span>
        </button>
      </div>
    </div>
  </div>
</div>


<?php
  }
} else {
  echo "0 résultats";
}

// Fermer la connexion à la base de données
$con = null;
?>

<script>
  function toggleTaskStatus(button) {
    const span = button.querySelector('span');

    if (span.textContent.trim() === 'En cours') {
      span.textContent = 'Terminée';
      button.classList.remove('text-gray-600', 'hover:text-gray-800', 'dark:text-gray-500', 'dark:hover:text-gray-400');
      button.classList.add('text-green-600', 'hover:text-green-800', 'dark:text-green-500', 'dark:hover:text-green-400');
    } else {
      span.textContent = 'En cours';
      button.classList.remove('text-green-600', 'hover:text-green-800', 'dark:text-green-500', 'dark:hover:text-green-400');
      button.classList.add('text-gray-600', 'hover:text-gray-800', 'dark:text-gray-500', 'dark:hover:text-gray-400');
    }
  }
</script>

</body>
</html>