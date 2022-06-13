<?php

    $error = false;
    $errorMessage = "Dados inválidos, volte e tente novamente.";

    $success = false;
    $successMessage = "Operação executada com sucesso.";

    class Report
    {
        public $id;
        public $title;
        public $description;
        public $embed;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(empty($_POST['id']) || empty($_POST['title']) || empty($_POST['description']) || empty($_POST['embed'])) {

            $error = true;
            
            $results = array();

            $report = new Report();
            $report->id = '';
            $report->title = '';
            $report->description = '';
            $report->embed = '';

            array_push($results, $report);

        } else {

            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $embed = $_POST['embed'];

            include 'dbconnection.php';

            $conn = OpenDbConnection();

            $sql = "UPDATE reports SET title = '".$title."', description = '".$description."', embed = '".$embed."' WHERE id = '".$id."'";

            if ($conn->query($sql) === TRUE) {

                $successMessage = "Registro atualizado com sucesso.";
                $success = true;

                $sql = "SELECT * FROM reports WHERE id = ".$id;
                $result = $conn->query($sql);

                $results = array();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
            
                        $report = new Report();
                        $report->id = $row["id"];
                        $report->title = $row["title"];
                        $report->description = $row["description"];
                        $report->embed = $row["embed"];

                        array_push($results, $report);
                    }
                } else {

                    $report = new Report();
                    $report->id = '';
                    $report->title = '';
                    $report->description = '';
                    $report->embed = '';

                    array_push($results, $report);

                    $error = true;
                    $errorMessage = "Não foi possível encontrar esse relatório (id: ".$_GET['id'].").";
                }

            } else {
                $errorMessage = "Ocorreu um erro, tente novamente.";
                $error = true;
            }

            CloseDbConnection($conn);

        }


    } else if (isset($_GET['id'])) {

        $id = $_GET['id'];

        include 'dbconnection.php';

        $conn = OpenDbConnection();

        $sql = "SELECT * FROM reports WHERE id = ".$id;
        $result = $conn->query($sql);

        $results = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
    
                $report = new Report();
                $report->id = $row["id"];
                $report->title = $row["title"];
                $report->description = $row["description"];
                $report->embed = $row["embed"];

                array_push($results, $report);
            }
        } else {

            $report = new Report();
            $report->id = '';
            $report->title = '';
            $report->description = '';
            $report->embed = '';

            array_push($results, $report);

            $error = true;
            $errorMessage = "Não foi possível encontrar esse relatório (id: ".$_GET['id'].").";
        }

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include 'sessionheader.php';?>
</head>
<body>
    <p class="pageTitle">Detalhes do Relatório</p>
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
        <form id="editreportform" action="editreport.php" method="post">
            <div class="formRow">
                <?php
                    if($report) {
                        echo '<input type="hidden" id="id" name="id" value="'.$report->id.'">';
                    }
                    if (isset($_POST['updates'])) {
                        echo '<input type="hidden" id="updates" name="updates" value="'.($_POST['updates']+1).'">';
                    } else {
                        echo '<input type="hidden" id="updates" name="updates" value="2">';
                    }
                ?>
                <div class="inputContainer">
                    <label class="inputLabel">Título</label>
                    <input class="input" maxlength="200" type="text" id="title" name="title" value="<?php echo $results[0]->title ?>"/>
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Descrição</label>
                    <textarea class="textarea" type="text" id="description" name="description"><?php echo $results[0]->description ?></textarea>
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Embed</label>
                    <textarea class="textarea" type="text" id="embed" name="embed"><?php echo $results[0]->embed ?></textarea>
                </div>
            </div>
            <div class="buttonAdapter">
                <?php
                    if($error) {
                        echo 
                        '<div class="button-disabled">
                            <p class="buttonText">Editar</p>
                        </div>';
                    } else {
                        echo 
                        '<div class="button" onclick="onSubmit();">
                            <p class="buttonText">Editar</p>
                        </div>';
                    }
                ?>
                <div class="button" style="margin-left: 20px;" onclick="onCancelButtonClick();">
                    <p class="buttonText">Cancelar</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php';?>

    <script>

        function onSubmit() {   
            document.getElementById("editreportform").submit();
        }

        function onCancelButtonClick() {
            <?php
                if (isset($_POST['updates'])) {
                    echo "window.history.go(-".$_POST['updates'].");";
                } else {
                    echo "window.history.back()";
                }
            ?>
        }

        document.getElementById('datadeinicio').addEventListener('input', function (e) {
            var x = e.target.value.replace(/[^0-9]/g, "").replace(/^([0-9]{2})([0-9]{2})([0-9]{4})$/, "$1/$2/$3");
            e.target.value = x;
        });
    </script>

</body>
</html>