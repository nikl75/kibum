<?php
/*
Template Name: kibum LISTE VERANS (INTERN)
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
				<div >

				<?php
				$args = array('limit'=>999, 'category'=>' -buchausstellung-oeffnungszeit', 'scope'=>'all', );
//				$args = array('limit'=>999, 'category'=>'-buchausstellung, -buchausstellung-oeffnungszeit', 'post_id'=>753,);
				$ev = EM_Events::get( $args );	
				$tDayToGroupLast = '';
				
				foreach ($ev as $t) :


					if($t->event_rsvp == 0){
						$tEventSpaces = '';
					} elseif ($t->output('#_AVAILABLESPACES') == 0 || get_field("kibum_ausgebucht", $t->post_id)) {
						$tEventSpaces = '<div class="kibum-fplaetze kibum-AUSGEBUCHT">AUSGEBUCHT</div>';;
					} elseif (get_field("kibum_abgesagt", $t->post_id)) {
						$tEventSpaces = '<div class="kibum-fplaetze kibum-ABGESAGT">ABGESAGT</div>';;
					} else {
						if ($t->output('#_AVAILABLESPACES') == 1) {
							$tEventSpaces = '<div class="kibum-fplaetze kibum-'.$t->output('#_AVAILABLESPACES').'">'.$t->output('#_AVAILABLESPACES').' Platz frei</div>';
						} else {
							$tEventSpaces = '<div class="kibum-fplaetze kibum-'.$t->output('#_AVAILABLESPACES').'">'.$t->output('#_AVAILABLESPACES').' Plätze frei</div>';
						}
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
						echo '<div class="" >
								<a class="kibum-veranstaltungsliste-hLTG "  >
									<h2 style="border-bottom:1px #55f solid;margin-top:3rem;padding:0;background-color:#eee;">'.$tDayDisplay.'</h2>
								</a>
								<div class="kibum-veranstaltung-liste-tag " >';
						if($tBuchausstellungOeffnungszeit){
							echo '<div id="#'.$tDayDispID.'" class="kibum-veranstlatung-liste-eintrag kibum-liste-buchausstellung row">
							
									<div class="kibum-image columns small-12 medium-6">
										<div class="kibum-ausstellungs-oeffnungszeit"><div class="kibum-titel"><a href="'.get_site_url().'/ausstellung/">'. $tBuchausstellungOeffnungszeit[0]->name .'</a></div><div class="uhr">Am '.date("d.m.y", strtotime($tBuchausstellungOeffnungszeit[0]->event_start_date)).' von '.date("H:i", strtotime($tBuchausstellungOeffnungszeit[0]->event_start_time)).' – '.
													date("H:i", strtotime($tBuchausstellungOeffnungszeit[0]->event_end_time)).' Uhr.</div><div class="kibum-excerpt"></div></div>
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
					
					$tTicketList = '';
					$EM_Tickets = $t->get_bookings()->get_tickets();
					foreach ($EM_Tickets as $EM_Ticket) {
						$tTicketList .= $EM_Ticket->ticket_spaces." | ".$EM_Ticket->ticket_name." | ".$EM_Ticket->ticket_name."<br/>";
					}
					$tT = '';
					if($t->event_rsvp_spaces || $t->event_spaces){
						$tT = "| sp ".$t->event_spaces." | sp rsvp ".$t->event_rsvp_spaces." |";
						if($t->event_spaces >= $t->event_rsvp_spaces){
							$tT .= "<h1 style='color:#0f0;'>+</h1>";
						} else {
							$tT .= "<h1 style='color:#f00;'>-</h1>";
							
						}
					}
					
//					echo "<pre>";
//					var_dump($t);
//					echo "</pre>";
			?>
						
							<div class="kibum-veranstlatung-liste-eintrag row">
								<div class="kibum-image columns small-12 medium-3">
									<!--<div class="kibum-image-inside"><a href="<?php echo $t->guid; ?>"><?php echo get_the_post_thumbnail($t->post_id ,'veran-liste' );?><div class="kibum-caption"><?php echo get_the_post_thumbnail_caption($t->post_id); ?></div></a></div>-->
								</div>
								<div class="kibum-content columns small-12 medium-6">
<!--									<?php if(is_user_logged_in()): ?>
									<div class="kibum-intern-todo"><?php echo $tVerCatToDo ?></div>
									<?php endif; ?>-->
									<div class="kibum-time"><?php echo date("H:i", strtotime($t->event_start_time)); ?> Uhr</div>
									<div class="kibum-titel"><a href="<?php echo $t->guid; ?>"><?php echo $t->name; ?></a></div>
									<!--<div class="kibum-cat"><?php echo $t->event_attributes['kibum_subline']; ?></div>-->
									<!--<div class="kibum-excerpt"><?php echo wp_trim_words( $t->post_content, 30, '<a href="'.$t->guid.'"> ... [mehr]</a>' ); ?></div>-->
								</div>
								<div class="kibum-angaben columns small-12 medium-3 row">
									<!--<div class="kibum-angaben-b01 columns small-6 medium-12">-->
										<!--<div class="kibum-date"><?php echo date("d.m.y", strtotime($t->event_start_date)); ?></div>-->
										<!--<div class="kibum-location <?php echo $tLocClass; ?>"><?php echo $tLoc; ?></div>-->
									<!--</div>-->
									<div class="kibum-angaben-b02 columns small-6 medium-12">
										<!--<div class="kibum-zielgruppe"><?php echo $tVerCatZielgruppen; ?></div>-->
<!--										<div class="kibum-anmeldung"><?php echo the_field('kibum_anmeldung', $t->post_id); ?></div>
										<?php echo $tEventSpaces; ?>
										<?php if($t->output('#_EVENTPRICERANGEALL') != 0):?>
										<div class="kibum-kosten"><?php echo $t->output('#_EVENTPRICERANGEALL');?> pro TeilnehmerIn</div>
										<?php else : ?>
										<div class="kibum-kosten">kostenfrei</div>
										<?php endif; ?>-->
										<div class=""><?php echo($t->event_id) ?> | <?php echo($t->post_id) ?> <?php echo($tT) ?></div>
										<div class="kibum-tickets"><?php echo $tTicketList; ?></div>
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
