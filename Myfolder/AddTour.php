<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="CSS/Code.css" />
    <title></title>
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
    ?>
    <main>
        <form method="POST" action="" enctype="multipart/form-data" class="AddTour">
            <h1> Create Your Tour </h1>
            <div class="row">
                <label>Name Tour</label>
                <input type="text" name="Nametour" /><br />
            </div>
            <div class="row">
                <label>Price</label>
                <input type="text" name="Price" /><br />
            </div>
            <div class="row">
                <label>Location</label>
                <input type="text" name="Location" /><br />
            </div>
            <div class="row">
                <label>Information</label>
                <textarea name="information" cols="40" rows="5"></textarea>
            </div>
            <div class="row">
                <label>Image</label>
                <input type="file" name="TourImage" /><br />
            </div>
            <hr>
            <h2> Choose category </h2>
            <?php
            $i =0;
            $sqlcategory = "SELECT * FROM category";
            $resultsqlcategory = mysqli_query($connect,$sqlcategory);
            while ($row = mysqli_fetch_assoc($resultsqlcategory)) {
                $Category_ID = $row['Category_ID'];
                $Information_Category = $row['Information_Category'];
                echo "
            <div class='category_tag' onmousedown=\"document.getElementsByClassName('category_tag')[$i].style.backgroundColor ='black'\" onclick=\"addcategorytonewtour('$Category_ID')\">
                <h4> $Information_Category </h4>
            </div>";
                $i++;
            }
            ?>
            <input type="submit" name="Add" value="Add" />
            <input type="hidden" id="Categorychoose" name="Category_choose" />
        </form>

    </main>
    <script>
        const choosecategory = [];
        var i = 0;
        function addcategorytonewtour(a) {
            choosecategory[i] = a;
            i++;
            document.getElementById('Categorychoose').value = choosecategory;
        }
    </script>
</body>
</html>
<?php

if(isset($_POST['Add'])){
		$NameTour = $_POST['Nametour'];
		$Price = $_POST['Price'];
        $Location = $_POST['Location'];
        $Information = $_POST['information'];
		$Tour_image = $_FILES['TourImage']['name'];
		$Tour_image_tmp = $_FILES['TourImage']['tmp_name'];
		move_uploaded_file($Tour_image_tmp, "Image/$Tour_image");
        $sqlimage = "INSERT INTO ImageTour VALUES('','$Tour_image')";
		$resultsqlimage = mysqli_query($connect,$sqlimage);
        $sqltagimage = "select * from imagetour where ImageName = '$Tour_image'";
        $resultsqltagimage = mysqli_query($connect,$sqltagimage);
        while ($row = mysqli_fetch_assoc($resultsqltagimage)){
            $TagimgID = $row["ImageTour_ID"];
        }
        $sqltaguser = "SELECT * FROM users WHERE User_Name = '".$_SESSION['User']."'";
        $resultsqltaguser = mysqli_query($connect,$sqltaguser);
        while ($row = mysqli_fetch_assoc($resultsqltaguser)){
            $UserID = $row["User_ID"];
        }
        $sql = "INSERT INTO tour VALUES('','$UserID','$TagimgID','$NameTour','$Price','$Location','$Information')";
		$result = mysqli_query($connect,$sql);
        if($result){
            echo"<script>alert('Add success') </script>";
        }
        else{
            echo"<script>alert('Something went wrong, can't add tour') </script>";
        }
        $sqltagtour = "SELECT * FROM tour WHERE User_ID = '$UserID' and Name_Tour ='$NameTour'";
        $resultsqltagtour = mysqli_query($connect,$sqltagtour);
        while ($row = mysqli_fetch_assoc($resultsqltagtour)){
            $TourID = $row["Tour_ID"];
        }
        $Categorys = ($_POST['Category_choose']);
        $Category = explode(",", $Categorys);
        $Categorylength = count($Category);
        for($x = 0; $x < $Categorylength; $x++) {
            $sqltagcategory = "INSERT INTO tour_category VALUES ('$Category[$x]','$TourID')";
            $resultsqltagcategory = mysqli_query($connect,$sqltagcategory);
        }
    }
    include 'foot.php';

?>