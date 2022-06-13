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
    <div class="container">
        <div class="previewImageAdapter">
            <img class="previewImage" src="./images/menu.png" />
        </div>
        <div class="menuContainer  ">
            <p class="menuTitle"><strong>Olá, <?php echo $_SESSION["name"] ?></strong></p>
            <div class="menuItemsContainer  ">
                <div class="menuItem" onclick="onMenuItemClick('projectsmenu.php');">
                    <p class="menuItemText">Projetos</p>
                </div>
                <div class="menuItem" onclick="onMenuItemClick('companiesmenu.php');">
                    <p class="menuItemText">Empresas</p>
                </div>
                <div class="menuItem" onclick="onMenuItemClick('reportsmenu.php');">
                    <p class="menuItemText">Relatórios</p>
                </div>
                <div class="menuItem" onclick="onMenuItemClick('employeesmenu.php');">
                    <p class="menuItemText">Funcionários</p>
                </div>
            </div>
            <div class="menuItemVoltar " onclick="onMenuItemClick('index.php');">
                <p class="menuItemTextVoltar">Voltar</p>
            </div>
        </div>
    </div>
    <div class="logoutContainer" onclick="onLogoutButtonClick();">
        <i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>
        <p class="logoutText">Logout</p>
    </div>

    <script>
        function onMenuItemClick(url) {
            window.location.href = url;
        }

        function onLogoutButtonClick() {
            window.location.href = 'logout.php';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>