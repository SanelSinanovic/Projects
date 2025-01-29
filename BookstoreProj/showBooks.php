<?php include "utilFunctions.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Bookstore - Show Books </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet"  href="styles.css">
</head>
<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-container w3-center">
            <h1> Bookstore </h1>
            <h2> All Books </h2>
        </header>
        <?php include "mainMenu.php"; ?>
     
        <div class="container w3-sand">
            <?php
                include "connectDatabase.php";

                $sql = "SELECT b.book_id, b.title, b.price, p.name as publisher_name, a.firstName, a.lastName "; 
                $sql .= "FROM book b "; 
                $sql .= "JOIN publisher p ON p.publisher_id = b.publisher_id "; 
                $sql .= "JOIN book_author ba ON b.book_id = ba.book_id "; 
                $sql .= "JOIN author a ON a.author_id = ba.author_id";

                $result = $conn->query($sql);

                if($result->num_rows > 0)
                {
                    echo "<table class='w3-table w3-striped'>";
                    echo "  <tr class='w3-teal'>";
                    echo "      <th> ID </th>";
                    echo "      <th> Title </th>";
                    echo "      <th> Author </th>";
                    echo "      <th> Price </th>";
                    echo "      <th> Publisher </th>";
                    echo "  </tr>";

                    while($row=$result->fetch_assoc())
                    {
                        echo "<tr>";
                        echo "  <td>".$row['book_id']."</td>";
                        echo "  <td>".$row['title']."</td>";
                        echo "  <td>".$row['firstName']." ".$row['lastName']."</td>";
                        echo "  <td>".$row['price']."</td>";
                        echo "  <td>".$row['publisher_name']."</td>";
                        echo " </tr>";
                     }
                echo "</table>";
                    }
                        $conn->close();
                ?>
    </div>
    </div>
</body>
</html>