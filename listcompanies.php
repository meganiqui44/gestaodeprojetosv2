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

    $sql = "SELECT * FROM empresas";
    $result = $conn->query($sql);

    class Company
    {
        public $id;
        public $nome;
        public $telefone;
    }

    $results = array();
    $seguimentos = array();
    array_push($seguimentos, 'Todos');

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $company = new Company();
            $company->id = $row["id"];
            $company->nome = $row["nome"];
            $company->telefone = $row["telefone"];

            if (!in_array($row["seguimento"], $seguimentos)) {
                array_push($seguimentos, $row["seguimento"]);
            }

            if(isset($_GET['filter'])) {

                if($_GET['filter'] === "Todos" || $row["seguimento"] === $_GET['filter']) {
                    array_push($results, $company);
                }

            } else {

                array_push($results, $company);

            }

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
    <p class="pageTitle"><strong>Empresas Disponíveis</strong></p>
    <img class="logoImageList" src="./images/logo.jpg" />
    <?php
        if($error) {
            echo '<p class="error">'.$errorMessage.'</p>';
        }
    ?> 
    <form id="filterlistcompanyform" action="listcompanies.php">
        <div class="filterFormAdapter">
            <div class="filterContainer">
                <div class="filterTitleAdapter">
                    <p class="filterTitle">Seguimento</p>
                    <select class="selectInput" name="filter" id="filter">
                        <?php
                            if(isset($_GET['filter'])) {
                                echo '<option value="'.$_GET['filter'].'">'.$_GET['filter'].'</option>';
                            }
                            foreach ($seguimentos as $seguimento) {
                                if(!(isset($_GET['filter']) && $seguimento === $_GET['filter'])) {
                                    echo '<option value="'.$seguimento.'">'.$seguimento.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="buttonFilterAdapter">
                <div class="button" onclick="onFilterSubmit();">
                    <p class="buttonText">Consultar</p>
                </div>
            </div>
        </div>
    </form>

    <div class="tableAdapter">
        <div class="tableTitleAdapter">
            <p class="tableTitle">Resultados</p>
        </div>
        <table class="table table-bordered table-striped">
            <tr class="tableCabecalho">
                <th class="tableTh">Nome da empresa</th>
                <th class="tableTh">Telefone</th>
            </tr>
            <?php
                for ($i = $startAt; $i < $endAt; $i++) {
                    if($i < count($results)) {
                        $item = $results[$i];
                        echo '<tr class="tableTr"><td onclick="onItemClick('.$item->id.')"class="tableTd">'.$item->nome.'</td><td class="tableTd">'.$item->telefone.'</tr>';
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
                    if(isset($_GET['filter'])) {
                        echo "window.location.href = 'listcompanies.php?page=' + nextPage + '&filter=' + '".$_GET['filter']."'";
                    } else {
                        echo "window.location.href = 'listcompanies.php?page=' + nextPage";
                    }
                ?>
            }
        }

        function onPaginationPreviousClick(previousPage) {
            if(previousPage > -1) {
                <?php 
                    if(isset($_GET['filter'])) {
                        echo "window.location.href = 'listcompanies.php?page=' + previousPage + '&filter=' + '".$_GET['filter']."'";
                    } else {
                        echo "window.location.href = 'listcompanies.php?page=' + previousPage";
                    }
                ?>
            }
        }

        function onItemClick(id) {
            window.location.href = 'editcompany.php?id=' + id;
        }

        function onBackButtonClick() {
            window.location.href = 'companiesmenu.php';
        }

        function onFilterSubmit() {
            document.getElementById("filterlistcompanyform").submit();
        }
    </script>

</body>
</html>