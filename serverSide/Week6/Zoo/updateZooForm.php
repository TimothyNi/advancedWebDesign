<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- updateZooForm.php -  form used to update the zoo json file
  Peter Johnson - peterk@webExplorations.com
  Written:   06-04-16 
  Revised:   
  -->
 <title>Update My Zoo</title>
 <!-- Insert the CSS styles -->
 <link rel="stylesheet" type="text/css" href="zoo.css">
 
 <!-- Insert the JavaScript functions -->
<script>var jsonFileName = 'priceData.json';

function showForm(){
   // Find the HTML <div> to display the results
   var theForm = document.getElementById("theForm");
   // Create an AJAX request object
   var thisRequest = new XMLHttpRequest();
   thisRequest.open("GET", jsonFileName, true);
   // Set up content header to send URL encoded variables 
   // using GET as part of the request asking for JSON type text
   thisRequest.setRequestHeader("Content-type", "application/json", true);
   // Run the on ready state change event
   thisRequest.onreadystatechange = function() {
      if(thisRequest.readyState == 4 && thisRequest.status == 200) {
         // parse the response text as JSON data
         var myZoo = JSON.parse(thisRequest.responseText);
         var stringToDisplay = "";
         // Clear the form before displaying new data
         theForm.innerHTML = "";
         
         // Append each string, forming one long string with the HTML table elements.
         stringToDisplay += "<form action='updateZooForm.php' method='POST'>";
         stringToDisplay += "<table><tr>";
         stringToDisplay += "<th>Name</th><th>Habitat</th><th>Population</th></tr>";
         for(var count=0; count< myZoo.zoo.length; count++)
         {
            stringToDisplay += "<tr>";
               stringToDisplay += "<td><input type='text' name='txtAnimal" + count 
                  + "' value='" + myZoo.zoo[count].animal + "'/></td>";
                  
               stringToDisplay += "<td><input type='text' name='txtHabitat" + count 
                  + "' value='" + myZoo.zoo[count].habitat + "'/></td>";
               stringToDisplay += "<td><input type='text' name='txtPopulation" + count 
                  + "' value='" + myZoo.zoo[count].population + "'/</td>";
            stringToDisplay += "</tr>";
         }
         stringToDisplay += "</table><br />";
         // Add on the submit button
         stringToDisplay += "<input type='submit' value='Do it' /><br /><br />";
         // Add a hidden field
         stringToDisplay += "<input type='hidden' name='hdnReturning' value='returning' />";
         stringToDisplay += "</form>";
         // Display the String containing the HTML table output as the text of the #result <div>.
         theForm.innerHTML = stringToDisplay;
      }
   }
   thisRequest.send(null);
   theForm.innerHTML = "<br />Requesting data from server...";
} // end of showForm( )


function showTable(){
   // Find the HTML <div> to display the results
   var result = document.getElementById("result");
   // Create an AJAX request object
   var thisRequest = new XMLHttpRequest();
   thisRequest.open("GET", jsonFileName, true);
   // Set up content header to send URL encoded variables 
   // using GET as part of the request asking for JSON type text
   thisRequest.setRequestHeader("Content-type", "application/json", true);
   // Run the on ready state change event
   thisRequest.onreadystatechange = function() {
      if(thisRequest.readyState == 4 && thisRequest.status == 200) {
         // parse the response text as JSON data
         var myZoo = JSON.parse(thisRequest.responseText);
         var stringToDisplay = "";
         // Clear the result box before displaying new data
         result.innerHTML = "";
         
         // Append each string, forming one long string with the HTML table elements.
         stringToDisplay += "<table><tr>";
         stringToDisplay += "<th>Name</th><th>Habitat</th><th>Population</th></tr>";
         for(var count=0; count< myZoo.zoo.length; count++)
         {
            stringToDisplay += "<tr>";
               stringToDisplay += "<td>" + myZoo.zoo[count].animal + "</td>";
               stringToDisplay += "<td>" + myZoo.zoo[count].habitat + "</td>";
               stringToDisplay += "<td>" + myZoo.zoo[count].population + "</td>";
            stringToDisplay += "</tr>";
         }
         stringToDisplay += "</table><br /><br />";
         
         // Display the String containing the HTML table output as the text of the #result <div>.
         result.innerHTML = stringToDisplay;
      }
   }
   thisRequest.send(null);
   result.innerHTML = "<br />Requesting data from server...";
} // end of showTable( )

</script>

 
 <!-- Insert in the PHP code -->
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
</head>
<body>
<div id="frame">
   
<h3>Update My Zoo</h3>
<!-- Display the form -->
<div id="theForm"></div>

<!-- Put the table showing the JSON data here -->
<div id="result"></div>

<!-- Populate the form and the table -->
<script>
   showForm( );
   showTable( );
</script>   

</div> <!-- end of #frame -->
</body>
</html>
