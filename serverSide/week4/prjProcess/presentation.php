<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
	<!-- presentation.php - This is the presentation file for the client Red Door Burgers
		Written by: Timothy Niccum
		Class: CSC 235 ServerSide Development
		Written:	10-1-16
		Revised:	10-2-16
	-->
	<title>Reasons for this project.</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css" />
	
	</head>
	<body>
	
	<div class = header>
            <H1>The Menu Updater for The Red Door Pub. <br> Timothy Niccum<br> 10/2/2016</H1>
    </div>
	<hr />
	<div class=main>
	
		<div class="questions"></div>
		
			<h1>Questions from the Client</h1>
		
			<ul>
				<li><strong>How</strong> fast will my employees be able to update the website?</li>
				<li><strong>Where</strong> are they supposed to input the information?</li>
				<li><strong>Who</strong> should be able to input the information</li>
				<li><strong>What</strong> kind of input should be they input?</li>
				<li><strong>Why</strong> should we use a form to input the data, instead of just trusting someone to update the HTML?</li>
			</ul>
		<div class="responses"></div>
	
			<h1>Responses from the Developer</h1>
		
			<ul>
				<li><strong>How:</strong>The employees will be able to update the page in a matter of seconds through the form.  Not having to worry about changing html at all.</li>
				<li><strong>Where:</strong>There will be a form that they can input the information on to on a page specifically made for that reason. </li>
				<li><strong>Who:</strong>This website form should be used by one of the head managers at the restaurant to update the Burger of the Month, and weekly beer list.</li>
				<li><strong>What:</strong>There will be a form input for the Burger of the Month, and a form input for the four different beers on the weekly beer list.</li>
				<li><strong>Why:</strong>It will take a lot less time for an employee to change the burger of the month, and the weekly beer list through a form.  This process will also be much more secure.</li>
			</ul>
   		</div>     
   		
   		<hr />
   		
   		<div class="link">
  			<h3>Here is a link to the Index File:</h3>
   			<p><a href="http://timothyniccum.com/webAdminTim/Individual/index.php" target="_blank">Red Door Burgers Menu Page</a></p>
			<h3>Here is a link to the Editing page:</h3>
   			<p><a href="http://timothyniccum.com/webAdminTim/Individual/edit.php" target="_blank">Red Door Burgers Form</a></p>
			<h3>Here is a link to the readMe page:</h3>
   			<p><a href="http://timothyniccum.com/webAdminTim/Individual/prjReadMe.php" target="_blank">Red Door Burgers readMe</a></p>
			
   			
   		</div>
		<hr />
		<div class="two ways">
			<h4>Here are two ways I could go about this application:</h4>
			<ul>
				<li>I could do this with a php form, that could enter the information into a database, and store it there.<br />  
				Push it from the edit page to the database then into the index page.  This seems needlessly complicatated, but may be the best way to accomplish the task.</li>
				<li>Here is a mock up of what the form will look like.  I would use this to input the information into a json, and that will be used to update the index file.<br />
				<img src="graphics/mockup.png" alt="mockup" style="width:50%;height:50%;"><br />
				I plan on using php to set up the edit page, and have it move the information to the index page.  I have built a solid, unchangable table in the index page to hold the rest of the menu items.  The only changeable items will be the Burger of the Month, and the Beers of the Week.</li>
			</ul>
			
   	</div>
	
</body>	
</html>
