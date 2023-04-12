<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" href="CSS/Code.css"/>
    <style>
    </style>
</head>
<body>
    <?php
    include 'General.php';
    if(isset($_SESSION['User'])){
        header('location: Mainmenu.php');
        exit();
    }
    include 'Alert.php';
    if(isset($_POST['register'])){
        if($_POST['password']!=$_POST['repassword']){
            echo"<script>alert('Something went wrong, try this later') </script>";
        }
        else{
            $sql = "INSERT INTO users VALUES ('','".$_POST['username']."','".$_POST['DOB']."','".$_POST['fullname']."','".$_POST['password']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['creditcard']."','".$_POST['register']."')";
            $result = mysqli_query($connect,$sql);
            if($result){
                echo"<script>alert('Complete register') </script>";
            }
            else{
                echo"<script>alert('Something went wrong, try this later') </script>";
            }
        }
    }
    ?>
    <div class="Registermenu">
        <h1> Sign Up</h1>
        <form action="" method="post" class="RegisterScreen">
            <div class="row">
                <p>Username</p><input type="text" name="username" /><br />
            </div>
            <div class="row">
                <p>Date of birth</p><input type="date" name="DOB" /><br />
            </div>
            <div class="row">
                <p>Fullname</p><input type="text" name="fullname" /><br />
            </div>
            <div class="row">
                <p>Password</p><input type="password" name="password" /><br />
            </div>
            <div class="row">
                <p>RePassword</p><input type="password" name="repassword" /><br />
            </div>
            <div class="row">
                <p>Email</p><input type="email" name="email" /><br />
            </div>
            <div class="row">
                <p>Phone number</p><input type="number" name="phone" /><br />
            </div>
            <div class="row">
                <p>Credit card</p><input type="text" name="creditcard" /><br />
            </div>
            <input type="submit" name="register" value="register" />
        </form>
        <hr />
        <h2> Or sign up using</h2>
        <div class="fastlogin">
            <button onclick="document.location=''">
                <p>Google</p><img src="image/G.png" />
            </button>
            <button onclick="document.location=''">
                <p>Facebook</p><img src="image/F.png" />
            </button>
        </div>
    </div>
    <?php 
        include 'foot.php';
    ?>
</body>

</html>