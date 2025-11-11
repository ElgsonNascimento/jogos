<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost:3307", "root", "", "cloud");

$username = trim($_POST["username"] ?? "");
$password = trim($_POST["user_pass"] ?? "");

$stmt = $conn->prepare("SELECT user_password FROM fuser WHERE user_name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row["user_password"])) {
        echo json_encode(["success" => true, "message" => "Acesso concedido"]);
    } else {
        echo json_encode(["success" => false, "message" => "Senha incorreta"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado"]);
}

