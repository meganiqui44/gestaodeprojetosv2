<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include 'sessionheader.php'; ?>
    <link rel="stylesheet" href="./menu.css">
</head>

<body>
    <div class="logoUnilever">
        <img class="logoUnilverazul" src="./images/logo-unilever.png" alt="">
    </div>
    <div class="logoutContainer" onclick="onLogoutButtonClick();">
        <i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>
        <p class="logoutText">Logout</p>
    </div>
    <div class="container">
        <div class="previewImageAdapter">
            <img class="previewImage" src="./images/imagemFuncionario.png" />
        </div>
        <div class="menuContainer">
            <p class="menuTitle"><strong>Funcionários</strong></p>
            <div class="menuItemsContainer">
                <?php
                if ($_SESSION["permission"] === 'admin') {
                    echo '<div class="menuItem" onclick="onMenuItemClick(\'addemployee.php\');"> 
                            <p class="menuItemText">Cadastrar Interno</p>
                        </div>';
                }
                ?>
                <div class="menuItem" onclick="onMenuItemClick('listemployees.php');">
                    <p class="menuItemText">Listar</br>Internos</p>
                </div>
                <?php
                if ($_SESSION["permission"] === 'admin') {
                    echo '<div class="menuItem" onclick="onMenuItemClick(\'addexternalemployee.php\');"> 
                            <p class="menuItemText">Cadastrar Terceirizado</p>
                        </div>';
                }
                ?>
                <div class="menuItem" onclick="onMenuItemClick('listexternalemployees.php');">
                    <p class="menuItemText">Listar Terceirizados</p>
                </div>
            </div>
            <div class="menuItemVoltar" onclick="onMenuItemClick('menu.php');">
                <p class="menuItemTextVoltar">Voltar</p>
            </div>

        </div>
    </div>

    <script>
        function onMenuItemClick(url) {
            window.location.href = url;
        }

        function onLogoutButtonClick() {
            window.location.href = 'logout.php';
        }
    </script>

</body>

</html>