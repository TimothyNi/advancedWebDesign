<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
<!-- registrationPrepared.php - Register new racers - edit, delete using prepared statements
  File provided for Lesson 10
  -->
<title>SunRun Registration</title>
<link rel="stylesheet" type="text/css" href="registration.css">

<?PHP
   // Set up connection constants
   // Using default username and password for AMPPS  
   define("SERVER_NAME","localhost");
   define("DBF_USER_NAME", "root");
   define("DBF_PASSWORD", "mysql");
   define("DATABASE_NAME", "sunRun");
   // Global connection object
   $conn = NULL;

   // Link to external library file
   //echo "PATH:" . getcwd( ) . "sunRunLib.php" . "<br />";
   // Need the / because getcwd( ) does not add it at the end of the path
   require_once(getcwd( ) . "/sunRunLib.php");   
   // Connect to database
   createConnection();
    // Is this a return visit?
    if(array_key_exists('hidIsReturning',$_POST)) {
        //echo '<h1>Welcome BACK</h1>';
        echo "<hr /><strong>\$_POST: </strong>";
        print_r($_POST);
        echo "<br />";
        
        // Get the array that was stored as a session variable
        // Used to populate the HTML textboxes using JavaScript DOM
        $thisRunner = unserialize(urldecode($_SESSION['sessionThisRunner']));

        // Did the user select a runner from the list?
        // 'new' is the value of the first item on the runner listbox 
        if(isset($_POST['lstRunner']) && !($_POST['lstRunner'] == 'new')){
           /* Original unsafe SQL - extracting runner and sponsor information
           $sql = "SELECT runner.id_runner, fName, lName, phone, gender, sponsorName 
           FROM runner 
           LEFT OUTER JOIN sponsor ON runner.id_runner = sponsor.id_runner 
           WHERE runner.id_runner =" . $_POST['lstRunner'];
           
           $result = $conn->query($sql);
          */
        
           $idRunner = $_POST['lstRunner'];
           $sql = "SELECT id_runner, fName, lName, phone, gender FROM Runner WHERE id_runner=?";
           
           // Set up a prepared statement
           if($stmt = $conn->prepare($sql)) {
              // Pass the parameters
              $stmt->bind_param("i", $idRunner);
              if($stmt->errno) {
                displayMessage("stmt prepare( ) had error.", "red" ); 
              }
              
               // Execute the query
               $stmt->execute();
               if($stmt->errno) {
                 displayMessage("Could not execute prepared statement", "red" );
               }
                                
               // Optional - Download all the rows into a cache
               // When fetch( ) is called all the records will be downloaded
               $stmt->store_result( );
                                
               // Get number of rows 
               //(only good if store_result( ) is used first)
               $rowCount = $stmt->num_rows;
                                
               // Bind result variables
               // one variable for each field in the SELECT
               // This is the variable that fetch( ) will use to store the result
               $stmt->bind_result($idRunner, $fName, $lName, $phone, $gender);
               
               // Fetch the value - returns the next row in the result set
               while($stmt->fetch( )) {
                // output the result
                echo("The id is: "     . $idRunner . "<br />");
                echo("The fName is: "  . $fName    . "<br />");
                echo("The lName is: "  . $lName    . "<br />");
                echo("The phone is: "  . $phone    . "<br />");
                echo("The gender is: " . $gender   . "<br />");
                echo("Row count is: "  . $rowCount . "<br />");
               }
               
               // Free results
               $stmt->free_result( );
               
               // Close the statement
               $stmt->close( );
                 
            } // end if( prepare( ))
            
           // Create an associative array mirroring the record in the HTML table
           // This will be used to populate the text boxes with the current runner info
           $thisRunner = [
               "id_runner" => $idRunner,
               "fName" => $fName,
               "lName" => $lName,
               "phone" => $phone,
               "gender"=> $gender
            ];

          // Save array as a serialized session variable
          $_SESSION['sessionThisRunner'] = urlencode(serialize($thisRunner));
           //echo "<hr /><strong>DEBUG \$thisRunner Array: </strong>";
           //print_r($thisRunner);
        } // end if lstRunner
        
        // Determine which button may have been clicked
        switch($_POST['btnSubmit']){
// = = = = = = = = = = = = = = = = = = = 
// DELETE  
// = = = = = = = = = = = = = = = = = = = 
case 'delete':
 //displayMessage("DELETE button pushed.", "green");
 
 //Make sure a runner has been selected.
 if($_POST["txtFName"] == "") {
    displayMessage("Please select a runner's name.", "red");
 } else {
    //We are going to Work on this part to make it more safe.
    // $sql = "DELETE FROM runner WHERE id_runner = " . $thisRunner["id_runner"];
    
    // $sql for prepared statement
    $sql = "DELETE FROM runner WHERE id_runner = ?";
    // Prepare
    if($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("i", $thisRunner['id_runner']);
        if($stmt->errno) {
          displayMessage("stmt prepare( ) had error.", "red" ); 
        }
        
        // Execute the query
        $stmt->execute();
        if($stmt->errno) {
           displayMessage("Could not execute prepared statement", "red" );
        }
                         
        // Free results
        $stmt->free_result( );
        
        // Close the statement
        $stmt->close( );
        
   } // end if( prepare( ))
    
    $result = $conn->query($sql);
    // Remove any records in Table:sponsor
    $sql = "DELETE FROM sponsor WHERE id_runner = " . $thisRunner["id_runner"];
             $result = $conn->query($sql); 
             if($result) {
                displayMessage($thisRunner['fName'] . " " . $thisRunner['lName'] . " deleted.", "green");
             }
          }
          // Zero out the current selected runner
          clearThisRunner( );
          break;
        // = = = = = = = = = = = = = = = = = = = 
        // ADD NEW RUNNER 
        // = = = = = = = = = = = = = = = = = = = 
        case 'new':
          //displayMessage("ADD NEW RUNNER button pushed.", "green");
          
          // Check for duplicate names using fName, lName, and phoneNumber
          // Original unsafe SQL
          /* $sql = "SELECT COUNT(*) AS total FROM runner 
           WHERE fName='" . $_POST['txtFName'] . "'
           AND   lName='" . $_POST['txtLName'] . "'
           AND   phone='" . unformatPhone($_POST['txtPhone']) . "'";
          */
          // Get the data from the POST request
          // Used to check for duplicates as well as to INSERT a new record
           $fName = $_POST['txtFName'];
           $lName = $_POST['txtLName'];
           $phone = unformatPhone($_POST['txtPhone']);
           $gender = $_POST['lstGender'];
           
           $sql = "SELECT fName, lName, phone FROM runner WHERE fName=? AND lName=? AND phone=?";

           // Set up a prepared statement
           if($stmt = $conn->prepare($sql)) {
                 // Pass the parameters
                 echo "\$fName is: $fName<br />";
                 echo "\$lName is: $lName<br />";
                 echo "\$phone is: $phone<br />";
                 $stmt->bind_param("sss", $fName, $lName, $phone) ;
                 if($stmt->errno) {
                   displayMessage("stmt prepare( ) had error.", "red" ); 
                 }
                 
                 // Execute the query
                 $stmt->execute();
                 if($stmt->errno) {
                    displayMessage("Could not execute prepared statement", "red" );
                 }
                 
                 // Store the result
                 $stmt->store_result( );
                 $totalCount = $stmt->num_rows;
                                  
                 // Free results
                 $stmt->free_result( );
                 // Close the statement
                 $stmt->close( );
            } // end if( prepare( ))
           
           echo "<hr /><strong>DEBUG TotalCount: </strong>";
           echo $totalCount . "<hr />";
           
           // Runner already registered?
           if($totalCount > 0) {
              displayMessage("This runner is already registered.", "red");
           }  
           //No duplicates
           else { 
              // Check for empty name fields or phone 
              if ($_POST['txtFName']=="" 
                  || $_POST['txtFName']==""
                  || $_POST['txtPhone']=="") {
                displayMessage("Please type in a first and last name and a phone number.", "red");
              }
              // First name and last name are populated
              else {
              // Add to Table:runner
              // Original Unsafe SQL
              /* $sql = "INSERT INTO runner (id_runner, fName, lName, phone, gender)
              VALUES (NULL, '" 
              . $_POST['txtFName'] ."', '" 
              . $_POST['txtLName'] ."', '"
              . unformatPhone($_POST['txtPhone']) ."', '"
              . $_POST['lstGender']."')";
              */
              
              $sql = "INSERT INTO runner (id_runner, fName, lName, phone, gender) VALUES (NULL, ?,?,?,?)";
              // Set up a prepared statement
              if($stmt = $conn->prepare($sql)) {
                    // Pass the parameters
                    $stmt->bind_param("ssss", $fName, $lName, $phone, $gender) ;
                    if($stmt->errno) {
                      displayMessage("stmt prepare( ) had error.", "red" ); 
                    }
                    
                    // Execute the query
                    $stmt->execute();
                    if($stmt->errno) {
                       displayMessage("Could not execute prepared statement", "red" );
                    }
                    
                    // Store the result
                    $stmt->store_result( );
                    $totalCount = $stmt->num_rows;
                                     
                    // Free results
                    $stmt->free_result( );
                    // Close the statement
                    $stmt->close( );
               } // end if( prepare( ))

                           //This is the area we are working on
						   
            /*  $sql = "INSERT INTO sponsor (id_sponsor, sponsorName, id_runner)
              VALUES (NULL,'" .$_POST['txtSponsor'] ."', 
                 (SELECT id_runner 
                    FROM runner 
                    WHERE fName='" . $_POST['txtFName'] . "' 
                    AND lName='"   . $_POST['txtLName'] . "'
                  )
               )";
			VALUES (NULL,'" . $_POST['txtSponsor'] . "', " . tempID . ")";
			   */
			   $sql = "INSERT INTO sponsor (id_sponsor, sponsorName, id_runner) VALUES (?, ?, tempID)";
				
                 ("SELECT id_runner FROM tempID AS runner WHERE fName=? AND lName=?"
                  );
               
			   if($stmt = $conn->prepare($sql)) {
              // Pass the parameters
                      echo "\$id_sponsor is: $id_sponsor<br />";
					  echo "\$sponsorName is: $sponsorName<br />";
				      echo "\$id_runner is: $id_runner<br />";
					  echo "\$fName is: $fName<br />";
					  echo "\$lName is: $lName<br />";
					  
					$stmt->bind_param("isiss", $id_sponsor, $sponsorName, $id_runner, $fName, $lName) ;
					  
                    if($stmt->errno) {
                      displayMessage("stmt prepare( ) had error.", "red" ); 
                    }
                    
                    // Execute the query
                    $stmt->execute();
                    if($stmt->errno) {
                       displayMessage("Could not execute prepared statement", "red" );
                    }
                    
                    // Store the result
                    $stmt->store_result( );
                    $totalCount = $stmt->num_rows;
                                     
                    // Free results
                    $stmt->free_result( );
                    // Close the statement
                    $stmt->close( );
               } // end if( prepare( ))
			 
             // Zero out the current selected runner
             clearThisRunner( );
           } // end of if/else($total > 0)
           break;
		   }
        // = = = = = = = = = = = = = = = = = = = 
        // UPDATE   
        // = = = = = = = = = = = = = = = = = = = 
        case 'update':
          //displayMessage("UPDATE button pushed.", "green");
          // Check for empty name 
         if ($_POST['txtFName']=="" || $_POST['txtLName']=="") {
            displayMessage("Please select a runner's name.", "red");
         }
         // First name and last name are selected
         else {
             $isSuccessful = false;
             // Update Table:runner
             // Hard-coded test SQL 
             // Make sure value for id_runner exists in Table:runner.
             //$sql = "UPDATE runner SET fName='FirstTest',
             //                          lName='LastTest',
             //                           phone='1112223333'
             //                          WHERE id_runner = 4";
			 
			 
			 
			 //We are working on below this.
			 
           /*  $sql = "UPDATE runner SET fName='" . $_POST['txtFName'] . "', "
             . " lName = '" . $_POST['txtLName'] . "', "
             . " phone = '" . unformatPhone($_POST['txtPhone']) . "', "
             . " gender = '" . $_POST['lstGender'] . "' 
             WHERE id_runner = " . $thisRunner['id_runner'];*/
			 
			 //We are working on above this.
			  mysqli_close($conn);
				createConnection();
				// Set up the SQL String, calling a stored procedure
				$sql = 'call runnerUpdate()';
				// Run the stored procedure
				$result = $conn->query($sql);
				// Extract out information from the array, storing each item in the dropdown list
					while($row = $result->fetch_assoc()) {  
				echo "<option value='" . $row['id_runner'] . "'>" . $row['name'] . "</option>\n";
			}
				// Close the stored procedure connection and reopen a new one
				// for other SQL calls
				mysqli_close($conn);
				createConnection();
			  
			 
			 
             $result = $conn->query($sql);
             if($result) {
                $isSuccessful = true;
             }
             // Update Table:sponsor
             // !!!! Does not update sponsor unless an entry already exists in the table !!!!
             $sql = "UPDATE sponsor SET sponsorName='" . $_POST['txtSponsor'] . "' WHERE id_runner = " . $thisRunner['id_runner'];
             $result = $conn->query($sql);
             if(!$result) {
                $isSuccessful = false;
             }
             // If successful update the variables
             if($isSuccessful) {
                displayMessage("Update successful!", "green");
                $thisRunner['id_runner'] = $_POST['id_runner'];
                $thisRunner['fName']  = $_POST['txtFName'];
                $thisRunner['lName']  = $_POST['txtLName'];
                $thisRunner['phone']  = unformatPhone($_POST['txtPhone']);
                $thisRunner['gender'] = $_POST['lstGender'];
                $thisRunner['sponsor']= $_POST['txtSponsor'];
   
                // Save array as a serialized session variable
                $_SESSION['sessionThisRunner'] = urlencode(serialize($thisRunner));
             }
          }
          // Zero out the current selected runner
          clearThisRunner( );
          break;
       } // end of switch( )
       
    }
    else // or, a first time visitor?
    {
        //echo '<h1>Welcome FIRST TIME</h1>';
    } // end of if new else returning
