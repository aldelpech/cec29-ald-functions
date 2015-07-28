<?php
/**
 * Plugin Name: 	ajout champs et fonctionnalités / WordPress users
 * Plugin URI: 		A créer		
 * Description: 	pour ajouter des champs au descriptif des utilisateurs WP et pouvoir afficher certains utilisateurs dans un format particulier	
 * Version: 		0.3.0
 * author 			Anne-Laure Delpech
 * Author URI: 		http://parcours-performance.com/anne-laure-delpech/#ald
 
 * Ce plugin a été créé car 
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * @package			cec29-functions
 * @version			0.1.0
 * @author 			Anne-Laure Delpech
 * @copyright 		Copyright (c) 2014-2014, Anne-Laure Delpech
 * @link			https://github.com/aldelpech/Plugins-WP/tree/master/cec29-ald-functions
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since 			0.1.0
 *
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/*----------------------------------------------------------------------------*
 * Path to files
 * @since 0.1.0
 *----------------------------------------------------------------------------*/
	/* 	
	http://testal.parcours-performance.com/wp-content/plugins/cec29-ald-functions/??? --> CEC29_ALD_DIR_URL
	/home/parcoursz/testal/wp-content/plugins/cec29-ald-functions/??? --> CEC29_ALD_DIR_URL
	cec29-ald-functions/cec29-functions.php??? --> CEC29_ALD_BASENAME
	/home/parcoursz/testal/wp-content/plugins/cec29-ald-functions/cec29-functions.php??? --> CEC29_ALD_MAIN_FILE
	
	*/
	define( 'CEC29_ALD_MAIN_FILE', __FILE__ );
	define( 'CEC29_ALD_BASENAME', plugin_basename( CEC29_ALD_MAIN_FILE ));
	define( 'CEC29_ALD_DIR_PATH', plugin_dir_path( CEC29_ALD_MAIN_FILE ));
	define( 'CEC29_ALD_DIR_URL', plugin_dir_url( CEC29_ALD_MAIN_FILE ));
	/* 
	echo '<p>' . CEC29_ALD_DIR_URL . '???  --> CEC29_ALD_DIR_URL' . '</p>' ;
	echo '<p>' . CEC29_ALD_DIR_PATH . '???  --> CEC29_ALD_DIR_URL' . '</p>' ;
	echo '<p>' . CEC29_ALD_BASENAME . '???  --> CEC29_ALD_BASENAME' . '</p>' ;
	echo '<p>' . CEC29_ALD_MAIN_FILE . '???  --> CEC29_ALD_MAIN_FILE' . '</p>' ;
	*/

/********************************************************************************
* appeler d'autres fichiers php et les exécuter
* @since 
********************************************************************************/	
	// ajouter des champs "user", les modifier et les voir
	require_once CEC29_ALD_DIR_PATH . 'includes/cec29-add-edit-viewfields.php'; 
	
	// charger des styles, fonts ou scripts correctement
	require_once CEC29_ALD_DIR_PATH . 'includes/cec29-enqueue-scripts.php'; 

	// @since 0.3
	// ajouter une taxonomie "secteur d'activité" pour les users wordpress
	require_once CEC29_ALD_DIR_PATH . 'includes/cec29-user-custom-taxonomy.php'; 
	

	// ajouter les éléments de Pronomic Google Maps en bas de page profil
	require_once CEC29_ALD_DIR_PATH . 'includes/cec29-pronomic-google-map.php'; 

	
/******************************************************************************
* Actions à réaliser à l'initialisation et l'activation du plugin
* @since 0.1.0
******************************************************************************/
	/* réaliser juste avant l'activation */
	add_action( 'init', 'cec29_functions_thumbnails' );
	add_action( 'init', 'cec29_register_secteur_taxonomy', 0 );

	function cec29_ald_functions_activation() {
		
		/* check that required plugins are activated
		* see http://solislab.com/blog/plugin-activation-checklist/
		* http://www.xpertdeveloper.com/2012/02/activate-wordpress-plugin-using-code/
		* on peut forcer l'activation au lieu d'afficher un message d'erreur
		*/
		
		// get currently activated plugins
		$current_plugin = get_option("active_plugins");
		
		if( count( $current_plugin ) > 0) {
			$required_plugins = array(
				'paid-memberships-pro/paid-memberships-pro.php',
				'pronamic-google-maps/pronamic-google-maps.php', 
				'theme-my-login/theme-my-login.php' // @since 0.2.0
			) ;
			foreach( $required_plugins as $plugin_name ) {
				if( !in_array($plugin_name, $current_plugin ) ) {
					$error = __( "Cette extension requiert ", 'cec29-ald-functions' ) ;
					$error .= $plugin_name . __( ". Merci de l'installer et l'activer avant d'activer cette extension.", 'cec29-ald-functions' ) ;
					wp_die( $error ) ;
				} 	
			}
		} else {
			$error = __( "Aucun plugin n'est activé.", 'cec29-ald-functions' ) ;
			wp_die( $error ) ;
		}
		
		// register the custom taxonomy
		cec29_register_secteur_taxonomy();
		
		// reflush (in order to create the new permalink system)
		// see http://code.tutsplus.com/articles/the-rewrite-api-post-types-taxonomies--wp-25488
		flush_rewrite_rules();
	}

	register_activation_hook(__FILE__, 'cec29_ald_functions_activation'); // plugin's activation 


/*----------------------------------------------------------------------------*
 * deactivation and uninstall
 * * @since 0.1.0
 *----------------------------------------------------------------------------*/
	/* upon deactivation, wordpress also needs to rewrite the rules */
	register_deactivation_hook(__FILE__, 'cec29_ald_functions_deactivation');

	function cec29_ald_functions_deactivation() {
		// flush_rewrite_rules(); // pour remettre à 0 les permaliens
	}
	
	// register uninstaller
	register_uninstall_hook(__FILE__, 'cec29_ald_functions_uninstall');
	
	function cec29_ald_functions_uninstall() {    
		// actions to perform once on plugin uninstall go here
		// remove all options and custom tables
	}