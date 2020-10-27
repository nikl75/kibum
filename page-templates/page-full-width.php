<?php
/*
Template Name: Full Width
*/
get_header(); ?>

<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		page-full-width.php
	</div>
</div>

<?php get_template_part( 'template-parts/featured-image' ); ?>
<main class="kibum-main-container columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'page' ); ?>
			<?php comments_template(); ?>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer();
