<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		single.php
	</div>
</div>

<div class="kibum-featured columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		<?php get_template_part( 'template-parts/featured-image' ); ?>
	</div>
</div>

<main class="kibum-main-container columns medium-9 kibum-margin-bottom">
	<div class="kibum-white-inside">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', '' ); ?>
			<?php the_post_navigation(); ?>
			<?php comments_template(); ?>
		<?php endwhile; ?>
	</div>
</main>

	<?php get_sidebar(); ?>

<?php get_footer();
