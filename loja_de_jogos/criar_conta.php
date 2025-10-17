<?php
    
    $conn = mysqli_connect("localhost:3307","root", "","cloud");
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $r = mysqli_query($conn, "SELECT * from fuser");
        while ($row = mysqli_fetch_assoc(result:$r)){
            echo $row["user_name"] . " " . $row ["user_nickname"] . " " . $row ["user_age"] . " " ."<br>";
        }
    
    }
    



    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $nickname = $_POST["nickname"];
        $age = $_POST["age"];
        $email = $_POST["email"];
        $passwd = $_POST["user_pass"];
        echo "$passwd";


        $stmt = $conn->prepare("INSERT INTO fuser(user_name, user_nickname, age, email, user_pass) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss",$username,$nickname,$age,$email,$passwd);
        if($stmt -> execute()){
            echo "Funcionou";
        }


    }
?>
