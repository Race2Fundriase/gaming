<?php
/*
Template Name: Help
*/
?>

<?php
 
  //response generation function
  $response = "";
 
  //function to generate response
  function my_contact_form_generate_response($type, $message){
 
    global $response;
 
    if($type == "success") $response = "<div class='success'>{$message}</div>";
    else $response = "<div class='error'>{$message}</div>";
 
  }
  
    //response messages
    $not_human       = "Human verification incorrect.";
    $missing_content = "Please supply all information.";
    $email_invalid   = "Email Address Invalid.";
    $message_unsent  = "Message was not sent. Try Again.";
    $message_sent    = "Thanks! Your message has been sent.";
     
    //user posted variables
    $name = $_POST['message_name'];
    $email = $_POST['message_email'];
    $message = $_POST['message_text'];
    $human = $_POST['message_human'];
     
    //php mailer variables
    $to = get_option('admin_email');
    $subject = "Someone sent a message from ".get_bloginfo('name');
    $headers = 'From: '. $email . "rn" .
      'Reply-To: ' . $email . "rn";
      
    if(!$human == 0){
	if($human != 2) my_contact_form_generate_response("error", $not_human); //not human!
	else {
       
	  //validate email
	    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	      my_contact_form_generate_response("error", $email_invalid);
	    else //email is valid
	    {
	      //validate presence of name and message
		if(empty($name) || empty($message)){
		  my_contact_form_generate_response("error", $missing_content);
		}
		else //ready to go!
		{
		  $sent = wp_mail($to, $subject, strip_tags($message), $headers);
		    if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
		    else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
		}
	    }
	}
      }
    else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);

?>

<?php get_header(); ?>
        <section>
            <div class="slider secondary clearfix">
                    
                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/slide1.jpg" alt=""/>
                    
                    <div class="inner-slider wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                    </div>
                    
            </div>
	</section>
	<div class="wide-fence why wrap"></div>
        
        <section>
	    <div class="container pad-top sand">
		<div class="inner-container wrap clearfix">
                    <div>
		    <h1 class="highlight"><?php the_title(); ?></h1>
                    </div>
		    <ul id="tab_control" class="tab_control left">
			<li><a href="#" class="btn btn-blue large active">FAQ</a></li>
			<li><a href="#" class="btn large">Contact Form</a></li>
		    </ul>
                    
                    <div id="other-search">
                        <?php $search_text = "Search Help"; ?> 
                        <form method="get" id="helpsearch"  action=""> 
                            
                            <input type="text" value="<?php echo $search_text; ?>"  
                            name="search" id="search"
                            onblur="if (this.value == '')  
                            {this.value = '<?php echo $search_text; ?>';}"  
                            onfocus="if (this.value == '<?php echo $search_text; ?>')  
                            {this.value = '';}" /> 
                           
                            <input type="hidden" id="helpsearchsubmit" /> 
                        </form>
                    </div>
                </div> 
	    </div>
	</section>
        
	<?php
	    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	    
	    $search = (get_query_var('search'));
	    
	    $args = array(
	        's' => $search,
		'post_type' => 'custom_type',
		'faq_type' => 'R2F',
		'order' => 'ASC',
		'posts_per_page' => '5',
		'paged' => $paged
	    );
	    
	    $wp_query = new WP_Query($args);
	
	?>
        <!--Tabbed Content-->
        <div id="tabs">
	    <div class="tabbed_content <?php if (!$response) {?> active <?php }; ?>">
		
	    <?php if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
	    
	    <?php if ($wp_query->current_post == 0) { $first = true; } else { $first = false; } ?>
	    <?php if ($wp_query->current_post == $wp_query->post_count - 1) { $last = true; } else { $last = false; } ?>
	   
	    
	    <div class="faq container sand <?php if (!$first) : ?> top-bg <?php endif; ?><?php if ($last) : ?> bot-bg <?php endif; ?> clearfix">
                <div class="inner-container wrap clearfix">
		   
		    <?php if ($first) { ?>
			<h2 class="highlight">FAQ</h2><br/>
		    <?php } ?>
		    
                    <h3 class="highlight question">Question</h3>
		    <p><?php the_title(); ?></p>
		    <h3 class="highlight answer">Answer</h3>
		    <?php the_content(); ?>
		    
		    <?php if ($last) : ?>
			 <?php bones_page_navi(); ?>
		    <?php endif; ?>
		    
                </div>
            </div>
            
	    
	    
	    <?php endwhile; ?>
	   
	    
	    <?php endif; ?>
	    <?php wp_reset_query(); ?>
	    
	</div><!--End of tab-->
        
	    <div class="tabbed_content <?php if ($response) {?> active <?php }; ?>">
		<div class="container grit bot-bg-alt top-bg-grass">
		    <div class="inner-container wrap clearfix">
			<style type="text/css">
			.error{
			  padding: 5px 9px;
			  border: 1px solid red;
			  color: red;
			  border-radius: 3px;
			}
		       
			.success{
			  padding: 5px 9px;
			  border: 1px solid green;
			  color: green;
			  border-radius: 3px;
			}
		       
			form span{
			  color: red;
			}
		      </style>
		       
		      <div id="respond">
			<?php echo $response; ?>
			<?php if (!$sent) : ?>
			<form action="<?php the_permalink(); ?>" method="post">
			<div class="form-elements">
			    <div>
			      <label for="name"><span>Name: </span> <span>*</span></label>
			      <div>
			      <input type="text" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>">
			      </div>
			    </div>
			  
			  <div>
			    <label for="message_email"><span>Email: </span> <span>*</span></label>
			    <div>
			    <input type="text" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>">
			    </div>
			  </div>
			  
			  <div>
			  <label for="message_text"><span>Message: </span> <span>*</span></label>
			    <div>
			    <textarea name="message_text" rows="8"><?php echo esc_textarea($_POST['message_text']); ?></textarea>
			    </div>
			  </div>
			  
			  <div>
			    <label for="message_human"><span>Human Verification:</span> <span>*</span></label>
			    <div>
			    <input type="text" style="width: 60px;" name="message_human"> <span>+ 3 = 5</span>
			    </div>
			  </div>
			 
			  <input type="hidden" name="submitted" value="1">
			  
			  <div class="text-center">  
			    <input class="btn large" type="submit"></p>
			  </div>
			  </div>
			</form>
			<?php endif; ?>
		      </div>
		    </div>
		</div>
	    </div><!--End of tab-->
        </div><!--End Tabs-->
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>