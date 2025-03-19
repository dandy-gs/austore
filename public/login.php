<?php
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: ./index.php");
    die();
}

include './config.php';
$msg = "";

if (isset($_GET['verification'])) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE kode='{$_GET['verification']}'")) > 0) {
        $query = mysqli_query($conn, "UPDATE users SET kode='' WHERE kode='{$_GET['verification']}'");

        if ($query) {
            $msg = "<div class='alert alert-success'>Akun anda telah terverifikasi.</div>";
        }
    } else {
        header("Location: login.php");
    }
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sandi = mysqli_real_escape_string($conn, md5($_POST['sandi']));

    $sql = "SELECT * FROM users WHERE email='{$email}' AND sandi='{$sandi}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (empty($row['kode'])) {
            $_SESSION['SESSION_EMAIL'] = $email;
            header("Location: ./aurelista.php");
        } else {
            $msg = "<div class='alert alert-info'>Pertama verifikasi akunmu dan ulangi lagi </div>";
        }
    } else {
        $msg = "<div class='alert alert-danger text-center text-lg'><h5>Ada yang salah dengan email atau passwordmu</h5> <h5>Jika belum punya akun silahkan mendaftar</h5></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login - Aurellista</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="./admin/css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="./admin/images/image.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Login Now</h2>
                        <p>Silahkan masukkan akun anda disini. </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Masukkan Emailmu" required>
                            <input type="sandi" class="sandi" name="sandi" placeholder="Masukkan Passwordmu" style="margin-bottom: 2px;" required>
                            <p><a href="forgot-password.php" style="margin-bottom: 15px; display: block; text-align: right;">Lupa Password?</a></p>
                            <button name="submit" name="submit" class="btn" type="submit">Masuk</button>
                        </form>
                        <div class="social-icons">
                            <p>Buat Akun Baru! <a href="register.php">Daftar</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="./admin/js/jquery.min.js"></script>
    <script>
        $(document).ready(function(c) {
            $('.alert-close').on('click', function(c) {
                $('.main-mockup').fadeOut('slow', function(c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>