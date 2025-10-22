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
        $hashed_passw = password_hash($passwd, PASSWORD_DEFAULT);


        $stmt = $conn->prepare("INSERT INTO fuser(user_name, user_nickname, user_age, user_email, user_password) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss",$username,$nickname,$age,$email,$hashed_passw);
        if($stmt -> execute()){
            echo "Funcionou";
        }


    }
?>
