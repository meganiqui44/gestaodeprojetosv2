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

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['phone']) || empty($_POST['code']) || empty($_POST['company']) || empty($_POST['address']) || empty($_POST['zipcode']) || empty($_POST['integration']) || empty($_POST['role']) || empty($_POST['permission'])) {

        $error = true;
    } else {

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

        $sql = "SELECT * FROM employees WHERE email = '" . $email . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $error = true;
            $errorMessage = "E-mail já utilizado, tente novamente com outro.";
        } else {

            $sql = "INSERT INTO employees (name, email, password, phone, code, company, address, zipcode, role,  integration, permission, projects) 
                VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $phone . "', '" . $code . "', '" . $company . "', '" . $address . "', '" . $zipcode . "', '" . $role . "', '" . $integration . "', '" . $permission . "', '" . $projects . "')";

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
    <p class="pageTitle">Novo Func. Terceirizado</p>
    <img class="logoImage" src="./images/logo.jpg" />
    <?php
        if($error) {
            echo '<p class="errorLessSpacing">'.$errorMessage.'</p>';
        }
        if($success) {
            echo '<p class="successLessSpacing">'.$successMessage.'</p>';
        }
    ?>  
    <div class="formAdapterLessSpacing">
        <form id="addexternalemployeeform" action="addexternalemployee.php" method="post">
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
                    <input class="input" type="text" maxlength="15" id="phone" name="phone">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Código</label>
                    <input class="input" maxlength="70" type="text" id="code" name="code">
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
                    <input class="input" type="text" maxlength="40" id="role" name="role">
                </div>
                <input type="hidden" id="permission" name="permission" value="externalemployee">
            </div>
            <div class="formRow">
                <div class="inputContainerSmall">
                    <label class="inputLabel">CEP</label>
                    <input class="input" type="text" maxlength="9" id="zipcode" name="zipcode" onblur="searchZipCode(this.value);">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Endereço</label>
                    <input class="input" type="text" maxlength="40" id="address" name="address">
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
            document.getElementById("addexternalemployeeform").submit();
        }

        function onCancelButtonClick() {
            window.location.href = 'employeesmenu.php';
        }

        document.getElementById('phone').addEventListener('input', function (e) {
            var x = e.target.value.replace(/[^0-9]/g, "").replace(/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/, "($1) $2-$3");
            e.target.value = x;
        });

        const currentPermission = 'externalemployee';
        const formSelectInput = document.getElementById("permission");
        formSelectInput.value = currentPermission;

        const companySelect = document.getElementById("companySelect");
        companySelect.addEventListener('change', onCompanySelectChange);

        const companyInput = document.getElementById("company");
        const currentCompanyId = <?php echo $companyResults ?  "'".$companyResults[0]->id."'" : '' ?>;
        companyInput.value = currentCompanyId;
        
        function onCompanySelectChange(e) {
            companyInput.value = e.target.value;
        }

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

        const zipCodeInput = document.getElementById("zipcode");
        zipCodeInput.addEventListener("keyup", (e) => {
            zipCode = zipCodeInput.value;
            if(zipCode && zipCode.length === 8) {
                zipCodeInput.value = `${zipCode.substr(0,5)}-${zipCode.substr(5,9)}`;
            }
            if (e.key && e.key === 'Enter') {
                searchZipCode(zipCode);
            }
        });

        function zipCodeCallback(zipcode) {
            if (!("erro" in zipcode)) {
                document.getElementById('address').value = `${zipcode.logradouro}, ${zipcode.bairro} - ${zipcode.localidade}, ${zipcode.uf}`;
            } else {
                document.getElementById('zipcode').value = ""
                document.getElementById('address').value = "";
                alert("CEP não encontrado.");
            }
        }

        function searchZipCode(valor) {
            var cep = valor.replace(/\D/g, '');

            if (cep != "") {

                var validacep = /^[0-9]{8}$/;

                if(validacep.test(cep)) {

                    document.getElementById('address').value = "";

                    var script = document.createElement('script');
                    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=zipCodeCallback';
                    document.body.appendChild(script);

                } else {

                    document.getElementById('zipcode').value = ""
                    document.getElementById('address').value = "";
                    alert("Formato de CEP inválido.");
                    
                }
            } else {
                document.getElementById('zipcode').value = ""
                document.getElementById('address').value = "";
            }
        };

    </script>

</body>
</html>