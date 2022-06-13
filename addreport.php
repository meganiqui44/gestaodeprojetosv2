<?php

$error = false;
$errorMessage = "Dados inválidos, tente novamente.";

$success = false;
$successMessage = "Operação executada com sucesso.";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['embed'])) {

        $error = true;
    } else {

        $title = $_POST['title'];
        $description = $_POST['description'];
        $embed = $_POST['embed'];

        include 'dbconnection.php';

        $conn = OpenDbConnection();

        $sql = "INSERT INTO reports (title, description, embed) 
            VALUES ('" . $title . "', '" . $description . "', '" . $embed . "')";

        if ($conn->query($sql) === TRUE) {
            $success = true;
        } else {
            $errorMessage = "Ocorreu um erro, tente novamente.";
            $error = true;
        }

        CloseDbConnection($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include 'sessionheader.php';?>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <p class="pageTitle">Novo Relatório</p>
    <img class="logoImage" src="./images/logo.jpg" />
    <?php
        if($error) {
            echo '<p class="error">'.$errorMessage.'</p>';
        }
        if($success) {
            echo '<p class="success">'.$successMessage.'</p>';
        }
    ?>  
    <div class="formAdapter">
        <form id="addreportform" action="addreport.php" method="post">
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Título</label>
                    <input class="input" maxlength="200" type="text" id="title" name="title"/>
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Descrição</label>
                    <textarea class="textarea" type="text" id="description" name="description"></textarea>
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Embed</label>
                    <textarea class="textarea" type="text" id="embed" name="embed"></textarea>
                </div>
            </div>
            <div class="buttonAdapter">
                <div class="button" onclick="onSubmit();">
                    <p class="buttonText">Inserir</p>
                </div>
                <div class="button" style="margin-left: 20px;" onclick="onCancelButtonClick();">
                    <p class="buttonText">Cancelar</p>
                </div>
            </div>
        </form>
    </div>

    <?php include 'footer.php';?>

    <script>

        function onSubmit() {
            document.getElementById("addreportform").submit();
        }

        function onCancelButtonClick() {
            window.location.href = 'reportsmenu.php';
        }

        document.getElementById('datadeinicio').addEventListener('input', function (e) {
            var x = e.target.value.replace(/[^0-9]/g, "").replace(/^([0-9]{2})([0-9]{2})([0-9]{4})$/, "$1/$2/$3");
            e.target.value = x;
        });
    </script>

</body>
</html>