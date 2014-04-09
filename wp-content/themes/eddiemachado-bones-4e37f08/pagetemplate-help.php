<?php
/*
Template Name: Help
*/
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
                            name="help-s" id="help-s"  
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
	    
	    $args = array(
		'post_type' => 'custom_type',
		'order' => 'ASC',
		'posts_per_page' => '2',
		'paged' => $paged
	    );
	    
	    $wp_query = new WP_Query($args);
	
	?>
        <!--Tabbed Content-->
        <div id="tabs">
	    <div class="tabbed_content active">
		
	    <?php if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
	    
	    <?php if ($wp_query->current_post == 0) { $first = true; } else { $first = false; } ?>
	    <?php if ($wp_query->current_post == $wp_query->post_count - 1) { $last = true; } else { $last = false; } ?>
	    <?php $meta_values = get_post_meta( get_the_ID(), 'Answer', true); ?>
	    
	    <div class="faq container sand <?php if (!$first) : ?> top-bg <?php endif; ?><?php if ($last) : ?> bot-bg <?php endif; ?> clearfix">
                <div class="inner-container wrap clearfix">
		   
		    <?php if ($first) { ?>
			<h2 class="highlight">FAQ</h2><br/>
		    <?php } ?>
		    
                    <h3 class="highlight question">Question</h3>
		    <p><?php the_title(); ?></p>
		    <h3 class="highlight answer">Answer</h3>
		    <p><?php echo $meta_values ?></p>
		    
		    <?php if ($last) : ?>
			 <?php bones_page_navi(); ?>
		    <?php endif; ?>
		    
                </div>
            </div>
            
	    
	    
	    <?php endwhile; ?>
	   
	    
	    <?php endif; ?>
	    <?php wp_reset_query(); ?>
	    
	</div><!--End of tab-->
        
	    <div class="tabbed_content">
		<p>Contact Form Goes Here!</p>
	    </div><!--End of tab-->
        </div><!--End Tabs-->
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>