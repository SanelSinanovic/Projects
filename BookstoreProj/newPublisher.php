<?php include "utilFunctions.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Bookstore - New Publisher </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet"  href="styles.css">
</head>
<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-container w3-center">
            <h1> Bookstore </h1>
            <h2> New Publisher </h2>
        </header>
        <?php include "mainMenu.php"; ?>
     
        <form action="newPublisher.php" method="POST" class="w3-container w3-sand">
            <fieldset> 
                <label for="name"> Name </label>
                <input class="w3-input w3-border" type="text" name="name"><br>
                
                <label for="email"> Email </label>
                <input class="w3-input w3-border" type="text" name="email"><br>

                <label for="phone"> Phone </label>
                <input class="w3-input w3-border" type="text" name="phoneNumber"><br>
            </fieldset>
            <input class="w3-btn w3-blue-grey" type="submit" name="submit" value="Add new publisher"><br>
</form>
<div class="container w3-sand">
    <?php
        if(isset($_POST['submit']))
        {
            if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['phoneNumber']))
                {
                    echo "<p> You have not entered all of the required details.<br/>
                    Please go back and try again.";
                    exit;
                }
        
                include "connectDatabase.php";
                
                $name= $_POST['name'];
                $email= $_POST['email'];
                $phoneNumber= $_POST['phoneNumber'];

                $sql= "INSERT INTO publisher (name, email, phoneNumber) VALUES ('$name','$email','$phoneNumber')";

                if($conn->query($sql) === TRUE)
                    {
                        echo "<b> New order created successfully! </b><br>";
                        echo "Name: ".htc($name)."<br>";
                        echo "Email: ".htc($email)."<br>";
                        echo "Phone: ".htc($phoneNumber)."<br>";
                    }
                    else
                    {
                        echo "Error: ".$sql."<br>";
                        echo $conn->error."<br>";
                    }
                    $conn->close();
        }
        ?>
    </div>
    </div>
</body>
</html>