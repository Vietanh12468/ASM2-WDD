<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" href="CSS/Code.css" />
</head>
<body>
    <?php
    include 'General.php';
    include 'Alert.php';
    if(isset($_GET["ID"])){
        $Tour_ID = $_GET["ID"];
        $sqlsearchtour = "select * from tour where Tour_ID = '$Tour_ID'";
        $resultsqlsearchtour = mysqli_query($connect,$sqlsearchtour);
        while ($row = mysqli_fetch_assoc($resultsqlsearchtour)){
            $User_ID = $row["User_ID"];
            $ImageTour_ID = $row["ImageTour_ID"];
            $Name_Tour = $row["Name_Tour"];
            $Price = $row["Price"];
            $location = $row["location"];
            $Information = $row["Information"];
            $sqlsearchmainimage = "select * from imagetour where ImageTour_ID = '$ImageTour_ID'";
            $resultsqlsearchmainimage = mysqli_query($connect,$sqlsearchmainimage);
            while ($row = mysqli_fetch_assoc($resultsqlsearchmainimage)){
                $mainimage= $row["ImageName"];
            }
            $sqlsearchuser = "select * from users where User_ID = '$User_ID'";
            $resultsqlsearchuser = mysqli_query($connect,$sqlsearchuser);
            while ($row = mysqli_fetch_assoc($resultsqlsearchuser)){
                $User_name= $row["User_Name"];
                $Phone= $row["Phone"];
                $Email= $row["Email"];
            }
        }
    }
    if(isset($_POST['Book'])){
        if(empty($_POST['startdate']) || $_POST['nticket']<0){
            $_SESSION['alert'] = "Please insert all information";
            header("Refresh:0");
        }
        else if(!isset($_SESSION['User'])){
            $_SESSION['alert'] = "Login to book this tour";
            header("Refresh:0");
        }
        else{
            $startdate = $_POST['startdate'];
            $nticket = $_POST['nticket'];
            $Costnticket = $nticket * $Price;
            if($Costnticket<=$_SESSION['Money']){
                $sqltaguser = "SELECT * FROM users WHERE User_Name = '".$_SESSION['User']."'";
                $resultsqltaguser = mysqli_query($connect,$sqltaguser);
                while ($row = mysqli_fetch_assoc($resultsqltaguser)){
                    $UserID = $row["User_ID"];
                }
                $sqladdticket = "insert into history_buy VALUES ('','$UserID','$Tour_ID',CURDATE(),'$startdate','$nticket')";
                $resultaddticket = mysqli_query($connect, $sqladdticket);
                if($resultaddticket){
                    $Newmoney=$_SESSION['Money']-$Costnticket;
                    $sqladdmoney= "update users set Money='$Newmoney' WHERE User_Name='". $_SESSION['User']. "'";
                    $resultsqladdmoney = mysqli_query($connect,$sqladdmoney);
                    $_SESSION['alert'] = "Succesfully book this tour";
                    header("Refresh:0");
                }
                else{
                    $_SESSION['alert'] = "Cannot book this tour";
                }
            }
            else{
                $_SESSION['alert'] = "You do not have enough money";
            }
        }
    }
    ?>

    <main>
        <?php
        echo "<img src='Image/$mainimage' class=Mainimage />";
        echo "<h2>$Name_Tour</h2>";
        ?>
        <div class="leftmaintour">
            <?php
            echo "<h3> Location: $location</h3>";
            echo "<Br>";
            $sqlsearchcategoryID = "select * from tour_category where Tour_ID = '$Tour_ID'";
            $resultsqlsearchcategoryID = mysqli_query($connect,$sqlsearchcategoryID);
            while ($row = mysqli_fetch_assoc($resultsqlsearchcategoryID)){
                $Category_ID= $row["Category_ID"];
                $sqlsearchcategory = "select * from category where Category_ID= '$Category_ID'";
                $resultsqlsearchcategory = mysqli_query($connect,$sqlsearchcategory);
                while ($row = mysqli_fetch_assoc($resultsqlsearchcategory)){
                    $Information_Category= $row["Information_Category"];
                    echo "<div class='category_tag'><h4>$Information_Category</h4></div>";
                }
            }
            ?>
        </div>
        <div class="rightmaintour">
            <div class="owner">
                 <?php
                 echo "<h3>Owner: $User_name</h3>";
                 ?>
                <div class="btt">
                    <a href="">
                        <img src="Image/message.png" />
                        <h5> Message</h5>
                    </a>
                
                </div>
            </div>
            <div class="Save">
                <h3> Add wishlist</h3>
                <div class="btt">
                    <a href="">
                        <img src="Image/Save.png" />
                        <h5>Add to cart </h5>
                    </a>

                </div>
            </div>
            <div class="Buy">
                <?php
                echo "<h3>Price: $Price $</h3>";
                ?>
                <div class="btt">
                    <a href="">
                        <img src="Image/Shop.png" />
                        <h5>Book now</h5>
                    </a>

                </div>
            </div>
        </div>
        <div class="Info">
            <hr />
            <h1> Information</h1>
            <?php
            echo "<p>$Information</p>";
            ?>
        </div>
        <hr />
        <form class="Buyform" action="" method="post">
            <h2> Booking </h2>
            <div>
                <label> Start day</label>
                <input type="date" name="startdate" />
                <br />
                <br />
                <label> Number of ticket</label>
                <input type="number" name="nticket" />
                <br />
            </div>
            <input type="submit" name="Book" value=" Confirm Book" />
        </form>
    </main>
    <?php 
        include 'foot.php';
    ?>

</body>
</html>