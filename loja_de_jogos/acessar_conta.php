<?php
$conn = new mysqli("localhost:3307", "root", "", "cloud"); // Conecta ao banco de dados "cloud" 
                                                         // no servidor MySQL local, porta 3307.

if ($_SERVER["REQUEST_METHOD"] === "POST") {  // caso o usuário clique em "submit",
    $username = trim($_POST["username"]);           // o formulário enviará os campos "username e 
    $password = trim($_POST["user_pass"]);          // "user_pass" no formato POST.


    $stmt = $conn->prepare("SELECT user_password FROM fuser WHERE user_name = ?"); // buscar o hash da senha do usuário informado
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {  // verifica se há um registro com o user_name na tabela
        if (password_verify($password, $row["user_password"])) {  // compara o hash de user_pass
            echo "Acesso concedido";  // hash da senha igual
        } else {
            echo "Login incorreto";  // hash da senha distinto
        }
    } else {
        echo "Usuário não encontrado";
    }
