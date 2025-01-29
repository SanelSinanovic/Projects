<?php include "utilFunctions.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Bookstore - Delete Book </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet"  href="styles.css">
</head>
<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-container w3-center">
            <h1> Bookstore </h1>
            <h2> Delete Book </h2>
        </header>
        <?php include "mainMenu.php"; ?>
     
        <form action="deleteBook.php" method="POST" class="w3-container w3-sand">
            <fieldset> 
                <p><label> Book </label>
                    <select name="book" class="w3-select">
                        <option value="" disabled selected> Choose Book </option>
                        <?php
                            include "connectDatabase.php";

                            $sql = "SELECT * ";
                            $sql .= "FROM book b ";

                            $result= $conn->query($sql);

                            if($result->num_rows > 0)
                                while($row = $result->fetch_assoc())
                                    {
                                        $customer_id = $row['book_id'];
                                        $customerFirstName = $row['title'];

                                        echo "<option value='$bookId'>$bookID-$bookTitle</option>";
                                    }

                            $conn->close();
                        ?>
                    </select>
            </fieldset>
            <br>
            <p><input type="submit" name="submit" class="w3-btn w3-blue-grey" value="Delete Book"></p>
        </form>

    <div class="w3-container w3-sand">
    <?php 

        if(isset($_POST['submit']))
        {
            if(!isset($_POST['book']))
            {
                echo "You have not entered all the required details. <br>";
                echo "Please go back and try again<br>";
                exit;
            }

            $book_id = $_POST['book'];
            $sql = "DELETE ";
            $sql .= "FROM book_author ";
            $sql .= "WHERE book_id = '$book_id' ";

            include "connectDatabase.php";

            if($conn->query($sqlBA) === TRUE)
            {
                echo "Book_author record(s) for author_id=$book_id successfully deleted<br>";
            }
            else
             echo "ERROR: ".$sqlBA."<br>".$conn->error;

                $sql = "DELETE *";
                $sql .= "FROM book ";
                $sql .= "WHERE book_id = '$book_id' ";

                if($conn->query($sql) == TRUE)
                {
                    echo "Book record for author_id=$book_id removed successfully!<br>";
                }
                else
                    echo "Error: ".$sql."<br>".$conn->error;
                $conn->close();
        }
    ?> 
    </div>
    </div>
</body>
</html>