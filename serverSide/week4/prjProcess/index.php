<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
	<!-- index.php - This is the Menu Page for Red Door Burgers
		Written by: Timothy Niccum
		Class: CSC 235 ServerSide Development
		Written:	10-1-16
		Revised:
	-->
	<title>Red Door Burgers.</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css" />
	
	</head>
	<body>
		<h1 align="center">Red Door Burgers</h1>
		<table align="center">
			<tr>
				<th>Menu Item</th>
				<th>Price</th>
			</tr>
			<tr>
				<td>Reg. Burger</td>
				<td>$6.50</td>
			</tr>
			<tr>
				<td>Cheeseburger</td>
				<td>$7.50</td>
			</tr>
			<tr>
				<td>Double Cheeseburger</td>
				<td>$9.50</td>
			</tr>
			<tr>
				<td>Fries</td>
				<td>$2.50</td>
			</tr>
			<tr>
				<td>Onion Rings</td>
				<td>$3.50</td>
			</tr>
			<tr>
				<td>Soda</td>
				<td>$1.50</td>
			</tr>
		</table>
		<?PHP
			// Display the ID number of the URL selected from the requesting page
			$id = $_GET["id"];
			//echo "The id for this link is " . $id . "<br /><br /><hr />";

			// Set up JSON data for id:link
			$jsonString = '{"1": "Burger Sample", 
						   "2": "Weekly Beer Sample",}';

			// OR, set up array for id=>link
			$lookup = array (
			   "1"=>"Burger Sample",
			   "2"=>"Weekly Beer Sample");

			echo "The Burger and Beer will be: " . $lookup[$id] . "<br />";

			echo '$jsonString is: ' . $jsonString . "<br />";
			//using JSON, convert to an associative array
			$jsonArray = json_decode($jsonString, true);
			echo '$jsonArray is: ';
			var_dump($jsonArray);
			echo "<br />";
			// display the data using a table containing text boxes for Burgers
			echo '<form id="frmBurger" method="POST" action="index1.php" />';
			echo '<table border="1"><table align="center"><tr><th>Menu Item</th><th>Special</th></tr>';
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
			//echo "The Burger and Beer will be: " . $jsonArray[$id] . "<br />";
			echo "<a href='presentation.php'>Return to the presentation</a><br /><hr />";

			// Redirect to the actual web page
			//header( 'Location: http://ibm.com' ) ;
			header( 'Location: ' . $lookup[$id] ) ;
			?>
	</body>	
</html>