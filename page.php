<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		page.php
	</div>
</div>


	<?php get_template_part( 'template-parts/featured-image' ); ?>
	<div class="columns">
	<div class="row" data-equalizer>
	<main class="kibum-main-container columns medium-9 kibum-margin-bottom" data-equalizer-watch="top">
		<div class="kibum-white-inside">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'page' ); ?>
			<?php comments_template(); ?>
		<?php endwhile; ?>
		</div>
	</main>

	<?php get_sidebar(); ?>	
	</div>
	</div>

<?php
get_footer();
