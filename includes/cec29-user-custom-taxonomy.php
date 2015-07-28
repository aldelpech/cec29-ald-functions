<?php
/**
 *
 * créer une taxonomie pour les membres du CEC29
 *
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.3.0
 *
 * @package    cec29-functions
 * @subpackage cec29-functions/includes
 */


 /**
 * register the "secteur d'activité" taxonomy
 */
 
function cec29_register_secteur_taxonomy() {
	// taxonomie secteur d'activité
	$labels = array(
		'name'              => _x( "Activité", 'taxonomy general name' ),
		'singular_name'     => _x( "Activité", 'taxonomy singular name' ),
		'search_items'      => __( 'Rechercher les activités' ),
		'all_items'         => __( "Tous les secteurs d'activité" ),
		'parent_item'       => __( 'Activité Parente' ),
		'parent_item_colon' => __( 'Activité :' ),
		'edit_item'         => __( "Editer l'activité" ), 
		'update_item'       => __( "Mettre à jour l'activité" ),
		'add_new_item'      => __( 'Ajouter une nouvelle activité' ),
		'new_item_name'     => __( 'Nouvelle activité' ),
		'menu_name'         => __( 'Activités' ),
	);
	$args = array(
		'labels' 			=> $labels,
		'hierarchical' 		=> false,
		'show_in_nav_menus' => false,
		'show_ui' 			=> true,
		'rewrite' 			=> array(
			'with_front' => true,
			'slug' => 'author/profession' // Use 'author' (default WP user slug).
		),
		'capabilities' => array(
				'manage_terms' => 'edit_users', // Using 'edit_users' cap to keep this simple.
				'edit_terms'   => 'edit_users',
				'delete_terms' => 'edit_users',
				'assign_terms' => 'read',
		),
		'update_count_callback' => 'cec29_update_secteur_count' // Use a custom function to update the count.
	);	 
	
	// register cette taxonomie pour les "users"
	register_taxonomy( 'activite', 'post', $args );	
}



 /** 
 * Thanks to Justin Tadlock
 * http://justintadlock.com/archives/2011/10/20/custom-user-taxonomies-in-wordpress
 * Function for updating the 'profession' taxonomy count.  What this does is update the count of a specific term 
 * by the number of users that have been given the term.  We're not doing any checks for users specifically here. 
 * We're just updating the count with no specifics for simplicity.
 *
 * See the _update_post_term_count() function in WordPress for more info.
 *
 * @param array $terms List of Term taxonomy IDs
 * @param object $taxonomy Current taxonomy object of terms
 */

function cec29_update_secteur_count( $terms, $taxonomy ) {
	global $wpdb;

	foreach ( (array) $terms as $term ) {

		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term ) );

		do_action( 'edit_term_taxonomy', $term, $taxonomy );
		$wpdb->update( $wpdb->term_taxonomy, compact( 'count' ), array( 'term_taxonomy_id' => $term ) );
		do_action( 'edited_term_taxonomy', $term, $taxonomy );
	}	 
}

/* Adds the taxonomy page in the admin. */
add_action( 'admin_menu', 'cec29__add_secteur_admin_page' );

/**
 * Thanks to Justin Tadlock
 * http://justintadlock.com/archives/2011/10/20/custom-user-taxonomies-in-wordpress
 * Creates the admin page for the 'activite' taxonomy under the 'Users' menu.  It works the same as any 
 * other taxonomy page in the admin.  However, this is kind of hacky and is meant as a quick solution.  When 
 * clicking on the menu item in the admin, WordPress' menu system thinks you're viewing something under 'Posts' 
 * instead of 'Users'.  We really need WP core support for this.
 */
function cec29__add_secteur_admin_page() {
	
	$tax = get_taxonomy( 'activite' );

	add_users_page(
		esc_attr( $tax->labels->menu_name ),
		esc_attr( $tax->labels->menu_name ),
		$tax->cap->manage_terms,
		'edit-tags.php?taxonomy=' . $tax->name
	);
}

/* Create custom columns for the manage activite page. 
* hook into the manage_edit-$taxonomy_columns filter 
*/
add_filter( 'manage_edit-activite_columns', 'cec29_manage_activite_user_column' );

/**
 * Unsets the 'posts' column and adds a 'users' column on the manage activite admin page.
 *
 * @param array $columns An array of columns to be shown in the manage terms table.
 */
