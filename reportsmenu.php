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
            <img class="previewImage" src="./images/imagemRelatorio.png" />
        </div>
        <div class="menuContainer">
            <p class="menuTitle"><strong>Relatórios</strong></p>
            <div class="menuItemsContainer">
                <?php
                if ($_SESSION["permission"] != 'externalemployee') {
                    echo '<div class="menuItem" onclick="onMenuItemClick(\'addreport.php\');"> 
                            <p class="menuItemText">Cadastrar Relatório</p>
                        </div>';
                }
                ?>
                <div class="menuItem" onclick="onMenuItemClick('listreports.php');">
                    <p class="menuItemText">Relatórios disponíveis</p>
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