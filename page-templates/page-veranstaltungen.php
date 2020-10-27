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
				<div class="accordion" data-multi-expand='true' data-allow-all-closed='true' data-deep-link='true' data-responsive-accordion-tabs='accordion medium-tabs'>

				<?php
				$args = array('limit'=>999, 'category'=>'-buchausstellung, -buchausstellung-oeffnungszeit', 'scope'=>'all', );
//				$args = array('limit'=>999, 'category'=>'-buchausstellung, -buchausstellung-oeffnungszeit', 'post_id'=>753,);
				$ev = EM_Events::get( $args );	
				$tDayToGroupLast = '';
				
				foreach ($ev as $t) :


					if (($t->output('#_AVAILABLESPACES') == 0 &&  $t->event_rsvp == 1) || get_field("kibum_ausgebucht", $t->post_id)) {
						$tEventSpaces = '<div class="kibum-fplaetze kibum-AUSGEBUCHT">AUSGEBUCHT</div>';;
					} elseif (get_field("kibum_abgesagt", $t->post_id)) {
						$tEventSpaces = '<div class="kibum-fplaetze kibum-ABGESAGT">ABGESAGT</div>';;
					} elseif ($t->event_rsvp == 1) {
						if ($t->output('#_AVAILABLESPACES') == 1) {
							$tEventSpaces = '<div class="kibum-fplaetze kibum-'.$t->output('#_AVAILABLESPACES').'">'.$t->output('#_AVAILABLESPACES').' Platz frei</div>';
						} else {
							$tEventSpaces = '<div class="kibum-fplaetze kibum-'.$t->output('#_AVAILABLESPACES').'">'.$t->output('#_AVAILABLESPACES').' Plätze frei</div>';
						}
					} else {
						$tEventSpaces = '';
					}



						
						
					$tDayToGroup = $t->event_start_date;

					$tDayDisplay = date_i18n("D d.m.", strtotime($tDayToGroup));
					$tDayDispID  = date_i18n("D-dmy", strtotime($tDayToGroup));
					
					if($tDayToGroup != $tDayToGroupLast){
						if($tDayToGroupLast != ''){
							echo '</div></div>';
						}
						$args = array('limit'=>1, 'category'=>'buchausstellung-oeffnungszeit', 'scope'=>date("Y-m-d", strtotime($tDayToGroup)));
						$tBuchausstellungOeffnungszeit = EM_Events::get( $args );	
						echo '<div class="accordion-item" data-accordion-item>
								<a class="kibum-veranstaltungsliste-hLTG accordion-title" href="#'.$tDayDispID.'" data-accordion>
									<h2>'.$tDayDisplay.'</h2>
								</a>
								<div class="kibum-veranstaltung-liste-tag accordion-content" data-tab-content>';
						if($tBuchausstellungOeffnungszeit){
							echo '<div id="#'.$tDayDispID.'" class="kibum-veranstlatung-liste-eintrag kibum-liste-buchausstellung row">
							
									<div class="kibum-image columns small-12 medium-6 medium-offset-3">
										<div class="kibum-ausstellungs-oeffnungszeit"><div class="kibum-titel"><a href="'.get_site_url().'/ausstellung/">'. $tBuchausstellungOeffnungszeit[0]->name .'</a></div><div class="uhr">Am '.date("d.m.y", strtotime($tBuchausstellungOeffnungszeit[0]->event_start_date)).' von '.date("H:i", strtotime($tBuchausstellungOeffnungszeit[0]->event_start_time)).' – '.
													date("H:i", strtotime($tBuchausstellungOeffnungszeit[0]->event_end_time)).' Uhr.</div><div class="kibum-excerpt">'.$tBuchausstellungOeffnungszeit[0]->post_content.'</div></div>
									</div>
								</div>';
						}
					}
					$tDayToGroupLast = $tDayToGroup;	
										
					$tVerCat = wp_get_post_terms( $t->post_id, 'veran-cat-zielgruppe' );
					$tVerCatZielgruppen = '';
					foreach ($tVerCat as $cat) {
						$tVerCatZielgruppen .= $cat->name.'<br/>';
					}
					
					$tVerCat = wp_get_post_terms( $t->post_id, 'event-categories' );
					$tVerCatCat = '';
					foreach ($tVerCat as $cat) {
						$tVerCatCat .= $cat->name.'<br/>';
					}
					
					$tVerCat = wp_get_post_terms( $t->post_id, 'veran-gaeste' );
					$tVerCatGaeste = '';
					foreach ($tVerCat as $cat) {
						$tVerCatGaeste .= $cat->name.'<br/>';
					}
					
					$tVerCat = wp_get_post_terms( $t->post_id, 'veran-cat-todo' );
					$tVerCatToDo = '';
					foreach ($tVerCat as $cat) {
						$tVerCatToDo .= ' • '.$cat->name;
					}
					
					$tLoc = '';
					$tLocClass = '';
					if ($t->location_id) {
						$tEvLoc = EM_Locations::get($t->location_id);
						foreach ($tEvLoc as $loc) {
							$tLoc .= $loc->location_name.'<br/>';
							$tLocClass .= $loc->slug.' ';
						}
					}
					
					$tTicketName = '';
					$EM_Tickets = $t->get_bookings()->get_tickets();
					foreach ($EM_Tickets as $EM_Ticket) {
						if( $EM_Ticket->is_displayable() ){
							$tTicketName .= $EM_Ticket->ticket_name." buchbar<br/>";
						}
					}
