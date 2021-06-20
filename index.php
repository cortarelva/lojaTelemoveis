<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        echo "<link rel='stylesheet' type='text/css' href='./main.css'/>";
        echo "<link rel='preconnect' href='https://fonts.gstatic.com'>";
        echo "<link href='https://fonts.googleapis.com/css2?family=Lato&display=swap' rel='stylesheet'>";
    ?>
    <title>Loja telemoveis</title>
</head>
<body>
    <section class="navbar">
    <h1 class="icon">Smart4all</h1>
    <div class="container">
    <form action="backend.php" method="post">
    <input  type="text" placeholder="Enter Username" name="nome">
    <input  type="password" placeholder="Enter Password" name="pass">
    <button class="btn_login" type="submit" name="submeter"><b>Login</b></button>
    <button class="btn_login" type="submit" name="novoRegisto"><b>Novo Cliente</b></button>
    </form>
    <label name="warning"></label>
    </div>
    
    </section>
    <label name="result"></label>
        <h1 class="header">Equipamentos</h1>
    <section class="container-card-group">
        
        
    <?php 
        
        include("BD_connection.php");
        $table_query= "SELECT * FROM equipamentos";
        $result = mysqli_query($connection, $table_query);
        $rows = mysqli_num_rows($result);
        ?>
        

        <?php
        if($rows > 0){
            while($row = mysqli_fetch_array($result)){
        echo"<div class='card'>";
        echo "<img class='img' src='./imagens/{$row['imgaddr']}'>";
        echo "<h3 class=\"card-header\"> {$row['marca']}</h3>";
        echo "<p class=\"card-text\">{$row['modelo']}</p>";
        echo "<p>€{$row['preco']}</p>";
        echo "<button class='btn_comprar'>Comprar</button>";
        echo "</div>";
      
            }
        }
 ?>
</section>

</body>
</html>