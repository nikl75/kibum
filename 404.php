<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>


<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		404.php
	</div>
</div>


	<div class="columns">
	<div class="row" data-equalizer>
	<main class="kibum-main-container columns medium-9 kibum-margin-bottom" data-equalizer-watch="top">
		<div class="kibum-white-inside">
<article>
	<header>
		<h1 class="entry-title"><?php _e( 'File Not Found', 'foundationpress' ); ?></h1>
	</header>
	<div class="entry-content">
		<div class="error">
			<p class="bottom"><?php _e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'foundationpress' ); ?></p>
		</div>
		<p><?php _e( 'Please try the following:', 'foundationpress' ); ?></p>
		<ul>
			<li>
				<?php _e( 'Check your spelling', 'foundationpress' ); ?>
			</li>
			<li>
				<?php
					/* translators: %s: home page url */
					printf(
						__( 'Return to the <a href="%s">home page</a>', 'foundationpress' ),
						home_url()
					);
				?>
			</li>
			<li>
				<?php _e( 'Click the <a href="javascript:history.back()">Back</a> button', 'foundationpress' ); ?>
			</li>
		</ul>
	</div>
</article>
		</div>
	</main>

	<?php get_sidebar(); ?>	
	</div>
</div>

<?php get_footer();
