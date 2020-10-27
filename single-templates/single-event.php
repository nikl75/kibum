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

get_header(); ?>

<div class="kibum-debug columns kibum-margin-bottom">
	<div class="kibum-white-inside">
		single-event.php
	</div>
</div>

<?php if(is_user_logged_in()): ?>
<div class="columns kibum-margin-bottom kibum-logged-in-nav">
	<div class="kibum-white-inside">
		<nav class="navigation post-navigation">
			<div class="nav-links">		
				<div class="nav-previous">
					<?php previous_post_link_plus( array(
					
					                    'order_by' => 'custom',
					                    'order_2nd' => 'post_title',
					                    'meta_key' => '_event_start',			
					                    'post_type' => '',
					                    'loop' => true,
					                    'end_post' => false,
					                    'thumb' => false,
					                    'max_length' => 50,
					                    'format' => '%link <br/> <span style="font-size:0.7rem;">%meta</span>',
					                    'link' => '%title',
					                    'date_format' => '',
					                    'tooltip' => '%title',
					                    'in_same_cat' => false,
					                    'in_same_tax' => false,
					                    'in_same_format' => false,
					                    'in_same_author' => false,
					                    'in_same_meta' => false,
					                    'ex_cats' => '210,175',
					                    'ex_cats_method' => 'strong',
					                    'in_cats' => '',
					                    'ex_posts' => '',
					                    'in_posts' => '',
					                    'before' => '',
					                    'after' => '',
					                    'num_results' => 1,
					                    'return' => ''			
					 ) ); ?>
				</div>	
				<div class="nav-next">
					<?php next_post_link_plus( array(
					
					                    'order_by' => 'custom',
					                    'order_2nd' => 'post_title',
					                    'meta_key' => '_event_start',			
					                    'post_type' => '',
					                    'loop' => true,
					                    'end_post' => false,
					                    'thumb' => false,
					                    'max_length' => 50,
					                    'format' => '%link <br/> <span style="font-size:0.7rem;">%meta</span>',
					                    'link' => '%title',
					                    'date_format' => '',
					                    'tooltip' => '%title',
					                    'in_same_cat' => false,
					                    'in_same_tax' => false,
					                    'in_same_format' => false,
					                    'in_same_author' => false,
					                    'in_same_meta' => false,
					                    'ex_cats' => '210,175',
					                    'ex_cats_method' => 'strong',
					                    'in_cats' => '',
					                    'ex_posts' => '',
					                    'in_posts' => '',
					                    'before' => '',
					                    'after' => '',
					                    'num_results' => 1,
					                    'return' => ''			
					 ) ); 	?>		
				</div>
			</div>
		</nav>
	</div>
</div>
<?php endif; ?>

<div class="kibum-featured columns kibum-margin-bottom">
		<?php get_template_part( 'template-parts/featured-image' ); ?>
