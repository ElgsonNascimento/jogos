<html>

<?php

include('conexao.php');

?>

<head>
    <meta charset="utf-8">
    <title>nome da loja de jogos</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <a href="index.php"><img src="imgs/logo.jpg" alt="Logo">
            <h1>Vapor</h1>
        </a>

        <nav>
            <a href="acessar_conta.html">acessar conta</a>
            <a href="criar_conta.html">criar conta</a>
        </nav>
    </header>
    <main>
        <div class="info-box">
            <h1 id="principal">Buscar jogos</h1>
            <br>
            <div class="pesquisar">
                <form action="">
                    <input name="busca" placeholder="Digite os termos de pesquisa" type="text" 
                        value="<?php if(isset($_GET['busca'])) echo htmlentities($_GET['busca']); ?>">
                    <button type="submit">Buscar</button>
                </form>
            </div>

       <table width=1000px border="1">
        <tr>
            <th>Tipo</th>
            <th>Título</th>
            <th>Gênero</th>
            <th>Preço</th>
            <th>Desenvolvedora</th>
        </tr>

        <?php
        if(!isset($_GET['busca']) || $_GET['busca'] == '') {
        ?>

        <tr>
            <td colspan="5"> Digite algo para pesquisar....</td>
        </tr>
        <?php 
        } else {
            $pesquisa = $mysqli->real_escape_string($_GET['busca']);
            
                        $sql_code = "
                SELECT 
                    G.game_ID AS ID_Item,
                    'Jogo' AS Tipo_Item, 
                    G.game_title AS Titulo,
                    G.game_price AS Preco,
                    G.game_genre AS Genero,
                    D.developer_name AS Desenvolvedora
                FROM 
                    Game G
                LEFT JOIN 
                    Developer D ON G.developer_game_ID = D.developer_ID
                WHERE 
                    G.game_title LIKE '%$pesquisa%' 
                    OR G.game_genre LIKE '%$pesquisa%'
                
                UNION ALL
                
                SELECT 
                    D.dlc_ID AS ID_Item,
                    'DLC' AS Tipo_Item,
                    D.dlc_title AS Titulo,
                    D.dlc_price AS Preco,
                    D.dlc_genre AS Genero,
                    DEV.developer_name AS Desenvolvedora
                FROM 
                    DLC D
                LEFT JOIN
                    Developer DEV ON D.developer_dlc_ID = DEV.developer_ID
                WHERE 
                    D.dlc_title LIKE '%$pesquisa%' 
                    OR D.dlc_genre LIKE '%$pesquisa%'
                
                ORDER BY 
                    Tipo_Item, Titulo
                ";
                $sql_query = $mysqli->query($sql_code) or die("ERRO AO CONSULTAR: " . $mysqli->error);


                if ($sql_query->num_rows == 0) {
                    ?>
                <tr>
                    <td colspan="5">Nenhum resultado encontrado....</td>
                </tr>
                <?php
                } else {
                    while($dados = $sql_query->fetch_assoc()){ 
                        ?>
                        <tr>
                            <td><?php echo $dados['Tipo_Item'];?></td>
                            <td>
                                <a href="jogo.html?id=<?php echo $dados['ID_Item'];?>&tipo=<?php echo $dados['Tipo_Item'];?>">
                                    <?php echo $dados['Titulo'];?>
                                </a>
                            </td>
                            <td><?php echo $dados['Genero'];?></td>
                            <td>R$ <?php echo number_format($dados['Preco'], 2, ',', '.');?></td>
                            <td><?php echo $dados['Desenvolvedora'];?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            <?php 
            } ?>
        </table>

        </div>


    <footer>
        Caso tenha qualquer problema, se dirigir a nossa equipe de suporte:
        +55 41 99999-9999.
        por favor nos avalie
    </footer>

    <script>

        const username = sessionStorage.getItem("username");
        const loggedIn = sessionStorage.getItem("loggedIn");

        if (loggedIn === "true") {
            const nav = document.querySelector("nav");
            nav.innerHTML = ""; 

            const perfil = document.createElement("a");
            perfil.href = "#";
            perfil.textContent = `Perfil de ${username}`; 

            const sair = document.createElement("a");
            sair.href = "#";
            sair.id = "logoutBtn";
            sair.textContent = "Sair";

            nav.appendChild(perfil);
            nav.appendChild(sair);

            const boas_vindas = document.getElementById("principal");
            boas_vindas.textContent = `Bem-vindo(a), ${username}`;

            sair.addEventListener("click", (e) => {
                e.preventDefault();
                sessionStorage.removeItem("username"); 
                sessionStorage.removeItem("loggedIn"); 
                window.location.reload(); 
            });
        }
    </script>


</body>

</html>