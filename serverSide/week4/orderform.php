<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
<!-- orderform.php - Order Form of Inventory
  Timothy Niccum
  Written:   10-2-2016 
  Revised:   
  -->
 <title>RMT Inventory Order Form</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">


</head>
<body>
<?php
		// Set up connection constants
		// Using default username and password for AMPPS  
		define("SERVER_NAME","localhost");
		define("DBF_USER_NAME", "root");
		define("DBF_PASSWORD", "mysql");
		define("DATABASE_NAME", "orderform");
		// Create connection object
		//$conn = new mysqli('', '', '', '');// The filename of the currently executing script to be used
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
	} 
		// as the action=" " attribute of the form element.
			$self = $_SERVER['PHP_SELF'];

		//For checking if this is the first time someone has visited.
			if(array_key_exists('hidSubmitFlag', $_POST))
	{
			//echo "<h2>Welcome back!</h2>";
		// Check submitFlag, go from there.  If you submit an add or a delete, you we get this welcome back message.
			$submitFlag = $_POST['hidSubmitFlag'];
			$invenArray = unserialize(urldecode($_SESSION['serializedArray']));
			switch($submitFlag)
	{
			case "01": addRecord( );
			break;
			case "99": deleteRecord( );
			break;
			default: displayInventory($invenArray);
			}
		}
		else
	{
			//echo "<h2>Welcome to the RMT Inventory Order Form.</h2>";
		// If this is the first time a person has come to the page, we will have to create this array below.
			$invenArray = array( );
			 $invenArray[0][0] ="Monitor";
			 $invenArray[0][1] ="560";
			 $invenArray[1][0] ="HDD";
			 $invenArray[1][1] ="1000";
			 $invenArray[2][0] ="Mouse";
			 $invenArray[2][1] ="450";
			 $invenArray[3][0] ="Headphones";
			 $invenArray[3][1] ="290";
		// This array needs to be saved for future use, or the next time we load the page.
			$_SESSION['serializedArray'] = urlencode(serialize($invenArray));
	}
		// We're going to put in the bones of the add and delete here:
			function addRecord( )
	{
			global $invenArray;
		// We have to place the items that can be added here.
			$invenArray[ ] = array($_POST['txtItem'],
							$_POST['txtQuant']);
			sort($invenArray);
			$_SESSION['serializedArray'] = urlencode(serialize($invenArray));
		} // end of addRecord( ) section, moving on to the deleteRecord( ) section
		function deleteRecord( )
	{
		global $invenArray;
			global $deleteMe;
			$deleteMe = $_POST['lstItem'];
			unset($invenArray[$deleteMe]);
			$_SESSION['serializedArray'] = urlencode(serialize($invenArray));
		} // end of deleteRecord( )
		function displayInventory( )
	{
		global $invenArray;
		 echo "<table border='1'>";
		 echo "<tr>";
		 echo "<th>Item</th>";
		 echo "<th>Quantity</th>";
		 echo "</tr>";
		 foreach($invenArray as $record)
	{
		echo "<tr>";
		foreach($record as $value)
	{
		echo "<td>$value</td>";
	}
		echo "</tr>";
	}
		echo "</table>";
		} // This is the end of displayInventory( )
	?>

		<h1>Different Items to Order</h1>
			<?php displayInventory( ); ?>

			<form action="<?php $self ?>"
			 method="POST"
			 name="frmAdd">
			<!-- In this section, we build the area we use to add items to the table -->
			 <fieldset id="fieldsetAdd">
			 <legend>Order an Item</legend>

			 <label for="txtItem">Order Item:</label>
			 <input type="text" name="txtItem" id="txtItem" value="Item" />
			 <br /><br />

			 <label for="txtQuant">Quantity:</label>
			 <input type="int" name="txtQuant" id="txtQuant" value="100" />
			 <br /><br />

			 <input type='hidden' name='hidSubmitFlag' id='hidSubmitFlag' value='01' />
			 <input name="btnSubmit" type="submit" value="Order This Item" />
			 </fieldset>
			</form>
			<br /><br />
			<form action="<?php $self ?>"
			 method="POST"
			 name="frmDelete">

			 <!--<fieldset id="fieldsetDelete">
			 <legend>Select an item to delete</legend>
			 <select name="lstItem" size="1">
			 <?php
			 // We fill the dropdown with items from the array above
			 foreach($invenArray as $index => $lstRecord)
			 {
			 // We use $lstRecord[0] so that we can use the Brand.  The [0] is the first column.
			 echo "<option value='" . $index . "'>" . $lstRecord[0] . "</option>\n";
			 }
			 ?>
			 </select>
			 <!-- This field is used to determine if the page has been viewed already-->
			 <input type='hidden' name='hidSubmitFlag' id='hidSubmitFlag' value='99' />
 <br /><br />
		   <!-- <input name="btnSubmit" type="submit" value="Delete this selection" /> -->
 </fieldset>
</body>
</html>