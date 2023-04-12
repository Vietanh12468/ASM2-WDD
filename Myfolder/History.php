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
    include 'Alert.php';
    if(isset($_POST['deposit_money'])){
        if (!empty($_POST['changingmoney'])){
            $sqltaguser = "SELECT * FROM users WHERE User_Name = '".$_SESSION['User']."'";
            $resultsqltaguser = mysqli_query($connect,$sqltaguser);
            while ($row = mysqli_fetch_assoc($resultsqltaguser)) {
                $Newmoney = $row['Money'] + $_POST['changingmoney'];
            }
            $sqldepositmoney= "update users set Money='$Newmoney' WHERE User_Name='".$_SESSION['User']. "'";
            $resultsqldepositmoney = mysqli_query($connect,$sqldepositmoney);
            if($resultsqldepositmoney){
                $_SESSION['alert'] = "your new money is ". $Newmoney;
                header("Refresh:0");
            }
            else{
                $_SESSION['alert'] = "Something went wrong";
            }
        }
        else{
            $_SESSION['alert'] = "Insert amount of money first";
            header("Refresh:0");
        }
    }
    if(isset($_POST['withdraw_money'])){
        if ($_SESSION['Money'] >= $_POST['changingmoney']){
            if (!empty($_POST['changingmoney'])){
                $sqltaguser = "SELECT * FROM users WHERE User_Name = '".$_SESSION['User']."'";
                $resultsqltaguser = mysqli_query($connect,$sqltaguser);
                while ($row = mysqli_fetch_assoc($resultsqltaguser)) {
                    $Newmoney = $row['Money'] - $_POST['changingmoney'];
                }
                $sqlwithdrawmoney= "update users set Money='$Newmoney' WHERE User_Name='".$_SESSION['User']. "'";
                $resultsqlwithdrawmoney = mysqli_query($connect,$sqlwithdrawmoney);
                if($resultsqlwithdrawmoney){
                    $_SESSION['alert'] = "your new money is ". $Newmoney;
                    header("Refresh:0");
                }
                else{
                    $_SESSION['alert'] = "Something went wrong";
                    header("Refresh:0");
                }
            }
            else{
            }
        }
        else{
            $_SESSION['alert'] = "You are too poor to do this action";
            header("Refresh:0");
        }
    }
    ?>
    <form method="post" class="DepositWithdraw">
        <label>Insert amount of money you want to deposist/withdraw</label>
        <input type="number" name="changingmoney" />$
        <br />
        <input type="submit" name="deposit_money" value="deposit money" />
        <input type="submit" name="withdraw_money" value="withdraw money" />

    </form>
    <main>
        <h2>History</h2>
        <table align="center" draggable="false">
            <tr>
                <th> ID</th>
                <th> Name Tour</th>
                <th> Buy date</th>
                <th> Start date</th>
                <th> Ticket</th>
                <th> Contact</th>
            </tr>
            <?php
            $sqldisplayhistory = "SELECT * FROM history_buy WHERE User_ID = '".$_SESSION['ID']."'";
            $resultdisplayhistory = mysqli_query($connect,$sqldisplayhistory);
            while ($row = mysqli_fetch_assoc($resultdisplayhistory)) {
                $BookTourID = $row['Tour_ID'];
                $Timebook = $row['Time_buy'];
                $Startday = $row['Start_date'];
                $Ticket = $row['number_ticket'];
                $sqlsearchtour = "select * from tour where Tour_ID = '$BookTourID'";
                $resultsqlsearchtour = mysqli_query($connect,$sqlsearchtour);
                while ($row = mysqli_fetch_assoc($resultsqlsearchtour)){
                    $ImageBookTour_ID = $row["ImageTour_ID"];
                    $Tourowner=$row["User_ID"];
                    $Namebooktour = $row["Name_Tour"];
                }
                $sqlsearchtourowner = "select * from users where User_ID = '$Tourowner'";
                $resultsqlsearchtourowner = mysqli_query($connect,$sqlsearchtourowner);
                while ($row = mysqli_fetch_assoc($resultsqlsearchtourowner)){
                    $User_name= $row["User_Name"];
                    $Phone= $row["Phone"];
                    $Email= $row["Email"];
                }
                $sqlsearchmainimage = "select * from imagetour where ImageTour_ID = '$ImageBookTour_ID'";
                $resultsqlsearchmainimage = mysqli_query($connect,$sqlsearchmainimage);
                while ($row = mysqli_fetch_assoc($resultsqlsearchmainimage)){
                    $mainimage= $row["ImageName"];
                }
                echo"
            <tr>
                <td class='IDcolumns'>$BookTourID</td>
                <td class='firstcolumns'>
                    <div class='historybuylist' onclick=\"location.href='ShowTour.php?ID=$BookTourID'\">
                        <img src='image/$mainimage' />
                        <h3>$Namebooktour</h3>
                    </div>
                </td>
                <td class='datecolumns'><h3>$Timebook</h3></td>
                <td class='datecolumns'><h3>$Startday</h3></td>
                <td class='ticketcolumns'><h3>$Ticket</h3></td>
                <td>
                        <h3>$User_name</h3>
                        <h3>Phone: $Phone</h3>
                        <br>
                        <h3>Email: $Email</h3>
                        <br>
                    <div class='btt'>
                        <a href=''>
                            <img src='Image/message.png' />
                            <h5> Message</h5>
                        </a>

                    </div>
                </td>
            </tr>";
            }


            ?>
        </table>
    </main>
    <main>
        <h2>Your tour</h2>
        <button class="Addnewtourbtt" onclick="location.href='AddTour.php'"> Add new tour  </button>
        <button class="Requestremovetourbtt" > Delete tour  </button>
            <table align="center" draggable="false">
            <tr>
                <th> ID</th>
                <th> Name Tour</th>
                <th> Buy date</th>
                <th> Start date</th>
                <th> Ticket</th>
                <th> Contact</th>
            </tr>
                <?php
            $sqldisplayyourtour = "select * from tour where User_ID = '".$_SESSION['ID']."'";
            $resultsqldisplayyourtour = mysqli_query($connect,$sqldisplayyourtour);
            while ($row = mysqli_fetch_assoc($resultsqldisplayyourtour)) {
                $TourID = $row['Tour_ID'];
                $ImageTour_ID = $row["ImageTour_ID"];
                $Nametour = $row["Name_Tour"];
                $sqlsearchtotalbook = "SELECT Tour_ID,COUNT(User_ID) as Total FROM history_buy WHERE Tour_ID='$TourID' GROUP BY Tour_ID";
                $resultsqlsearchtotalbook = mysqli_query($connect,$sqlsearchtotalbook);
                while ($row = mysqli_fetch_assoc($resultsqlsearchtotalbook)){
                    $Total= $row["Total"];
                }
                $sqlsearchmainimage = "select * from imagetour where ImageTour_ID = '$ImageTour_ID'";
                $resultsqlsearchmainimage = mysqli_query($connect,$sqlsearchmainimage);
                while ($row = mysqli_fetch_assoc($resultsqlsearchmainimage)){
                    $mainimage= $row["ImageName"];
                }
                if(mysqli_num_rows($resultsqlsearchtotalbook)<1){
                    echo "
            <tr>
                <td class='IDcolumns'>$TourID</td>
                <td class='firstcolumns'>
                    <div class='historybuylist' onclick=\"location.href='ShowTour.php?ID=$TourID'\">
                        <img src='image/$mainimage' />
                        <h3>$Nametour</h3>
                    </div>
                </td>
                <td colspan='4'> This tour is so bad that nobody book this </td>
            </tr>";
                }
                else{
                    echo"
            <tr>
                <td class='IDcolumns' rowspan='$Total'>$TourID</td>
                <td class='firstcolumns' rowspan='$Total'>
                    <div class='historybuylist' onclick=\"location.href='ShowTour.php?ID=$TourID'\">
                        <img src='image/$mainimage' />
                        <h3>$Nametour</h3>
                    </div>
                </td>";
                    $sqldisplaysellhistory = "SELECT * FROM history_buy WHERE Tour_ID = '$TourID'";
                    $resultselldisplayhistory = mysqli_query($connect,$sqldisplaysellhistory);
                    while ($row = mysqli_fetch_assoc($resultselldisplayhistory)){
                        $Timebook = $row['Time_buy'];
                        $Startday = $row['Start_date'];
                        $Ticket = $row['number_ticket'];
                        $BookUserID =$row['User_ID'];
                        $sqlsearchbookuser = "select * from users where User_ID = '$BookUserID'";
                        $resultsqlsearchbookuser = mysqli_query($connect,$sqlsearchbookuser);
                        while ($row = mysqli_fetch_assoc($resultsqlsearchbookuser)){
                            $User_name= $row["User_Name"];
                            $Phone= $row["Phone"];
                            $Email= $row["Email"];
                        }
                        echo"
                <td class='datecolumns'><h3>$Timebook</h3></td>
                <td class='datecolumns'><h3>$Startday</h3></td>
                <td class='ticketcolumns'><h3>$Ticket</h3></td>
                <td>
                        <h3>$User_name</h3>
                        <h3>Phone: $Phone</h3>
                        <br>
                        <h3>Email: $Email</h3>
                        <br>
                    <div class='btt'>
                        <a href=''>
                            <img src='Image/message.png' />
                            <h5> Message</h5>
                        </a>
                    </div>
                    <br />
                    <div class='btt'>
                        <a href=''>
                            <img src='Image/X.png' />
                            <h5> Cancel order</h5>
                        </a>
                    </div>
                </td>
            </tr>";
                    }
                }
            }



                ?>
        </table>
    </main>
    <?php 
        include 'foot.php';
    ?>
</body>
</html>