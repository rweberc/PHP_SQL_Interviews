<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Enter Interviews</title>
<!--
				 Name:  Ryan Weber
   	Date of Creation:  12/16/13
         	     Desc:  This script allows user to enter a record data into the Interviews table.  The script
                 			creates an "all-in-one" form and checks that form data was entered for each field and 
                         that entered for data for the data field is in the proper format (using preg_match()).
-->
</head>
<body>
	<?php
		// entry form boolean set to true, by default
		$displayForm = true;
		
		//initialize variables to store field data
		$intName = "";
		$position = "";
		$date = "";
		$candName = "";
		$commAb = "";
		$profApp = "";
		$compSkills = "";
		$busKnow = "";
		$intComm = "";
		
		// Display header
		echo "<h2>Interview Entry</h2>";

		// check if form data had been entered
		if (isset($_POST['Submit']))
		{
		
			//retreive form data
			$intName = stripslashes(trim(($_POST['intName'])));
			$position = stripslashes(trim(($_POST['position'])));
			$date = stripslashes(trim(($_POST['date'])));
			$candName = stripslashes(trim(($_POST['candName'])));
			$commAb = stripslashes(trim(($_POST['commAb'])));
			$profApp = stripslashes(trim(($_POST['profApp'])));
			$compSkills = stripslashes(trim(($_POST['compSkills'])));
			$busKnow = stripslashes(trim(($_POST['busKnow'])));
			$intComm = stripslashes(trim(($_POST['intComm'])));
			
			
			// if so, validate the data, display appropriate warning messages
			if (($intName == null) || ($position == null) || ($date == null) || ($candName == null) || 
					($commAb == null) || ($profApp == null) || ($compSkills == null) || ($busKnow == null) || 
					($intComm == null))
				echo "<p><strong>All form fields must be filled before the new data can be entered!</strong></p>";
			else
				$displayForm = false;
			
			// check that date was entered in the proper format
			if (!preg_match('/[1-2][0-9]{3}(-)[0-1][0-9](-)[0-3][0-9]/', $date))
			{
				// if date not in right format, reset field
				$date = "";
				
				// display and error statement
				echo "<p><strong>Date must be entered in the following format: yyyy-mm-dd!</strong></p>";
				
				$displayForm = true;
			}
			
			// else, if data is valid, enter new records
			if (!$displayForm)
			{
				
				// Connect to database, suppress any errors (to be outputted with echo statement below, if present
				// in order to ensure proper html formatting
				$DBConnect = @mysql_connect("cis.luzerne.edu", {username here}, {password here});
				
				
				// Determine the status of the database connection.  Dislpay some of 
				// its versioning if successful.
				if ($DBConnect === FALSE)
				{
					echo "<p>Database connection failed.</p>";	
					echo "<p>The mysql_error() is: " . mysql_error() . "<br />" . 
							" and the mysql_errno() is: " . mysql_errno() . "</p>";
				}
				else
				{
					// Try selecting the desired database
					if (@mysql_select_db("rw0001", $DBConnect) === FALSE)
					{
						echo "<p>A connection was established with the host but not the 'rw0001' database.</p>";
						echo "<p>The mysql_error() is: " . mysql_error() . "<br />" . 
							" and the mysql_errno() is: " . mysql_errno() . "</p>";
					}
					else
					{

						// Try inserting a record into the Interviews table.
						$SQLString = "insert into Interviews (Interviewer, Position, InterviewDate,
										Candidate, Communication, Appearance, ComputerSkills, BusinessKnowledge, Comments)
										values ('" . $intName . "', '" . $position . "', '" . $date . "', '" . $candName . "', 
													'" . $commAb . "', '" . $profApp . "', '" . $compSkills . "', 
													'" . $busKnow . "', '" . $intComm  . "')";
					
						$InsertQueryResult = @mysql_query($SQLString, $DBConnect);
						
						
						if ($InsertQueryResult == FALSE)
						{
							echo "<p>The record insertion failed.</p>";
							echo "<p>The mysql_error() is: " . mysql_error() . "<br />" . 
								" and the mysql_errno() is: " . mysql_errno() . "</p>";
				
						}
						else
							echo "<p>The interview information was saved.</p>";
							
						
						// Clear the query results.
						mysql_free_result($InsertQueryResult);
		
						
					}
					
					// should close mysql connection with:    
					mysql_close($DBConnect);
				}
			}
		}
		
		if ($displayForm)
		{

			?>
            	<form name = "intForm" action = "p3s3enterinterviews.php" method = "post" align="center">
            	<table>
               <tr>
               	<td align="right">Interviewer's Name</td>
					<td><input type="text" name="intName" value = "<?php echo $intName; ?>"  size="50"></td>
               </tr>
               <tr>
   			     	<td align="right">Position</td>
                  <td><input type="text" name="position" value = "<?php echo $position; ?>" size="79"></td>
               </tr>
               <tr>
   			     	<td align="right">Date of Interview</td>
                  <td><input type="text" name="date" value = "<?php echo $date; ?>" size="46">
                  	(must be in the form yyyy-mm-dd)</td>
               </tr>
               <tr>
   			     	<td align="right">Candidate's Name</td>
                  <td><input type="text" name="candName" value = "<?php echo $candName; ?>" size="50"></td>
               </tr>
               <tr>
   			     	<td align="right">Communication Abilities</td>
                  <td><textarea id="commAb" name = "commAb" rows="6" cols="70"><?php echo $commAb; ?></textarea></td>
               </tr>
               <tr>
   			     	<td align="right">Professional Appearance</td>
                  <td><textarea id="profApp" name = "profApp" rows="6" cols="70"><?php echo $profApp; ?></textarea></td>
               </tr>
               <tr>
   			     	<td align="right">Computer Skills</td>
                  <td><textarea id="compSkills" name="compSkills" rows="6" cols="70" 
                  	><?php echo $compSkills; ?></textarea></td>
               </tr>
               <tr>
   			     	<td align="right">Business Knowledge</td>
                  <td><textarea id="busKnow" name = "busKnow" rows="6" cols="70"><?php echo $busKnow; ?></textarea></td>
               </tr>
               <tr>
   			     	<td align="right">Interviewer's Comments</td>
                  <td><textarea id="intComm" name = "intComm" rows="6" cols="70"><?php echo $intComm; ?></textarea></td>
               </tr>
               </table>
               
  				 <input type="reset" value="Clear"/>&nbsp;&nbsp;
               <input type="submit" name = "Submit" value="Submit"/>
              </form>
           <?php
		}	
    ?>
    
    <!-- link to view interviews -->
    <p><a href = "p3s3viewinterviews.php">View Interviews</a></p>

    
</body>
</html>