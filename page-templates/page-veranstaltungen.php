<?php
/*
Template Name: kibum VERANSTALTUNGEN
*/

setlocale(LC_TIME, 'de_DE');

get_header(); ?>

<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		page-veranstaltungen.php
	</div>
</div>


	<?php get_template_part( 'template-parts/featured-image' ); ?>
	<div class="columns">
	<div class="row">


		<main class="kibum-main-container columns medium-12 kibum-margin-bottom" data-equalizer-watch="top">
			<div class="kibum-white-inside">
				<?php while ( have_posts() ) : the_post(); ?>
				<?php if(!empty( get_the_content())):?>
					<div class="kibum-page-content">
						<?php the_content(); ?>
					</div>
				<?php endif;?>
				<?php endwhile; ?>
				
			</div>
		</main>

	</div>
	</div>

<?php
get_footer();
