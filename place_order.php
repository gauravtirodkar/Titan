<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "urbandine");

if (isset($_POST["add_to_cart"])) {
    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if (!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id'            =>    $_GET["id"],
                'item_name'            =>    $_POST["hidden_name"],
                'item_price'        =>    $_POST["hidden_price"],
                'item_quantity'        =>    $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        } else {
            echo '<script>alert("Item Already Added")</script>';
        }
    } else {
        $item_array = array(
            'item_id'            =>    $_GET["id"],
            'item_name'            =>    $_POST["hidden_name"],
            'item_price'        =>    $_POST["hidden_price"],
            'item_quantity'        =>    $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="index.php"</script>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>UrbanDine</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <br />
    <div class="container">
    <?php
    $customer = $_GET['customer'];
    if (!empty($_SESSION["shopping_cart"])) {
        $total = 0;
    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
        $name = $values["item_name"];
        $price = $values["item_price"];
        $quantity = $values["item_quantity"];
        $sql = "INSERT INTO orders (item_name, item_price, item_quantity,c_id)
        VALUES ('$name', '$price', '$quantity','$customer')";  
        if ($connect->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connect->error;
        }          
    }
}
$connect->close();
?>
    </div>

    </div>
    <br />

</body>

<style>
    a {
        color: white;
        text-decoration: none;
    }
</style>

</html>