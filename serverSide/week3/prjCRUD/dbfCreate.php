<!DOCTYPE html>
<html lang='en'>
   <head>
   <meta charset="utf-8" />
   <title>General Store Create</title>
   <link rel="stylesheet" type="text/css" href="stylesheet.css">
   </head>
<body>
<h1>General Store Test Page</h1>
<?PHP
/* dbfCreate.php - Demonstrate SQL create and populate
             Inventory for the General Store
			 
   Written by Timothy Niccum
   Written: 9/24/2016
   Revised:   
*/
   
// Set up connection constants
// Using default username and password for AMPPS  
	define("SERVER_NAME","localhost");
	define("DBF_USER_NAME", "root");
	define("DBF_PASSWORD", "mysql");
	define("DATABASE_NAME", "genericStore");
// Create connection object
	$conn = new mysqli('sql305.byethost6.com', 'b6_18853491', 'gizmo616254', 'b6_18853491_databaseWk3');
// Start with a new database to start primary keys at 1
$sql = "DROP DATABASE " . DATABASE_NAME;
runQuery($sql, "DROP " . DATABASE_NAME, true);
// Check connection
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Create database if it doesn't exist
	$sql = "CREATE DATABASE IF NOT EXISTS " . DATABASE_NAME;
//	if ($conn->query($sql) === TRUE) {
//    echo "The database " . DATABASE_NAME . " exists or was created successfully!<br />";
//}	else {
//  echo "Error creating database " . DATABASE_NAME . ": " . $conn->error;
//    echo "<br />";
//}
runQuery($sql, "Creating " . DATABASE_NAME, true);
// Select the database
	$conn->select_db(DATABASE_NAME);

/*******************************
 * Create the tables
 *******************************/
// Create Table:prodTable
$sql = "CREATE TABLE IF NOT EXISTS prodTable (
        prod_ID	 	   INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        productName    VARCHAR(25) NOT NULL,
        price     	   VARCHAR(25) NOT NULL,
        productPage    VARCHAR(50) NOT NULL,
        dept_ID    	   INT(11),
		manu_ID	       INT(11)
        )";
	runQuery($sql, "Creating prodTable ", false);


// Create Table:deptTable
 $sql = "CREATE TABLE IF NOT EXISTS deptTable (
     dept_ID    	   INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
     department 	   VARCHAR(25) NOT NULL,
     departmentManager VARCHAR(50) NOT NULL
     )";
runQuery($sql, "Table:deptTable", false);

// Create Table:manuTable
$sql = "CREATE TABLE IF NOT EXISTS manuTable (
     manu_ID    	  INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
     manufacturer     VARCHAR(25) NOT NULL,
     manufacturerPage VARCHAR(50) NOT NULL
     )";
runQuery($sql, "Table:manuTable", false);

// Create Table: genStore
$sql = "CREATE TABLE IF NOT EXISTS genStore (
     gen_ID 		   INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
     productName       VARCHAR(25) NOT NULL,
     price     	       VARCHAR(25) NOT NULL,
	 prod_ID		   INT(25),
	 department 	   VARCHAR(25) NOT NULL,
     departmentManager VARCHAR(50) NOT NULL,
	 dept_ID    	   INT(11)
     )";
runQuery($sql, "Table:genStore", false);

/***************************************************
 * Populate Tables Using Sample Data
 * This data will later be collected using a form.
 ***************************************************/
// Populate Table:prodTable

// Populate the table one record at a time
//$sql = "INSERT INTO prodTable (productName, price, productPage, dept_ID, manu_ID) "
//   . "VALUES('Soft Pillow', '14.99', 'http://MyStore.com/softpillow.php', '3', '2')";
//if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully.<br />";
//} else {
//    echo "<strong>Error:</strong> " . $sql . "<br>" . $conn->error;
//}

