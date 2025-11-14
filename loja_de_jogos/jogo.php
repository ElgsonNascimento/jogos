<?php
include('conexao.php')

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET["id"];
    $check = $conn->prepare("SELECT * FROM game WHERE game_id = :id");
    $check->bind_param(":id", $id);
    $check->execute();
    $result = .json_encode($check->get_result());

    echo "${result}"
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_GET["id"];

}
?>
