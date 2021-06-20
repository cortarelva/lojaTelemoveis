<?php



$servername = "localhost";
$username = "root";
$password = "";
$bd = "loja_telemoveis";


$connection = mysqli_connect($servername,$username,$password,$bd);



if(!$connection){
    echo "Erro! Não foi possivel ligar á BD!";
}


















?>