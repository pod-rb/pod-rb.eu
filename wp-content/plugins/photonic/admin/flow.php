<?php
/**
 * Contains the flow layout skeleton. Cannot be overridden by a theme file
 *
 * Screen 1: Provider selection
 * Screen 2: Display Type selection; input: Provider
 * Screen 3: Gallery selection; input: Display Type
 * Screen 4: Layout selection; input: Gallery & Display Type
 *
 * @since 2.00
 */
?>
<div id="photonic-flow-wrapper" data-current-screen="1">
	<form id="photonic-flow" data-photonic-submission="" data-photonic-submission-pending="">
		<div id="photonic-flow-provider" class="photonic-flow-screen photonic-gallery" data-screen="1">
			<!-- Provider selection -->
			<h1><?php _e('Choose Gallery', 'photonic'); ?></h1>
			<a href="#" class="photonic-gallery-wp" data-provider="wp" title="WordPress"><span class="photonic-source">&nbsp;</span></a>
			<a href="#" class="photonic-gallery-flickr" data-provider="flickr" title="Flickr"><span class="photonic-source">&nbsp;</span></a>
			<a href="#" class="photonic-gallery-picasa" data-provider="picasa" title="Picasa / Google Photos"><span class="photonic-source">&nbsp;</span></a>
			<a href="#" class="photonic-gallery-smugmug" data-provider="smug" title="SmugMug"><span class="photonic-source">&nbsp;</span></a>
			<a href="#" class="photonic-gallery-500px" data-provider="500px" title="500px"><span class="photonic-source">&nbsp;</span></a>
			<a href="#" class="photonic-gallery-zenfolio" data-provider="zenfolio" title="Zenfolio"><span class="photonic-source">&nbsp;</span></a>
			<a href="#" class="photonic-gallery-instagram" data-provider="instagram" title="Instagram"><span class="photonic-source">&nbsp;</span></a>
		</div>

		<!-- "Display Type" selection -->
		<div class="photonic-flow-screen" data-submitted="" data-screen="2">
		</div>

		<!-- Gallery Builder -->
		<div class="photonic-flow-screen" data-submitted="" data-screen="3">
		</div>

		<!-- Layout Selection -->
		<div class="photonic-flow-screen" data-submitted="" data-screen="4">
		</div>

		<!-- Layout Options -->
		<div class="photonic-flow-screen" data-submitted="" data-screen="5">
		</div>

		<!-- Final shortcode -->
		<div class="photonic-flow-screen" data-submitted="" data-screen="6">
		</div>

		<div id="photonic-flow-navigation" class="photonic-flow-navigation">
			<a href="#" id="photonic-nav-previous" class="previous disabled">Previous</a>
			<a href="#" id="photonic-nav-next" class="next">Next</a>
		</div>

		<input type="hidden" id="provider" name="provider"/>
		<input type="hidden" id="selected_data" name="selected_data"/>
	</form>
</div>
