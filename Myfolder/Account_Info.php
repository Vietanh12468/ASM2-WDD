<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" href="CSS/Code.css"/>
</head>
<body>
    <?php
    include 'General.php';
    if(!isset($_SESSION['User'])){
        header('location: Mainmenu.php');
        $_SESSION['alert'] = "Login to do this action";
        exit();
    }
    if(isset($_POST['PassChange'])){
        if ($_POST['oldpass'] !=  $Pass){
            echo"<script>alert('Old password is incorrect') </script>";
        }
        elseif (empty($_POST['newpass'])){
            echo"<script>alert('new password can not be empty') </script>";
        }
        elseif($_POST['newpass'] == $_POST['renewpass']){
            $sqlchangepass = "UPDATE users SET PASSWORD= '".$_POST['newpass']."'  WHERE User_Name ='".$username."'";
            $resultsqlchangepass = mysqli_query($connect, $sqlchangepass);
            if($resultsqlchangepass){
                echo"<script>alert('succesfully change password') </script>" ;
            }
            else{
                echo"<script>alert('Something went wrong') </script>";
            }
        }
        else{
            echo"<script>alert('new password is incorrect with retype newpassword') </script>";
        }
    }
    include 'Alert.php';
    $sql = "SELECT * from users WHERE User_Name ='".$_SESSION['User']."'";
    $result = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_assoc($result)){
        $Fullname = $row["Fullname"];
        $Email = $row["Email"];
        $Phone = $row["Phone"];
        $Credit_card = $row["Credit_card"];
        $Pass = $row["PASSWORD"];
    }
    ?>
    <div class="changepassword" id="changepassword">
        <form class="changepasswordscreen" action="" method="post">
            <span onclick="document.getElementById('changepassword').style.display='none'" class="close" title="Close Modal">&times;</span>
            <div class="logoutform">
                <label> Old password </label>
                <input type="text" name="oldpass" placeholder="" />
                <br />
                <label> New password </label>
                <input type="text" name="newpass" placeholder="" />
                <br />
                <label> Retype new password </label>
                <input type="text" name="renewpass" placeholder="" />
                <br />
                <input type="submit" name="PassChange" value="Change password" />
            </div>
        </form>
    </div>
    <main>
        <h1> Account Information</h1>
        <br />
        <img class="profilepic" src="image/Profile_Picture.gif" />
        <?php echo "<h1>" .$_SESSION['User']. "</h1>"; ?>
        <div class="user_info">
            <h2>Fullname: <?php echo $Fullname; ?></h2>
            <h2>Email: <?php echo $Email; ?></h2>
            <h2>Phone: <?php echo $Phone; ?></h2>
            <h2>Credit_card: <?php echo $Credit_card; ?></h2>
            <button href=""> Change your information </button>
        </div>
        <br />
        <h1> Account Setting</h1>
        <div class="other_info">
            <button onclick="document.getElementById('changepassword').style.display='block'" type="button"> Change password </button>
            <button href="" > Delete account </button>
            <button onclick="location.href='ඞ.php'" class="adminmode"> Admin mode </button>
        </div>
    </main>
    <?php 
        include 'foot.php';
    ?>

</body>
</html>