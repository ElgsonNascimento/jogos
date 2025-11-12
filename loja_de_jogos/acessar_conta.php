<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost:3307", "root", "", "cloud");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erro de conexão ao banco de dados."]);
    exit;
}

$username = trim($_POST["username"] ?? "");
$password = trim($_POST["user_pass"] ?? "");
$accountType = $_POST["account_type"] ?? "user"; // default to user

// Escolhe a tabela dependendo do tipo de conta
if ($accountType === "Publisher") {
    $table = "publisher";
    $userField = "publisher_name";
    $passField = "publisher_password";
} else {
    $table = "fuser";
    $userField = "user_name";
    $passField = "user_password";
}

// Prepara e executa a consulta
$stmt = $conn->prepare("SELECT $passField FROM $table WHERE $userField = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se encontrou o usuário
if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row[$passField])) {
        echo json_encode(["success" => true, "message" => "Acesso concedido como $accountType"]);
    } else {
        echo json_encode(["success" => false, "message" => "Senha incorreta"]);
    }
} else {
    echo json_encode(["success" => false, "message" => ucfirst($accountType) . " não encontrado"]);
}

$stmt->close();
$conn->close();
?>
