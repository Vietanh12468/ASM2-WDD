<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <style>
    </style>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" href="CSS/Code.css" />
</head>
<body>
    <?php
    include 'General.php';
    include 'Alert.php';
    ?>
    <div class="form_search">
        <form action="Search.php" method="get">
            <input type="text" name="search" placeholder="Search Anywhere" />
            <input type="submit" value="Search" />
        </form>
    </div>


    <main>
        <h1>Search result</h1>
        <hr />
        <?php
        if (isset($_GET['search'])){
            $i = 1;
            $sqlsearchtour = "SELECT * FROM tour WHERE Name_Tour LIKE '%".$_GET['search']."%'";
            $resultsqlsearchtour = mysqli_query($connect,$sqlsearchtour);
            while ($row = mysqli_fetch_assoc($resultsqlsearchtour)) {
                if($i <12){
                    $Tour_ID = $row["Tour_ID"];
                    $ImageTour_ID = $row["ImageTour_ID"];
                    $Name_Tour = $row["Name_Tour"];
                    $Price = $row["Price"];
                    $location = $row["location"];
                    $sqlsearchmainimage = "select * from imagetour where ImageTour_ID = '$ImageTour_ID'";
                    $resultsqlsearchmainimage = mysqli_query($connect,$sqlsearchmainimage);
                    while ($row = mysqli_fetch_assoc($resultsqlsearchmainimage)){
                        $mainimage= $row["ImageName"];
                    }
                    echo "
            <div class='box' onclick=\"location.href='ShowTour.php?ID=".$Tour_ID."'\">
                <div class='boximg'>
                    <img src='image/$mainimage' />
                </div>
                <h3> $Name_Tour </h3>
                <h4> location: $location </h4>
                <h5> Price: $Price $</h5>
            </div>";
                }
                if($i==4 || $i==8  || $i ==12){
                    echo "<hr>";
                }
                $i++;
            }
        }
        ?>
    </main>
    <?php 
        include 'foot.php';
    ?>
</body>
</html>