$prodTableArray = array(
   array("Plates", "10.99", "http://MyStore.com/plates.php", 1, 1),
   array("Big Plant", "75.99", "http://MyStore.com/bigplants.php", 2, 2),
   array("Fluffy Pillow", "25.99", "http://MyStore.com/fluffypillow.php", 3, 3),
   array("Pet Pillow", "14.99", "http://MyStore.com/petpillow.php", 3, 3)
   );

foreach($prodTableArray as $prodTable) {   
   echo $prodTable[0] . " " . $prodTable[1] . "<br />";
   $sql = "INSERT INTO prodTable (productName, price, productPage, dept_ID, manu_ID) "
       . "VALUES ('" . $prodTable[0] . "', '" 
       . $prodTable[1] . "', '" 
       . $prodTable[2] . "', '"
       . $prodTable[3] . "', '"
	   . $prodTable[4] . "')";
       
    runQuery($sql, "Record inserted for: " . $prodTable[1], false);
} // end of foreach


// Populate Table:deptTable
$deptTableArray = array(
   array("Kitchenware", "Roger Garrison"),
   array("Outdoors", "Shayna Niccum"),
   array("Bedding", "Timothy Niccum"),
   array("Pets", "Rollie St. Claire"),
   array("Living Room", "John Smith")
   );

foreach($deptTableArray as $deptTable) {   
   echo $deptTable[0] . " " . $deptTable[1] . "<br />";
   $sql = "INSERT INTO deptTable (department, departmentManager) "
       . "VALUES ('" . $deptTable[0] . "', '" 
       . $deptTable[1] . "')";
       
    runQuery($sql, "Record inserted for: " . $deptTable[1], false);
} // end of foreach

// Populate Table:manuTable
$manuTableArray = array(
   array("KitchenwareINC","www.kitchenwareINC.com"),
   array("Bedding INC","http://www.beddingINC.com"),
   array("Naturemade", "http://naturemade.com")
   );

foreach($manuTableArray as $manuTable) {   
   echo $manuTable[0] . " " . $manuTable[1] . "<br />";
   $sql = "INSERT INTO manuTable (manufacturer, manufacturerPage) "
       . "VALUES ('" . $manuTable[0] . "', '" 
       . $manuTable[1] . "')";
	   
    runQuery($sql, "Record inserted for: " . $manuTable[1], false);
} // end of foreach

// Populate Table:genStore
// Determine prod_ID for Soft Pillow
/*$sql = "SELECT prod_ID FROM prodTable WHERE productName='Soft Pillow' AND price='14.99'";
$result = $conn->query($sql);
$record = $result->fetch_assoc();
//echo '$record: <pre>';
// print_r($record);
// echo '</pre>';
$thisProduct = $record['prod_ID'];
//echo '$thisProduct: '. $thisProduct . '<br />';

// Determine dept_ID for Shayna Niccum
$sql = "SELECT dept_ID FROM deptTable WHERE department='Outdoors' AND departmentManager='Shayna Niccum'";
$result = $conn->query($sql);
$record = $result->fetch_assoc();
$thisdept_ID = $record['dept_ID'];
//echo '$thisManager: ' . $thisManager . '<br />';*/

/*foreach($prodTableArray as $prodTable) {
    //echo "<strong>Adding $prodTable[0] $prodTable[1]</strong><br />";
    buildgenStore($prod_ID[0], $prod_ID[1], "Soft Pillows
	");
    buildgenStore($prod_ID[0], $prod_ID[1], "Plates");
}*/

/***************************************************
 * Display the tables
 ***************************************************/
