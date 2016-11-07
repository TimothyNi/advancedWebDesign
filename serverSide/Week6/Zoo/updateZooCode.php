<?PHP
/* updateZooCode.php - the main PHP code for the updateZoo.php page */

// Determine if this is a new or returning visitor
// check to see if this is the first time viewing the page
$jsonFileName = 'zoo4.json';

//* // DEBUG: Show the $_POST[ ]
echo '<pre>';
print_r($_POST);
echo "</pre><hr />";
//*/

if(array_key_exists('hdnReturning',$_POST)) {
   
   echo "<h1>Welcome back!</h1>";
   // Read the JSON file
   $thisArray = readJSON($jsonFileName);
   
   
   // Replace the data in the array with the user input
   for($x=0; $x<count($thisArray['zoo']); $x++){
      $thisArray['zoo'][$x]['animal'] = $_POST['txtAnimal' . $x];
      $thisArray['zoo'][$x]['habitat'] = $_POST['txtHabitat' . $x];
      $thisArray['zoo'][$x]['population'] = $_POST['txtPopulation' . $x];
   }
  //* // Show the array
   echo '$thisArray: <pre>';
   print_r($thisArray);
   echo '</pre>';
  //*/
      
   // Update the JSON file
   writeJSON($thisArray, $jsonFileName);

} else /* first time coming to this page */ {
    echo "<h1>Welcome NEW VISITOR</h1>";
} // end of if/else


/*************** FUNCTIONS (Alphabetical) *************************/

/* -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
 * readJSON( ) - read the JSON file
 * returns:   array with JSON data
 * -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - */
function readJSON($thisFile) {
   // Set up an array to hold the JSON data
   $tempArray = array( );
   
   try {
      // get data from the JSON file
      $jsonData = file_get_contents($thisFile);
      // convert it into an array
      $tempArray = json_decode($jsonData, true);
      return $tempArray;
   }
   catch (Exception $e) {
      echo 'Caught exception: ', $e->getMessage(), "\n";
   }
} // end of readJSON( )


/* -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
 * writeJSON( ) - write the JSON file
 * Parameters:   $myArray - Array to be written to the file
 *               $myFile - Name of the JSON file storing the data
 -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - */
function writeJSON($tempArray, $thisFile) {
   // convert array to JSON formatted variable
   $jsonData = json_encode($tempArray, JSON_PRETTY_PRINT);
   try {
      // write to the JSON file
      if(file_put_contents($thisFile, $jsonData)) {
         echo 'Zoo file updated successfully<br />';
      }
      else {
         echo 'There was an error writing to the ' . $File . " file.<br />";
      }
   }
   catch (Exception $e) {
      echo 'Caught exception: ', $e->getMessage(), "\n";
   }
} // end of writeJSON( )

?>