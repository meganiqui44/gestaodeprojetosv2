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

$sql = "SELECT * FROM projetos";
$result = $conn->query($sql);

class Project
{
    public $id;
    public $nome;
    public $inicio;
    public $status;
}

$results = array();
$projetos = array();
array_push($projetos, 'Todos');
$status = array();
array_push($status, 'Todos');

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $project = new Project();
        $project->id = $row["id"];
        $project->nome = $row["nome"];
        $project->inicio = $row["inicio"];
        $project->status = $row["status"];

        array_push($projetos, $row["nome"]);

        if (!in_array($row["status"], $status)) {
            array_push($status, $row["status"]);
        }

        if (isset($_GET['projectFilter'])) {

            if ($_GET['projectFilter'] === "Todos") {

                if (isset($_GET['statusFilter']) && $_GET['statusFilter'] === "Todos") {
                    array_push($results, $project);
                }

                if (isset($_GET['statusFilter']) && $_GET['statusFilter'] === $row["status"]) {
                    array_push($results, $project);
                }
            } else {

                if ($_GET['projectFilter'] === $row["nome"]) {

                    if (isset($_GET['statusFilter']) && $_GET['statusFilter'] === "Todos") {
                        array_push($results, $project);
                    } else if (isset($_GET['statusFilter']) && $_GET['statusFilter'] === $row["status"]) {
                        array_push($results, $project);
                    }
                }
            }
        } else {

            array_push($results, $project);
        }
    }

    $total = ceil((count($results) / $limit) - 1);

    if ($page > $total) {
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
    <?php include 'sessionheader.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./listprojects.css">
   
</head>

<body>
    <div class="backButtonAdapter">
    
    <p class="backButtonText" onclick="onBackButtonClick()">Voltar</p>
    <i class="fa-solid fa-square-left fa-2x"></i>
    </div>
    <p class="pageTitle"><strong>Projetos Existentes </strong></p>
    <img class="logoImageList" src="./images/logo.jpg" />
    <?php
    if ($error) {
        echo '<p class="error">' . $errorMessage . '</p>';
    }
    ?>
    <form id="filterlistprojectsform" action="listprojects.php">
        <div class="filterFormAdapter">
            <div class="filterContainer">
                <div class="filterTitleAdapter">
                    <p class="filterTitle">Projetos</p>
                    <select class="selectInput form-select" name="projectFilter" id="projectFilter">
                        <?php
                        if (isset($_GET['projectFilter'])) {
                            echo '<option value="' . $_GET['projectFilter'] . '">' . $_GET['projectFilter'] . '</option>';
                        }
                        foreach ($projetos as $projeto) {
                            if (!(isset($_GET['projectFilter']) && $projeto === $_GET['projectFilter'])) {
                                echo '<option value="' . $projeto . '">' . $projeto . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="filterContainer">
                <div class="filterTitleAdapter">
                    <p class="filterTitle">Status</p>
                    <select class="selectInput form-select" name="statusFilter" id="statusFilter">
                        <?php
                        if (isset($_GET['statusFilter'])) {
                            echo '<option value="' . $_GET['statusFilter'] . '">' . $_GET['statusFilter'] . '</option>';
                        }
                        foreach ($status as $stat) {
                            if (!(isset($_GET['statusFilter']) && $stat === $_GET['statusFilter'])) {
                                echo '<option value="' . $stat . '">' . $stat . '</option>';
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
                <th class="tableTh">Nome do projeto</th>
                <th class="tableTh">Data de início</th>
                <th class="tableTh">Status</th>
            </tr>
            <?php
            for ($i = $startAt; $i < $endAt; $i++) {
                if ($i < count($results)) {
                    $item = $results[$i];
                    echo '<tr class="tableTr" onclick="onItemClick(' . $item->id . ')"><td class="tableTd">' . $item->nome . '</td><td class="tableTd">' . $item->inicio . '</td><td class="tableTd">' . $item->status . '</tr>';
                }
            }
            ?>
        </table>
    </div>

    <div class="paginationAdapter">
        <div class="paginationButton" onclick="onPaginationPreviousClick(<?php echo ($page - 1) ?>)">
            <p class="paginationButtonText">
                <</p>
        </div>
        <div class="paginationCurrentPageTextAdapter">
            <p class="paginationCurrentPageText"><?php echo ($page + 1) . '/' . ($total + 1) ?></p>
        </div>
        <div class="paginationButton" onclick="onPaginationNextClick(<?php echo ($page + 1) ?>)">
            <p class="paginationButtonText">></p>
        </div>
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
            if (nextPage <= <?php echo $total ?>) {
                <?php
                if (isset($_GET['statusFilter'])) {
                    echo "window.location.href = 'listprojects.php?page=' + nextPage + '&statusFilter=' + '" . $_GET['statusFilter'] . "'";
                } else {
                    echo "window.location.href = 'listprojects.php?page=' + nextPage";
                }
                ?>
            }
        }

        function onPaginationPreviousClick(previousPage) {
            if (previousPage > -1) {
                <?php
                if (isset($_GET['statusFilter'])) {
                    echo "window.location.href = 'listprojects.php?page=' + previousPage + '&statusFilter=' + '" . $_GET['statusFilter'] . "'";
                } else {
                    echo "window.location.href = 'listprojects.php?page=' + previousPage";
                }
                ?>
            }
        }

        function onItemClick(id) {
            window.location.href = 'editproject.php?id=' + id;
        }

        function onBackButtonClick() {
            window.location.href = 'projectsmenu.php';
        }

        function onFilterSubmit() {
            document.getElementById("filterlistprojectsform").submit();
        }
    </script>

</body>

</html>