?>

</head>
<body>
<div id="frame">
<h1>SunRun Registration</h1>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
      method="POST"
      name="frmRegistration"
      id="frmRegistration">

     <label for="lstRunner"><strong>Select Runner's Name</strong></label>

     <select name="lstRunner" id="lstRunner" onChange="this.form.submit();">
        <option value="new">Select a name</option>
        <?PHP
           // Loop through the runner table to build the <option> list
              $sql = "SELECT id_runner, CONCAT(fName,' ',lName) AS 'name' 
                      FROM runner ORDER BY lName";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {    
                echo "<option value='" . $row['id_runner'] . "'>" . $row['name'] . "</option>\n";
           }
           
           /* **** The call to the stored procedure will go here ***** */
		/*// Close out existing connection
      // Create a new one for the stored procedure
      mysqli_close($conn);
      createConnection();
      // Set up the SQL String, calling a stored procedure
      $sql = 'call getRunnerList()';
      // Run the stored procedure
      $result = $conn->query($sql);
      // Extract out information from the array, storing each item in the dropdown list
      while($row = $result->fetch_assoc()) {  
         echo "<option value='" . $row['id_runner'] . "'>" . $row['name'] . "</option>\n";
      }
      // Close the stored procedure connection and reopen a new one
      // for other SQL calls
      mysqli_close($conn);
      createConnection();*/









        ?>
   </select> 
   &nbsp;&nbsp;<a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">New</a>
   <br />
   <br />
   
   <fieldset>
      <legend>Runner's Information</legend>
            
      <div class="topLabel">
         <label for="txtFName">First Name</label>
         <input type="text" name="txtFName"   id="txtFName"   value="<?php echo $thisRunner['fName']; ?>" />
         
      </div>
      
      <div class="topLabel">
         <label for="txtLName">Last Name</label>
         <input type="text" name="txtLName"   id="txtLName"   value="<?php echo $thisRunner['lName']; ?>" />
      </div>
      
      <div class="topLabel">
         <label for="txtPhone">Phone</label>
         <input type="text" name="txtPhone"   id="txtPhone"   value="<?php echo formatPhone($thisRunner['phone']); ?>" />
      </div>
      
      <div class="topLabel">
         <label for="lstGender">Gender</label>
         <select name="lstGender" id="lstGender">
            <option value="female">Female</option>
            <option value="male">Male</option>
         </select> 
      </div>
      
      <div class="topLabel">
         <label for="txtSponsor">Sponsor</label>
         <input type="text" name="txtSponsor" id="txtSponsor" value="<?php echo $thisRunner['sponsor']; ?>" />
      </div>
   </fieldset>
   
   <br />
   <button name="btnSubmit" 
           value="delete"
           style="float:left;"
           onclick="this.form.submit();">
           Delete
   </button>
          
   <button name="btnSubmit"    
           value="new"  
           style="float:right;"
           onclick="this.form.submit();">
           Add New Runner Information
   </button>
          
   <button name="btnSubmit" 
           value="update" 
           style="float:right;"
           onclick="this.form.submit();">
           Update
   </button>
   <br />     
  <!-- Use a hidden field to tell server if return visitor -->
  <input type="hidden" name="hidIsReturning" value="true" />
