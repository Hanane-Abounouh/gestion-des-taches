
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./style.css" rel="stylesheet">
</head>


<body class="flex flex-col min-h-screen bg-gray-100 justify-center items-center">
 
<?php include 'navbar.php'; ?>
    

    <section class="container mx-auto  flex flex-col justify-center items-center h-screen">
    <div class="w-full ml-48 ">
        <h1 class="text-3xl font-semibold mb-4 text-left">Liste des tâches</h1>
    </div>
        
        <div class="border border-[#8e6396] bg-[#ffff] p-20 mt-12">
            <!-- Boutons d'exportation -->
            <div class="flex justify-between gap-4 mb-4">
  <div class="flex gap-4">
    <a href="export.php?type=csv" type="button" class="inline-block bg-[#884fc0] text-white rounded-full border-2 border-primary-100 px-6 pb-[6px] pt-2 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:border-primary-accent-200 hover:bg-secondary-50/50 focus:border-primary-accent-200 focus:bg-secondary-50/50 focus:outline-none focus:ring-0 active:border-primary-accent-200 motion-reduce:transition-none dark:border-primary-400 dark:text-primary-300 dark:hover:bg-blue-950 dark:focus:bg-blue-950">
      Exporter CSV
    </a>
    <a href="export.php?type=pdf" type="button" class="inline-block bg-[#884fc0] text-white   rounded-full border-2 border-primary-100 px-6 pb-[6px] pt-2 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:border-primary-accent-200 hover:bg-secondary-50/50 focus:border-primary-accent-200 focus:bg-secondary-50/50 focus:outline-none focus:ring-0 active:border-primary-accent-200 motion-reduce:transition-none dark:border-primary-400 dark:text-primary-300 dark:hover:bg-blue-950 dark:focus:bg-blue-950">
      Exporter PDF
    </a>
  </div>
  <div class="flex justify-end">
    <a href="AddTache.php" type="button" class="inline-block rounded-full border bg-gray-300   px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-black shadow-green-3 transition duration-150 ease-in-out hover:bg-green-accent-300 hover:shadow-green-2 focus:bg-success-accent-300 focus:shadow-green-2 focus:outline-none focus:ring-0 active:bg-green-600 active:shadow-green-2 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong">
      Ajouter
    </a>
  </div>
</div>


            <div class="grid grid-cols-1  md:grid-cols-2 lg:grid-cols-3 gap-4 mt-10 ">

            <?php
// Connexion à la base de données (assurez-vous de remplacer les valeurs par les vôtres)
require "connection.php";

// Requête SQL pour récupérer les tâches
$sql = "SELECT * FROM taches";
$result = $con->query($sql);

// Si des tâches sont trouvées, les afficher
if ($result->rowCount() > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
?>
                <!-- Première tâche -->
<div class="flex flex-col bg-white w-96 justify-center border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-900 dark:shadow-neutral-800/70">
<div class="bg-gray-100 border-b rounded-t-xl py-3 px-4 md:py-4 md:px-5 dark:bg-neutral-900 dark:border-neutral-900">
    <p class="mt-1 text-sm text-gray-600 dark:text-neutral-500">
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
      <a class="inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-[#864ac2] hover:text-[#6b4e87] disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400" href="#">
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
        <button class="text-green-600 hover:text-green-800 dark:text-green-500 dark:hover:text-green-400" aria-label="Modifier la tâche">
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


<div>

    <div class="flex flex-col bg-white w-96 justify-center border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-900 dark:shadow-neutral-800/70">

  <div class="p-4 md:p-5">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
    <?php echo $row["titre"]; ?>
    </h3>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
    <?php echo $row["dateEcheance"]; ?>
    </p>
    <p class="mt-2 text-gray-500 dark:text-neutral-400">
    <?php echo $row["description"]; ?>
    </p>
    <div class=" flex justify-between items-center mt-8">
     
      <div class="flex items-center gap-10">
      <div class="flex gap-3">
      <button class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400" aria-label="Supprimer la tâche">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
        <button class="text-green-600 hover:text-green-800 dark:text-green-500 dark:hover:text-green-400" aria-label="Modifier la tâche">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536-10.607 10.607H4.625v-4.536l10.607-10.607zM19 3.75l1.25 1.25-2.536 2.536-1.25-1.25L19 3.75z"/>
          </svg>
        </button>
      </div>
        
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

// Fermer la connexion à la base de données
$con = null;
?>

                <!-- Répétez ces divs pour chaque tâche -->
            </div>
        </div>
    </section>





    <?php include 'footer.php'; ?>


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
