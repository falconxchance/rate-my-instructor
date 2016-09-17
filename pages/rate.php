<?php

global $table_instructors, $table_rate;

if( $context[ 'user' ][ 'is_guest' ] ) // if not logged in
{
	echo "<h4><font size='+2'>Rate; Login required.</font></h4>";
	
	echo "<p>You need to login before you can rate an instructor.</p>";
}
else// if logged in
{
	if( $requested_ins_name ) // if ins name is requested (main)
	{
		//if( !isset( $_POST[ 'submit' ] ) )  // if the form is not submitted yet...show the form
		//{
			$requested_ins_name = mysql_escape_string( $requested_ins_name );
			$requested_ins_name = html_entity_decode( $requested_ins_name );
			$requested_ins_name = mysql_real_escape_string( $requested_ins_name );	
			
			$query = "SELECT ins_name, id FROM `" . $table_instructors . "` WHERE `ins_name` = '" . $requested_ins_name . "' LIMIT 1";
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			$IsInstructorExist = mysql_num_rows( $result ); 
			
			$ins_name_ = ucwords( $requested_ins_name );
			
			if( $IsInstructorExist )
			{
				$row = mysql_fetch_assoc( $result ) or die( mysql_error( ) ) ;
				{
					$instructor_id = $row[ 'id' ];
				}
				
				
			$query = "SELECT rater_id FROM `" . $table_rate . "` WHERE `ins_id` = '" . $instructor_id . "' AND `rater_id` = '" . $context[ 'user' ][ 'id' ] . "' LIMIT 1";
			
			$result = mysql_query( $query ) or die( mysql_error( ) ) ;
			$IsRateExist = mysql_num_rows( $result ); 
				
				if( $IsRateExist ) // we dont want more than 1 rate so
				{
					echo "<h4><font size='+2'>Error occured while rating " . $ins_name_ . ".</font></h4>";
	
					echo "<p>You can only rate once for each instructor.</p>";
				}
				else
				{
					
					echo "<h4><font size='+2'>It's your turn to grade " . $ins_name_ . "!</font></h4>";
					
						?>
					
					<div class="form_settings">
					
						<form method="post" action="index.php?page=finishrate">
					
						<p><span>Rating ID:</span><input type="text" name="_raterid" value="<?php echo $context[ 'user' ][ 'id' ]; ?>" readonly /></p>
						
						<p><span>Instructor ID:</span><input type="text" name="_insid" value="<?php echo $instructor_id; ?>" readonly /></p><br>
				
			  <?php
			   
			   echo "<p>Dear " . $context[ 'user' ][ 'name' ] . ", it's your time to <u>grade</u> <strong>" . $ins_name_ . "</strong> now! Please avoid submitting any kind of inaccurate information. The above information is for reference purpose only. Please proceed below in order to rate this instructor. Everything in this form is required in order to calculate accurate results.<br><br>Please note that you won't be able to edit/modify your rating towards this instructor in future, so make sure before you publish your rating.</p>";
		   
				
			//echo "Please note that your IP address (" . getUserIP() . ") will be saved with the following rating but will remain confidential.";</p>
					
					?>
			   
			  <br> <hr><br><br>
				
				
				<fieldset id="rate_group1">
				
				<legend>Rate this instructor (out of <?php echo $website_maxrating ?>)</legend><br>
				
				<?php
				
				
				for( $counter = 1; $counter <= $website_maxrating; $counter++ ) 
				{
					echo '<p><span>' . $counter . '. ' . getratename( $counter ) . '</span><input type="radio" value="' . $counter . '" name="rate_group1"></p>';
				}
					
				
				?>
			   
		</fieldset><br><br>
		
		<fieldset id="lod_group2">
		
		<legend>Level of difficulty (out of <?php echo $website_maxlod ?>)</legend><br>
		
		<?php
		
			for( $counter = 1; $counter <= $website_maxrating; $counter++ ) 
			{
				echo '<p><span>' . $counter . '. ' . getlodname( $counter ) . '</span><input type="radio" value="' . $counter . '" name="lod_group2"></p>';
			}
				
		?>
		
			
		</fieldset><br>
		
		<fieldset><legend>Textbook Requirement</legend></fieldset><br>
		
		<p><span>Is textbook required by this instructor?</span><input type="checkbox" name="textbook" value="1"></p>
		
		<br>
		<br>
		
		<fieldset><legend>Preference</legend></fieldset><br>
		
		<p><span>Would you take this instructor again?</span><input type="checkbox" name="takeagain" value="1"></p>
		
		<br><br>
		
		 <fieldset><legend>Attendance Policy</legend></fieldset><br>
		
		<p><span>Does this professor take attendance seriously?</span><input type="checkbox" name="attendance" value="1"></p>
		
		<br><br>
		
		 <fieldset><legend>Grade Earned</legend></fieldset><br>
		
		<span>What grade did you receive eventually?</span>
		
		<select name="grades">
		<?php
		
		for( $counter = 1; $counter <= 11; $counter++ )
		{
		  echo "<option value='" . $counter . "'>" . generategrade( $counter ) . "</option>";
		}
		
		
		?>
		
		
		
		</select><br><br><br>
		
		<fieldset><legend>Course</legend></fieldset><br>
		
		<span>What course did you take with this instructor?</span>
		
		<?php
		
		
		$query = "SELECT course_1, course_2, course_3, course_4, course_5 FROM " . $table_instructors . " WHERE id=" . $instructor_id . " LIMIT 1";
			
		$result = mysql_query( $query ) or die( mysql_error( ) ) ;
		$IsInsExist = mysql_num_rows( $result ); 
		
		if( $IsInsExist )
		{
			$row = mysql_fetch_array( $result ) or die( mysql_error( ) ) ;
			
			$courses = array( $row[ 'course_1' ], $row[ 'course_2' ], $row[ 'course_3' ], $row[ 'course_4' ], $row[ 'course_5' ] );
		}
		
		?>
		
		<select name="course">
		<?php
		
				foreach( $courses as $validcourses ) 
				{
					if( 	!empty( $validcourses ) )
					{
						
						echo "<option value='" . $validcourses . "'>" . $validcourses . "</option>";
					}
				}
				
				echo "<option value='N/A'>Not in the list</option>";
		
		?>
		</select>
		
		
		
		</p>
		
		<br><br>
		
		<fieldset id="test_info_group3">
		
		<legend>Format of <?php echo $ins_name_; ?>'s tests, exams and quizzes</legend><br>
		
		<?php
		//GetTestInfoNames( $id )
		
		
			for( $counter = 1; $counter <= 5; $counter++ ) 
			{
				echo '<p><span>' . GetTestInfoNames ( $counter ) . '</span><input type="radio" value="' . $counter . '" name="test_info_group3"></p>';
			}
		?>
		
			
		</fieldset>
       
		
		<br><fieldset><legend>Tags</legend></fieldset>
		
		<p><i>Choose tags that describes this instructor. (max 3)</i></p>
		
		<?php
		
		global $table_tags;
		
			$query = "SELECT * FROM " . $table_tags;
		
				$result = mysql_query( $query ) or die( mysql_error( ) ) ;
				
				$IsTagsExist = mysql_num_rows( $result );
				
				if( $IsTagsExist )
				{
					echo "<table style='border-spacing:0; border: 1px solid black;'>";
					
					echo "<tr><th>Tags</th><th>Choose</th></tr>";
			
					while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) 
					{
						$count++;
						
						echo "<tr><td>" . $row[ 'names' ] . "</td><td><input type='checkbox' name='tags[]' value=" . $row[ 'id' ] . "></td></tr>";
					}
					
					echo "</table>";
				}
				else
				{
					echo "<p>There are no tags in database.</p>";
				}
		
		?>
		
		
		<fieldset><legend>Your comment about this instructor</legend></fieldset><br>
		
		<p>
		
		<span>Would you like to say something about this instructor? For example: your unique experience, writing / reading intensity, attendance policy, availability outside of class, required participation etc...</span>
		
		<textarea rows="8" cols="50" name="comment"></textarea>
		
		</p>
		
		<br><br>
						
						
						<center><input class="submit" type="submit" name="submit" value="Rate!" /></center>
						
						</form>
						
					 
						
						
						
					</div>
					
					
					
					<?php
					
					}
					
				}
				else
				{
					echo "<p>Error: Instructor not found.</p>";
				}
	
	}
	else // if ins name NOT requested
	{
		
		echo "<h2>Rate: Unknown</h2>";
		
		echo "<p>Seems like you are lost. Please get back to the <a href='javascript:history.back()'>previous page</a>.</p>";
		
	}
}


?>