<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "urbandine");

$user = $_SESSION['user'];

if (isset($_POST["add_to_cart"])) {
	if (isset($_SESSION["shopping_cart"])) {
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if (!in_array($_GET["id"], $item_array_id)) {
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		} else {
			echo '<script>alert("Item Already Added")</script>';
		}
	} else {
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
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
				echo '<script>window.location="order.php"</script>';
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


	<nav class="navbar  navbar-collapse navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Urban-Dine</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="#">Home </a></li>
					<li><a href="#">About</a></li>
					<li class="active"><a href="#">Logged In As <?php echo $user;?><span class="sr-only">(current)</span></a></li>
					
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<br />
	<div class="container">
		<br />
		<br />

		<?php
		$query = "SELECT * FROM dishes ORDER BY id ASC";
		$result = mysqli_query($connect, $query);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_array($result)) {
				?>
				<div class="col-md-4">
					<form method="post" action="order.php?action=add&id=<?php echo $row["id"]; ?>">
						<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
							<img src="images/dishes/<?php echo $row["image"]; ?>" class="img-responsive" /><br />

							<h4 class="text-info"><?php echo $row["name"]; ?></h4>

							<h4 class="text-danger">Rs. <?php echo $row["price"]; ?></h4>

							<input type="text" name="quantity" value="1" class="form-control" />

							<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

							<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />

							<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

						</div>
					</form>
				</div>
		<?php
			}
		}
		?>
		<div style="clear:both"></div>
		<br />
		<h3>Order Details</h3>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr>
					<th width="40%">Item Name</th>
					<th width="10%">Quantity</th>
					<th width="20%">Price</th>
					<th width="15%">Total</th>
					<th width="5%">Action</th>
				</tr>
				<?php
				if (!empty($_SESSION["shopping_cart"])) {
					$total = 0;
					foreach ($_SESSION["shopping_cart"] as $keys => $values) {
						?>
						<tr>
							<td><?php echo $values["item_name"]; ?></td>
							<td><?php echo $values["item_quantity"]; ?></td>
							<td>Rs. <?php echo $values["item_price"]; ?></td>
							<td>Rs. <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
							<td><a href="order.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
						</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
						?>
					<tr>
						<td colspan="3" align="right">Total</td>
						<td align="right">Rs. <?php echo number_format($total, 2); ?></td>
						<td></td>
					</tr>
				<?php
				}
				?>

			</table>
		</div>
	</div>
	</div>

	<div class="confirm">
		<button class="btn btn-warning btn-lg"> <a href="bill.php">Confirm Order</a> </button>
	</div>

</body>

</html>

<style>
	.confirm {
		text-align: center;
		padding: 15px;
	}
	body{
		background-color : #F9EEEE;
	}
	
</style>