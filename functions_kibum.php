<?php 

add_image_size("veran-liste",500, 9999, false);


function my_single_template( $template )
{
    // Get the current single post object
    $post = get_queried_object();
    // Set our 'constant' folder path
    $path = 'single-templates/';

    // Set our variable to hold our templates
    $templates = array();

    // Get the post categories
    $categories = get_the_category( $post->ID );
    
    // Just for incase, check if we have categories
    if ( $categories ) {
        foreach ( $categories as $category ) {
            // Create possible template names
            $templates[] = $path . 'single-cat-' . $category->slug . '.php';
            $templates[] = $path . 'single-cat-' . $category->term_id . '.php';
        } //endforeach
    } //endif $categories
        
    // Get the post terms (custom categories of type event-categories)
    $terms = get_the_terms( $post->ID, 'event-categories');

	// Just for incase, check if we have categories
	if ( $terms ) {
	    foreach ( $terms as $term ) {
	        // Create possible template names
	        $templates[] = $path . 'single-term-' . $term->slug . '.php';
	        $templates[] = $path . 'single-term-' . $term->term_id . '.php';
	    } //endforeach
	} //endif $categories
    
 	// Lets handle the custom post type section
 	if ( 'post' !== $post->post_type ) {
 	    $templates[] = $path . 'single-' . $post->post_type . '-' . $post->post_name . '.php';
 	    $templates[] = $path . 'single-' . $post->post_type . '.php';
 	}

    // Set our fallback templates
    $templates[] = $path . 'single.php';
    $templates[] = $path . 'default.php';
    $templates[] = 'index.php';

    /**
     * Now we can search for our templates and load the first one we find
     * We will use the array ability of locate_template here
     */
    $template = locate_template( $templates );
	
    // Return the template rteurned by locate_template
    return $template;
}
add_filter( 'single_template', 'my_single_template');


/*-------------------------------*/
/* CUSTOM GALLERY OUTPUT 
/*-------------------------------*/
function my_post_gallery($output, $attr) {
    global $post;
    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }
    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
    ), $attr));
    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';
    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }
    if (empty($attachments)) return '';
    if (!isset($attr['columns'])){
    	$attr['columns']=3;
    }
    
    // Here's your actual output, you may customize it to your needs
    $output = '<div class="kibum-galerie galerie row">';

    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {
        // Fetch the thumbnail (or full image, it's up to you)
//      $img = wp_get_attachment_image_src($id, 'medium');
//      $img = wp_get_attachment_image_src($id, 'my-custom-image-size');
        $img = wp_get_attachment_image_src($id, 'full');
        $output .= '<div class="columns galerie-item medium-'.$attr['columns'].' small-12"><div class="kibum-galerie-wrapper"><div class="kibum-galerie-inside" style="background: url('.$img[0].'); " >';
        $output .= '';
        $output .= '</div></div></div>';
    }
    $output .= '</div>';
    return $output;
}
add_filter('post_gallery', 'my_post_gallery', 10, 2);


function ltg_customize_register( $wp_customize ) {

	$wp_customize->remove_control( 'background_color' );
 	$wp_customize->remove_setting( 'background_color' );
 
    // Inlcude the Alpha Color Picker control file.
    require_once get_template_directory() . '/dist/assets/extensions/alpha-color-picker/alpha-color-picker.php';
 
    $wp_customize->add_setting(
        'frame_alpha_color_setting',
        array(
            'default'    => 'rgba(222, 22, 22, 0.3)',
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport'  => 'refresh'
        )
    );
    $wp_customize->add_control(
        new Customize_Alpha_Color_Control(
            $wp_customize,
            'frame_alpha_color_control',
            array(
                'label'        => 'Rahmen Farbe',
                'section'      => 'colors',
                'settings'     => 'frame_alpha_color_setting',
                'show_opacity' => true, // Optional.
                'palette'      => array(
                    'rgba(222, 22, 22, 0.3)',
                    'rgba(105, 221, 23, 0.2)',
                    'rgba( 55, 55, 55, 0.2 )',
                )
            )
        )
    );
    
    $wp_customize->add_setting(
        'font_color_setting',
        array(
            'default'    => '#000',
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport'  => 'refresh'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'font_color_control',
            array(
                'label'        => 'Schrift Farbe',
                'section'      => 'colors',
                'settings'     => 'font_color_setting',
                'palette'      => array(
                    'rgb(222, 22, 22)',
                    'rgb(105, 221, 23)',
                    'rgb( 55, 55, 55)',
                )
            )
        )
    );

    $wp_customize->add_setting(
        'footer_color_setting',
        array(
            'default'    => '#DDD',
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport'  => 'refresh'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_color_control',
            array(
                'label'        => 'Fuß Farbe',
                'section'      => 'colors',
                'settings'     => 'footer_color_setting',
                'palette'      => array(
                    'rgb(222, 22, 22)',
                    'rgb(105, 221, 23)',
                    'rgb( 55, 55, 55)',
                )
            )
        )
    );

}
add_action( 'customize_register', 'ltg_customize_register' );


function ltg_customizer_head_styles() {
	$frame_alpha_color = get_theme_mod( 'frame_alpha_color_setting' ); 
    $body_font_color = get_theme_mod( 'font_color_setting' ); 
    $footer_color = get_theme_mod('footer_color_setting');
	
	?> <style id="ltg_customizer_color" type="text/css"> <?php
	
	if ( $frame_alpha_color != '' ) :
	?>
		.kibum-outer-row.kibum-top, .kibum-outer-row.kibum-main {
			background-color: <?php echo $frame_alpha_color; ?>;
		}
	<?php
	endif;

	if ( $body_font_color != '' ) :
	?>
		body, .kibum-description a {
			color: <?php echo $body_font_color; ?>;
		}
	<?php
    endif;
 
    if ( $footer_color != '' ) :
    ?>
        footer  .kibum-white-darker-inside {
            background-color: <?php echo $footer_color; ?>;
        }
    <?php
    endif;

   

	?> </style> <?php
}
add_action( 'wp_head', 'ltg_customizer_head_styles' );







function ltg_theme_setup() {
	// add Gutenberg align-wide and align-full support
	add_theme_support( 'align-wide' );
	
	// custom header image
	$defaults_header = array(
	    'default-image' 			 => get_template_directory_uri() . '/dist/assets/images/corporate/kibum_medallion.png',
		'width'					 => 700,
		'height'				 => 620,
	    'flex-height'            => false,
	    'flex-width'             => false,
	    'header-text'            => false,
	    'uploads'                => true,
	    'random-default'         => false,
	    'wp-head-callback'       => '',
	    'admin-head-callback'    => '',
	    'admin-preview-callback' => '',
	    'video'                  => false,
	    'video-active-callback'  => 'is_front_page',
	);
	add_theme_support( 'custom-header', $defaults_header );
	
	// custom background image
	$defaults_bg = array(
		'default-color'          => '#888',
		'default-image'          => get_template_directory_uri() . '/dist/assets/images/corporate/kibum_hintergrund.jpg',
		'default-repeat'         => 'no-repeat',
		'default-position-x'     => 'center',
	    'default-position-y'     => 'top',
	    'default-size'           => 'cover',
		'default-attachment'     => 'fixed',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => 'true'
	);
    add_theme_support( 'custom-background', $defaults_bg );
    
    $defaults_logo = array(
        'height'      => 200,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo' => true,
    );
    add_theme_support( 'custom-logo', $defaults_logo );
}
add_action( 'after_setup_theme', 'ltg_theme_setup', 100 );


