<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <style>
        main{
            height:auto;
            max-height:5000px;
        }
    </style>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" href="CSS/Code.css" />
</head>
<body>
    <?php
    include 'General.php';
    include 'Alert.php';
    if(isset($_POST['DeleteTour'])){
        $sqldeletetour= "DELETE from tour WHERE Tour_ID ='".$_POST['ownerID']."'";
        $resultsqldeletetour = mysqli_query($connect,$sqldeletetour);
        if($resultsqldeletetour){
            $_SESSION['alert'] = "Delete complete";
            header("Refresh:0");
        }
        else{
            $_SESSION['alert'] = "Something went wrong";
        }
    }
    if(isset($_POST['DeleteAcc'])){
        $sqldeleteuser= "DELETE from users WHERE User_ID ='".$_POST['AccID']."'";
        $resultsqldeleteuser = mysqli_query($connect,$sqldeleteuser);
        if($resultsqldeleteuser){
            $_SESSION['alert'] = "Delete complete";
            header("Refresh:0");
        }
        else{
            $_SESSION['alert'] = "Something went wrong";
        }
    }
    if(isset($_POST['Addmoney'])){
        if (!empty($_POST['AccID'])){
            $sqladdmoney= "SELECT Money,User_Name FROM users WHERE User_ID='".$_POST['AccID']."'";
            $resultsqladdmoney = mysqli_query($connect,$sqladdmoney);
            while ($row = mysqli_fetch_assoc($resultsqladdmoney)) {
                $Newmoney = $row['Money'] + $_POST['money'];
                $Accusername = $row["User_Name"];
            }
            $sqladdmoney= "update users set Money='$Newmoney' WHERE User_ID='". $_POST['AccID']. "'";
            $resultsqladdmoney = mysqli_query($connect,$sqladdmoney);
            if($resultsqladdmoney){
                $_SESSION['alert'] = "$Accusername new money is ". $Newmoney;
                header("Refresh:0");
            }
            else{
                $_SESSION['alert'] = "Something went wrong";
            }
        }
        else{
            $_SESSION['alert'] = "Something went wrong";
        }
    }
    if(isset($_POST['Addcategory'])){
        $sqladdcategory = "INSERT INTO category VALUES ('','".$_POST['category']."')";
        $resultsqladdcategory = mysqli_query($connect,$sqladdcategory);
        if($resultsqladdcategory){
            $_SESSION['alert'] = "Add Category complete";
            header("Refresh:0");
        }
        else{
            $_SESSION['alert'] = "Something went wrong";
        }
    }
    if(isset($_POST['Removecategory'])){
        $sqladdcategory = "DELETE from category WHERE Category_ID = '".$_POST['CategoryID']."'";
        $resultsqladdcategory = mysqli_query($connect,$sqladdcategory);
        if($resultsqladdcategory){
            $_SESSION['alert'] = "Remove Category complete";
            header("Refresh:0");
        }
        else{
            $_SESSION['alert'] = "Something went wrong";
        }
    }
    ?>
    <main id='1' class='adminmain'>
        <h2> Tour manager</h2>
        <div class="form_searchadmin">
            <form action="" method="get" >
                <input type="text" name="search1"/>
                <input type="submit" value="Search" />
            </form>
        </div>
        <?php
        if (isset($_GET['search1'])){
        $sqlsearchtour = "SELECT * FROM tour WHERE Name_Tour LIKE '%".$_GET['search1']."%' or Tour_ID LIKE '%".$_GET['search1']."%'";
        $resultsqlsearchtour = mysqli_query($connect,$sqlsearchtour);
        $i =0;
        echo"        <h2>search result</h2>";
        while ($row = mysqli_fetch_assoc($resultsqlsearchtour)) {
            $Tour_ID = $row["Tour_ID"];
            $User_ID = $row["User_ID"];
            $ImageTour_ID = $row["ImageTour_ID"];
            $Name_Tour = $row["Name_Tour"];
            $Price = $row["Price"];
            $location = $row["location"];
            $sqlsearchmainimage = "select * from imagetour where ImageTour_ID = '$ImageTour_ID'";
            $resultsqlsearchmainimage = mysqli_query($connect,$sqlsearchmainimage);
            while ($row = mysqli_fetch_assoc($resultsqlsearchmainimage)){
                $mainimage= $row["ImageName"];
            }
            $sqluser = "SELECT * FROM users WHERE User_ID = '$User_ID'";
            $resultsqluser = mysqli_query($connect,$sqluser);
            while ($row = mysqli_fetch_assoc($resultsqluser)){
                $User_name= $row["User_Name"];
            }
            echo "
        <div class='box' onmousedown=\"document.getElementsByClassName('box')[$i].style.backgroundColor ='black'\" onclick=\"document.getElementById('owner_ID').value='".$Tour_ID."'\">
            <div class='boximg'>
                <img src='image/$mainimage' />
            </div>
            <h3> $Name_Tour </h3>
            <h4> location: $location </h4>
            <h5> Price: $Price $</h5>
            <h5> User: $User_name </h5>
        </div>";
            $i++;
        }
    }
        ?>
        <form method="post" class="Deletetour">
            <input type="hidden" id="owner_ID" name="ownerID" value="" />
            <input type="submit" name="DeleteTour" value="Delete Tour" />
            <input type="submit" value="Delete All Tour From this account" />
        </form>
    </main>
    <main id='2' class='adminmain'>
        <h2> Account manager</h2>
        <div class="form_searchadmin">
            <form action="" method="get">
                <input type="text" name="search2" />
                <input type="submit" value="Search" />
            </form>
        </div>
        <?php
        if (isset($_GET['search2'])){
        $i = 0;
        $sqlsearchuser = "SELECT * FROM users WHERE User_ID like '%".$_GET['search2']."%' or User_Name like '%".$_GET['search2']."%' or Email LIKE '%".$_GET['search2']."%' or Phone LIKE '%".$_GET['search2']."%'";
        $resultsqlsearchuser = mysqli_query($connect,$sqlsearchuser);
        echo"        <h2>Search result </h2>";
        while ($row = mysqli_fetch_assoc($resultsqlsearchuser)) {
            $User_ID = $row["User_ID"];
            $User_Name = $row["User_Name"];
            $Fullname = $row["Fullname"];
            $Email = $row["Email"];
            $Credit_card = $row["Credit_card"];
            $Money = $row["Money"];
            echo "
        <div class='box' onmousedown=\"document.getElementsByClassName('box')[$i].style.backgroundColor ='black'\" onclick=\"document.getElementById('Acc_ID').value='".$User_ID."'\">
            <h3> $User_Name </h3>
            <h4> Fullname: $Fullname </h4>
            <h5> Email: $Email $</h5>
            <h5> Credit card: $Credit_card </h5>
            <h5> Money: $Money $</h5>
        </div>";
        }
        $i++;
    }
        ?>
        <form method="post" class="AdminAcc">
            <input type="hidden" id="Acc_ID" name="AccID" value="" />
            <label>Insert money here</label>
            <input type="number" name="money">
            <label>$</label>
            <input type="submit" name="Addmoney" value="Add Money" />
            <input type="submit" name="Removemoney" value="Remove Money" />
            <input type="submit" name="DeleteAcc" value="Delete This Account" />
        </form>
    </main>
    <main id='3' class='adminmain'>
        <h2> Manage Category</h2>
        <form method="post" class="categoryadmin">
            <input type="hidden" id="Category_ID" name="CategoryID" value="" />
            <label>insert category here</label>
            <input type="text" name="category" />
            <input type="submit"  name="Addcategory" value=" Add category" />
            <input style="float:right" type="submit" name="Removecategory" value="Remove category" />
        </form>
        <hr>
        <?php
        $i =0;
        $sqlcategory = "SELECT * FROM category";
        $resultsqlcategory = mysqli_query($connect,$sqlcategory);
        while ($row = mysqli_fetch_assoc($resultsqlcategory)) {
            $Category_ID = $row['Category_ID'];
            $Information_Category = $row['Information_Category'];
            echo "
        <div class='category_tag' onmousedown=\"document.getElementsByClassName('category_tag')[$i].style.backgroundColor ='black'\" onclick=\"document.getElementById('Category_ID').value='".$Category_ID."'\">
            <h4> $Category_ID | $Information_Category </h4>
        </div>";
        $i++;
        }
        ?>
    </main>
    <?php 
        include 'foot.php';
    ?>
</body>
</html>
