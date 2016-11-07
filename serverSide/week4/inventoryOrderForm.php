<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
    <!-- clientOrderForm.php - Server Side Development - allow users to order products
		Timothy Niccum
		Written: 10/5/2016
		Revised:
	-->
        <title>Inventory Order Form</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <?PHP
        // Is this a return visit?
        define("SERVER_NAME","localhost");
		define("DBF_USER_NAME", "team");
		define("DBF_PASSWORD", "CSC235");
		define("DATABASE_NAME", "Inventory");
        // Create connection object

        $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD, DATABASE_NAME);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if(array_key_exists('hidSubmitFlag',$_POST)) {
            displayAllItems($conn);
            updateData();
        }else{
            displayAllItems($conn);
        }

        function displayAllItems($conn){
            $sql = "SELECT manu_ID, prodName, prodQuant FROM manu";
            $result = $conn->query($sql);
            displayResult($result, $sql);
            echo "<br />";
        }

        function updateData(){
            
            $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD, DATABASE_NAME);
            
            $txtPrName = $_POST['txtPrName'];
            $txtOrderNum = $_POST['txtOrderNum'];
            $selManu_ID = $_POST['selManu_ID'];
            $txtManu = $_POST['txtManu'];


            #inventID`, `prodName`, `orderNum`, `manu_ID`, `manufacturer
            $sql = "INSERT INTO Inventory.inventoryOrder (inventID, prodName, orderNum, manu_ID, manufacturer) "
                . "VALUES (NULL, '" 
                . $txtPrName . "', '" 
                . $txtOrderNum . "', '"
                . $selManu_ID . "', '" 
                . $txtManu . "')";

            runQuery($sql, "New record insert" . $txtQSOCall, true);
            
            $conn -> close();
        }

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



        function displayResult($result, $sql) {
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
        }

    function displayOptions(){
        $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD, DATABASE_NAME);
        
        $sql = "SELECT * FROM item";
        $result = $conn->query($sql);
        
        echo '<option value=null>Select an option</option>';

        while($row = $result->fetch_assoc( )){ 
            echo "<option value=" . $row[itemID] . ">" . $row[itemName] . "</option>";
        }
        
           $conn ->close();
        
    }

        $conn->close();
        ?>

    </head>
    <body>
        <!--<div id="frame">
        </div>
        -->
        
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>"
              method="POST"
              name="frmAdd">

            <fieldset id="fieldsetAdd">
                <legend>Order Item</legend>

                <label for="txtPrName">Product:</label>
                <input type="text" name="txtPrName" id="txtPrName" value="HDD" />
                <br /><br />

                <label for="txtOrderNum">Order Amount:</label>
                <input type="int" name="txtOrderNum" id="txtOrderNum" value="50"/>
                <br /><br />

                <label for="selManu_ID">Product ID:</label>
                <select name="selManu_ID">
                    <?php
                        displayOptions();
                    ?>
                </select>
                <br /><br />

                <label for="txtManu">Manufacturer:</label>
                <input type="text" name="txtManu" id="txtManu" value="Samsung"/>
                <br /><br />

                <input type='hidden' name='hidSubmitFlag' id='hidSubmitFlag' value='01' />
                <input name="btnSubmit" type="submit" value="Submitted"/>


            </fieldset>
        </form>
        <br /><br />



    </body>
</html>