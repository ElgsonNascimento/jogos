<?php
$conn = new mysqli("localhost:3307", "root", "", "cloud");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["user_pass"];


    $stmt = $conn->prepare("SELECT user_pass FROM fuser WHERE user_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row["user_pass"])) {
            echo "Acesso concedido";
        } else {
            echo "Login incorreto";
        }
    } else {
        echo "Usuário não encontrado";
    }
}
?>
