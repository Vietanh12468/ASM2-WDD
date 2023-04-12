<?php
    if(isset($_SESSION['alert'])){
        echo"<script>alert('". $_SESSION['alert'] ."') </script>";
        $_SESSION['alert'] = null;
    }
?>