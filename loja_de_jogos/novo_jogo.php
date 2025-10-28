<?php
   
    $conexao = mysqli_connect("localhost:3307","root", "","cloud");
     /*if($_SERVER["REQUEST_METHOD"] == "GET"){
        $r = mysqli_query($conexao, "SELECT * from game");
        while ($row = mysqli_fetch_assoc(result:$r)){
            echo $row["game_title"] . " " . $row ["game_price"] . " " . $row ["game_launch_date"] . " " . $row ["game_genre"]  . " " . $row ["game_description"] ."<br>";
        }
    
    }

    */

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST["game_title"];
        $preco = $_POST["game_price"];
        $lancamento = date('d/m/Y H:i:s');
        $genero = $_POST["game_genre"];
        $descricao = $_POST["game_description"];
        $d = $_POST["developer_name"];
        $p = $_POST["publisher"]; 

        //trava a continuidade do php ao encontrar erros a serem tratados
        $flag = 0;

        //procura titulo de jogo no banco de dados        
        $r = mysqli_query($conexao, "SELECT game_title from Game");
        while ($row = mysqli_fetch_assoc(result:$r)){
            if($row["game_title"] == $nome){// achou jogo no banco
                echo "erro, titulo de jogo já cadastrado."
                $flag = 1
            }; 
        }
        //procura desenvolvedor no banco de dados
        if ($flag == 0){
            $r = mysqli_query($conexao, "SELECT developer_name from Developer");
            while ($row = mysqli_fetch_assoc(result:$r)){
                if($row["developer_name"] == $d){// achou dev no banco
                    $flag = 0;
                } else{
                    echo "erro, desenvolvedor escolhido não selecionado."
                    $flag = 1
                };
            }
        }

        if ($flag == 0){
            $query = "SELECT developer_ID FROM developer WHERE developer_name = '$d'";
            $result = mysqli_query($conexao, $query);
            $developer = mysqli_fetch_assoc($result)['developer_ID'];

            $query = "SELECT publisher_ID FROM publisher WHERE publisher_name = '$p'";
            $result = mysqli_query($conexao, $query);
            $publisher = mysqli_fetch_assoc($result)['publisher_ID'];
                


            $stmt = $conexao -> prepare("INSERT INTO game(game_title, game_price, game_launch_date, game_genre,game_description,developer_game_ID,publisher_game_ID) VALUES (?,?,?,?,?,?,?)");
            $stmt -> bind_param("sdsssii",$nome,$preco,$lancamento,$genero,$descricao,$developer,$publisher);
            if($stmt -> execute()){
                echo "Jogo cadastrado com sucesso.";
            }
        }
    }
?>