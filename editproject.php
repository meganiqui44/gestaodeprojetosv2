<?php

    $error = false;
    $errorMessage = "Dados inválidos, volte e tente novamente.";

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
        while($row = $result->fetch_assoc()) {
        
            $company = new Company();
            $company->id = $row["id"];
            $company->nome = $row["nome"];

            array_push($companyResults, $company);
        }
    }

    class Project
    {
        public $id;
        public $nome;
        public $seguimento;
        public $status;
        public $descricao;
        public $inicio;
        public $duracao;
        public $lider;
        public $empresa;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(empty($_POST['id']) || empty($_POST['nomedoprojeto']) || empty($_POST['seguimento']) || empty($_POST['descricao']) || empty($_POST['datadeinicio']) || empty($_POST['duracao']) || empty($_POST['lider']) || empty($_POST['company']) || empty($_POST['status'])) {

            $error = true;
            
            $results = array();

            $project = new Project();
            $project->id = '';
            $project->nome = '';
            $project->seguimento = '';
            $project->status = '';
            $project->descricao = '';
            $project->inicio = '';
            $project->duracao = '';
            $project->lider = '';
            $project->empresa = '';

            array_push($results, $project);

        } else {

            $id = $_POST['id'];
            $nomedoprojeto = $_POST['nomedoprojeto'];
            $seguimento = $_POST['seguimento'];
            $descricao = $_POST['descricao'];
            $datadeinicio = $_POST['datadeinicio'];
            $duracao = $_POST['duracao'];
            $lider = $_POST['lider'];
            $empresacontratada = $_POST['company'];
            $status = $_POST['status'];


            $sql = "UPDATE projetos SET nome = '".$nomedoprojeto."', seguimento = '".$seguimento."', status = '".$status."', descricao = '".$descricao."', inicio = '".$datadeinicio."', duracao = '".$duracao."', lider = '".$lider."', empresa = '".$empresacontratada."' WHERE id = '".$id."'";

            if ($conn->query($sql) === TRUE) {

                $successMessage = "Registro atualizado com sucesso.";
                $success = true;

                $sql = "SELECT * FROM projetos WHERE id = ".$id;
                $result = $conn->query($sql);

                $results = array();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
            
                        $project = new Project();
                        $project->id = $row["id"];
                        $project->nome = $row["nome"];
                        $project->seguimento = $row["seguimento"];
                        $project->status = $row["status"];
                        $project->descricao = $row["descricao"];
                        $project->inicio = $row["inicio"];
                        $project->duracao = $row["duracao"];
                        $project->lider = $row["lider"];
                        $project->empresa = $row["empresa"];

                        array_push($results, $project);
                    }
                } else {

                    $project = new Project();
                    $project->id = '';
                    $project->nome = '';
                    $project->seguimento = '';
                    $project->status = '';
                    $project->descricao = '';
                    $project->inicio = '';
                    $project->duracao = '';
                    $project->lider = '';
                    $project->empresa = '';

                    array_push($results, $project);

                    $error = true;
                    $errorMessage = "Não foi possível encontrar esse projeto (id: ".$_GET['id'].").";
                }

            } else {
                $errorMessage = "Ocorreu um erro, tente novamente.";
                $error = true;
            }

            CloseDbConnection($conn);

        }


    } else if (isset($_GET['id'])) {

        $id = $_GET['id'];

        
        $sql = "SELECT * FROM projetos WHERE id = ".$id;
        $result = $conn->query($sql);

        $results = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
    
                $project = new Project();
                $project->id = $row["id"];
                $project->nome = $row["nome"];
                $project->seguimento = $row["seguimento"];
                $project->status = $row["status"];
                $project->descricao = $row["descricao"];
                $project->inicio = $row["inicio"];
                $project->duracao = $row["duracao"];
                $project->lider = $row["lider"];
                $project->empresa = $row["empresa"];

                array_push($results, $project);
            }
        } else {

            $project = new Project();
            $project->id = '';
            $project->nome = '';
            $project->seguimento = '';
            $project->status = '';
            $project->descricao = '';
            $project->inicio = '';
            $project->duracao = '';
            $project->lider = '';
            $project->empresa = '';

            array_push($results, $project);

            $error = true;
            $errorMessage = "Não foi possível encontrar esse projeto (id: ".$_GET['id'].").";
        }

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include 'adminsessionheader.php';?>
</head>
<body>
    <p class="pageTitle">Detalhes Do Projeto</p>
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
        <form id="editprojectform" action="editproject.php" method="post">
            <div class="formRow">
                <?php
                    if($project) {
                        echo '<input type="hidden" id="id" name="id" value="'.$project->id.'">';
                    }
                    if (isset($_POST['updates'])) {
                        echo '<input type="hidden" id="updates" name="updates" value="'.($_POST['updates']+1).'">';
                    } else {
                        echo '<input type="hidden" id="updates" name="updates" value="2">';
                    }
                ?>
                <div class="inputContainer">
                    <label class="inputLabel">Nome do Projeto</label>
                    <input class="input" maxlength="50" type="text" id="nomedoprojeto" name="nomedoprojeto" value="<?php echo $results[0]->nome ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Seguimento</label>
                    <input class="input" maxlength="50" type="text" id="seguimento" name="seguimento" value="<?php echo $results[0]->seguimento ?>">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Descrição</label>
                    <input class="input" maxlength="150" type="text" id="descricao" name="descricao" value="<?php echo $results[0]->descricao ?>">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Data de início</label>
                    <input class="input" type="text" maxlength="10" placeholder="25/12/2021" id="datadeinicio" name="datadeinicio" value="<?php echo $results[0]->inicio ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Duração (em dias)</label>
                    <input class="input" type="number" id="duracao" name="duracao" value="<?php echo $results[0]->duracao ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Líder</label>
                    <input class="input" maxlength="50" type="text" id="lider" name="lider" value="<?php echo $results[0]->lider ?>">
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
                    <input class="input" maxlength="50" type="text" id="status" name="status" value="<?php echo $results[0]->status ?>">
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
            document.getElementById("editprojectform").submit();
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


        const currentCompany = '<?php echo $results[0]->empresa ?>' || '';
        const companySelect = document.getElementById('companySelect');
        companySelect.addEventListener('change', onCompanySelectChange);
        companySelect.value = currentCompany;
        
        const companyInput = document.getElementById('company');
        companyInput.value = currentCompany;

        function onCompanySelectChange(e) {
            companyInput.value = e.target.value;
        }

    </script>

</body>
</html>