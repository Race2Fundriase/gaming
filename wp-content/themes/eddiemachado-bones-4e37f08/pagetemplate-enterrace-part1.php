<?php
/*
Template Name: Enter Race Part 1
*/
?>

<?php get_header(); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?=get_template_directory_uri()?>/library/jquery.jqGrid-4.6.0/css/ui.jqgrid.css" />
<section>
<div id="content" class="container grit bot-bg bot-bg-alt clearfix">
	<div class="inner-container wrap">
	<br/>
	<br/>
	<h1 class="highlight">Enter Race</h1>
	<div id="signUp" class="boxShadow">
		<form id="signUpDataForm">
       
		<h2 class="highlight">Player Name</h2>
		<fieldset class="myfields">
		<div><input type="text" id="playerName" value=""/></div>
		</fieldset>
       
		</form>
	</div>
	<div id="chooseCharacter" class="boxShadow">
		<form id="raceTokensDataForm">
       
		<h2 class="highlight">Choose a Character</h2>
		<fieldset class="myfields">
		<div>
			<select id="tokenId" name="tokenId" style="width: 350px">
			</select>
		</div>
		</fieldset>
       
		</form>
	</div>

	
	<div id="cellOptions" class="boxShadow">
		<form id="mapGridDataForm">
		<h2 class="highlight">Character Options</h2>
		<fieldset class="myfields">
		<div><input type="text" id="drivingStyleWeight" value="0.5" data-slider-highlight="true" data-slider-theme="control" data-slider="true"/>
			<div class="status">
				<p class="left-status">Careful</p><p class="right-status">Agressive</p>
			</div>
		</div>
		<br/>
		<div><input type="text" id="noOfPitstops" value="1" data-slider-highlight="true" data-slider-theme="control" data-slider="true" data-slider-range="1,10"/>
			<div class="status">
				<p class="left-status">Fewer Pitsops</p><p class="right-status">More Pitstops</p>
			</div>
		</div>
		</fieldset>
		</form>
	</div>
	<div class="text-left signup"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
	
</div>
</section>
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>