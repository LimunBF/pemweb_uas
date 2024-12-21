<?php
header('Content-Type: application/json');
require_once '../connection/connect.php';

$pdo = getDatabaseConnection();

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    http_response_code(401);
    exit();
}

$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Fetch user data
    $stmt = $pdo->prepare("SELECT name, email, phone_number, ktp_number, date_of_birth, gender FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
        http_response_code(404);
    }
} elseif ($method === 'POST') {
    // Validate CSRF token
    $input = json_decode(file_get_contents('php://input'), true);
    if (empty($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['error' => 'Invalid CSRF token']);
        http_response_code(403);
        exit();
    }

    // Sanitize and update user data
    $name = htmlspecialchars(trim($input['name'] ?? ''));
    $phone_number = htmlspecialchars(trim($input['phone_number'] ?? ''));
    $ktp_number = htmlspecialchars(trim($input['ktp_number'] ?? ''));
    $date_of_birth = htmlspecialchars(trim($input['date_of_birth'] ?? ''));
    $gender = htmlspecialchars(trim($input['gender'] ?? ''));

    $stmt = $pdo->prepare("
        UPDATE users 
        SET 
            name = COALESCE(NULLIF(:name, ''), name),
            phone_number = COALESCE(NULLIF(:phone_number, ''), phone_number),
            ktp_number = COALESCE(NULLIF(:ktp_number, ''), ktp_number),
            date_of_birth = COALESCE(NULLIF(:date_of_birth, ''), date_of_birth),
            gender = COALESCE(NULLIF(:gender, ''), gender)
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':ktp_number', $ktp_number);
    $stmt->bindParam(':date_of_birth', $date_of_birth);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'User updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update user']);
        http_response_code(500);
    }
} else {
    echo json_encode(['error' => 'Method not allowed']);
    http_response_code(405);
}
