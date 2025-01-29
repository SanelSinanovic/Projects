<?php include "utilFunctions.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Bookstore - Delete Author </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet"  href="styles.css">
</head>
<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-container w3-center">
            <h1> Bookstore </h1>
            <h2> Delete Author </h2>
        </header>
        <?php include "mainMenu.php"; ?>
     
        <form action="deleteAuthor.php" method="POST" class="w3-container w3-sand">
            <fieldset> 
                <p><label> Author </label>
                    <select name="author" class="w3-select">
                        <option value="" disabled selected> Choose Author </option>
                        <?php
                            include "connectDatabase.php";

                            $sql = "SELECT * ";
                            $sql .= "FROM author a ";

                            $result= $conn->query($sql);

                            if($result->num_rows > 0)
                                while($row = $result->fetch_assoc())
                                    {
                                        $authorId = $row['author_id'];
                                        $authorFirstName = $row['firstName'];
                                        $authorLastName = $row['lastName'];

                                        echo "<option value='$authorId'>$authorLastName-$authorFirstName</option>";
                                    }

                            $conn->close();
                        ?>
                    </select>
            </fieldset>
            <br>
            <p><input type="submit" name="submit" class="w3-btn w3-blue-grey" value="Delete author"></p>
        </form>

    <div class="w3-container w3-sand">
    <?php 

        if(isset($_POST['submit']))
        {
            if(!isset($_POST['author']))
            {
                echo "You have not entered all the required details. <br>";
                echo "Please go back and try again<br>";
                exit;
            }

            $author_id = $_POST['author'];
            include "connectDatabase.php";

            $author_id = $_POST['author'];
            $sql = "DELETE ";
            $sql .= "FROM book_author ";
            $sql .= "WHERE author_id = '$author_id' ";

            include "connectDatabase.php";

            if($conn->query($sqlBA) === TRUE)
            {
                echo "Book_author record(s) for author_id=$author_id successfully deleted<br>";
            }
            else
                echo "ERROR: ".$sqlBA"<br>".$conn->error;

                $sql = "DELETE *";
                $sql .= "FROM author *";
                $sql .= "WHERE author_id = '$author_id' ";

                if($conn->query($sql) == TRUE)
                {
                    echo "Author record for author_id=$author_id removed successfull!<br>";
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