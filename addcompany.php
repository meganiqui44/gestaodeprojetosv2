<?php

$error = false;
$errorMessage = "Dados inválidos, tente novamente.";

$success = false;
$successMessage = "Operação executada com sucesso.";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['cnpj']) || empty($_POST['nome']) || empty($_POST['seguimento']) || empty($_POST['numerodeprofissionais']) || empty($_POST['telefone']) || empty($_POST['zipcode']) || empty($_POST['localizacao'])) {

        $error = true;
    } else {

        $nome = $_POST['nome'];
        $seguimento = $_POST['seguimento'];
        $numerodeprofissionais = $_POST['numerodeprofissionais'];
        $telefone = $_POST['telefone'];
        $zipcode = $_POST['zipcode'];
        $localizacao = $_POST['localizacao'];
        $cnpj = $_POST['cnpj'];

        include 'dbconnection.php';

        $conn = OpenDbConnection();

        $sql = "INSERT INTO empresas (nome, seguimento, numerodeprofissionais, telefone, zipcode, localizacao, cnpj) 
            VALUES ('" . $nome . "', '" . $seguimento . "', '" . $numerodeprofissionais . "', '" . $telefone . "', '" . $zipcode . "', '" . $localizacao . "', '" . $cnpj . "')";

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
    <p class="pageTitle"><strong>Nova Empresa</strong></p>
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
        <form id="addcompanyform" action="addcompany.php" method="post">
            <div class="formRow">
                <div class="inputContainer">
                    <label id="cnpjInput" class="inputLabel">CNPJ</label>
                    <input class="input" type="text" id="cnpj" name="cnpj">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Nome</label>
                    <input class="input" maxlength="50" type="text" id="nome" name="nome">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainer">
                    <label class="inputLabel">Seguimento</label>
                    <input class="input" maxlength="50" type="text" id="seguimento" name="seguimento">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Número de profissionais</label>
                    <input class="input" type="number" id="numerodeprofissionais" name="numerodeprofissionais">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Telefone</label>
                    <input class="input" type="text" maxlength="15" id="telefone" name="telefone">
                </div>
            </div>
            <div class="formRow">
                <div class="inputContainerSmall">
                    <label class="inputLabel">CEP</label>
                    <input class="input" type="text" maxlength="9" id="zipcode" name="zipcode" onblur="searchZipCode(this.value);">
                </div>
                <div class="inputContainer">
                    <label class="inputLabel">Endereço</label>
                    <input class="input" type="text" id="localizacao" name="localizacao">
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
        </div>
    </div>

    <?php include 'footer.php';?>

    <script>

        function onSubmit() {
            document.getElementById("addcompanyform").submit();
        }

        function onCancelButtonClick() {
            window.location.href = 'companiesmenu.php';
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