function cec29_manage_activite_user_column( $columns ) {

	unset( $columns['posts'] );  //  posts = id de la colonne dans tous langages

	$columns['users'] = __( 'Users' );

	return $columns;
}

/* Customize the output of the custom column on the manage activite page. 
* hook into the manage_$taxonomy_custom_column filter
*/
add_action( 'manage_activite_custom_column', 'cec29_manage_activite_column', 10, 3 );

/**
 * Displays content for custom columns on the manage activite page in the admin.
 *
 * @param string $display WP just passes an empty string here.
 * @param string $column The name of the custom column.
 * @param int $term_id The ID of the term being displayed in the table.
 */
function cec29_manage_activite_column( $display, $column, $term_id ) {

	if ( 'users' === $column ) {
		$term = get_term( $term_id, 'activite' );
		echo $term->count;
	}
} 

/* Add section to the edit user page in the admin to select activite. */
add_action( 'show_user_profile', 'cec29_edit_user_activite_section' );
add_action( 'edit_user_profile', 'cec29_edit_user_activite_section' );


/**
 * Adds an additional settings section on the edit user/profile page in the admin.  This section allows users to 
 * select a activite from a checkbox of terms from the activite taxonomy.  This is just one example of 
 * many ways this can be handled.
 *
 * @param object $user The user object currently being edited.
 */
function cec29_edit_user_activite_section( $user ) {

	$tax = get_taxonomy( 'activite' );

	/* Make sure the user can assign terms of the activite taxonomy before proceeding. */
	if ( !current_user_can( $tax->cap->assign_terms ) )
		return;

	/* Get the terms of the 'activite' taxonomy. */
	$terms = get_terms( 'activite', array( 'hide_empty' => false ) ); ?>

	<h3><?php _e( 'activite' ); ?></h3>

	<table class="form-table">

		<tr>
			<th><label for="activite"><?php _e( 'Select Activité' ); ?></label></th>

			<td><?php

			/* If there are any activite terms, loop through them and display checkboxes. */
			if ( !empty( $terms ) ) {

				foreach ( $terms as $term ) { ?>

					<input type="radio" name="activite" id="activite-<?php echo esc_attr( $term->slug ); ?>" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( true, is_object_in_term( $user->ID, 'activite', $term ) ); ?> /> <label for="activite-<?php echo esc_attr( $term->slug ); ?>"><?php echo $term->name; ?></label> <br />
				<?php }
			}

			/* If there are no activite terms, display a message. */
			else {
				_e( "Il n'y a pas d'activités définies." );
			}

			?></td>
		</tr>

	</table>
<?php }


/* Update the activite terms when the edit user page is updated. */
add_action( 'personal_options_update', 'cec29_save_user_activite_terms' );
add_action( 'edit_user_profile_update', 'cec29_save_user_activite_terms' );

/**
 * Saves the term selected on the edit user/profile page in the admin. This function is triggered when the page 
 * is updated.  We just grab the posted data and use wp_set_object_terms() to save it.
 *
 * @param int $user_id The ID of the user to save the terms for.
 */
function cec29_save_user_activite_terms( $user_id ) {

	$tax = get_taxonomy( 'activite' );

	/* Make sure the current user can edit the user and assign terms before proceeding. */
	if ( !current_user_can( 'edit_user', $user_id ) && current_user_can( $tax->cap->assign_terms ) )
		return false;

	$term = esc_attr( $_POST['activite'] );

	/* Sets the terms (we're just using a single term) for the user. */
	wp_set_object_terms( $user_id, array( $term ), 'activite', false);

	clean_object_term_cache( $user_id, 'activite' );
}

/* Filter the 'sanitize_user' to disable username. */
add_filter( 'sanitize_user', 'cec29_disable_username' );

/**
 * Disables the 'activite' username when someone registers.  This is to avoid any conflicts with the custom 
 * 'author/activite' slug used for the 'rewrite' argument when registering the 'activite' taxonomy.  This
 * will cause WordPress to output an error that the username is invalid if it matches 'activite'.
 *
 * @param string $username The username of the user before registration is complete.
 */
function cec29_disable_username( $username ) {

	if ( 'activite' === $username )
		$username = '';

	return $username;
}