//					echo "<pre>";
//					var_dump($EM_Tickets);
//					echo "</pre>";
			?>
						
							<div class="kibum-veranstlatung-liste-eintrag row">
								<?php 
									if(get_the_post_thumbnail($t->post_id)) : 
								?>
								<div class="kibum-image columns small-12 medium-3">
									<div class="kibum-image-inside"><a href="<?php echo $t->guid; ?>"><?php echo get_the_post_thumbnail($t->post_id ,'veran-liste' );?><div class="kibum-caption"><?php echo get_the_post_thumbnail_caption($t->post_id); ?></div></a></div>
								</div>
								<?php endif; ?>
								<div class="kibum-content <?php if(!get_the_post_thumbnail($t->post_id)) { echo "medium-offset-3";} ?> columns small-12 medium-6">
									<?php if(is_user_logged_in()): ?>
									<div class="kibum-intern-todo"><?php echo $tVerCatToDo ?></div>
									<?php endif; ?>
									<div class="kibum-titel"><a href="<?php echo $t->guid; ?>"><?php echo $t->name; ?></a></div>
									<div class="kibum-cat"><?php echo $t->event_attributes['kibum_subline']; ?></div>
									<div class="kibum-excerpt"><?php echo wp_trim_words( $t->post_content, 30, '<a href="'.$t->guid.'"> ... [mehr]</a>' ); ?></div>
								</div>
								<div class="kibum-angaben columns small-12 medium-3 row">
									<div class="kibum-angaben-b01 columns small-6 medium-12">
										<div class="kibum-date"><?php echo date("d.m.y", strtotime($t->event_start_date)); ?></div>
										<div class="kibum-time"><?php echo date("H:i", strtotime($t->event_start_time)); ?> Uhr</div>
										<div class="kibum-location <?php echo $tLocClass; ?>"><?php echo $tLoc; ?></div>
									</div><div class="kibum-angaben-b02 columns small-6 medium-12">
										<div class="kibum-zielgruppe"><?php echo $tVerCatZielgruppen; ?></div>
										<div class="kibum-anmeldung"><?php echo the_field('kibum_anmeldung', $t->post_id); ?></div>
										<?php echo $tEventSpaces; ?>
										<?php if($t->output('#_EVENTPRICERANGEALL') != 0):?>
										<div class="kibum-kosten"><?php echo $t->output('#_EVENTPRICERANGEALL');?> pro TeilnehmerIn</div>
										<?php elseif (get_field("kibum_a_ohne_ticket", $t->post_id)) : ?>
										<div class="kibum-kosten"> <?php echo get_field("kibum_text_liste_a_ohne_ticket", $t->post_id) ?> </div>
										<?php else : ?>
										<div class="kibum-kosten">kostenfrei</div>
										<?php endif; ?>
										<?php if($tTicketName != ''):?>
										<div class="kibum-tickets"><?php echo $tTicketName; ?></div>
										<?php endif; ?>
										
									</div>
								</div>
							</div>
						





<?php
				

				endforeach;
				?>
					</div>



			</div>
		</main>

	</div>
	</div>

<?php
get_footer();
