<?php

$error = false;
$errorMessage = "Dados inválidos, tente novamente.";

$success = false;
$successMessage = "Operação executada com sucesso.";

include 'dbconnection.php';

$conn = OpenDbConnection();

$sql = "SELECT * FROM projetos";
$result = $conn->query($sql);
$results = array();

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

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['phone']) || empty($_POST['re']) || empty($_POST['department']) || empty($_POST['role']) || empty($_POST['permission'])) {

        $error = true;
    } else {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $re = $_POST['re'];
        $department = $_POST['department'];
        $role = $_POST['role'];
        $permission = $_POST['permission'];
        $projects = empty($_POST['projects']) ? '' : $_POST['projects'];

        $sql = "SELECT * FROM employees WHERE email = '" . $email . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $error = true;
            $errorMessage = "E-mail já utilizado, tente novamente com outro.";
        } else {

            $sql = "INSERT INTO employees (name, email, password, phone, re, department, role, permission, projects) 
                VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $phone . "', '" . $re . "', '" . $department . "', '" . $role . "', '" . $permission . "', '" . $projects . "')";

            if ($conn->query($sql) === TRUE) {
                $success = true;
            } else {
                $errorMessage = "Ocorreu um erro, tente novamente.";
                $error = true;
            }
        }

        CloseDbConnection($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include 'sessionheader.php';?>
    <script src="./js/tagify/tagify.min.js"></script>
    <script src="./js/tagify/tagify.polyfills.min.js"></script>
    <link href="./js/tagify/tagify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <p class="pageTitle">Novo Funcionário Interno</p>
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
        <form id="addemployeeform" action="addemployee.php" method="post">
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Nome Completo</label>
                    <input class="input" maxlength="160" type="text" id="name" name="name">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">E-mail</label>
                    <input class="input" maxlength="80" autocomplete="email" type="text" id="email" name="email">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Senha</label>
                    <input class="input" maxlength="25" autocomplete="new-password" type="password" id="password" name="password">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Telefone</label>
                    <input class="input" type="text" maxlength="15" id="phone" name="phone">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">RE</label>
                    <input class="input" maxlength="70" type="text" id="re" name="re">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Setor</label>
                    <input class="input" type="text" maxlength="40" id="department" name="department">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Cargo</label>
                    <input class="input" type="text" maxlength="40" id="role" name="role">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Permissão</label>
                    <select class="formSelectInput" name="permission" id="permission">
                        <option value="admin">Administrador</option>
                        <option value="employee">Func. Interno</option>
                        <option value="externalemployee">Func. Terceirizado</option>
                        <option value="disabled">Desabilitado</option>
                    </select>
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Participa ou é responsável por algum projeto?</label>
                    <input type="text" id="projectsInput">
                    <input type="hidden" id="projectsFormInput" name="projects" value="">
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
            document.getElementById("addemployeeform").submit();
        }

        function onCancelButtonClick() {
            window.location.href = 'employeesmenu.php';
        }

        document.getElementById('phone').addEventListener('input', function (e) {
            var x = e.target.value.replace(/[^0-9]/g, "").replace(/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/, "($1) $2-$3");
            e.target.value = x;
        });

        const projectsInput = document.getElementById("projectsInput");
        const projectsInputTagify = new Tagify(projectsInput, {
            userInput: false,
            whitelist: [
                <?php
                    foreach ($results as $project) {
                        echo "{ value:'".$project->nome."', code:'".$project->id."'},";
                    }
                ?>
            ]
        });
        projectsInput.addEventListener('change', onProjectsInputChange);

        function onProjectsInputChange(e) {
            const projectsFormInput = document.getElementById("projectsFormInput");
            const projectsInputValue = e.target.value ? JSON.parse(e.target.value) : '';
            let projectsFormInputValue = "";

            for(let i = 0; i < projectsInputValue.length; i++) {
                projectsFormInputValue += projectsInputValue[i].code + ",";
            }

            projectsFormInputValue = projectsFormInputValue.substring(0, projectsFormInputValue.length - 1);
            projectsFormInput.value = projectsFormInputValue;
        }

    </script>

</body>
</html>