<?php
/*
Template Name: kibum BUCHAUSSTELLUNG
*/


get_header(); ?>

<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		page-buchausstellung.php
	</div>
</div>


	<?php get_template_part( 'template-parts/featured-image' ); ?>
	<div class="columns">
	<div class="row">


		<main class="kibum-main-container columns medium-12 kibum-margin-bottom" data-equalizer-watch="top">
			<div class="kibum-white-inside">
				<?php while ( have_posts() ) : the_post(); ?>
				
				
					<?php $tVerCat = wp_get_post_terms( $post->ID, 'veran-cat-todo' );
					$tVerCatToDo = '';
					foreach ($tVerCat as $cat) {
						$tVerCatToDo .= ' • '.$cat->name; 
					}
					?>
				
					<?php if(is_user_logged_in()): ?>
					<div class="kibum-intern-todo"><?php echo $tVerCatToDo ?></div>
					<?php endif; ?>
				
				
				
				
				
				
				
				<?php if(!empty( get_the_content())):?>
					<div class="kibum-page-content">
						<?php the_content(); ?>
					</div>
				<?php endif;?>
				<?php endwhile; ?>

				<div class="kibum-buchausstellung-uebersicht" >

				<?php
				$args = array('limit'=>999, 'category'=>'buchausstellung', 'scope'=>'all');
				$ev = EM_Events::get( $args );	
				$tDayToGroupLast = '';
				
				foreach ($ev as $t) :
					
					if($t->output('#_AVAILABLESPACES') == 0 || get_field("kibum_ausgebucht", $t->post_id)) {
						$tEventSpaces = 'AUSGEBUCHT';
					} elseif (get_field("kibum_abgesagt", $t->post_id)) {
						$tEventSpaces = 'ABGESAGT';
					} else {
						if ($t->output('#_AVAILABLESPACES') == 1) {
							$tEventSpaces = $t->output('#_AVAILABLESPACES').' Platz frei';
						} else {
							$tEventSpaces = $t->output('#_AVAILABLESPACES').' Plätze frei';
						}
					}
						
						
					$tDayToGroup = $t->event_start_date;

					$tDayDisplay = date_i18n("D d.m.", strtotime($tDayToGroup));
					
					
					if($tDayToGroup != $tDayToGroupLast){
						if($tDayToGroupLast != ''){
							echo '</div></div></div>';
						}
						$args = array('limit'=>1, 'category'=>'buchausstellung-oeffnungszeit', 'scope'=>date("Y-m-d", strtotime($tDayToGroup)));
						$tBuchausstellungOeffnungszeit = EM_Events::get( $args );	
						echo '<div class="row">
								<div class="kibum-buchausstellungliste-hLTG column medium-2 small-12">
									'.$tDayDisplay.'
								</div>
								<div class="kibum-buchausstellung-liste-tag column medium-10 small-12">
									<div class="row">';
					}
					$tDayToGroupLast = $tDayToGroup;	

			?>
							<div class="kibum-buchausstellung-liste-eintrag column medium-2 small-12">
									<?php if ($tEventSpaces != 'AUSGEBUCHT' && $tEventSpaces != 'ABGESAGT') : ?>
									<a href="<?php echo $t->guid; ?>">
									<?php endif; ?>
										<div class="kibum-time"><?php echo date("H", strtotime($t->event_start_time)); ?>–<?php echo date("H", strtotime($t->event_end_time)); ?> Uhr</div>	
									<?php if ($tEventSpaces != 'AUSGEBUCHT' && $tEventSpaces != 'ABGESAGT') : ?>
									</a>
									<?php endif; ?>									
									<div class="kibum-fplaetze kibum-<?php echo $tEventSpaces; ?>"><?php echo $tEventSpaces; ?></div>
							</div>




<?php
				

				endforeach;
				?>
					</div>
				</div>
				



			</div>
		</main>

	</div>
	</div>

<?php
get_footer();

