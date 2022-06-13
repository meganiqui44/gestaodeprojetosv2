<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include 'sessionheader.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./menu.css">
</head>

<body>
    <div class="logoUnilever">
        <img class="logoUnilverazul" src="./images/logo-unilever.png" alt="">
    </div>
    <div class="logoutContainer iconLogout" onclick="onLogoutButtonClick();">
    <i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i> 
    <p class="logoutText">Logout</p>
    </div>
    <div class="container">
        <div class="previewImageAdapter">
            <img class="previewImage" src="./images/imagemEmpresa.png" />
        </div>
        <div class="menuContainer">
            <p class="menuTitle"><strong>Empresas</strong></p>
            <div class="menuItemsContainer">
                <?php
                if ($_SESSION["permission"] === 'admin') {
                    echo '<div class="menuItem" onclick="onMenuItemClick(\'addcompany.php\');"> 
                                <p class="menuItemText">Cadastrar Empresa</p>
                            </div>';
                }
                ?>

                <div class="menuItem" onclick="onMenuItemClick('listcompanies.php');">
                    <p class="menuItemText">Empresas disponíveis</p>
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