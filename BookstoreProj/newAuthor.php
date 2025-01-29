<?php include "utilFunctions.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Bookstore - New Author </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet"  href="styles.css">
</head>
<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-container w3-center">
            <h1> Bookstore </h1>
            <h2> New Author </h2>
        </header>
        <?php include "mainMenu.php"; ?>
     
        <form action="newAuthor.php" method="POST" class="w3-container w3-sand">
            <fieldset> 
                <label for="name"> First name </label>
                <input class="w3-input w3-border" type="text" name="fName"><br>
                <label for="email"> Last name </label>
                <input class="w3-input w3-border" type="text" name="lName"><br>
            </fieldset>
            <input class="w3-btn w3-blue-grey" type="submit" name="submit" value="Add new author"><br>
        </form>

        <div class="container w3-sand">
            <?php
                if(isset($_POST['submit']))
                {
                    if(!isset($_POST['customer']))
                    {
                        echo "You have not entered all the required details. <br>";
                        echo "Please go back and try again<br>";
                        exit;
                    }
        
                    include "connectDatabase.php";
                    
                    $fName= mysqli_real_escape_string($conn, $_POST['fName']);
                    $lName= mysqli_real_escape_string($conn, $_POST['lName']);

                    $sql= "INSERT INTO author (lastName, firstName) VALUES ('$lastName,$fName')";

        
                    if($conn->query($sql) === TRUE)
                    {
                        $author_id = $conn->insert_id;
                        echo "<br> New author created successfully!</b><br>";
                        echo "Author ID: $author_id<br>";
                        echo "First Name: ".htc($fName)."<br>";
                        echo "Last Name: ".htc($lName)."<br>";
                    }
                    else
                        echo "Error: ".$sql."<br>";
                        echo $conn->error."<br>";
                    
                    $conn->close();
                }
    ?> 
    </div>

    </div>
</body>
</html>