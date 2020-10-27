<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 *
 *
 * -------------------
 * code friedhof
 * -------------------
 *
 * ltg post navigation: nicht benutzt, da posts nach veröffentlichungsdatum sortiert werden.
 * <div class="kibum-postnav columns kibum-margin-bottom">
 *	<div class="kibum-white-inside">
 *			<?php the_post_navigation(); ?>
 *	</div>
 * </div>
 * andere lösung: https://codex.wordpress.org/Function_Reference/get_adjacent_post
 *
 *
 */

get_header(); 

?>

<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		single-term-buchausstellung.php
	</div>
</div>

	<div class="kibum-featured columns kibum-margin-bottom">
			<?php get_template_part( 'template-parts/featured-image' ); ?>
	</div>




	<div class="columns">
		<div class="row" data-equalizer>	
		<main class="kibum-main-container kibum-buchausstellung columns medium-7 kibum-margin-bottom" data-equalizer-watch="top">
				<div class="kibum-white-inside">


				<?php while ( have_posts() ) : the_post(); ?>
					<?php  

						$EM_Event = em_get_event($post->ID, 'post_id');
						echo '<h1 class="entry-title">'.$EM_Event->output('#_EVENTDATES').'<br/>'.$EM_Event->output('#_24HSTARTTIME').' – '.$EM_Event->output('#_24HENDTIME').'</h1>';
						
						
						if($EM_Event->output('#_AVAILABLESPACES') == 0 || get_field("kibum_ausgebucht", $EM_Event->post_id)) {

							echo '<div class="kibum-fplaetze single-event kibum-ausgebucht">Ausgebucht</div>';
						} elseif (get_field("kibum_abgesagt", $EM_Event->post_id)) {
							echo '<div class="kibum-fplaetze single-event kibum-ausgebucht">Abgesagt</div>';
						} else {
							echo $EM_Event->output('#_BOOKINGFORM');
						}
						// debug stuff ltg
						echo '<div class="kibum-debug"><pre>';
						echo $EM_Event->output('#_AVAILABLESPACES').' #_AVAILABLESPACES<br/>';
						echo $EM_Event->output('#_BOOKEDSPACES').' #_BOOKEDSPACES<br/>';
						echo $EM_Event->output('#_SPACES').' #_SPACES<br/>';
						echo '<br/></pre></div>';
						
						// debug stuff ltg
					?>
<div class="kibum-debug">
	<small>				
	<pre><?php var_dump($EM_Event) ?></pre>
	</small>
</div>

		
				</div>

		</main>
		
		<aside class="kibum-sidebar columns medium-5 kibum-margin-bottom" data-equalizer-watch="top">
			<div class="kibum-white-inside">
	
				<?php
				$args = array('limit'=>999, 'category'=>'buchausstellung', 'scope'=>'all', );
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
						echo '<div class="row kibum-buchausstellung-uebersicht">
								<div class="kibum-buchausstellungliste-hLTG-sidebar column small-12">
									'.$tDayDisplay.'
								</div>
								<div class="kibum-buchausstellung-liste-tag column small-12">
									<div class="row">';
					}
					$tDayToGroupLast = $tDayToGroup;	
				?>
							<div class="kibum-buchausstellung-liste-eintrag column medium-4 small-12">
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
			
		</aside>
			
		
		
		
	</div>
</div>

	<?php endwhile; ?>




<?php get_footer();

