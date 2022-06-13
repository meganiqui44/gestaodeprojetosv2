<?php

$error = false;
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        include 'dbconnection.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        $conn = OpenDbConnection();
        $sql = "SELECT * FROM employees WHERE email = '$email' and password = '$password'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $count = mysqli_num_rows($result);

        if ($count == 1) {

            $id = $row['id'];
            $permission = $row['permission'];
            $email = $row['email'];
            $password = $row['password'];
            $name = $row['name'];
            $code = $row['code'];
            $re = $row['re'];
            $phone = $row['phone'];
            $department = $row['department'];
            $role = $row['role'];
            $projects = $row['projects'];
            $company = $row['company'];
            $address = $row['address'];
            $integration = $row['integration'];
            $zipcode = $row['zipcode'];

            if ($permission === 'disabled') {

                $error = true;
                $errorMessage = "Conta desativada, entre em</br>contato com o administrador.";
            } else {

                session_start();

                $_SESSION['id'] = $id;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['name'] = $name;
                $_SESSION['code'] = $code;
                $_SESSION['re'] = $re;
                $_SESSION['phone'] = $phone;
                $_SESSION['department'] = $department;
                $_SESSION['role'] = $role;
                $_SESSION['projects'] = $projects;
                $_SESSION['company'] = $company;
                $_SESSION['address'] = $address;
                $_SESSION['integration'] = $integration;
                $_SESSION['zipcode'] = $zipcode;
                $_SESSION['permission'] = $permission;

                header("Location: menu.php");
            }
        } else {

            $error = true;
            $errorMessage = "Informações incorretas, por favor tente novamente.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!--<?php include 'header.php'; ?>-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./index.css">
</head>

<body>
    <div class="container-login">
        <div class="previewImageAdapter">
            <img class="previewImage" src="./images/topo-login.jpeg" />
            <p class="loginTextGestao"><strong>G8 Gestão de Projetos</strong></p>
        </div>
        <div class="container">

            <div class="loginContainer">
                <!--<p class="loginTitle"><strong>G8 Gestão de Projetos</strong></p>-->
                <form class="loginForm" action="index.php" method="post">
                    <label class="inputLabel form-label" for="email"><b>E-mail</b></label>
                    <input class="input form-control form-control-lg " autocomplete="email" type="email" placeholder="Email" name="email" required>
                    </br>
                    <label class="inputLabel" for="password"><b>Senha</b></label>
                    <input class="input form-control form-control-lg" autocomplete="current-password" type="password" placeholder="Senha" name="password" required>
                    <?php
                    if ($error) {
                        echo '<p class="login-error-text">' . $errorMessage . '</p>';
                    }
                    ?>
                  <!--  <div class="buttonLoginAdapter ">
                        <button class="button " type="submit">
                            <p class="buttonText btn btn-primary btn-lg">Login</p>
                        </button>
                    </div>-->

                    <div class="buttonLoginAdapter ">
                        <button class=" button buttonText" type="submit">Login
                           
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script>
        function onMenuItemClick(url) {
            window.location.href = url;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>