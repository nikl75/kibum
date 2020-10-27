<?php

function kibum_programm_f( $atts ) {
	$a = shortcode_atts( array(
		'ersatz-text' => '<h2>Hier finden Sie bald unser neues Programm</h2><br/>',
        'noch-tage' => 3650,
        'schon-tage' => 3650,
	), $atts);
    
 
    return kibum_build_programm($a['noch-tage'], $a['schon-tage'], $a['ersatz-text']);
}
add_shortcode('kibum-programm', 'kibum_programm_f');

function kibum_build_programm($startScopeTageVersatz, $endScopeTageVersatz, $keinProgrammText)
{
    $tContent = '';

    $startScope = date("Y-m-d", time()-($startScopeTageVersatz*86400));
    $endScope = date("Y-m-d", time()+($endScopeTageVersatz*86400));

    $tScope = $startScope.','.$endScope; 
    
    if(is_user_logged_in()){
        $tContent .= 'INTERN: Termine zwischen '.$startScope.' ('.$startScopeTageVersatz.' Tage in die Vergangenheit) – '.$endScope.' ('.$endScopeTageVersatz.' Tage in die Zukunft) werden angezeigt<br/>';
    }
    $args = array('limit'=>999, 'category'=>'-buchausstellung, -buchausstellung-oeffnungszeit', 'scope'=>$tScope, );
    // $args = array('limit'=>999, 'category'=>'-buchausstellung, -buchausstellung-oeffnungszeit', 'post_id'=>753,);
    $ev = EM_Events::get( $args );	
    $tDayToGroupLast = '';
    if (count((array)$ev) == 0){
        $tContent .= '<h2>'.$keinProgrammText.'</h2><br/>';
    } else {
    $tContent .= '<div class="accordion" data-multi-expand="true" data-allow-all-closed="true" data-deep-link="true" data-responsive-accordion-tabs="accordion medium-tabs">';
    foreach ($ev as $t) {

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
                $tContent .= '</div></div>';
            }
            $args = array('limit'=>1, 'category'=>'buchausstellung-oeffnungszeit', 'scope'=>date("Y-m-d", strtotime($tDayToGroup)));
            $tBuchausstellungOeffnungszeit = EM_Events::get( $args );	
            $tContent .= '<div class="accordion-item" data-accordion-item>
                    <a class="kibum-veranstaltungsliste-hLTG accordion-title" href="#'.$tDayDispID.'" data-accordion>
                        <h2>'.$tDayDisplay.'</h2>
                    </a>

                    <div class="kibum-veranstaltung-liste-tag accordion-content" data-tab-content>';
            if($tBuchausstellungOeffnungszeit){
                $tContent .= '<div id="#'.$tDayDispID.'" class="kibum-veranstaltung-liste-eintrag kibum-liste-buchausstellung row">
                
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
        $tContent .= '<div class="kibum-veranstaltung-liste-eintrag row">';
        if(get_the_post_thumbnail($t->post_id)) { 
            $tContent .= '
                            <div class="kibum-image columns small-12 medium-3">
                                <div class="kibum-image-inside"><a href="'.$t->guid.'">'.get_the_post_thumbnail($t->post_id ,'veran-liste' ).'<div class="kibum-caption">'.get_the_post_thumbnail_caption($t->post_id).'</div></a></div>
                            </div>';
        } 
        $tContent .= '<div class="kibum-content ';
        if(!get_the_post_thumbnail($t->post_id)) {$tContent .= "medium-offset-3";}
        $tContent .= ' columns small-12 medium-6">';

            if(is_user_logged_in()){
                $tContent .= '
                            <div class="kibum-intern-todo">'.$tVerCatToDo .'</div>';
            }
        $tContent .= '
                        <div class="kibum-titel"><a href="'.$t->guid.'">'.$t->name.'</a></div>
                        <div class="kibum-cat">'.$t->event_attributes['kibum_subline'].'</div>
                        <div class="kibum-excerpt">'.wp_trim_words( $t->post_content, 30, '<a href="'.$t->guid.'"> ... [mehr]</a>' ).'</div>
                    </div>';
                    
        $tContent .= '
        <div class="kibum-angaben columns small-12 medium-3 row">
            <div class="kibum-angaben-b01 columns small-6 medium-12">
                <div class="kibum-date">'.date("d.m.y", strtotime($t->event_start_date)).'</div>
                <div class="kibum-time">'.date("H:i", strtotime($t->event_start_time)).' Uhr</div>
                <div class="kibum-location '.$tLocClass.'">'.$tLoc.'</div>
            </div><div class="kibum-angaben-b02 columns small-6 medium-12">
                <div class="kibum-zielgruppe">'.$tVerCatZielgruppen.'</div>
                <div class="kibum-anmeldung">'.get_field('kibum_anmeldung', $t->post_id).'</div>
                '.$tEventSpaces;

                if($t->output('#_EVENTPRICERANGEALL') != 0){
                    $tContent .= '<div class="kibum-kosten">'.$t->output("#_EVENTPRICERANGEALL").' pro TeilnehmerIn</div>';
                } elseif (get_field("kibum_a_ohne_ticket", $t->post_id)) {
                    $tContent .= '
                <div class="kibum-kosten"> '.get_field("kibum_text_liste_a_ohne_ticket", $t->post_id) .' </div>
                ';} else {
                    $tContent .= '
                <div class="kibum-kosten">kostenfrei</div>
                ';}
                if($tTicketName != ''){$tContent .= '
                <div class="kibum-tickets">'.$tTicketName.'</div>
                ';}
        $tContent .= '</div></div></div>';

    }

    $tContent .=    '</div></div></div>';
}
    return $tContent;
}