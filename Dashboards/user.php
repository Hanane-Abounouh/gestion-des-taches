<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="../style.css" rel="stylesheet">
</head>
<body>
    <section>
        <div class="w-[85%] overflow-hidden rounded-lg shadow-xs">
            <div class="flex gap-5 items-center text-gray-600 mt-5 hover:text-gray-900">
                <img src="https://icons.veryicon.com/png/o/miscellaneous/management-console-icon-update-0318/users-84.png" class="sFlh5c pT0Scc iPVvYb" style="max-width: 30px; height: 30px; width: 30px;" alt="User Icon">
                <span class="text-2xl text-blue-600 font-bold">Users</span>
                <button onclick="showAddUserForm()" class="text-green-500 hover:text-blue-500 py-1 px-2 rounded-full text-xl flex items-center justify-center">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="w-full overflow-x-auto mt-10">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-800 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">id_user</th>
                            <th class="px-4 py-3">nom_user</th>
                            <th class="px-4 py-3">email</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" class="bg-white divide-y">
                    <?php
                    require "../connection.php";

                    $sql = "SELECT users.*, roles.nom_role FROM users JOIN roles ON users.id_role = roles.id_role";
                    $result = $con->query($sql);

                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr class='text-gray-800'>";
                            echo "<td class='px-4 py-3 text-sm'>{$row['id_user']}</td>";
                            echo "<td class='px-4 py-3 text-xs'>{$row['nom']}</td>";
                            echo "<td class='px-4 py-3 text-sm'>{$row['email']}</td>";
                            echo "<td class='px-4 py-3'>";
                            echo "<div class='flex items-center space-x-4 text-sm'>";
                            echo "<button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg edit-btn' aria-label='Edit'>";
                            echo "<svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20'><path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path></svg>";
                            echo "</button>";
                            echo "<button class='delete-btn flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg' aria-label='Delete' data-user-id='{$row['id_user']}'>";
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

    <div id="addUserForm" class="hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Add User</h2>
            <form id="userForm" onsubmit="addUser(); return false;">
                <div class="mb-4">
                    <label for="fullName" class="block text-gray-700 font-bold mb-2">Full Name:</label>
                    <input type="text" id="fullName" name="fullName" class="border rounded-lg px-4 py-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email Address:</label>
                    <input type="email" id="email" name="email" class="border rounded-lg px-4 py-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 font-bold mb-2">Role:</label>
                    <select id="role" name="role" class="border rounded-lg px-4 py-2 w-full">
                    <?php
                    $role_sql = "SELECT * FROM roles";
                    $roles = $con->query($role_sql);
                    while ($role = $roles->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$role['id_role']}'>{$role['nom_role']}</option>";
                    }
                    ?>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add
                </button>
                <button type="button" onclick="hideAddUserForm()" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Fonction pour ajouter un utilisateur via AJAX
        function addUser() {
            // Collecte des données du formulaire
            var fullName = document.getElementById('fullName').value;
            var email = document.getElementById('email').value;
            var role = document.getElementById('role').value;

            // Envoi de la requête AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Analyse de la réponse JSON
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Mise à jour de la table des utilisateurs avec la nouvelle ligne
                        var user = response.user;
                        var newRow = "<tr class='text-gray-800'>" +
                            "<td class='px-4 py-3 text-sm'>" + user.id_user + "</td>" +
                            "<td class='px-4 py-3 text-xs'>" + user.nom + "</td>" +
                            "<td class='px-4 py-3 text-sm'>" + user.email + "</td>" +
                            "<td class='px-4 py-3'>" +
                            "<div class='flex items-center space-x-4 text-sm'>" +
                            "<button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg edit-btn' aria-label='Edit'>" +
                            "<svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20'><path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path></svg>" +
                            "</button>" +
                            "<button class='delete-btn flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg' aria-label='Delete' data-user-id='" + user.id_user + "'>" +
                            "<svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path></svg>" +
                            "</button>" +
                            "</div>" +
                            "</td>" +
                            "</tr>";
                        document.getElementById('userTableBody').innerHTML += newRow;
                        // Réinitialisation des champs du formulaire
                        document.getElementById('fullName').value = '';
                        document.getElementById('email').value = '';
                        // Masquer le formulaire d'ajout
                        hideAddUserForm();
                    } else {
                        console.error(response.message);
                        // Afficher un message d'erreur à l'utilisateur
                    }
                } else if (xhr.readyState === XMLHttpRequest.DONE) {
                    // Gestion des erreurs
                    console.error('Une erreur s\'est produite lors de l\'ajout de l\'utilisateur.');
                    // Afficher un message d'erreur à l'utilisateur
                }
            };
            xhr.send('fullName=' + encodeURIComponent(fullName) + '&email=' + encodeURIComponent(email) + '&role=' + encodeURIComponent(role));
        }

        function hideAddUserForm() {
            // Masque le formulaire pour ajouter un utilisateur
            document.getElementById('addUserForm').classList.add('hidden');
        }

        function showAddUserForm() {
            // Affiche le formulaire pour ajouter un utilisateur
            document.getElementById('addUserForm').classList.remove('hidden');
        }
        function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        // Envoi de la requête AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Supprimez la ligne de l'utilisateur supprimé de la table
                var row = document.querySelector('[data-user-id="' + userId + '"]').closest('tr');
                if (row) {
                    row.remove();
                } else {
                    console.error('User row not found.');
                }
            } else if (xhr.readyState === XMLHttpRequest.DONE) {
                console.error('An error occurred while deleting the user.');
            }
        };
        xhr.send('userId=' + encodeURIComponent(userId));
    }
}
    </script>
</body>
</html>
