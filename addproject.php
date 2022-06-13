<?php

$error = false;
$errorMessage = "Dados inválidos, tente novamente.";

$success = false;
$successMessage = "Operação executada com sucesso.";

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
    while ($row = $result->fetch_assoc()) {

        $company = new Company();
        $company->id = $row["id"];
        $company->nome = $row["nome"];

        array_push($companyResults, $company);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['nomedoprojeto']) || empty($_POST['seguimento']) || empty($_POST['descricao']) || empty($_POST['datadeinicio']) || empty($_POST['duracao']) || empty($_POST['lider']) || empty($_POST['company']) || empty($_POST['status'])) {

        $error = true;
    } else {

        $nomedoprojeto = $_POST['nomedoprojeto'];
        $seguimento = $_POST['seguimento'];
        $descricao = $_POST['descricao'];
        $datadeinicio = $_POST['datadeinicio'];
        $duracao = $_POST['duracao'];
        $lider = $_POST['lider'];
        $empresacontratada = $_POST['company'];
        $status = $_POST['status'];


        $sql = "INSERT INTO projetos (nome, seguimento, status, descricao, inicio, duracao, lider, empresa) 
            VALUES ('" . $nomedoprojeto . "', '" . $seguimento . "', '" . $status . "', '" . $descricao . "', '" . $datadeinicio . "', '" . $duracao . "', '" . $lider . "', '" . $empresacontratada . "')";

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
<head>
    <?php include 'sessionheader.php';?>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <p class="pageTitle"><strong>Novo Projeto</strong></p>
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
        <form id="addprojectform" action="addproject.php" method="post">
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Nome do Projeto</label>
                    <input class="input" maxlength="50" type="text" id="nomedoprojeto" name="nomedoprojeto">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Seguimento</label>
                    <input class="input" maxlength="50" type="text" id="seguimento" name="seguimento">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Descrição</label>
                    <input class="input" maxlength="150" type="text" id="descricao" name="descricao">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Data de início</label>
                    <input class="input" type="text" maxlength="10" placeholder="25/12/2021" id="datadeinicio" name="datadeinicio">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Duração (em dias)</label>
                    <input class="input" type="number" id="duracao" name="duracao">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Líder</label>
                    <input class="input" maxlength="50" type="text" id="lider" name="lider">
                </div>
            </div>
            <div class="formRow">
            <div class="inputContainer">
                    <label class="inputLabel">Empresa</label>
                    <select class="formSelectInput" name="companySelect" id="companySelect">
                        <?php
                            foreach ($companyResults as $companyResult) {
                                echo '<option value="'.$companyResult->id.'">'.$companyResult->nome.'</option>';
                            }
                        ?>
                    </select>
                    <input type="hidden" id="company" name="company" value="">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Status</label>
                    <input class="input" maxlength="50" type="text" id="status" value="Em andamento" name="status">
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
            document.getElementById("addprojectform").submit();
        }

        function onCancelButtonClick() {
            window.location.href = 'projectsmenu.php';
        }

        document.getElementById('datadeinicio').addEventListener('input', function (e) {
            var x = e.target.value.replace(/[^0-9]/g, "").replace(/^([0-9]{2})([0-9]{2})([0-9]{4})$/, "$1/$2/$3");
            e.target.value = x;
        });

        const companySelect = document.getElementById("companySelect");
        companySelect.addEventListener('change', onCompanySelectChange);

        const companyInput = document.getElementById("company");
        const currentCompanyId = <?php echo $companyResults ?  "'".$companyResults[0]->id."'" : '' ?>;
        companyInput.value = currentCompanyId;
        
        function onCompanySelectChange(e) {
            companyInput.value = e.target.value;
        }

    </script>

</body>
</html>