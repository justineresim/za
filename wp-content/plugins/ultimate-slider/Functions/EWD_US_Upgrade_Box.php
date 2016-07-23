<?php

function EWD_US_Upgrade_Box() {
?>
	<div id="side-sortables" class="metabox-holder ">
	<div id="upcp_pro" class="postbox " >
		<div class="handlediv" title="Click to toggle"></div><h3 class='hndle'><span><?php _e("Full Version", 'EWD_US') ?></span></h3>
		<div class="inside">
			<ul><li><a href="http://www.etoilewebdesign.com/plugins/ultimate-slider/"><?php _e("Upgrade to the full version ", "EWD_US"); ?></a><?php _e("to take advantage of all the available features of the Ultimate Slider for Wordpress!", 'EWD_US'); ?></li></ul>
			<h3 class='hndle'><span><?php _e("What you get by upgrading:", 'EWD_US') ?></span></h3>
				<ul>
					<li>Lightbox integration - let visitors zoom in on images and create a scrolling gallery.</li>
					<li>Choose from numerous transition and title effects!</li>
					<li>Watermarks to protect your images, dozens of styling and control options and much more!</li>
					<li>Access to e-mail support.</li>
				</ul>
			<div class="full-version-form-div">
				<form action="edit.php?post_type=us" method="post">
					<div class="form-field form-required">
						<label for="Key"><?php _e("Product Key", 'EWD_US') ?></label>
						<input name="Key" type="text" value="" size="40" />
					</div>							
					<input type="submit" name="Upgrade_To_Full" value="<?php _e('Upgrade', 'EWD_US') ?>">
				</form>
			</div>
		</div>
	</div>
	</div>

<?php
}

function EWD_US_Upgrade_Notice() {
?>
	<div id="side-sortables" class="metabox-holder ">
	<div id="upcp_pro" class="postbox " >
		<div class="handlediv" title="Click to toggle"></div><h3 class='hndle'><span><?php _e("Upgrade Complete!", 'EWD_US') ?></span></h3>
		<div class="inside">
			<ul><li><?php _E("Thanks for upgrading!", 'EWD_US'); ?></li></ul>
		</div>
	</div>
	</div>

<?php
}
?>