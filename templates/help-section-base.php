<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php _e('WP Toolkit 2 - Help Section', WPT_TEXTDOMAIN); ?></h2>

	<ul>
	<?php foreach($sections as $section): ?>
		<li><?php echo($section); ?> - <?php echo(WPT_PATH_HELP . $section . '.html'); ?></li>
	<?php endforeach; ?>
	</ul>
	
	
	
</div>