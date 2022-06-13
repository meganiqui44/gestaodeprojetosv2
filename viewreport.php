<?php

    $error = false;
    $errorMessage = "Dados inválidos, volte e tente novamente.";

    class Report
    {
        public $id;
        public $title;
        public $description;
        public $embed;
    }

    if (isset($_GET['id'])) {

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
    <p class="pageTitle">Relatório: <?php 
        if($error) {
            echo 'Desconhecido';
        } else {
            echo $results[0]->title;
        }
    ?></p>
    <img class="logoImage" src="./images/logo.jpg" />
    <?php
        if($error) {
            echo '<p class="error">'.$errorMessage.'</p>';
        }
    ?>
    <div class="formAdapter">
        <form id="editreportform" action="editreport.php" method="post">
            <div class="formRow">
                <div class="reportAdapter">
                    <?php echo $results[0]->embed ?>
                </div>
            </div>
            <div class="buttonAdapter">
                <div class="button" style="margin-left: 20px;" onclick="onCancelButtonClick();">
                    <p class="buttonText">Voltar</p>
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
            window.history.back();
        }

        document.getElementById('datadeinicio').addEventListener('input', function (e) {
            var x = e.target.value.replace(/[^0-9]/g, "").replace(/^([0-9]{2})([0-9]{2})([0-9]{4})$/, "$1/$2/$3");
            e.target.value = x;
        });
    </script>

</body>
</html>