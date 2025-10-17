<?php
    
    $conn = mysqli_connect("localhost:3307","root", "","cloud");
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $r = mysqli_query($conn, "SELECT * from game");
        while ($row = mysqli_fetch_assoc(result:$r)){
            echo $row["game_title"] . " " . $row ["game_price"] . " " . $row ["game_launch_date"] . " " . $row ["game_genre"]  . " " . $row ["game_description"] ."<br>";
        }
    
    }
    



    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST["nome"];
        $preco = $_POST["preco"];
        $lancamento = $_POST["lancamento"];
        $genero = $_POST["genero"];
        $descricao = $_POST["descricao"];
        $d = $_POST["developer"];
        $p = $_POST["publisher"];

        $query = "SELECT developer_ID FROM developer WHERE developer_name = '$d'";
        $result = mysqli_query($conn, $query);
        $developer = mysqli_fetch_assoc($result)['developer_ID'];

        $query = "SELECT publisher_ID FROM publisher WHERE publisher_name = '$p'";
        $result = mysqli_query($conn, $query);
        $publisher = mysqli_fetch_assoc($result)['publisher_ID'];
        


        $stmt = $conn->prepare("INSERT INTO game(game_title, game_price, game_launch_date, game_genre,game_description,developer_game_ID,publisher_game_ID) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sdsssii",$nome,$preco,$lancamento,$genero,$descricao,$developer,$publisher);
        if($stmt -> execute()){
            echo "Funcionou";
        }


    }
?>