<?php

    $error = false;
    $errorMessage = "Dados inválidos, volte e tente novamente.";

    $success = false;
    $successMessage = "Operação executada com sucesso.";

    include 'dbconnection.php';

    $conn = OpenDbConnection();

    $sql = "SELECT * FROM projetos";
    $result = $conn->query($sql);
    $projectResults = array();

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

            array_push($projectResults, $project);
        }
    }

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['phone']) || empty($_POST['re']) || empty($_POST['department']) || empty($_POST['role']) || empty($_POST['permission'])) {
            
            $error = true;

            $results = array();

            $employee = new Employee();
            $employee->id = '';
            $employee->name = '';
            $employee->email = '';
            $employee->password = '';
            $employee->phone = '';
            $employee->re = '';
            $employee->department = '';
            $employee->role = '';
            $employee->permission = '';
            $employee->projects = '';

            array_push($results, $employee);

        } else {

            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $re = $_POST['re'];
            $department = $_POST['department'];
            $role = $_POST['role'];
            $permission = $_POST['permission'];
            $projects = empty($_POST['projects']) ? '' : $_POST['projects'];

            $sql = "UPDATE employees SET name = '$name', email = '$email', password = '$password', phone = '$phone', re = '$re', department = '$department', role = '$role', permission = '$permission', projects = '$projects' WHERE id = '$id'";

            if ($conn->query($sql) === TRUE) {

                $successMessage = "Registro atualizado com sucesso.";
                $success = true;

                $sql = "SELECT * FROM employees WHERE id = ".$id;
                $result = $conn->query($sql);

                $results = array();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {

                        $employee = new Employee();
                        $employee->id = $row["id"];
                        $employee->name = $row["name"];
                        $employee->email = $row["email"];
                        $employee->password = $row["password"];
                        $employee->phone = $row["phone"];
                        $employee->re = $row["re"];
                        $employee->department = $row["department"];
                        $employee->role = $row["role"];
                        $employee->permission = $row["permission"];
                        $employee->projects = $row["projects"];
            
                        array_push($results, $employee);
                    }
                } else {

                    $employee = new Employee();
                    $employee->id = '';
                    $employee->name = '';
                    $employee->email = '';
                    $employee->password = '';
                    $employee->phone = '';
                    $employee->re = '';
                    $employee->department = '';
                    $employee->role = '';
                    $employee->permission = '';
                    $employee->projects = '';

                    array_push($results, $employee);

                    $error = true;
                    $errorMessage = "Não foi possível encontrar esse funcionário (id: ".$_GET['id'].").";
                }

            } else {
                $errorMessage = "Ocorreu um erro, tente novamente.";
                $error = true;
            }

            CloseDbConnection($conn);
            
        }

    } else if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $sql = "SELECT * FROM employees WHERE id = ".$id;
        $result = $conn->query($sql);

        $results = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

                $employee = new Employee();
                $employee->id = $row["id"];
                $employee->name = $row["name"];
                $employee->email = $row["email"];
                $employee->password = $row["password"];
                $employee->phone = $row["phone"];
                $employee->re = $row["re"];
                $employee->department = $row["department"];
                $employee->role = $row["role"];
                $employee->permission = $row["permission"];
                $employee->projects = $row["projects"];
    
                array_push($results, $employee);
            }
        } else {

            $employee = new Employee();
            $employee->id = '';
            $employee->name = '';
            $employee->email = '';
            $employee->password = '';
            $employee->phone = '';
            $employee->re = '';
            $employee->department = '';
            $employee->role = '';
            $employee->permission = '';
            $employee->projects = '';

            array_push($results, $employee);

            $error = true;
            $errorMessage = "Não foi possível encontrar esse funcionário (id: ".$_GET['id'].").";
        }

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include 'adminsessionheader.php';?>
    <script src="./js/tagify/tagify.min.js"></script>
    <script src="./js/tagify/tagify.polyfills.min.js"></script>
    <link href="./js/tagify/tagify.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <p class="pageTitle">Detalhes De Func. Interno</p>
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
        <form id="editemployeeform" action="editemployee.php" method="post">
            <div class="formRow">
                <?php
                    if($employee) {
                        echo '<input type="hidden" id="id" name="id" value="'.$employee->id.'">';
                    }
                    if (isset($_POST['updates'])) {
                        echo '<input type="hidden" id="updates" name="updates" value="'.($_POST['updates']+1).'">';
                    } else {
                        echo '<input type="hidden" id="updates" name="updates" value="2">';
                    }
                ?>
                <div class="inputContainer">
                    <label class="inputLabel">Nome Completo</label>
                    <input class="input" maxlength="160" type="text" id="name" name="name" value="<?php echo $results[0]->name ?>">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">E-mail</label>
                    <input class="input" maxlength="80" autocomplete="email" type="text" id="email" name="email" value="<?php echo $results[0]->email ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Senha</label>
                    <input class="input" maxlength="25" autocomplete="new-password" type="password" id="password" name="password" value="<?php echo $results[0]->password ?>">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Telefone</label>
                    <input class="input" type="text" maxlength="15" id="phone" name="phone" value="<?php echo $results[0]->phone ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">RE</label>
                    <input class="input" maxlength="70" type="text" id="re" name="re" value="<?php echo $results[0]->re ?>">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Setor</label>
                    <input class="input" type="text" maxlength="40" id="department" name="department" value="<?php echo $results[0]->department ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Cargo</label>
                    <input class="input" type="text" maxlength="40" id="role" name="role" value="<?php echo $results[0]->role ?>">
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
            document.getElementById("editemployeeform").submit();
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

        document.getElementById('phone').addEventListener('input', function (e) {
            var x = e.target.value.replace(/[^0-9]/g, "").replace(/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/, "($1) $2-$3");
            e.target.value = x;
        });

        const currentProjects = [<?php echo $results[0]->projects ?>];

        const projectsWhiteList = [
            <?php
                foreach ($projectResults as $project) {
                    echo "{ value:'".$project->nome."', code:'".$project->id."'},";
                }
            ?>
        ];

        const projectsInput = document.getElementById("projectsInput");
        const projectsInputTagify = new Tagify(projectsInput, {
            userInput: false,
            whitelist: projectsWhiteList,
        });

        const projectsToAdd = [];

        for(let i = 0; i < currentProjects.length; i++) {
            const projectFound = projectsWhiteList.filter(function(project) {
                return project.code === `${currentProjects[i]}`;
            });
            projectFound[0] && projectsToAdd.push(projectFound[0]);
        }

        projectsInput.addEventListener('change', onProjectsInputChange);

        if (projectsToAdd.length > 0) {
            projectsInputTagify.addTags(projectsToAdd);
        };

        const currentPermission = '<?php echo $results[0]->permission ?>' || 'admin';
        const formSelectInput = document.getElementById("permission");
        formSelectInput.value = currentPermission;

        function onProjectsInputChange(e) {
            const projectsFormInput = document.getElementById("projectsFormInput");
            const projectsInputValue = JSON.parse(e.target.value);
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