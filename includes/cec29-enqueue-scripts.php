<?php
/**
 *
 * afficher les nouveaux champs dans le profil utilisateur
 *
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.2.0
 *
 * @package    cec29-functions
 * @subpackage cec29-functions/includes
 */

// echo '<H3>hors de la fonction</H3>' ; 
if (! function_exists('cec29_enqueue_scripts') ){
	function cec29_enqueue_scripts() {
	
	// enqueue css
	
	wp_register_style(
		'cec29_admin_style',
		CEC29_ALD_DIR_URL . 'css/admin-style.css' ,
		array(),
		null,
		'all' // no media type
	);

	wp_enqueue_style( 'cec29_admin_style' ) ;

	// echo '<H3>Dans la fonction</H3>' ; 
	
	// enqueue fonts
	wp_enqueue_style( 
		'google-nova-round', 
		'http://fonts.googleapis.com/css?family=Nova+Round'
	);
	
	// enqueue scripts
	// wp_enqueue_script( 'custom-js', 'link to file' ); // nécessaire pour images upload
	
	}
}

add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
add_action( 'wp_enqueue_scripts', 'wp_enqueue_media' );
// see http://code.tutsplus.com/tutorials/loading-css-into-wordpress-the-right-way--cms-20402
add_action( 'wp_enqueue_scripts', 'cec29_enqueue_scripts' );  // to enqueue in the website front end
// add_action( 'admin_enqueue_scripts', 'cec29_enqueue_scripts' );  // to enqueue in administration panel
// add_action( 'login_enqueue_scripts', 'cec29_enqueue_scripts' );  // to enqueue in the WP login page