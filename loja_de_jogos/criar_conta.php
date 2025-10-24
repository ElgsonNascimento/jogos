<?php
    
    $conn = mysqli_connect("localhost:3307","root", "","cloud");
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $r = mysqli_query($conn, "SELECT * from fuser");
        while ($row = mysqli_fetch_assoc(result:$r)){
            echo $row["user_name"] . " " . $row ["user_nickname"] . " " . $row ["user_age"] . " " ."<br>";
        }
    
    }
    



    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = trim($_POST["username"]);
        $nickname = trim($_POST["nickname"]);
        $age = $_POST["age"];
        $email = trim($_POST["email"]);
        $passwd = trim($_POST["user_pass"]);
        $hash_passwd = password_hash($passwd, PASSWORD_DEFAULT); // a biblioteca gera um Hash Digest com o 
                                                                // algoritmo "bcrypt", incluindo SALT.
        $check = $conn->prepare("SELECT id FROM fuser WHERE user_name = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "Username já escolhido. Escolha outro username.";
        } else {
        $stmt = $conn->prepare("INSERT INTO fuser(user_name, user_nickname, user_age, user_email, user_password) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss",$username,$nickname,$age,$email,$hash_passwd);
        if($stmt -> execute()) {
            echo "Funcionou";
        } else {
            echo "Não foi possível criar a conta";
        }
        


    }
}
?>

