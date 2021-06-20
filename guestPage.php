<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <?php
        echo "<link rel='stylesheet' type='text/css' href='./main.css'/>";
        echo "<link rel='preconnect' href='https://fonts.gstatic.com'>";
        echo "<link href='https://fonts.googleapis.com/css2?family=Lato&display=swap' rel='stylesheet'>";
    ?>
    <title>Guest</title>
</head>
<body>
    
    
    <section class="navbar">
        
         <div class="container">
            <h1 class="icon">Guest</h1>  
         </div>
    </section>
    
    
    <a style="float: right;" href="index.php">Log Off</a>
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
        echo "<div>Só para vizualizar</div>";
        echo "</div>";
            }
        }
        ?>
</section>
<h1 class="header">Lista de Produtos</h1>
<br><br>
<form action="backend.php" method="post">
<table class="table">
    <tr>
        <th>Id</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Preço</th>
        
    </tr>
       <?php
        include("BD_connection.php");

        $table_query= "SELECT * FROM equipamentos";

        $result = mysqli_query($connection, $table_query);
        $rows = mysqli_num_rows($result);

        if($rows > 0){

            while($row = mysqli_fetch_array($result)){
                     echo "<tr><td>{$row['id']}</td><td>{$row['marca']}</td><td>{$row['modelo']}</td><td>{$row['preco']}</td></tr>";
                }
            } 
            mysqli_close($connection); 
        ?>            
</table>  
</form>

</body>
</html>