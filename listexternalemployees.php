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
    $companyResults = array();

    class Company
    {
        public $id;
        public $nome;
    }

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        
            $company = new Company();
            $company->id = $row["id"];
            $company->nome = $row["nome"];

            array_push($companyResults, $company);
        }
    }

    $sql = "SELECT * FROM employees WHERE  permission = 'externalemployee'";
    $result = $conn->query($sql);

    class Employee
    {
        public $id;
        public $name;
        public $email;
        public $password;
        public $phone;
        public $re;
        public $department;
        public $role;
        public $permission;
        public $projects;
    }

    $results = array();
    $employees = array();
    array_push($employees, 'Todos');
    $status = array();
    array_push($status, 'Todos');

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $employee = new Employee();
            $employee->id = $row["id"];
            $employee->name = $row["name"];
            $employee->email = $row["email"];
            $employee->password = $row["password"];
            $employee->phone = $row["phone"];
            $employee->code = $row["code"];
            $employee->company = $row["company"];
            $employee->address = $row["address"];
            $employee->zipcode = $row["zipcode"];
            $employee->role = $row["role"];
            $employee->integration = $row["integration"];
            $employee->permission = $row["permission"];
            $employee->projects = $row["projects"];

            array_push($results, $employee);

        }

        $total = ceil((count($results)/$limit) - 1);

        if($page > $total) {
            $page = 0;
        }

    } else {
        $errorMessage = "Nenhum funcionário encontrado.";
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
    <p class="pageTitle">Func. Terceirizados</p>
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
                <th class="tableTh">Nome</th>
                <th class="tableTh">Email</th>
                <th class="tableTh">Código</th>
                <th class="tableTh">Empresa</th>
            </tr>
            <?php
                for ($i = $startAt; $i < $endAt; $i++) {
                    if($i < count($results)) {
                        $item = $results[$i];

                        $companyName = "";
                        foreach($companyResults as $company) {
                            if($company->id == $item->company) {
                                $companyName = $company->nome;
                            }
                        }

                        echo '<tr class="tableTr" onclick="onItemClick('.$item->id.')"><td class="tableTd">'.$item->name.'</td><td class="tableTd"><p>'.$item->email.'</p></td><td class="tableTd"><p>'.$item->code.'</p></td><td class="tableTd"><p>'.$companyName.'</p></td></tr>';
                    }
                }
            ?>
        </table>-
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
                        echo "window.location.href = 'listexternalemployees.php?page=' + nextPage + '&statusFilter=' + '".$_GET['statusFilter']."'";
                    } else {
                        echo "window.location.href = 'listexternalemployees.php?page=' + nextPage";
                    }
                ?>
            }
        }

        function onPaginationPreviousClick(previousPage) {
            if(previousPage > -1) {
                <?php 
                    if(isset($_GET['statusFilter'])) {
                        echo "window.location.href = 'listexternalemployees.php?page=' + previousPage + '&statusFilter=' + '".$_GET['statusFilter']."'";
                    } else {
                        echo "window.location.href = 'listexternalemployees.php?page=' + previousPage";
                    }
                ?>
            }
        }
        
        function onItemClick(id) {
            window.location.href = 'editexternalemployee.php?id=' + id;
        }

        function onBackButtonClick() {
            window.location.href = 'employeesmenu.php';
        }

        function onFilterSubmit() {
            document.getElementById("filterlistexternalemployeesform").submit();
        }
    </script>

</body>
</html>