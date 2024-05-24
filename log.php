<?php
require "connection.php";

$email = $_POST['email'];
$pass = $_POST['password'];

session_start();

if ($_POST['email'] == "" or $_POST['password'] == "") {
    // Si cette condition est vraie, nous restons ici et affichons un message
    header("location: login.php?error=You must fill in the email and pass field");
    exit;
} else {
    // Préparez la requête SQL
    $existing = $con->prepare("SELECT users.id_user, users.nom, users.motDePasse, users.email,users.id_role, roles.nom_role 
    FROM users 
    JOIN roles ON users.id_role = roles.id_role 
    WHERE email = :email");

    // Exécutez la requête avec les paramètres liés
    $existing->execute([':email' => $email]);

    // Récupérez la ligne résultante
    $row = $existing->fetch(PDO::FETCH_ASSOC);

    if ($existing->rowCount() == 0) {
        // Si cette condition est vraie, nous allons à la page massage.html
        header("location: login.php?error=this email is undefined!!!");
        exit;
    } else {
        echo "Hashed Password from Database: " . $row["motDePasse"];
        echo "<br> Entered Password: " . $pass;
        echo "<br>";
        echo $email;
        $hashed_password = $row["motDePasse"];

        if ($pass == $hashed_password) {
            // Le mot de passe est correct
            echo "Password is correct";
            $_SESSION["nom"] = $row["nom"];
            $_SESSION["id_user"] = $row["id_user"]; // Utilisez la clé correcte de la colonne ID_user
            $_SESSION["id_role"] = $row["id_role"]; // Assurez-vous que la clé correspond à votre base de données
            // Set cookies for user preferences (non-sensitive information)
            setcookie('nom', $row['nom'], time() + (86400 * 30), "/"); // 30 days
            // setcookie('email', $row['email'], time() + (86400 * 30), "/"); // Commented out email cookie set line
            setcookie('nom_role', $row['nom_role'], time() + (86400 * 30), "/"); // 30 days

            // Redirection en fonction du rôle de l'utilisateur
            if ($row['nom_role'] == 'Admin') {
                header("Location: ./Dashboards/homeDashboards.php");
            } else {
                header("Location: Home.php");
            }
            exit();
        } else {
            // Mot de passe incorrect
            echo "Invalid password.";
        }
    }
}
?>
