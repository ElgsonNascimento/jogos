<?php

include('conexao.php');

header("Content-Type: application/json");
$conn = mysqli_connect("localhost:3307","root","","cloud");

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipo_conta = $_POST["tipo_conta"] ?? "";
    $username = trim($_POST["username"]);
    $nickname = trim($_POST["nickname"]);
    $age = $_POST["age"];
    $email = trim($_POST["email"]);
    $passwd = trim($_POST["user_pass"]);
    $passwd2 = trim($_POST["user_pass2"]);

    if ($passwd !== $passwd2) {
        $response["message"] = "As senhas não coincidem.";
        echo json_encode($response);
        exit;
    }

    $hash_passwd = password_hash($passwd, PASSWORD_DEFAULT);

    if ($tipo_conta === "usuario") {
        // === Usuário comum ===
        $check = $conn->prepare("SELECT id FROM fuser WHERE user_name = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $response["message"] = "Nome de usuário já escolhido.";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO fuser (user_name, user_nickname, user_age, user_email, user_password)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("sssss", $username, $nickname, $age, $email, $hash_passwd);

            if ($stmt->execute()) {
                $response["success"] = true;
                $response["message"] = "Conta de usuário criada com sucesso!";
            } else {
                $response["message"] = "Erro ao criar conta de usuário.";
            }
        }

    } elseif ($tipo_conta === "publicador") {
        // === Conta de publicador ===
        $check = $conn->prepare("SELECT publisher_ID FROM Publisher WHERE publisher_name = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $response["message"] = "Nome de publicador já existente.";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO Publisher (publisher_name, publisher_password)
                VALUES (?, ?)
            ");
            $stmt->bind_param("ss", $username, $hash_passwd);

            if ($stmt->execute()) {
                $response["success"] = true;
                $response["message"] = "Conta de publicador criada com sucesso!";
            } else {
                $response["message"] = "Erro ao criar conta de publicador.";
            }
        }

    } else {
        $response["message"] = "Selecione um tipo de conta válido.";
    }
}

echo json_encode($response);
?>

