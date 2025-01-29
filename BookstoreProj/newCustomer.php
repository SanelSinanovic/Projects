<?php include "utilFunctions.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Customer </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet"  href="styles.css">
</head>
<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-container w3-center">
            <h1> Bookstore </h1>
            <h2> New Customer </h2>
        </header>
        <?php include "mainMenu.php"; ?>
        <form action="newCustomer.php" class="w3-container w3-sand" method="POST">
            <fieldset>
                <label> First Name </label>
                <input type="text" class="w3-input w3-border" name="fName">

                <label> Last Name </label>
                <input type="text" class="w3-input w3-border" name="lName">

                <label> Email </label>
                <input type="text" class="w3-input w3-border" name="email">

                <label> Phone Number </label>
                <input type="text" class="w3-input w3-border" name="phoneNumber">

                <label> Address </label>
                <input type="text" class="w3-input w3-border" name="address">

                <label> City </label>
                <input type="text" class="w3-input w3-border" name="city">

                <label> State </label>
                <input type="text" class="w3-input w3-border" name="state">

                <label> Zip </label>
                <input type="text" class="w3-input w3-border" name="zip">
            </fieldset>
    <br>
    <input type="submit" class="w3-btn w3-blue-grey" name="submit" value="Add new customer">
    </form>    

    <div class="w3-container w3-sand">
       <?php 
        if(isset($_POST['submit']))
        {
            if(!isset($_POST['fName']) || !isset($_POST['lName']) || !isset($_POST['email']) || 
            !isset($_POST['phoneNumber']) || !isset($_POST['address']) ||
            !isset($_POST['city']) || !isset($_POST['state']) || !isset($_POST['zip']))
                {
                    echo "You have not enetered all of the required fields. <br>";
                    echo "Please go back and try again.";
                    exit;
                }
        # everything looks good so far
        #proceed to connect
        include "connectDatabase.php";

        #create short variable names 
        $fName= mysqli_real_escape_string($conn, $_POST['fName']);
        $lName= mysqli_real_escape_string($conn, $_POST['lName']);
        $email= mysqli_real_escape_string($conn, $_POST['email']);
        $phoneNumber= mysqli_real_escape_string($conn, $_POST['phoneNumber']);
        $address= mysqli_real_escape_string($conn, $_POST['address']);
        $city= mysqli_real_escape_string($conn, $_POST['city']);
        $state= mysqli_real_escape_string($conn, $_POST['state']);
        $zip= mysqli_real_escape_string($conn, $_POST['zip']);
        
        #query
        $sql= "INSERT INTO customer (firstName, lastName, email, phoneNumber, address, city, state, zip)
                VALUES ('$fName','$lName','$email','$phoneNumber','$address','$city','$state','$zip')";
        
        if($conn->query($sql)=== TRUE)
        {
            $customer_id = $conn->insert_id; #primary key is auto generated
            echo "<b> customer created successfull! </b><br>";
            echo "Customer id: $customer_id<br>";
            echo "First name: $fName<br>";
            echo "Last name: $lName<br>";
            echo "Phone number: $phoneNumber<br>";
            echo "Email: $email<br>";
            echo "Address: $address<br>";
            echo "City: $city<br>";
            echo "State: $state<br>";
            echo "Zip: $zip<br>";
        }
        else
        {
            echo "Error: Unable to create new customer.".$conn->error."<br>";
            echo $sql;
        }
        
        $conn->close();
    }    
    ?> 
    </div>

    </div>
</body>
</html>