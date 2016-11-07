<?php
 // For Tracking the Session Variables
 session_start( );
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css">
		<!-- prjWebForm - Assignment01 - Week 01 CSC235
			Timothy Niccum	niccumt@csp.edu
			Written: 9-11-16
		-->
	<title>Cat Food Preferences</title>
</head>
<body>
<?php
// The filename of the currently executing script to be used
// as the action=" " attribute of the form element.
$self = $_SERVER['PHP_SELF'];

//For checking if this is the first time someone has visited.
if(array_key_exists('hidSubmitFlag', $_POST))
{
 echo "<h2>Welcome back!</h2>";
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
 echo "<h2>Welcome to the cat food description.</h2>";
 // If this is the first time a person has come to the page, we will have to create this array below.
 $invenArray = array( );
 $invenArray[0][0] ="Fancy Feast";
 $invenArray[0][1] ="Wet Food Can";
 $invenArray[0][2] ="0.75";
 $invenArray[0][3] ="7";
 $invenArray[1][0] ="Whisker Lickens";
 $invenArray[1][1] ="Dry Treat Bag";
 $invenArray[1][2] ="3.00";
 $invenArray[1][3] ="9";
 $invenArray[2][0] ="Merrik";
 $invenArray[2][1] ="Wet Food Can";
 $invenArray[2][2] ="1.25";
 $invenArray[2][3] ="10";
 // This array needs to be saved for future use, or the next time we load the page.
 $_SESSION['serializedArray'] = urlencode(serialize($invenArray));
}
// We're going to put in the bones of the add and delete here:
function addRecord( )
{
 global $invenArray;
 // We have to place the items that can be added here.
 $invenArray[ ] = array($_POST['txtBrand'],
 $_POST['txtType'],
 $_POST['txtPrice'],
 $_POST['txtQty']);
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
 echo "<th>Brand</th>";
 echo "<th>Type</th>";
 echo "<th>Price</th>";
 echo "<th>Enjoyment Level 1 - 10</th>";
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
 <!-- This is a picture taken in my kitchen on my cell phone. -->
<img src="graphic/catfood.jpg" alt="photo of my cats Fancy Feast" height="125" width="150">
 <!-- Getting into the buiding blocks of the HTML -->
<h1>Different Types of Cat Food</h1>
<h2>Their prices, and how my cats enjoy them:</h2>
<?php displayInventory( ); ?>
</p>
<form action="<?php $self ?>"
 method="POST"
 name="frmAdd">
<!-- In this section, we build the area we use to add items to the table -->
 <fieldset id="fieldsetAdd">
 <legend>Add an Cat Food</legend>

 <label for="txtBrand">Brand:</label>
 <input type="text" name="txtBrand" id="txtBrand" value="Brand" />
 <br /><br />

 <label for="txtType">Type:</label>
 <input type="text" name="txtType" id="txtType" value="Type" />
 <br /><br />

 <label for="txtPrice">Price:</label>
 <input type="text" name="txtPrice" id="txtPrice" value="1.00" />
 <br /><br />

 <label for="txtQty">Enjoyment Level 1 - 10:</label>
 <input type="text" name="txtQty" id="txtQty" value="10" size="5" />
 <br /><br />
 <input type='hidden' name='hidSubmitFlag' id='hidSubmitFlag' value='01' />
 <input name="btnSubmit" type="submit" value="Add this information" />
 </fieldset>
</form>
<br /><br />
<form action="<?php $self ?>"
 method="POST"
 name="frmDelete">

 <fieldset id="fieldsetDelete">
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
 <input name="btnSubmit" type="submit" value="Delete this selection" />
 </fieldset>
</form>
<p style="font-size:10px;font-weight:200;">
 Photo by Timothy Niccum in My Kitchen <a href="http://timothyniccum.byethost6.com/graphic/catfood.jpg" target="_blank"></a>
</p>
</body>
</html>