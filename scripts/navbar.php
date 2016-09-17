


<ul id="menu">
          
                                    <?php if( $requested_page == "main" || !$requested_page ) { ?>
                                   
                            	<li class="selected"><a href="<?php echo $website_url; ?>">Main</a></li>
 
 									<?php } else { ?>
                                    
                                    <li><a href="<?php echo $website_url; ?>">Main</a></li>
                                    
                                   <?php } ?>
                           
                         
                            <?php if( $requested_page == "instructor" || $requested_page == "rate" || $requested_page == "finishrate" || $requested_page == "addinstructor" ) { ?>
                            
                            <li class="selected"><a href="<?php echo $website_url; ?>index.php?page=instructor">Instructors</a></li>
                            <?php } else { ?>
                            
                            <li><a href="<?php echo $website_url; ?>index.php?page=instructor">Instructors</a></li>
                            
                            <?php } ?>
                            
                            <?php if( $requested_page == "myratings" || $requested_page == "myrating" ) { ?>
                                
                                
                            <li class="selected"><a href="<?php echo $website_url; ?>index.php?page=myratings">My Ratings</a></li>
                            
                            <?php } else { ?>
                            
                            <li><a href="<?php echo $website_url; ?>index.php?page=myratings">My Ratings</a></li>
                            
                            <?php } ?>
                            
                            
                       
                            <?php if( $requested_page == "search"  ) { ?>
                            
                            <li class="selected"><a href="<?php echo $website_url; ?>index.php?page=search">Search</a></li>
                            
                            <?php } else { ?>
                            
                            <li><a href="<?php echo $website_url; ?>index.php?page=search">Search</a></li>
                            
                            <?php } ?>
                       
                            
                            <li><a href="http://your-forum.example.com">Homepage</a></li>
                            
                            <?php 
							
							
							if ( $context[ 'user' ][ 'is_admin' ] ) 
							
							{ 
								if( $requested_page == "admin"  )
								{
							
									
									?>
									
									<li class="selected"><a href="index.php?page=admin">Admin</a></li>
									
									<?php 
									
								}
								else
								{ ?>
									<li><a href="index.php?page=admin">Admin</a></li>
						<?php	}
							
							}
						
							 if ( !$context[ 'user' ][ 'is_guest' ] ) { ?>
                            
                            <li><a href="http://your-forum.example.com/index.php?action=logout;<?php echo $context['session_var'] . "=" . $context['session_id']; ?>">Logout</a></li>
                            
                            <?php } else { ?>
                            
                            <li><a href="http://your-forum.example.com/index.php?action=login">Login</a></li>
                            
                            <?php } ?>
                            
                        
                        </ul>