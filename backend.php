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
    <title>Back Office</title>
</head>

<body>

    <section class="navbar">

        <div class="container">
            <h1 class="icon">Admin</h1>
        </div>
    </section>

    <br><br>
    <a style="float: right;" href="index.php">Log Off</a>

    <?php
    //////////////Login
    //user admin pass admin
    function login()
    {
        include("BD_connection.php");

        if (isset($_POST["nome"], $_POST["pass"])) {

            $nome = $_POST["nome"];
            $pass = $_POST["pass"];
            $warning = $_POST["warning"];

            if (empty($nome) || empty($pass)) {
                header("Location: ./index.php");
            }


            $query = "SELECT username, pass, level FROM gestor_login WHERE username = '$nome' AND pass = '$pass' LIMIT 1";

            $result = mysqli_query($connection, $query);
            $rows = mysqli_num_rows($result);

            if ($rows == 1) {
                $check = mysqli_fetch_assoc($result);

                if ($check['level'] == "admin") {
                    header("Location: ./backend.php");
                } else if ($check['level'] == "guest") {
                    header("Location: ./guestPage.php");
                } else {
                    header("Location: ./pag_erro.php");
                }
            } else {
                header("Location: ./pag_erro.php");
            }


            mysqli_close($connection);
        }
    }


    if (isset($_POST["submeter"])) {

        login();
    }


    ?>

    <!---------------------------------------------------------------------------->
    <form action="backend.php" method="post">
        <h1 class="header">Gestão de utilizadores</h1>
        <br><br>
        <table class="table">
            <tr>
                <th>Id</th>
                <th>UserName</th>
                <th>Password</th>
                <th>Nivel</th>

            </tr>
            <?php
            include("BD_connection.php");

            $table_query = "SELECT * FROM gestor_login";

            $result = mysqli_query($connection, $table_query);
            $rows = mysqli_num_rows($result);

            if ($rows > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr><td>{$row['Id']}</td><td>{$row['username']}</td><td>{$row['pass']}</td><td>{$row['level']}</td></tr>";
                }
            }

            echo "<div style='font-weight:900;'>Foram encontrados {$rows} registos</div>";

            mysqli_close($connection);
            ?>
            <br><br>
        </table>
    </form>
    <br><br>
    <br><br>
    <form action="backend.php" method="POST">
        <section class="inserir_dados">
            <input type="number" name="id" placeholder="Selecionar registo por id">
            <br><br>
            <button name="eliminar_utilizador">Eliminar Utilizador</button>
            <br><br>
            <input type="text" name="username" placeholder="UserName">
            <br><br>
            <input type="text" name="pass" placeholder="Password">
            <br><br>
            <input type="text" name="level" placeholder="Nivel">
            <br><br>
            <button name="alterar_password">Alterar Password</button>
            <br><br>
            <button name="inserir_utilizador">Inserir Utilizador</button>
            <br><br>
        </section>
    </form>
    <br><br>
    <br><br>
    <?php
    if (isset($_POST["inserir_utilizador"])) {
        inserirUtilizador();
    }
    if (isset($_POST['alterar_password'])) {
        alterarPassword();
    }
    if (isset($_POST["eliminar_utilizador"])) {
        eliminarUtilizador();
    }



    function inserirUtilizador()
    {
        include("BD_connection.php");

        if (isset($_POST['username'], $_POST['pass'], $_POST['level'])) {

            $nome = $_POST['username'];
            $pass = $_POST['pass'];
            $level = $_POST['level'];

            $existe = "SELECT * FROM gestor_login WHERE username = '{$nome}' ";
            $check = mysqli_query($connection, $existe);
            $ja_existe = mysqli_num_rows($check);

            if ($nome == "" || $pass == "" || $level == "") {
                echo "<script>alert('Nome, pass e nivel obrigatorios')</script>";
            } else {
                if ($ja_existe == 0) {

                    $query = "INSERT INTO gestor_login (username,pass,level) VALUES ('{$nome}','{$pass}','{$level}')";

                    if (mysqli_query($connection, $query)) {
                        header("Refresh:0");
                        echo "<script> alert('Utilizador inserido com sucesso')</script>";
                    } else {
                        header("Refresh:0");
                        echo  "<script> alert('Não foi possivel inserir utilizador')</script>";
                    }
                } else {
                    header("Refresh:0");
                    echo  "<script> alert('Já existe um utilizador com este nome')</script>";
                }

                mysqli_close($connection);
            }
        }
    }



    function alterarPassword()
    {
        include("BD_connection.php");

        if (isset($_POST['id'], $_POST['pass'])) {

            $id = $_POST["id"];
            $pass = $_POST["pass"];

            $query_alterar = "UPDATE gestor_login SET pass='{$pass}' WHERE Id='{$id}'";

            if (mysqli_query($connection, $query_alterar)) {
                header("Refresh:0");
                echo "<script>alert('Password alterada')</script>";
            } else {
                header("Refresh:0");
                echo "<script>alert('Nao foi possivel alterar a password')</script>";
            }
        }
        mysqli_close($connection);
    }


    function eliminarUtilizador()
    {
        include("BD_connection.php");

        if (isset($_POST['id'])) {

            $id = $_POST['id'];

            $delete = "DELETE FROM gestor_login WHERE Id = '{$id}'";

            if (mysqli_query($connection, $delete)) {
                header("Refresh:0");
                echo "<script>alert('Resgisto Eliminado')</script>";
            } else {
                header("Refresh:0");
                echo "<script>alert('Não foi possivel eliminar o registo')</script>" . mysqli_error($connection);
            }
        }
        mysqli_close($connection);
    }
    ?>



    <!------------------------------------------------------------------------------------->

    <br><br>
    <h1 class="header">Gestão de Produtos</h1>
    <br><br>
    <form action="backend.php" method="POST">
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Preço</th>

            </tr>
            <?php
            include("BD_connection.php");

            $table_query = "SELECT * FROM equipamentos";

            $result = mysqli_query($connection, $table_query);
            $rows = mysqli_num_rows($result);

            if ($rows > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr><td>{$row['id']}</td><td>{$row['marca']}</td><td>{$row['modelo']}</td><td>{$row['preco']}</td></tr>";
                }
            }
            echo "<div style='font-weight:900;'>Foram encontrados {$rows} registos</div>";

            mysqli_close($connection);
            ?>
            <br><br>
        </table>
    </form>
    <br><br>
    <form action="backend.php" method="post">
        <section class="inserir_dados">
            <input type="number" name="id_Equipamento" placeholder="Selecionar registos por id">
            <br><br>
            <button type="submit" name="eliminar_produto">Eliminar Equipamento</button>
            <br><br>
            <input type="text" name="marca" placeholder="marca">
            <br><br>
            <input type="text" name="modelo" placeholder="modelo">
            <br><br>
            <input type="text" name="preco" placeholder="preço">
            <br><br>
            <form action="backend.php" method="post" enctype="multipart/form-data">
                <label>Carregar imagem</label>
                <br>
                <input type="file" name="uploadImagem">
            </form>
            <br><br>
            <button type="submit" name="editar">Editar Equipamento</button>
            <br><br>
            <button type="submit" name="inserir">Inserir Novo Equipamento</button>
            <br><br>
        </section>
    </form>
    <?php
    if (isset($_POST["inserir"])) {
        inserir();
    }
    if (isset($_POST["editar"])) {
        atualizar();
    }
    if (isset($_POST['eliminar_produto'])) {
        eliminarEquipamento();
    }



    function inserir()
    {
        include("BD_connection.php");

        if (isset($_POST['marca'], $_POST['modelo'], $_POST['preco'])) {

            $marca = $_POST["marca"];
            $modelo = $_POST["modelo"];
            $preco = $_POST["preco"];



            $existe = "Select * from equipamentos where modelo = '{$modelo}' ";
            $check = mysqli_query($connection, $existe);
            $ja_existe = mysqli_num_rows($check);

            if ($ja_existe == 0) {
                $query = "INSERT INTO equipamentos (marca,modelo,preco, imgaddr) VALUES ('$marca','$modelo','$preco','{$img_novo_nome}')";

                if (mysqli_query($connection, $query)) {
                    header("Refresh:0");
                    echo "<script>alert('Equipamento Inserido com Sucesso')</script>";
                } else {
                    header("Refresh:0");
                    echo "<script>alert('Não foi possivel inserir Equipamento')</script>";
                }
            } else {
                header("Refresh:0");
                echo "<script>alert('Este Modelo jã existe em catalogo')</script>";
            }
        }
        //Inserir imagem na pasta imagens
        if ($_FILES["uploadImagem"]["error"] == 0) {
            if ($_FILES["uploadImagem"]["size"] > 125000) {
                echo "<script>alert('Ficheiro é muito grande')</script>";
            }
        } else {
            $check_ext_img = strtolower(pathinfo($_FILES["uploadImagem"]["name"], PATHINFO_EXTENSION));

            $extPermitidas = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $extPermitidas)) {
                $img_novo_nome = uniqid("IMG-", true) . '.' . $check_ext_img;
                $target_file = "imagens/" . $img_novo_nome;
                move_uploaded_file($_FILES["uploadImagem"]["tmp_name"], $target_file);
            } else {
                echo "<script>alert('Não é possivel carregar imagens deste tipo')</script>";
            }
        }
    }
    ?>

    <?php
    function atualizar()
    {
        include("BD_connection.php");

        if (isset($_POST['idEquipamento'], $_POST['marca'], $_POST['modelo'], $_POST['preco'])) {

            $id = $_POST["idEquipamento"];
            $marca = $_POST["marca"];
            $modelo = $_POST["modelo"];
            $preco = $_POST["preco"];

            $query = "UPDATE equipamentos SET id = '{$id}', marca = '{$marca}',modelo = '{$modelo}', preco = '{$preco}' WHERE id= '{$id}'";

            if (mysqli_query($connection, $query)) {
                header("Refresh:0");
                echo "<script>alert('Dados do equipamento alterados')</script>";
            } else {
                header("Refresh:0");
                echo "<script>alert('Nao foi possivel alterar os dados')</script>";
            }

            mysqli_close($connection);
        }
    }
    ?>
    <?php
    function eliminarEquipamento()
    {
        include("BD_connection.php");

        if (isset($POST_['id_equipamento'])) {
            $id = $_POST["id_equipamento"];

            $delete_query = "DELETE FROM equipamentos WHERE id = '{$id}'";

            if (mysqli_query($connection, $delete_query)) {
                header("Refresh:0");
                echo "<script>alert('Resgisto Eliminado')</script>";
            } else {
                header("Refresh:0");
                echo "<script>alert('Não foi possivel eliminar o registo')</script>";
            }
        }
        mysqli_close($connection);
    }
    ?>
    <!------------------------------------------------------------------------------------------------>
    <br><br>
    <footer>
        Footer
        Footer
        Footer
        Footer
    </footer>















</body>

</html>