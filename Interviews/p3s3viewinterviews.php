<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>View Interviews</title>
<!--
				 Name:  Ryan Weber
   	Date of Creation:  12/17/13
         	     Desc:  This script allows the user to view all interview data stored in the Inteviews table.  The 		
                 			records are displayed in an html table.  If no records are found, a message is displayed
                         apprising the user of this fact.
-->

</head>
<body>
	<?php
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
				
				// Create a query to select all records from Interviews table
				$QueryInterviews = @mysql_query("select * from Interviews");
				
				if ($QueryInterviews === FALSE)
				{
					echo "<p>Invalid query statement.</p>";	
					echo "<p>The mysql_error() is: " . mysql_error() . "<br />" . 
						" and the mysql_errno() is: " . mysql_errno() . "</p>";
				}
				else
				{
					// output header
					echo "<h2>Interviews</h2>";
					
					// check if any records are available in Interviews table
					if (mysql_num_rows($QueryInterviews) == 0) 
						echo "There are no interviews to display.</p>";
					else
					{
						// if records are available, display them
    					$CurRecord = mysql_fetch_assoc($QueryInterviews);
						echo "<p><table border ='1'>";
						echo "<tr>";
						echo "<th>Int. ID</th>";
						echo "<th>Int. Name</th>";
						echo "<th>Position</th>";
						echo "<th>Int. Date</th>";
						echo "<th>Cand. Name</th>";
						echo "<th>Comm. Skills</th>";
						echo "<th>Appearance</th>";
						echo "<th>Comp. Skills</th>";
						echo "<th>Bus. Knowledge</th>";
						echo "<th>Comments</th>";
						echo "</tr>";
						
						// Output the reocrds in the resultset, one record per table row.
						while ($CurRecord != null)
						{
							echo "<tr>";
							echo "<td>" . $CurRecord['InterviewID'] . "</td>";	
							echo "<td>" . $CurRecord['Interviewer'] . "</td>";	
							echo "<td>" . $CurRecord['Position'] . "</td>";	
							echo "<td>" . $CurRecord['InterviewDate'] . "</td>";	
							echo "<td>" . $CurRecord['Candidate'] . "</td>";	
							echo "<td>" . $CurRecord['Communication'] . "</td>";	
							echo "<td>" . $CurRecord['Appearance'] . "</td>";	
							echo "<td>" . $CurRecord['ComputerSkills'] . "</td>";	
							echo "<td>" . $CurRecord['BusinessKnowledge'] . "</td>";	
							echo "<td>" . $CurRecord['Comments'] . "</td>";	
							echo "</tr>";
							
							//advance to next record
							$CurRecord = mysql_fetch_assoc($QueryInterviews);
						}
						
						echo "</table></p>";
					}
				}
				
				// Clear the query results.
				mysql_free_result($QueryInterviews);
			}
			
			// should close mysql connection with:    
			mysql_close($DBConnect);
		}
	?>	
    
    <!-- link to enter new interview data -->
    
	<a href= "p3s3enterinterviews.php">Enter data for a new interview</a>	
</body>
</html>