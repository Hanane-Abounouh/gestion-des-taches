<?php
require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id_user = $input['id_user'];

    if (!empty($id_user)) {
        $stmt = $con->prepare("DELETE FROM users WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $id_user);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