</form>
<br /><br />
<h2>Registered Runners</h2>
<?PHP
   displayRunnerTable( );
   echo "<br />"; 
?>
<script>
   // Populate the drop-down box with current value
   document.getElementById("lstGender").value = "<?PHP echo $thisRunner['gender']; ?>";
</script>
<h2><strong>Explain prepared statements as one good defense against SQL Injection:</strong></h2>
<p>Prepared statements are a simple and easy way to give your page a second level of protection.  They place themselves between the page itself and the people trying to get access into the page.  It works by placing question marks where the user input is going to go, separating the SQL Statement from the user collected data.  This keeps the hacker from placing something in the user input that could influence the SQL statement, and giving them access.</p>
<p>The injection, again, is the hacker placing code in the user input that allows them to change the code in their favor.  Giving them access or destroying the database, depending on their intentions.  Prepared statements are a safety net.  A layer of protection against what the hackers are trying to mess up.
</p>
<br />
<h2><strong>Explain Control of User Input:</strong></h2>
<p>Controlling user input is the most import part of security on a page that has forms.  Malicious code is one of the easiest ways for someone to take control of, pull data from, or alter a database.  Popping some complicated html into the form is a way that hackers gain access, and that can be stopped with some preparation on our end.</p>
<p>Htmlentities() takes the html elements such as < in the user input, and changes them to &lt;.  That helps keep things under the control of the programmer instead of a hacker.  The strip_tags() does something similar, but instead of changing them to &lt;, they actually take the tags out completely.  That really helps keep hackers from taking any sort of control, or altering your site in a malicious manner.
</p><br />
<h2><strong>Here is my video:</strong></h2><br />
<center><iframe width="560" height="315" src="https://www.youtube.com/embed/5IE4RRYc7gY" frameborder="0" allowfullscreen></iframe></center>
</div>

</body>
</html>
