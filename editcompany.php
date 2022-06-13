<?php

    $error = false;
    $errorMessage = "Dados inválidos, volte e tente novamente.";

    $success = false;
    $successMessage = "Operação executada com sucesso.";

    class Company
    {
        public $id;
        public $nome;
        public $seguimento;
        public $numerodeprofissionais;
        public $telefone;
        public $zipcode;
        public $localizacao;
        public $cnpj;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(empty($_POST['id']) || empty($_POST['cnpj']) || empty($_POST['nome']) || empty($_POST['seguimento']) || empty($_POST['numerodeprofissionais']) || empty($_POST['telefone']) || empty($_POST['zipcode']) || empty($_POST['localizacao'])) {
            
            $error = true;

            $results = array();

            $company = new Company();
            $company->id = '';
            $company->nome = '';
            $company->seguimento = '';
            $company->numerodeprofissionais = '';
            $company->telefone = '';
            $company->localizacao = '';
            $company->cnpj = '';

            array_push($results, $company);

        } else {

            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $seguimento = $_POST['seguimento'];
            $numerodeprofissionais = $_POST['numerodeprofissionais'];
            $telefone = $_POST['telefone'];
            $zipcode = $_POST['zipcode'];
            $localizacao = $_POST['localizacao'];
            $cnpj = $_POST['cnpj'];

            include 'dbconnection.php';

            $conn = OpenDbConnection();

            $sql = "UPDATE empresas SET nome = '".$nome."', seguimento = '".$seguimento."', numerodeprofissionais = '".$numerodeprofissionais."', telefone = '".$telefone."', zipcode = '".$zipcode."', localizacao = '".$localizacao."', cnpj = '".$cnpj."' WHERE id = '".$id."'";

            if ($conn->query($sql) === TRUE) {

                $successMessage = "Registro atualizado com sucesso.";
                $success = true;

                $sql = "SELECT * FROM empresas WHERE id = ".$id;
                $result = $conn->query($sql);

                $results = array();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
            
                        $company = new Company();
                        $company->id = $row["id"];
                        $company->nome = $row["nome"];
                        $company->seguimento = $row["seguimento"];
                        $company->numerodeprofissionais = $row["numerodeprofissionais"];
                        $company->telefone = $row["telefone"];
                        $company->zipcode = $row["zipcode"];
                        $company->localizacao = $row["localizacao"];
                        $company->cnpj = $row["cnpj"];
            
                        array_push($results, $company);
                    }
                } else {

                    $company = new Company();
                    $company->id = '';
                    $company->nome = '';
                    $company->seguimento = '';
                    $company->numerodeprofissionais = '';
                    $company->telefone = '';
                    $company->zipcode = '';
                    $company->localizacao = '';
                    $company->cnpj = '';

                    array_push($results, $company);

                    $error = true;
                    $errorMessage = "Não foi possível encontrar essa empresa (id: ".$_GET['id'].").";
                }

            } else {
                $errorMessage = "Ocorreu um erro, tente novamente.";
                $error = true;
            }

            CloseDbConnection($conn);
            
        }

    } else if (isset($_GET['id'])) {

        $id = $_GET['id'];

        include 'dbconnection.php';

        $conn = OpenDbConnection();

        $sql = "SELECT * FROM empresas WHERE id = ".$id;
        $result = $conn->query($sql);

        $results = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
    
                $company = new Company();
                $company->id = $row["id"];
                $company->nome = $row["nome"];
                $company->seguimento = $row["seguimento"];
                $company->numerodeprofissionais = $row["numerodeprofissionais"];
                $company->telefone = $row["telefone"];
                $company->zipcode = $row["zipcode"];
                $company->localizacao = $row["localizacao"];
                $company->cnpj = $row["cnpj"];
    
                array_push($results, $company);
            }
        } else {

            $company = new Company();
            $company->id = '';
            $company->nome = '';
            $company->seguimento = '';
            $company->numerodeprofissionais = '';
            $company->telefone = '';
            $company->zipcode = '';
            $company->localizacao = '';
            $company->cnpj = '';

            array_push($results, $company);

            $error = true;
            $errorMessage = "Não foi possível encontrar essa empresa (id: ".$_GET['id'].").";
        }

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include 'adminsessionheader.php';?>
</head>
<body>
    <p class="pageTitle">Detalhes Da Empresa</p>
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
        <form id="editcompanyform" action="editcompany.php" method="post">
            <div class="formRow">
                <?php
                    if($company) {
                        echo '<input type="hidden" id="id" name="id" value="'.$company->id.'">';
                    }
                    if (isset($_POST['updates'])) {
                        echo '<input type="hidden" id="updates" name="updates" value="'.($_POST['updates']+1).'">';
                    } else {
                        echo '<input type="hidden" id="updates" name="updates" value="2">';
                    }
                ?>
                <div class="inputContainer">
                    <label id="cnpjInput" class="inputLabel">CNPJ</label>
                    <input class="input" type="text" id="cnpj" name="cnpj" value="<?php echo $results[0]->cnpj ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Nome</label>
                    <input class="input" maxlength="50" type="text" id="nome" name="nome" value="<?php echo $results[0]->nome ?>">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Seguimento</label>
                    <input class="input" maxlength="50" type="text" id="seguimento" name="seguimento" value="<?php echo $results[0]->seguimento ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Número de profissionais</label>
                    <input class="input" type="number" id="numerodeprofissionais" name="numerodeprofissionais" value="<?php echo $results[0]->numerodeprofissionais ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Telefone</label>
                    <input class="input" type="text" maxlength="15" id="telefone" name="telefone" value="<?php echo $results[0]->telefone ?>">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainerSmall">
                    <label class="inputLabel">CEP</label>
                    <input class="input" type="text" maxlength="9" id="zipcode" name="zipcode" onblur="searchZipCode(this.value);" value="<?php echo $results[0]->zipcode ?>">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Endereço</label>
                    <input class="input" type="text" id="localizacao" name="localizacao" value="<?php echo $results[0]->localizacao ?>">
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
            document.getElementById("editcompanyform").submit();
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

        document.getElementById('cnpj').addEventListener('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
            e.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
        });

        document.getElementById('telefone').addEventListener('input', function (e) {
            var x = e.target.value.replace(/[^0-9]/g, "").replace(/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/, "($1) $2-$3");
            e.target.value = x;
        });

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
                document.getElementById('localizacao').value = `${zipcode.logradouro}, ${zipcode.bairro} - ${zipcode.localidade}, ${zipcode.uf}`;
            } else {
                document.getElementById('zipcode').value = ""
                document.getElementById('localizacao').value = "";
                alert("CEP não encontrado.");
            }
        }

        function searchZipCode(valor) {
            var cep = valor.replace(/\D/g, '');

            if (cep != "") {

                var validacep = /^[0-9]{8}$/;

                if(validacep.test(cep)) {

                    document.getElementById('localizacao').value = "";

                    var script = document.createElement('script');
                    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=zipCodeCallback';
                    document.body.appendChild(script);

                } else {

                    document.getElementById('zipcode').value = ""
                    document.getElementById('localizacao').value = "";
                    alert("Formato de CEP inválido.");
                    
                }
            } else {
                document.getElementById('zipcode').value = ""
                document.getElementById('localizacao').value = "";
            }
        };
    </script>

</body>
</html>