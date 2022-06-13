<?php

    $error = false;

    $page = 0;
    $limit = 4;
    $startAt = $page * $limit;
    $endAt = $startAt + $limit;
    $total = 0;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        $startAt = $page * $limit;
        $endAt = $startAt + $limit;
    }

    include 'dbconnection.php'; 

    $conn = OpenDbConnection();

    $sql = "SELECT * FROM reports";
    $result = $conn->query($sql);

    class Report
    {
        public $id;
        public $title;
        public $description;
        public $embed;
    }

    $results = array();
    $reports = array();
    array_push($reports, 'Todos');
    $status = array();
    array_push($status, 'Todos');

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $report = new Report();
            $report->id = $row["id"];
            $report->title = $row["title"];
            $report->description = $row["description"];
            $report->embed = $row["embed"];

            array_push($results, $report);

        }

        $total = ceil((count($results)/$limit) - 1);

        if($page > $total) {
            $page = 0;
        }

    } else {
        $errorMessage = "Nenhum item encontrado.";
    }

    CloseDbConnection($conn);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include 'sessionheader.php';?>
    <link rel="stylesheet" href="./listprojects.css">
</head>
<body>
    <p class="pageTitle">Relatórios Disponíveis</p>
    <img class="logoImageList" src="./images/logo.jpg" />
    <?php
        if($error) {
            echo '<p class="error">'.$errorMessage.'</p>';
        }
    ?>

    <div class="filterFormAdapter"></div>

    <div class="tableAdapter">
        <div class="tableTitleAdapter">
            <p class="tableTitle">Resultados</p>
        </div>
        <table class="table table-bordered table-striped">
            <tr class="tableCabecalho">
                <th class="tableTh">Título</th>
                <th class="tableTh">Descrição</th>
                <th class="tableTh">Ações</th>
            </tr>
            <?php
                for ($i = $startAt; $i < $endAt; $i++) {
                    if($i < count($results)) {
                        $item = $results[$i];
                        echo '<tr class="tableTr"><td class="tableTd" onclick="onOpenItemClick('.$item->id.')">'.$item->title.'</td><td class="tableTd" onclick="onOpenItemClick('.$item->id.')"><p>'.$item->description.'</p></td><td class="tableTd" onclick="onItemClick('.$item->id.')"><div><p><b>Editar</b></p></div></td></tr>';
                    }
                }
            ?>
        </table>
    </div>

    <div class="paginationAdapter">
        <div class="paginationButton" onclick="onPaginationPreviousClick(<?php echo ($page - 1) ?>)">
            <p class="paginationButtonText"><</p>
        </div>
        <div class="paginationCurrentPageTextAdapter">
            <p class="paginationCurrentPageText"><?php echo ($page + 1).'/'.($total + 1) ?></p>
        </div>
        <div class="paginationButton" onclick="onPaginationNextClick(<?php echo ($page + 1) ?>)">
            <p class="paginationButtonText">></p>
        </div>
    </div>

    <div class="backButtonAdapter">
        <p class="backButtonText" onclick="onBackButtonClick()">Voltar</p>
    </div>

    <div class="footerAdapter">
        <div class="footerContainer">
            <div class="footerImageLeftListAdapter">
                <img class="footerImageLeft" src="./images/footerLeft.jpg" />
            </div>
            <div class="footerImageRightListAdapter">
                <img class="footerImageRight" src="./images/footerRight.jpg" />
            </div>
        </div>
    </div>

    <script>
        function onPaginationNextClick(nextPage) {
            if(nextPage <= <?php echo $total ?>) {
                <?php 
                    if(isset($_GET['statusFilter'])) {
                        echo "window.location.href = 'listreports.php?page=' + nextPage + '&statusFilter=' + '".$_GET['statusFilter']."'";
                    } else {
                        echo "window.location.href = 'listreports.php?page=' + nextPage";
                    }
                ?>
            }
        }

        function onPaginationPreviousClick(previousPage) {
            if(previousPage > -1) {
                <?php 
                    if(isset($_GET['statusFilter'])) {
                        echo "window.location.href = 'listreports.php?page=' + previousPage + '&statusFilter=' + '".$_GET['statusFilter']."'";
                    } else {
                        echo "window.location.href = 'listreports.php?page=' + previousPage";
                    }
                ?>
            }
        }
        
        function onItemClick(id) {
            window.location.href = 'editreport.php?id=' + id;
        }

        function onOpenItemClick(id) {
            window.location.href = 'viewreport.php?id=' + id;
        }

        function onBackButtonClick() {
            window.location.href = 'reportsmenu.php';
        }

        function onFilterSubmit() {
            document.getElementById("filterlistreportsform").submit();
        }
    </script>

</body>
</html>