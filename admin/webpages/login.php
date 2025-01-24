<?php
    //resume session here to fetch session values
    session_start();
    /*
        if user is login then redirect to dashboard page
    */
    if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin'){
        header('location: ./dashboard.php');
    }

    //if the login button is clicked
    require_once('../classes/adminaccount.class.php');
    
    if (isset($_POST['login'])) {
        $account = new AdminAccount();
        $account->adminEmail = htmlentities($_POST['adminEmail']);
        $account->adminPassword = htmlentities($_POST['adminPassword']);
        if ($account->sign_in_admin()){
            $_SESSION['user'] = 'admin';
            header('location: ./dashboard.php');
        }else{
            $error =  'Invalid email/password. Try again.';
        }
    }
    
    //if the above code is false then html below will be displayed
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../vendor/bootstrap-5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Your custome css goes here -->
    <link rel="stylesheet" href="../css/style-lp.css">
    <link rel="icon" href="../images/zc_lib_seal.png" type="image/x-icon">
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet"/>
    <!-- Bootstrap DateTimePicker CSS and JavaScript -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <title>Login</title>
</head>

<body>
    <div class="main">
        <!-- Login Card -->
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-md-6 col-lg-4 card-login p-4 px-5">
                <div class="row header d-flex justify-content-center mb-4">
                    <img src="../images/zc_lib_seal.png" class="logo-login" alt="">
                    <h4 class="header-title text-center">Zamboanga City Library - Admin</h4>
                </div>
                <form method="post" action="">
                    <div class="row d-flex justify-content-center">
                        <div class="input-group flex-column mb-3">
                            <label for="adminEmail" class="label">Email</label>
                            <input type="email" name="adminEmail" id="adminEmail" class="input" placeholder="example@gmail.com" required value="<?php if(isset($_POST['adminEmail'])) { echo $_POST['adminEmail']; } ?>">
                            <div></div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="input-group flex-column mb-3">
                            <label for="adminPassword" class="label">Password</label>
                            <input type="password" name="adminPassword" id="adminPassword" class="input" placeholder="Enter your password" required value="<?php if(isset($_POST['adminPassword'])) { echo $_POST['adminPassword']; } ?>">
                            <div></div>
                        </div>
                    </div>

                    <!-- <div class="row justify-content-end forgot-password">
                        <div class="col-auto">
                            <a href="#">Forgot Password?</a>
                        </div>
                    </div> -->

                    <button type="submit" name="login" class="sign-in-btn mt-4">SIGN IN</button>
                    <?php
                    if (isset($_POST['login']) && isset($error)){
                    ?>
                        <p class="text-danger mt-3 text-center"><?= $error ?></p>
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>
        <img src="../images/wave-bg.png" alt="Background Image" class="background-image"> <!-- Background Waves -->
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>