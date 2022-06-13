<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include 'sessionheader.php';?>
</head>
<body>
    <div class="container">
        <div class="previewImageAdapter">
            <img class="previewImage" src="./images/preview.png" />
        </div>
        <div class="menuContainer">
            <p class="menuTitle">Acesso não autorizado.</p>
        </div>
    </div>

    <script>
        setTimeout(function () {    
            window.location.href = "menu.php";
        }, 2500);
    </script>

</body>
</html>