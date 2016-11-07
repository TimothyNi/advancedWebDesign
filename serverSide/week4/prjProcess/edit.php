<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
	<!-- presentation.php - This is the presentation file for the client Red Door Burgers
		Written by: Timothy Niccum
		Class: CSC 235 ServerSide Development
		Written:	10-1-16
		Revised:
	-->	
	<title>Form Page for Red Door Burgers.</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css" />
	<?PHP

		// Returning user or new?
		if(isset($_POST['hdnArrayLen'])) {
   
		echo 'Welcome Back';

		// Get the array that was stored as a session variable
		   $lookupArray = unserialize(urldecode($_SESSION['serializedArray'])); 
		   // Store the new values from the request form into the array
		   // Extract how many length of array
		   $arrayLen = $_POST['hdnArrayLen']; 
		   for($index=0; $index<$arrayLen; $index++) {

			 $lookupArray[$index] = $_POST['txtBurger' . $index];
		   }
		   // Remember as session variable
		   $_SESSION['serializedArray'] = urlencode(serialize($lookupArray));

		}
		else { 
		   // new visit, initialize array
		   $lookupArray = array ("Sample Burger","Sample Weekly Beer List");
		   // Remember this data
		   $_SESSION['serializedArray'] = urlencode(serialize($lookupArray));
		}
		?>
	</head>
	<body>
	<body>
<h1>Sample Burger of the Month and Weekly Beer List Editor</h1>

<?PHP
// display the data using a table containing text boxes for Burgers
echo '<form id="frmBurger" method="POST" action="index.php" />';
echo '<table border="1"><tr><th>Menu Item</th><th>Special</th></tr>';
for($index = 0; $index<count($lookupArray); $index++) {
   echo '<tr><td>' . $index . '</td><td>';
   echo '<input type="text" name="txtBurger' . $index . '" id="txtBurger' . $index 
   . '" value="' . $lookupArray[$index] . '" />';
   echo '</td></tr>';
}
echo '</table><br /><br />';
echo '<input type="submit" value="Save" />';
// Tell the server how many rows are in the array using a hidden field
echo '<input type="hidden" name="hdnArrayLen" value="' . count($lookupArray) . '" />';
echo '</form>';
?>
<h3>Here is a link to the Presentation page:</h3>
   			<p><a href="http://timothyniccum.com/webAdminTim/Individual/presentation.php" target="_blank">Red Door Burgers Presentation Page</a></p>
</body>
</html>