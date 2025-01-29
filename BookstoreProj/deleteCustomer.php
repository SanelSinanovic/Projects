<?php include "utilFunctions.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Delete Customer </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet"  href="styles.css">
</head>
<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-container w3-center">
            <h1> Bookstore </h1>
            <h2> Delete Customer </h2>
        </header>
        <?php include "mainMenu.php"; ?>
     
        <form action="deleteCustomer.php" method="POST" class="w3-container w3-sand">
            <fieldset> 
                <label> Customer </label>
                    <select name="customer" class="w3-select">
                        <option value="" disabled selected> Choose customer </option>
                        <?php
                            include "connectDatabase.php";

                            #select customers who do not have orders
                            $sql = "SELECT c.customer_id, c.firstName, c.lastName ";
                            $sql .= "FROM customer c LEFT JOIN orders o ";
                            $sql .= "ON c.customer_id = o.customer_id ";
                            $sql .= "WHERE o.order_id IS NULL ";

                            $result= $conn->query($sql);

                            if($result->num_rows > 0)
                                while($row = $result->fetch_assoc())
                                    {
                                        $customer_id = $row['customer_id'];
                                        $customerFirstName = $row['firstName'];
                                        $customerLastName = $row['lastName'];

                                        echo "<option value='$customerId'>$customerId-$customerLastName,$customerFirstName</option>";
                                    }

                            $conn->close();
                        ?>
                    </select>
                    <br>
                    <b> NOTE </b>: Only customers with no orders can be deleted.
            </fieldset>
            <br>
            <input type="submit" name="submit" class="w3-btn w3-blue-grey" value="Delete customer">
        </form>

    <div class="w3-container w3-sand">
    <?php 

        if(isset($_POST['submit']))
        {
            if(!isset($_POST['customer']))
            {
                echo "You have not entered all the required details. <br>";
                echo "Please go back and try again<br>";
                exit;
            }

            $customer_id = $_POST['customer'];
            include "connectDatabase.php";

            $sql = "DELETE ";
            $sql .= "FROM customer ";
            $sql .= "WHERE customer_id = '$customer_id' ";

            if($conn->query($sql) === TRUE)
                {
                    echo "Customer record for customer_id=$customer_id successfully deleted<br>";
                }
                else
                    {
                     echo "ERROR: ".$sql."<br>".$conn->error;
                        }
            $conn->close();
        }
        
       
    ?> 
    </div>

    </div>
</body>
</html>