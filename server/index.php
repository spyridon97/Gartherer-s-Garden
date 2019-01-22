<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Εμφάνιση όλων</title>
    <meta name="description" content="Show all products and comments">    
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css">
</head>

<body>

<?php

    include "database_connect.php";
    /*
    
    database_connect.php:
    <?php
    $host = "localhost";
    $username = "ErgasiaB";
    $password = "2019BErgasia";
    $database_in_use = "ergasiab";
    
    $mysqli = new mysqli($host, $username, $password, $database_in_use);
    mysqli_set_charset($mysqli, "utf8");
    ?>
    
    */
    echo "<h1>Emfanish olwn</h1>";
    
    
    $sql = "SELECT Id, Name, Price, Image, Quote, Effect, Casting_Cost FROM products";
    $result = $mysqli->query($sql);
    
    while($row = $result->fetch_assoc()) {   
        
        $bottleimage="<image src='Bottles/".$row["Image"]."'>";
        $iconimage="<image src='Icons/".$row["Image"]."'>";
        $adimage="<image src='Ads/".$row["Image"]."'>";
        echo $bottleimage;
        echo $iconimage;
        if(file_exists("Ads/".$row["Image"]))echo $adimage;//emfanish eikonas ad mono an yparxei
        
        echo"<br>";
        
        echo "<b>Id:</b> " . $row["Id"]."<br>";
        echo "<b> Name: </b>" . $row["Name"]."<br>";
        echo "<b> Price: </b>" . $row["Price"]."<br>";
        echo "<b> Quote: </b>" . $row["Quote"].""."<br>";
        echo "<b> Effect: </b>" . $row["Effect"]."<br>";
        if($row["Casting_Cost"]){//an den exei casting cost tote bgainei to mhnuma passive
            echo "<b> Casting Cost: </b>" . $row["Casting_Cost"]."<br>";
        }else echo"<b> Passive</b>";
        echo "<br>";
        
        $sql = "SELECT Id, Product_Id, Comment_Text, Stars, Date  FROM comments";
        $result2 = $mysqli->query($sql);
    
        while($row2 = $result2->fetch_assoc()) 
            if($row2["Product_Id"]==$row["Id"]){
                echo "<b> Id σχολίου: </b>".$row2["Id"];
                echo "<b> Σχόλιο: </b>".$row2["Comment_Text"];
                echo "<b> Αστέρια: </b>".$row2["Stars"];
                echo "<b> Ημερομηνία: </b>".$row2["Date"];
                echo "<br>";
            }
        }

    $mysqli->close();

?>    

</body>
</html>