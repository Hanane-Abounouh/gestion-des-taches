<?php
require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['fullName'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if (!empty($nom) && !empty($email) && !empty($role)) {
        $stmt = $con->prepare("INSERT INTO users (nom, email, id_role) VALUES (:nom, :email, :role)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            $id_user = $con->lastInsertId();
            echo json_encode(['success' => true, 'message' => 'User added successfully.', 'user' => ['id_user' => $id_user, 'nom' => $nom, 'email' => $email]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add user.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
