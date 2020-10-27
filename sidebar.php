<?php
/**
 * The sidebar containing the main widget area
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

<aside class="kibum-sidebar columns medium-3 kibum-margin-bottom" data-equalizer-watch="top">
	<div class="kibum-white-inside">
	<div class="row">
		<?php dynamic_sidebar( 'sidebar-widgets' ); ?>
	</div>
	</div>
</aside>
