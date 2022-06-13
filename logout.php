<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include 'sessionheader.php';?>
    <link rel="stylesheet" href="./menu.css">
</head>
<body>
    <div class="container">
        <div class="previewImageAdapter">
            <img class="previewImage" src="./images/preview.png" />
        </div>
        <div class="menuContainer">
            <p class="menuTitle">Até mais, <?php echo $_SESSION["name"] ?>!</p>
        </div>
    </div>

    <script>
        setTimeout(function () {    
            window.location.href = "doLogout.php";
        }, 3000);
    </script>

</body>
</html>