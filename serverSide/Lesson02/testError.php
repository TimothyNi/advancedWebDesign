<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- testError.php - Testing error settings on PHP
        Your Name
        Written:   Current Date 
        Revised:   
    -->
    <title>Testing Error Settings</title>

</head>
<body>
    <h1>Testing Error Settings</h1>
    <?php
        print("The next line will generate an error.<br />");
        printaline("Not a real function.");
        print("This will not be displayed because of the error on the previous line<br />");
    ?>

</body>
</html>