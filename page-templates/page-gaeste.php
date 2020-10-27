<?php
/*
Template Name: kibum GÄSTE
*/

setlocale(LC_TIME, 'de_DE');

get_header(); ?>

<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		page-gäste.php
	</div>
</div>


	<?php get_template_part( 'template-parts/featured-image' ); ?>
	<div class="columns">
	<div class="row">


		<main class="kibum-main-container columns medium-12 kibum-margin-bottom">
			<div class="kibum-white-inside">
				<?php while ( have_posts() ) : the_post(); ?>
				<?php if(!empty( get_the_content())):?>
				<div class="row kibum-gaeste-content">
					<div class="columns small-12">
						<?php the_content(); ?>
					</div>
				</div>
				<?php endif;?>
				<?php endwhile; ?>

				<div class="accordion kibum-gaeste-accordion" data-accordion data-multi-expand='true' data-allow-all-closed='true' data-deep-link='true' >

				<?php
				
				
				$args = array (
				            'taxonomy' => 'veran-gaeste', //empty string(''), false, 0 don't work, and return empty array
				            'orderby' => 'name',
				            'order' => 'ASC',
				            'hide_empty' => false, //can be 1, '1' too
//				            'include' => 'all', //empty string(''), false, 0 don't work, and return empty array
//				            'exclude' => 'all', //empty string(''), false, 0 don't work, and return empty array
//				            'exclude_tree' => 'all', //empty string(''), false, 0 don't work, and return empty array
//				            'number' => false, //can be 0, '0', '' too
//				            'offset' => '',
//				            'fields' => 'all',
//				            'name' => '',
//				            'slug' => '',
				            'hierarchical' => true, //can be 1, '1' too
//				            'search' => '',
//				            'name__like' => '',
//				            'description__like' => '',
//				            'pad_counts' => false, //can be 0, '0', '' too
//				            'get' => '',
//				            'child_of' => false, //can be 0, '0', '' too
//				            'childless' => false,
//				            'cache_domain' => 'core',
//				            'update_term_meta_cache' => true, //can be 1, '1' too
//				            'meta_query' => '',
//				            'meta_key' => array(),
//				            'meta_value'=> '',
				    );
				
				$terms = get_terms( $args );
				
				foreach ($terms as $t) :
						$tImg = get_field('kibum_gaecat_bild', 'term_'.$t->term_taxonomy_id);

						$args = array('post_type' => 'event', 'veran-gaeste'=>$t->slug, );
						$tEvQ = new WP_Query( $args );
							
						$tEvOut = '';
						if ($tEvQ->post_count != 0) {
							foreach ($tEvQ->posts as $b) {
								
								$tEv = EM_Events::get(array('post_id'=>$b->ID));
//								var_dump($tEv[0]->name);
//echo '<pre>';
//var_dump($tEv);
//echo '</pre>';
								$tEvOut .= '<a class="ev-title" href="'.$tEv[0]->guid.'">'.$tEv[0]->post_title.' </a> –  '.date_i18n("D d.m.", strtotime($tEv[0]->event_start_date)).' '.date_i18n("H:i", strtotime($tEv[0]->event_start_time)).' Uhr<br/>';
//						var_dump($b);
								$tEv = '';
							}
						}
					
						echo '	<div class="accordion-item" data-accordion-item>
									<a class="kibum-gaeste-hLTG accordion-title" href="#'.$t->slug.'" data-accordion>
										<div class="row">
											<div class="columns medium-12">
												<h2>'. $t->name.'</h2>
											</div>
											
										</div>
									</a>
									<div class="kibum-gaeste-liste-content accordion-content " id="'.$t->slug.'"data-tab-content>';
						echo ' 			<div class="row">
						
											<div class="kibum-gaeste-img columns medium-2">
												'.wp_get_attachment_image( $tImg, 'medium' ).'
											</div>
											
											<div class="columns medium-10">
												<div class="beschreibung">
												'.$t->description.'
												</div>
												<div class="veranstaltungen">
												'.$tEvOut.'
												</div>
											</div>
										</div>
										
										';
						
						echo '		</div>
								</div>';
							
				endforeach;
				?>
				</div>


			</div>
		</main>

	</div>
	</div>

<?php
get_footer();
