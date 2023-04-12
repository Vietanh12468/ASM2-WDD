
    <?php
    session_start();
    $connect = mysqli_connect("localhost","root","","toursellerhtml");
    if(isset($_POST['Login'])){
        $username = $_POST['username'];
        $password = $_POST['Pass'];
        $sql = "SELECT * from users WHERE User_Name = '$username' and PASSWORD ='$password'";
        $result = mysqli_query($connect, $sql);
        if(mysqli_num_rows($result)===1){
            if($result){
                $_SESSION['alert'] = "Login successfully";
                $_SESSION['User'] = $username;
                header('location: Mainmenu.php');
                exit();
            }
        }
        else{
            $_SESSION['alert'] = "Incorrect password or username";
        }
    }
    if (isset($_SESSION['User'])){
        $showmoney= "SELECT * FROM users WHERE User_Name='".$_SESSION['User']."'";
        $resultshowmoney = mysqli_query($connect,$showmoney);
        while ($row = mysqli_fetch_assoc($resultshowmoney)) {
            $_SESSION['Money'] = $row['Money'];
            $_SESSION['ID'] = $row['User_ID'];
        }
    }
    if(isset($_POST['Logout'])){
        unset($_SESSION['User']);
        unset($_SESSION['Money']);
        unset($_SESSION['ID']);
        $_SESSION['alert'] = "Logout successfully";
    }
?>
    <div class="menu">
        <div class="leftmenu">
            <a href="MainMenu.php">
                <img src="image/logo.png" />
            </a>
        </div>
        <div class="leftmenu2">
            <ul>
                <li>
                    <a href="">New Tour</a>
                </li>
                <li>
                    <a href="" class="category">Category</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
            </ul>
        </div>
        <div class="rightmenu">
            <ul>
                <li>
                    <a>
                        <?php
                        if(!isset($_SESSION['User']))
                        {
                            echo "<span onclick=\"document.getElementById('login').style.display='block'\" class=\"open\" style=\"width:auto;\">Login</span>";
                        }
                        else {
                            echo "<span onclick=\"document.getElementById('logout').style.display='block'\" class=\"open\" style=\"width:auto;\">Logout</span>";
                        ?>
                    </a>
                </li>
                <li>
                    <a href="History.php"> Money: <?php echo $_SESSION['Money'] ?>$</a>
                </li>
                <li>
                    <a href="Account_Info.php">
                        <?php echo $_SESSION['User'];
                        } ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="empty"></div>
    <div id="login" class="login">
        <form class="loginScreen" action="" method="post">
            <span onclick="document.getElementById('login').style.display='none'" class="close" title="Close Modal">&times;</span>
            <div class="loginform">
                <label> Username </label>
                <input type="text" name="username" placeholder="123@mail.com" />
                <br />
                <label> Password </label>
                <input type="password" name="Pass" placeholder="..." />
                <br />
                <input type="submit" name="Login" value="Login" />
                <p>
                    Forget password, press<a href=""> here </a>
                </p>
                <p>
                    Don't have an account yet sign up <a href="Register.php"> here </a>
                </p>
            </div>
        </form>

    </div>
    <div id="logout" class="logout">
        <form class="logoutScreen" action="" method="post">
            <span onclick="document.getElementById('logout').style.display='none'" class="close" title="Close Modal">&times;</span>
            <div class="logoutform">
                <label> Are you sure want to logout </label>
                <input type="submit" name="Logout" value="logout" />
            </div>
        </form>
    </div>
    