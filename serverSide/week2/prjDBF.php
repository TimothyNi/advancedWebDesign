<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<!-- prjDBF.html - Demonstrate using SELECT to display data
Timothy Niccum
Written:   9/18/2016
Revised:
-->
<title>Generic Store</title>

<link rel="stylesheet" type="text/css" href="stylesheet.css">
<?PHP
// Set up constants for each table format
	define('prodTable', '0');
	define('deptTable', '1');
	define('manuTable', '2');
	$tableFormat = prodTable;
	$sql = 'SELECT * FROM prodTable';
// Is this a return visit?
if(array_key_exists('hidIsReturning',$_POST)) {
            echo '<h1>Welcome back to Generic Store!</h1>';
            //print_r($_POST);
            echo '<br />';
	 // display the list of music works based on the selection
            if(isset($_POST['lstDisplay'])) {
		// Save item that was selected by the user
                $selection = $_POST['lstDisplay'];
              //  echo 'DEBUG $selection: ' . $selection . '<br />';
                switch($selection) {
                    case "prodTable": {
                        $tableFormat=prodTable;
                        $sql = "SELECT * FROM prodTable ORDER BY productName";
                        break;
                    }
                    case "deptTable": {
                        $tableFormat=deptTable;
						$sql= "SELECT * FROM deptTable ORDER BY department";
                        break;
                    }
                    case "manuTable": {
                        $tableFormat=manuTable;
						$sql= "SELECT * FROM manuTable ORDER BY manufacturer";
                        break;
                    }
					case "genStore": {
                        $tableFormat=genStore;
						$sql= "SELECT * FROM genStore ORDER BY productName";
                        break;
                    }
				    
                    default: echo $selection .
                        ' is not a valid choice from the list of displays<br />';
						
                }// end of switch( )
				 } // if(isset( ))
}
else // or, a first time visitor?
{
	echo '<h1>Welcome first time to Generic Store</h1>';
} // end of if new else returning

function displayData( ) {
		global $sql;
		global $tableFormat;
		//echo 'DEBUG: $sql: ' . $sql . '<br />';
		// Create a database object
		// PARAMETERS:   server       user    password database
		//$db = new mysqli('sql305.byethost6.com', 'b6_18853491', 'gizmo616254', 'b6_18853491_database');
	  
		if($db->connect_errno > 0){
		 die('Unable to connect to database [' . $db->connect_error . ']');
		}
		
		// Get the data from the database using SQL
		if(!$result = $db->query($sql)){
		 die('There was an error running the query [' . $db->error . ']');
		}
		// Display the records in a table
// while($row = $result->fetch_assoc()){
// echo $row['title'] . '<br />';
// }
switch($tableFormat) {
	case prodTable:
	{
		echo '<h2>Product List</h2>';
			echo '<table>';
			echo '<tr>';
			echo '<th>Product Name</th>';
			echo '<th>Price</th>';
			echo '<th>Product Page</th>';
			echo '</tr>';

		while($row = $result->fetch_assoc( )){
			echo '<tr>';
			echo '<td><strong>' . $row['productName'] . '</strong></td>';
			echo '<td>' . $row['price'] . '</td>';
		$link = $row['productPage'];
			echo '<td><a href="' . $link . '" target="_blank">'
		. $link . '</a></td>';
			echo '</tr>';
}
echo '</table>';
		break;
	}

	case deptTable:
{
	echo '<h2>List of Departments</h2>';
	echo '<table>';
	echo '<tr>';
	echo '<th>Departments</th>';
	echo '<th>Department Managers</th>';
	echo '</tr>';

	while($row = $result->fetch_assoc( )){
		echo '<tr>';
		echo '<td>' . $row['department'] . '</td>';
		echo '<td>' . $row['departmentManager'] . '</td>';
		echo '</tr>';
}
echo '</table>';
break;
}

	case manuTable:
	{
	echo '<h2>Manufacturers</h2>';
	echo '<table>';
	echo '<tr>';
	echo '<th>Manufacturers</th>';
	echo '<th>Manufacturer Websites</th>';
	echo '</tr>';

	while($row = $result->fetch_assoc( )){
		echo '<tr>';
		echo '<td>' . $row['manufacturer'] . '</td>';
		$link = $row['manufacturerWebsite'];
			echo '<td><a href="' . $link . '" target="_blank">'
		. $link . '</a></td>';
		echo '</tr>';
}
echo '</table>';
break;
}
case genStore:
	{
	echo '<h2>All Information</h2>';
	echo '<table>';
	echo '<tr>';
	echo '<th>Product Name</th>';
	echo '<th>Price</th>';
	echo '<th>On Hand Qauntity</th>';
	echo '<th>Departments</th>';
	echo '<th>Manufacturers</th>';
	echo '</tr>';

	while($row = $result->fetch_assoc( )){
			echo '<tr>';
			echo '<td><strong>' . $row['productName'] . '</strong></td>';
			echo '<td>' . $row['price'] . '</td>';
		echo '<td>' . $row['onHandQauntity'] . '</td>';
		echo '<td>' . $row['department'] . '</td>';
		echo '<td>' . $row['manufacturer'] . '</td>';
		echo '</tr>';
}
echo '</table>';
break;
}
	default:
	echo $tableFormat . ' is not a valid table format.<br />';
} // end of switch( )
		
		echo '<br />Total results: ' . $result->num_rows;

		// Close the database object
		$db->close;
	} // end of displayData( )
?>

</head>
<body>
<div id="frame">
<!--<h1>Generic Store</h1>-->
<form name="frmDBF"
action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>'
method="POST">
<strong>What information would you like to view?</strong>
<!-- Use JavaScript to automatically submit the selection -->
<select name="lstDisplay" onchange="this.form.submit()">
<option value="null">Select an item</option>
<option value="prodTable">Products</option>
<option value="deptTable">Departments</option>
<option value="manuTable">Manufacturers</option>
<option value="genStore">All Info</option>

</select>

<!-- set up alternative button in case JavaScript is not active -->
<noscript>
&nbsp; &nbsp; &nbsp;
<input type="submit" name="btnSubmit" value="View the list" />
<br /><br />
</noscript>

<!-- Use a hidden field to tell server if return visitor -->
<input type="hidden" name="hidIsReturning" value="true" />
</form>
<?PHP
displayData( );
?>

</div>
<p><strong>Steps taken during this project:</strong></p>
<ol>
<li>The first step I took was to draw a <a href="http://timothyniccum.byethost6.com/week2/graphics/ERD.png">ERD</a>, and set up the <a href="http://timothyniccum.byethost6.com/week2/graphics/prjDBFDesign.png">Excel files</a> for myself to work off of.  This was very important. </li>
<li>The next thing I did was open phpMyAdmin and start setting up the database I was hoping to us. </li>
<li>After struggles to get the database together, I then jumped into the coding my page to get the dropdown menus to work.</li>
<li>A couple of hours later I was able to breathe again, and then try to get my database set up on my server.</li>
<li>Then I got it all put together.  I am happy.</li>
</ol>
</body>
</html>