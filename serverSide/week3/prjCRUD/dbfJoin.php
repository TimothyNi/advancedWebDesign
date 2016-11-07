<!DOCTYPE html>
<html lang='en'>
   <head>
   <meta charset="utf-8" />
   <title>Generic Store JOINs</title>
   <link rel="stylesheet" type="text/css" href="stylesheet.css">
   </head>
<body>
<h1>Generic Store Join Testing</h1>
<?PHP
/* dbfJoin.php
             Registration data for the Generic Store
   Written by Timothy Niccum
   Written  9/25/2016
   Revised: ??? 
*/
   
// Set up connection constants
// Using default username and password for AMPPS  
	define("SERVER_NAME","localhost");
	define("DBF_USER_NAME", "root");
	define("DBF_PASSWORD", "mysql");
	define("DATABASE_NAME", "genericStore");

// Create connection object
	$conn = new mysqli('sql305.byethost6.com', 'b6_18853491', 'gizmo616254', 'b6_18853491_databaseWk3');
// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
} 

// Select the database
	$conn->select_db(DATABASE_NAME);

// Display Table:product
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

/* Display specific field names using aliases
		echo "productName and price from prodTable<br />";
		echo "Using aliases<br />";
	// FROM prodTable";
		$sql = "SELECT productName AS 'Product Name', price AS 'Price' FROM prodTable";
		$result = $conn->query($sql);
		displayResult($result, $sql);
		echo "<br />";*/
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

// JOIN (INNER JOIN by default)
		echo "JOIN<br />";
		echo "(This INNER JOIN was pretty simple.  SELECT * FROM prodTable JOIN deptTable ON prodTable.prod_ID = deptTable.dept_ID)<br />";
			$sql = "SELECT * FROM prodTable 
			JOIN deptTable
			ON prodTable.prod_ID = deptTable.dept_ID";
			$result = $conn->query($sql);
			displayResult($result, $sql);
		echo "<br />";

// LEFT INNER JOIN
// Inner join shows what is common between tables.
// Consequently, a LEFT INNER and RIGHT INNER
// both give the same result.
		echo "LEFT INNER JOIN<br />";
		echo "(SELECT * FROM prodTable JOIN deptTable ON prodTable.prod_ID = deptTable.dept_ID)<br />";
			$sql = "SELECT * FROM prodTable 
			JOIN deptTable
			ON prodTable.prod_ID = deptTable.dept_ID";
			$result = $conn->query($sql);
			displayResult($result, $sql);
		echo "<br />"; 

// RIGHT INNER JOIN
		echo "RIGHT INNER JOIN<br />";
		echo "(SELECT * FROM prodTable JOIN deptTable ON prodTable.prod_ID = deptTable.dept_ID)<br />";
			$sql = "SELECT * FROM prodTable 
			JOIN deptTable
			ON prodTable.prod_ID = deptTable.dept_ID";
			$result = $conn->query($sql);
			displayResult($result, $sql);
		echo "<br />";

// INNER JOIN THREE TABLES
		echo "INNER JOIN 3 TABLES<br />";
		echo "(SELECT * FROM prodTable JOIN deptTable ON prodTable.prod_ID = deptTable.dept_ID JOIN manuTable ON prodTable.prod_ID = manuTable.manu_ID)<br />";
		$sql = "SELECT * FROM prodTable 
			JOIN deptTable
			ON prodTable.prod_ID = deptTable.dept_ID
			JOIN manuTable
			ON prodTable.prod_ID = manuTable.manu_ID";
			$result = $conn->query($sql);
			displayResult($result, $sql);
		echo "<br />"; 

// LEFT OUTER JOIN
		echo "LEFT OUTER JOIN (Left table: prodTable)<br />";
		echo "(This one was hard, but I got it select from prodTable, and then LEFT JOIN deptTable: SELECT * FROM prodTable LEFT JOIN deptTable ON prodTable.prod_ID = deptTable.dept_ID)<br />";
			$sql = "SELECT * FROM prodTable 
			LEFT JOIN deptTable
			ON prodTable.prod_ID = deptTable.dept_ID";
			$result = $conn->query($sql);
			displayResult($result, $sql);
		echo "<br />";

// RIGHT OUTER JOIN
		echo "RIGHT OUTER JOIN (Right table: deptTable)<br />";
		echo "(This one was hard, but I got it select from prodTable, and then RIGHT JOIN deptTable: SELECT * FROM prodTable RIGHT JOIN deptTable ON prodTable.prod_ID = deptTable.dept_ID)<br />";
			$sql = "SELECT * FROM deptTable 
			LEFT JOIN prodTable
			ON prodTable.prod_ID = deptTable.dept_ID";
			$result = $conn->query($sql);
			displayResult($result, $sql);
		echo "<br />";
// Close the database
$conn->close();


/********************************************
 * displayResult( ) - Execute a query and display the result
 * Parameters: $rs  - Result set to display as 2D array
 *             $sql - SQL string used to display an error msg
 ********************************************/
function displayResult($result, $sql) {
  if ($result->num_rows > 0) {
      echo "<table border='1'>\n";
      // print headings (field names)
      $heading = $result->fetch_assoc( );
      echo "<tr>\n";
      // print field names 
      foreach($heading as $key=>$value){
         echo "<th>" . $key . "</th>\n";
      }
      echo "</tr>\n";
      
      // Print values for the first row
      echo "<tr>\n";
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
<p>INNER JOIN compares two tables and only returns results where a match exists.
 The 1st table items are duplicated when they match multiple results in the 2nd.
OUTER JOIN compares two tables and returns data when a match is available otherwise it posts a NULL. 
Similar to INNER JOIN, this will duplicate rows in the one table when it matches more than one record in the other table. 
OUTER JOINS tend to make result sets larger, because they won't by themselves remove any records from the set. 
You must also qualify an OUTER join to determine when and where to add the NULL values.  
LEFT means keep all records from the 1st table no matter what and insert NULL values when the 2nd table doesn't match.
RIGHT means keep all records from the 2nd table no matter what and insert NULL values into the 1st table when it doesn't match.
 </p>
</body>
</html>