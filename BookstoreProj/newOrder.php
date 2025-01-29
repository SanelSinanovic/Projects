<?php include "utilFunctions.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Bookstore - New Order </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet"  href="styles.css">
</head>
<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-container w3-center">
            <h1> Bookstore </h1>
            <h2> New Order </h2>
        </header>
        <?php include "mainMenu.php"; ?>
     
        <form action="newOrder.php" method="POST" class="w3-container w3-sand">
            <fieldset> 
                <label> Customer </label>
                <select class="w3-select" name="customer" id="customer">
                    <option value="" disabled selected> Choose customer </option>
                    <?php
                        include "connectDatabase.php";

                        $sql = "SELECT * FROM customer";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0)
                            while ($row = $result->fetch_assoc())
                            {
                                $customer_id = $row['customer_id'];
                                $lastName = $row['lastName'];
                                $firstName = $row['firstName'];
                                $address = $row['address'];
                                $city = $row['city'];
                                $state = $row['state'];
                                $zip = $row['zip'];

                                echo "<option value='$customer_id'>$customer_id";
                                echo "|$lastName, $firstName";
                                echo "|$address; $city; $state; $zip";
                                echo "</option>";
                            }
                        $conn->close();
                        ?>
                    </select>

                   <label> Selected book(s) </label>
                   <input name= "booksSel" id="booksSel" value="None" type="hidden">
                   <select class="w3-select" name="listBooksSel" id="listBooksSel">
                    
                        </select>
                        <input class="w3-button w3-teal w3-round-large" value="Remove book" onclick='removeBook()'>
                        <br><br>

                        <div class="container w3-khaki w3-padding w3-border-blue-grey w3-leftbar w3-topbar w3-bottombar
                        w3-rightbar">
                            <h3> Book Selection </h3>
                            <label> Avaliable Book(s) </label>
                        <select class="w3-select" id="listBooksAv">
                            <option value="" disabled selected> Choose book </option>
                            <?php
                                include  "connectDatabase.php";
                                $sql = "SELECT * FROM book";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0)
                                    while($row = $result->fetch_assoc())
                                    {
                                        $bookId=$row['book_id'];
                                        $title=$row['title'];
                                        $isbn=$row['ISBN'];
                                        $price=$row['price'];

                                        echo "<option value='$bookId' id='book-$bookId'>$bookId|$title|$isbn|$price</option>";
                                
                                    }
                                    $conn->close();
                            ?>
            <select>
            <label> Quantity </label>
            <input class="w3-input w3-border" type="number" id="quantity" maxlength="30" size="30" />
            
            <input class="w3-button w3-teal w3-round-large" value="Add book" onclick="addBook()">
            <br>
        </div>

        <label> Order Date </label>
            <input class="w3-input w3-border" type="date" id="orderDate" maxlength="30" size="30" />

        <label> Ship Date </label>
            <input class="w3-input w3-border" type="date" id="shipDate" maxlength="60" size="60" />
            
        <label> Shipping Street </label>
            <input class="w3-input w3-border" type="street" id="street" maxlength="60" size="60" />
        
        <label> Shipping Zip </label>
            <input class="w3-input w3-border" type="text" id="zip" maxlength="20" size="20" />
          
        <input class="w3-button w3-teal w3-round-large" value="Copy customer's addess" onclick='copyAddress()'><br>

        <label> Shipping Cost</label>
        <input class="w3-input w3-border" type="text" name="cost" id="cost" maxlength="20" size="20"/>

        </fieldset>

        <p><input class="w3-btn w3-blue-grey" type="submit" value="Add New Order"/> </p>
                                </form>
        
        <div class="container w3-sand">
            <?php
            if(isset($_POST['submit']))
            {
                if(!isset($_POST['customer']) || !isset($_POST['orderDate']) || !isset($_POST['shipDate'])
                || !isset($_POST['street']) || !isset($_POST['city']) || !isset($_POST['state']) || !isset($_POST['zip'])
                || !isset($_POST['cost']) || !isset($_POST['booksSel']))
                    {
                        echo "<p> You have not entered all of the required details.<br/>
                        Please go back and try again.";
                        exit;
                    }
            
                    include "connectDatabase.php";
                    
                    $customer= $_POST['customer'];
                    $orderDate= mysqli_real_escape_string($conn, $_POST['orderDate']);
                    $shipDate= mysqli_real_escape_string($conn, $_POST['shipDate']);
                    $street= mysqli_real_escape_string($conn, $_POST['street']);
                    $city= mysqli_real_escape_string($conn, $_POST['city']);
                    $state= mysqli_real_escape_string($conn, $_POST['state']);
                    $zip= mysqli_real_escape_string($conn, $_POST['zip']);
                    $cost= mysqli_real_escape_string($conn, $_POST['cost']);
                    $booksSel= $_POST['booksSel'];
                    $booksSelArray= explode("|", $boksSel);

                    echo "[debug] booksSel = $booksSel<br>";
                    $sql= "INSERT INTO orders (customer_id, orderDate, shipDate, shipStreet, shipCity, shipState, shipZip, Shipcost) ";
                    $sql .=" VALUES ('$customer','$orderDate','$shipDate','$street','$city','$state','$zip',$cost)";

        
                    if($conn->query($sql) === TRUE)
                    {
                        $order_id = $conn->insert_id;
                        echo "<b> New order created successfully! </b><br>";
                        echo "Order ID: $order_id<br>";
                        echo "Customer ID: $customer<br>";
                        echo "Order Date: " .htc($orderDate)."<br>";
                        echo "Shipping Date: " .htc($shipDate)."<br>";
                        echo "Shipping Cost: " .htc($cost)."<br>";
                        echo "------------| <b>Address</b> |----------<br>";
                        echo "Street: " .htc($street)."<br>";
                        echo "City: " .htc($city)."<br>";
                        echo "State: " .htc($state)."<br>";
                        echo "Zip: " .htc($zip)."<br>";

                        echo "-----------| <br> Item Details</b> |-------<br>";
                        for($i=0; $i< count($booksSelArray); $i++)
                        {
                            if(strlen($booksSelArray[$i]) < 2)
                                continue;

                            $curBookItemArray = explode(";", $booksSelArray[$i]);

                            $curBookId = $curBookItemArray[0];
                            $curBookPrice = $curBookItemArray[1];
                            $curBookQty = $curBookItemArray[3];

                            echo "Item: ".strval($i+1)."<br>";
                            echo "Book ID: $curBookId<br>";
                            echo "Price: $curBookPrice<br>";
                            echo "Quantity: $curBookQty<br>";

                            if(empty($curBookId))
                                continue;

                                $sql="INSERT INTO book_order (book_id, order_id, quantity, paidEach) VALUES
                                ($curBookId, $order_id, $curBookQty, $curBookPrice)";

                            if($conn->query($sql) == TRUE)
                                echo "book_id: $curBookId added successfully<br>";
                            else
                            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                            echo "------------------------<br>";
                        }
                    }
                    else
                    {
                        echo "Error: ".$sql."<br>".$conn->error."<br>";
                    }
                    $conn->close();
                }
    ?> 
    </div>
    </div>
            <script>
                function copyAddress()
                {
                    var selCustomer= document.getElementById('customer');
                    var selCustomerIndex= selCustomer.selectedIndex;
                    var selCustomerInnerHTML= selCustomer[selCustomerIndex].innerHTML;
                    var fullAddressStr= selCustomerInnerHTML.split("|")[2];
                    var fullAddressArray= fullAddressStr.split(';');
                    var address= fullAddressArray[0];
                    var city= fullAddressArray[1];
                    var state= fullAddressArray[2];
                    var zip= fullAddressArray[3];

                    var addressElem = document.getElementById('street');
                    var cityElem = document.getElemenetById('city');
                    var stateElem = document.getElementById('state');
                    var zipElem = document.getElementById('zip');

                    addressElem.value = address;
                    cityElem.value = city;
                    stateElem.value = state;
                    zipElem.value = zip;
                }

                function AddBook()
                {
                    var listSel = deocument.getElementById('listBooksSel');
                    var listAv = document.getElementById('listBooksAv');
                    var qty = document.getElementById('quantity');
            
                    if(listAv.options.length< 1)
                        return;
                    if(qty.value =="")
                        qty.value = 1;

                    var listAvIndex = listAv.selectedIndex;
                    var listAvInner = listAv[listAvIndex].innerHTML;
                    var listAvVal = listAv[listAvIndex].value;

                    listSel.options[listSel.options.length] = new Option(listAvInner+"|"+qty.value, listAvVal);

                    listAv[listAvIndex] = null;

                    sortSelect(listSel);

                    result="";
                    for(i=0; i< listSel.options.length; i++)
                        optArray = listSel.option[i].innerHTML.split("|");
                        price = optArray[3];
                        quantity = optArray[4];
                       
                        result += listSel.options[i].value + ";"+price+";"+quantity+"|";
                }
                    booksSel.value = result;
            }

                function removeBook() {
                    var listSel = deocument.getElementById('listBooksSel');
                    var listAv = document.getElementById('listBooksAv');
                    var booksSel = document.getElementById('booksSel');

                    if(listSel.options.length < 1)
                        return;

                    var listSelIndex = listSel.selectedIndex;
                    var listSelInner = listSel[listSelIndex].innerHTML;
                    var listSelVal = listSel[listSelIndex].value;

                    listAv.options[listAv.options.length] = new Option(listSelInner, listSelVal);

                    listSel[listSelIndex] = null;

                    sortSelect(listAv);

                    result="";
                    selArray = booksSel.value.split('|');
                    for(i= 0; i < .selArray.length; i++)
                        {
                            cutBookArray = selArray[i].split(';');
                    
                            if(cutBookArray[0] != listSelVal)
                                result += selArray[i] + "|";
                        }

                    if(result.slice(-2,-1) == '|')
                        result = result.substr(0,result.length-2);

                        booksSel.value = result;
                </script>
</body>
</html>