</div>





	<div class="columns">
		<div class="row" data-equalizer data-equalize-on="medium">	
		<main class="kibum-main-container kibum-veranstaltung columns medium-8 kibum-margin-bottom" data-equalizer-watch>
			<div class="kibum-white-inside">
				<article class="event">
					<?php while ( have_posts() ) : the_post(); 
					$EM_Event = em_get_event($post->ID, 'post_id');
					
					
					if(($EM_Event->output('#_AVAILABLESPACES') == 0 && $EM_Event->event_rsvp == 1) || get_field("kibum_ausgebucht", $EM_Event->post_id)) {
						$tEventSpaces = 'AUSGEBUCHT';
					} elseif (get_field("kibum_abgesagt", $EM_Event->post_id)) {
						$tEventSpaces = 'ABGESAGT';
					} else {
						if ($EM_Event->output('#_AVAILABLESPACES') == 1) {
							$tEventSpaces = $EM_Event->output('#_AVAILABLESPACES').' Platz frei';
						} else {
							$tEventSpaces = $EM_Event->output('#_AVAILABLESPACES').' Plätze frei';
						}
					}
					
					
					$tVerCat = wp_get_post_terms( $post->ID, 'veran-cat-todo' );
					$tVerCatToDo = '';
					foreach ($tVerCat as $cat) {
						$tVerCatToDo .= ' • '.$cat->name;
					}
					
					
					?>
					
					<?php if(is_user_logged_in()): ?>
					<div class="kibum-intern-todo"><?php echo $tVerCatToDo ?></div>
					<?php endif; ?>
					
					<header>
						<h1 class="entry-title"><?php echo $EM_Event->output('#_EVENTNAME');?></h1>
					</header>
					<div class="entry-content">
					
						<div class="kibum-uhr-datum"><?php echo $EM_Event->output('#_EVENTDATES');?><br/><?php echo $EM_Event->output('#_EVENTTIMES');?> Uhr</div>
						<br/>
						<div class="kibum-ort"><?php echo $EM_Event->output('#_LOCATIONNAME');?></div>
						<div class="kibum-zielgruppe"><?php echo $EM_Event->output('#_ZIELGRUPPE');?></div>
						<div class="kibum-cat"><?php echo $EM_Event->output('#_CATEGORYNAME');?></div>
						<?php if ($EM_Event->output('#_EVENTPRICERANGEALL') != 0) : ?>
						<div class="kibum-kosten"><?php echo $EM_Event->output('#_EVENTPRICERANGEALL');?> pro TeilnehmerIn</div>
						<?php else : ?>
						<div class="kibum-kosten">kostenfrei</div>
						<?php endif; ?>
						<br/>
						<div class="kibum-sub"><?php echo wpautop($EM_Event->output('#_ATT{kibum_subline}'));?></div>
						<br/>
						<div class="kibum-eventnotes"><?php echo $EM_Event->output('#_EVENTNOTES');?></div>
					</div>
				</article>
				
				
				
				
				<?php if(is_user_logged_in()): ?>
				<div class="kibum-intern">
				<h3>------ INTERN --------</h3>
				<label>Programm Kurzbeschreibung</label>
				<?php echo get_field('kibum_kurzbeschreibung'); ?>
				<label>Plätze gesamt: </label><?php echo $EM_Event->output('#_SPACES') ?><br/>
				<label>Freie Plätze: </label><?php echo $EM_Event->output('#_AVAILABLESPACES') ?><br/>
				</div>
				<?php endif; ?>
				
				
				
				
				
				
			</div>
		</main>
					
			
		
		<aside class="kibum-sidebar columns medium-4 kibum-margin-bottom " data-equalizer-watch>
			<div class="kibum-white-inside">
				<div class="row">
					<div class="columns"><h3>Anmeldung</h3>
						
						
						<?php if ($EM_Event->output('#_SPACES') == 0 && !get_field("kibum_a_ohne_ticket", $EM_Event->post_id)) : ?>
							<div class="kibum-fplaetze single-event ">... ist für diese Veranstaltung nicht erforderlich.</div>
						<?php elseif ($tEventSpaces != 'AUSGEBUCHT' && $tEventSpaces != 'ABGESAGT') : ?>
							<?php if(get_field("kibum_a_ohne_ticket", $EM_Event->post_id)) :?>
								<div class="kibum-fplaetze single-event "><?php echo get_field("kibum_text_event_a_ohne_ticket", $EM_Event->post_id) ?></div>
							<?php else : ?>
								<div class="kibum-fplaetze single-event kibum-<?php echo $tEventSpaces; ?>">Bitte jede Klasse einzeln anmelden. <br/><?php echo $tEventSpaces; ?></div>
								<?php echo $EM_Event->output('#_BOOKINGFORM');?>
							<?php endif; ?>
						<?php else : ?>
							<div class="kibum-fplaetze single-event kibum-<?php echo $tEventSpaces; ?>"><?php echo $tEventSpaces; ?></div>
						
						<?php endif; ?>
						
					</div>
				</div>
			</div>
		</aside>
		</div>
	</div>





		
				<?php endwhile; ?>



<?php get_footer();
