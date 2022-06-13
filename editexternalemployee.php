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

    class Employee
    {
        public $id;
        public $name;
        public $email;
        public $password;
        public $phone;
        public $code;
        public $company;
        public $address;
        public $zipcode;
        public $role;
        public $integration;
        public $permission;
        public $projects;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(empty($_POST['id']) || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['phone']) || empty($_POST['code']) || empty($_POST['company']) || empty($_POST['address']) || empty($_POST['zipcode']) || empty($_POST['integration']) || empty($_POST['role']) || empty($_POST['permission'])) {

            $error = true;

            $results = array();

            $employee = new Employee();
            $employee->id = '';
            $employee->name = '';
            $employee->email = '';
            $employee->password = '';
            $employee->phone = '';
            $employee->code = '';
            $employee->company = '';
            $employee->address = '';
            $employee->zipcode = '';
            $employee->role = '';
            $employee->integration = '';
            $employee->permission = '';
            $employee->projects = '';

            array_push($results, $employee);

        } else {

            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $code = $_POST['code'];
            $company = $_POST['company'];
            $address = $_POST['address'];
            $zipcode = $_POST['zipcode'];
            $role = $_POST['role'];
            $integration = $_POST['integration'];
            $permission = $_POST['permission'];
            $projects = empty($_POST['projects']) ? '' : $_POST['projects'];

            $sql = "UPDATE employees SET name = '$name', email = '$email', password = '$password', phone = '$phone', code = '$code', company = '$company', address = '$address', zipcode = '$zipcode', role = '$role', integration = '$integration', permission = '$permission', projects = '$projects' WHERE id = '$id'";

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
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $phone = $_POST['phone'];
                        $code = $_POST['code'];
                        $company = $_POST['company'];
                        $address = $_POST['address'];
                        $zipcode = $_POST['zipcode'];
                        $role = $_POST['role'];
                        $integration = $_POST['integration'];
                        $permission = $_POST['permission'];
                        $projects = empty($_POST['projects']) ? '' : $_POST['projects'];
            
                        array_push($results, $employee);
                    }
                } else {

                    $employee = new Employee();
                    $employee->id = '';
                    $employee->name = '';
                    $employee->email = '';
                    $employee->password = '';
                    $employee->phone = '';
                    $employee->code = '';
                    $employee->company = '';
                    $employee->address = '';
                    $employee->zipcode = '';
                    $employee->role = '';
                    $employee->integration = '';
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
        } else {

            $employee = new Employee();
            $employee->id = '';
            $employee->name = '';
            $employee->email = '';
            $employee->password = '';
            $employee->phone = '';
            $employee->code = '';
            $employee->company = '';
            $employee->address = '';
            $employee->zipcode = '';
            $employee->role = '';
            $employee->integration = '';
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
    <p class="pageTitle">Detalhes De Func. Terceirizado</p>
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
        <form id="editexternalemployeeform" action="editexternalemployee.php" method="post">
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
                <div class="inputContainer">
                    <label class="inputLabel">Integração concluída?</label>
                    <select class="formSelectInput" name="integration" id="integration">
                        <option value="no">Não</option>
                        <option value="yes">Sim</option>
                    </select>
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Telefone</label>
                    <input class="input" type="text" maxlength="15" id="phone" name="phone" value="<?php echo $results[0]->phone ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Código</label>
                    <input class="input" maxlength="70" type="text" id="code" name="code" value="<?php echo $results[0]->code ?>">
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
                    <label class="inputLabel">Cargo</label>
                    <input class="input" type="text" maxlength="40" id="role" name="role" value="<?php echo $results[0]->role ?>">
                </div>
                <input type="hidden" id="permission" name="permission" value="externalemployee">
            </div>
            <div class="formRow">
                <div class="inputContainerSmall">
                    <label class="inputLabel">CEP</label>
                    <input class="input" type="text" maxlength="9" id="zipcode" name="zipcode" onblur="searchZipCode(this.value);" value="<?php echo $results[0]->zipcode ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Endereço</label>
                    <input class="input" type="text" maxlength="40" id="address" name="address" value="<?php echo $results[0]->address ?>">
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
            document.getElementById("editexternalemployeeform").submit();
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

        const currentIntegration = '<?php echo $results[0]->integration ?>' || 'no';
        const integrationSelect = document.getElementById('integration');
        integrationSelect.value = currentIntegration;

        const currentCompany = '<?php echo $results[0]->company ?>' || '';
        const companySelect = document.getElementById('companySelect');
        companySelect.value = currentCompany;
        const companyInput = document.getElementById('company');
        companyInput.value = currentCompany;

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