<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <!-- readWriteJSON.html - PHP test read/write operations with JSON file
  Peter Johnson - peterk@webExplorations.com
  Written:   06-06-16 - originally was zoo4.html
  Revised:   06-07-16 - Added PHP functions to read/write 
  -->
 <title>Test R/W JSON</title>
<link rel="stylesheet" type="text/css" href="zoo.css">

<!-- Add JavaScript -->
<script>
function getJSON(){
   // Find the HTML <div> to display the results
   var result = document.getElementById("result");
   // Create an AJAX request object
   var thisRequest = new XMLHttpRequest();
   thisRequest.open("GET", "zoo4.json", true);
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
         stringToDisplay += "<table><thead><tr>";
         stringToDisplay += "<th>Name</th><th>Habitat</th><th>Population</th></tr></thead>";
         for(var count=0; count< myZoo.zoo.length; count++)
         {
            stringToDisplay += "<tr>";
               stringToDisplay += "<td>" + myZoo.zoo[count].animal + "</td>";
               stringToDisplay += "<td>" + myZoo.zoo[count].habitat + "</td>";
               stringToDisplay += "<td>" + myZoo.zoo[count].population + "</td>";
            stringToDisplay += "</tr>";
         }
         stringToDisplay += "</table";
         // Display the String containing the HTML table output as the text of the #result <div>.
         result.innerHTML = stringToDisplay;
      } // end of if(readyState && thisRequest.status
   } // end of onreadystatechange = function( )
   thisRequest.send(null);
   result.innerHTML = "<br />Requesting data from server...";
} // end of getJSON( )
</script>

<?PHP
   // The JSON filename
   $myJSONFile = "zoo4.json";
   // Set up a temporary array to hold the JSON data
   $zooArray = array( );
   $zooArray = readJSON($myJSONFile);
   
   
   // Hard-code in a change to the first record with a time stamp
   // Later, the data from the form textboxes will be used to update this array
   date_default_timezone_set("America/Chicago");
   $zooArray['zoo'][0]['animal'] = "Candy-striped Platypus " . date("h:i:sa");
   
   writeJSON($zooArray, $myJSONFile);


/*************** FUNCTIONS (Alphabetical) *************************/

/* -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - 
 * readJSON( ) - read the JSON file
 * returns:   array with JSON data
 * -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - */
function readJSON($thisFile) {
   // Set up an array to hold the JSON data
   $thisArray = array( );
   
   try {
      // get data from the JSON file
      $jsonData = file_get_contents($thisFile);
      // convert it into an array
      $thisArray = json_decode($jsonData, true);
      return $thisArray;
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
function writeJSON($thisArray, $thisFile) {
   // convert array to JSON formatted variable
   $jsonData = json_encode($thisArray, JSON_PRETTY_PRINT);
   try {
      // write to the JSON file
      if(file_put_contents($thisFile, $jsonData)) {
         echo '<br />Zoo file updated successfully<br />';
      }
      else {
         echo 'There was an error writing to the ' . $myFile . " file.<br />";
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
   <h1>Test read/write JSON File</h1>
   <div id="result"></div>
   <!-- Repopulate with new information -->
   <script>getJSON( );</script>
</div>
</body>
</html>