echo "All Fields from prodTable<br />";
	echo "(Some Products don't have a Department.)<br />";
		$sql = "SELECT * FROM prodTable";
		$result = $conn->query($sql);
		displayResult($result, $sql);
	echo "<br />";
	if ($result->num_rows > 0) {
	   echo "<table border='1'>\n";
		// print headings (field names)
		  $heading = $result->fetch_assoc( );
		echo "<tr>\n";
      // Print field names as table headings
      foreach($heading as $key=>$value){
         echo "<th>" . $key . "</th>\n";
      }
      echo "</tr>";
      // Print the values for the first row
      echo "<tr>";
      foreach($heading as $key=>$value){
         echo "<td>" . $value . "</td>\n";
      }
    // output rest of the records
		while($row = $result->fetch_assoc()) {
    //print_r($row);
    //echo "<br />";
        echo "<tr>\n";
    // print data
			foreach($row as $key=>$value) {
        echo "<td>" . $value . "</td>\n";
        }
        echo "</tr>\n";
    }
		echo "</table>\n";
// No results
		} else {
		echo "<strong>zero results using SQL: </strong>" . $sql;
	}
 
 // Display Table:department
		echo "All Fields from deptTable<br />";
		echo "(Not every Department has a Product.)<br />";
			$sql = "SELECT * FROM deptTable";
			$result = $conn->query($sql);
			displayResult($result, $sql);
		echo "<br />"; 
		
// Display Table:manufacture
		echo "All Fields from manuTable<br />";
		echo "(Not every Department has a Manufacturer.)<br />";
			$sql = "SELECT * FROM manuTable";
			$result = $conn->query($sql);
			displayResult($result, $sql);
		echo "<br />"; 


// Close the database
$conn->close();

/*************************************************************
 * buildgenStore( ) -   Find Specific Prducts and the Managers of that Department
 * Sets up a table with two foreign keys 
 * connecting Table:prodTable to Table:deptTable
 * Parameters:  $productName - Products name
 *              $price - Price of the product
 *              $department - The name of the department to find it in_array
 **************************************************************/
function buildgenStore($productName, $price, $department) {
global $conn;
   
   // Populate Table:genStore
   // Determine prod_ID
   $sql = "SELECT prod_ID FROM prodTable 
           WHERE productName='" . $productName
           . "' AND price='" . $price . "'";
   $result = $conn->query($sql);
   $record = $result->fetch_assoc();
   $prod_ID = $record['prod_ID'];
   //echo '$thisProduct: ' . $thisProduct;
   
   // Determine dept_ID
  $sql = "SELECT dept_ID FROM deptTable WHERE department='" . $thisdept_ID . "'";
   $result = $conn->query($sql);
   $record = $result->fetch_assoc();
   $dept_ID = $record['dept_ID'];
   //echo ' -- $dept_ID: ' . $dept_ID . '<br />';
      
   // Check to make sure product isn't already in this department
   $sql = "SELECT dept_ID FROM genStore 
     WHERE dept_ID = " . $dept_ID 
     . " AND prod_ID= " . $prod_ID;
   $result = $conn->query($sql);
   
   /* determine number of rows result set */
   $row_count = $result->num_rows;
   if($row_count > 0) {
      echo "prod_ID " . $thisProduct
      . " has already registered for Department " 
      . $thisdept_ID . "<br />";
   } else { // Not a duplicate
      $sql = "INSERT INTO genStore (productName, price, department) 
       VALUES (" . $prod_ID . ", " . $dept_ID . ", 1234, true)";
      runQuery($sql, "Insert " . $gen_ID . " and " . $thisprod_ID, false);
   } // end if($result)
   
} // end of buildgenStore( )

/********************************************
 * displayResult( ) - Execute a query and display the result
 *    Parameters:  $rs - result set to display as 2D array
 *                 $sql - SQL string used to display an error msg
 ********************************************/
function displayResult($result, $sql) {

} // end of displayResult( )


/********************************************
 * runQuery( ) - Execute a query and display message
 *    Parameters:  $sql         -  SQL String to be executed.
 *                 $msg         -  Text of message to display on success or error
 *     ___$msg___ successful.    Error when: __$msg_____ using SQL: ___$sql____.
 *                 $echoSuccess - boolean True=Display message on success
 ********************************************/
function runQuery($sql, $msg, $echoSuccess) {
 global $conn;
    
   // run the query
   if ($conn->query($sql) === TRUE) {
      if($echoSuccess) {
         echo $msg . " successful.<br />";
      }
   } else {
      echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $conn->error;
   }   
} // end of runQuery( ) 
?>

</body>
</html>