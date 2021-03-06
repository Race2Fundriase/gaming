<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // Google Chrome Frame for IE ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>
		<meta name="description" content="Race 2 Fundraise was created to enable charities, clubs, schools and other not for profit organisations to have a fun and interactive fundraising platform that enables them to create unique and relevant cost effective fundraising events."/>
		
		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>
		
		<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/library/css/jquery.qtip.min.css" />

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-48361950-1', 'race2fundraise.com');
ga('send', 'pageview');

</script>
		
		<script>site_url='<?=site_url()?>';</script>
		<script>theme_url='<?=get_template_directory_uri()?>';</script>
		<script>current_user_id = <?=get_current_user_id();?>;</script>
		<script>current_player_name = '<?=get_player_name();?>';</script>
		<script>is_admin = <?php if(appthemes_check_user_role("administrator")) echo("true"); else echo("false");?>;</script>
		<script>url_id = '<?=get_url_id();?>';</script>
	</head>

	<body <?php body_class(); ?>>

		<div id="container">
			<?php
			if (!is_page_template('pagetemplate-offlineprint1.php') && !is_page_template('pagetemplate-offlineprint2.php')
				&& !is_page_template('pagetemplate-offlineprint3.php')) {
			?>
			<header class="header" role="banner">
<?php $C = get_defined_constants(); if ($C["DB_NAME"] == "cl52-r2f-accp") echo("<p class=\"highlight\">ACCEPTANCE</p>"); ?>
				<div id="inner-header" class="wrap clearfix">

					<nav role="navigation">
						<?php bones_main_nav(); ?>
					</nav>
					
					<div id="nobtn-search">
						<?php $search_text = "Search"; ?> 
						<form method="get" id="searchform"  
						action="<?php bloginfo('home'); ?>/"> 
						<input type="text" value="<?php echo $search_text; ?>"  
						name="s" id="s"  
						onblur="if (this.value == '')  
						{this.value = '<?php echo $search_text; ?>';}"  
						onfocus="if (this.value == '<?php echo $search_text; ?>')  
						{this.value = '';}" /> 
						<input type="hidden" id="searchsubmit" /> 
						</form>
					</div>
				</div>
				
				
			</header>
			<?php } ?>