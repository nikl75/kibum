<?php
/*
Template Name: kibum OHNE TITEL
*/

get_header(); ?>

<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		page-notitle.php
	</div>
</div>


	<?php get_template_part( 'template-parts/featured-image' ); ?>
	<div class="columns">
	<div class="row" data-equalizer>
	<main class="kibum-main-container columns medium-9 kibum-margin-bottom" data-equalizer-watch="top">
		<div class="kibum-white-inside">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'page-notitle' ); ?>
		<?php endwhile; ?>
		</div>
	</main>

	<?php get_sidebar(); ?>	
	</div>
	</div>

<?php
get_footer();
