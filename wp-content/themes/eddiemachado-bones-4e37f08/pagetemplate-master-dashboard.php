<?php
/*
Template Name: Master Dashboard
*/

if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>
<?php get_header(); ?>

	<div class="wide-fence why wrap"></div>
<br/>
        <section>
	    <div class="container pad-top sand bot-bg">
		<div class="inner-container wrap clearfix">
            <div>
		    <h1 class="highlight"><?php the_title(); ?></h1>
                    </div>
		    <ul id="tab_control" class="">
			<li><a href="<?=site_url();?>/wp-admin" class="btn large ">WP Admin</a>Open the main Wordpress dashboard to administer the site.</li>
			<li><a href="<?=site_url();?>/maps-admin" class="btn large ">Map Admin</a>Update/Create maps.</li>
			<li><a href="<?=site_url();?>/token-admin" class="btn large">Token Admin</a>Update/Create Tokens.</li>
			<li><a href="<?=site_url();?>/token-type-admin" class="btn large">Token Type Admin</a>Token Types such as Land, Sea or Air define how the token interacts with the landscape - a token may be of only ONE type.</li>
			<li><a href="<?=site_url();?>/token-category-admin" class="btn large">Token Category Admin</a>Token Categories such as Balloon, Taxi categorise tokens for use when selecting for a game - a token may be in more than one category.</li>
			<li><a href="<?=site_url();?>/voucher-admin" class="btn large">Voucher Admin</a>Create/Update game creation vouchers.</li>
			<li><a href="<?=site_url();?>/create-online-race-1" class="btn large ">Create Online Game</a>Create an online game.</li>
			<li><a href="<?=site_url();?>/create-offline-race-1" class="btn large ">Create Offline Game</a>Create an offline game.</li>
		    </ul>
            </div> 
	    </div>
	</section>
        
        
        
<?php get_footer(); ?>