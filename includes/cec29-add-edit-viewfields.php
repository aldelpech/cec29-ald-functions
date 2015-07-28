<?php
/**
 *
 * afficher les nouveaux champs dans le profil utilisateur
 *
 *
 * @link       	http://parcours-performance.com/anne-laure-delpech/#ald
 * @since      	0.1.0
 *
 * @package    cec29-functions
 * @subpackage cec29-functions/includes
 */

// Thanks to http://wpengineer.com/2173/custom-fields-wordpress-user-profile/
function cec29_ald_functions_show_user_profile( $user ) {
?>
	<h3><?php _e('Autres informations de profil', 'cec29-ald-functions'); ?></h3>
	<?php // show_admin_bar(true); ?>
	<table class="form-table">
		<!-- user_entreprise -->
		<tr>
			<th>
				<label for="user_entreprise"><?php _e('Entreprise', 'cec29-ald-functions'); ?>
			</label></th>
			<td>
				<input type="text" name="user_entreprise" id="user_entreprise" value="<?php echo esc_attr( get_the_author_meta( 'user_entreprise', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Le nom de votre entreprise', 'cec29-ald-functions'); ?></span>
			</td>
		</tr>
		<!-- user_parrain -->
		<tr>
			<th>
				<label for="address"><?php _e('Parrain', 'cec29-ald-functions'); ?>
			</label></th>
			<td>
				<input type="text" name="user_parrain" id="user_parrain" value="<?php echo esc_attr( get_the_author_meta( 'user_parrain', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Votre parrain.', 'cec29-ald-functions'); ?></span>
			</td>
		</tr>
		<!-- user_nb_salaries -->
		<tr>
			<th>
				<label for="user_nb_salaries"><?php _e('Emplois', 'cec29-ald-functions'); ?>
			</label></th>
			<td>
				<input type="text" name="user_nb_salaries" id="user_nb_salaries" value="<?php echo esc_attr( get_the_author_meta( 'user_nb_salaries', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Le nombre de salariés + vous', 'cec29-ald-functions'); ?></span>
			</td>
		</tr>
		<!-- user_adresse -->
		<tr>
			<th>
				<label for="user_adresse"><?php _e('Adresse', 'cec29-ald-functions'); ?>
			</label></th>
			<td>
				<input type="text" name="user_adresse" id="user_adresse" value="<?php echo esc_attr( get_the_author_meta( 'user_adresse', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Votre adresse (hors ville)', 'cec29-ald-functions'); ?></span>
			</td>
		</tr>
		<!-- user_code_postal -->
		<tr>
			<th>
				<label for="user_code_postal"><?php _e('Code postal', 'cec29-ald-functions'); ?>
			</label></th>
			<td>
				<input type="text" name="user_code_postal" id="user_code_postal" value="<?php echo esc_attr( get_the_author_meta( 'user_code_postal', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Votre code postal', 'cec29-ald-functions'); ?></span>
			</td>
		</tr>
		<!-- user_ville -->
		<tr>
			<th>
				<label for="user_ville"><?php _e('Ville', 'cec29-ald-functions'); ?>
			</label></th>
			<td>
				<input type="text" name="user_ville" id="user_ville" value="<?php echo esc_attr( get_the_author_meta( 'user_ville', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Votre ville', 'cec29-ald-functions'); ?></span>
			</td>
		</tr>
		<!-- user_tel -->
		<tr>
			<th>
				<label for="user_tel"><?php _e('Fixe', 'cec29-ald-functions'); ?>
			</label></th>
			<td>
				<input type="text" name="user_tel" id="user_tel" value="<?php echo esc_attr( get_the_author_meta( 'user_tel', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e("Votre n° de téléphone fixe - c'est ce n° qui s'affichera.", 'cec29-ald-functions'); ?></span>
			</td>
		</tr>
		<!-- user_mobile -->
		<tr>
			<th>
				<label for="user_mobile"><?php _e('Mobile', 'cec29-ald-functions'); ?>
			</label></th>
			<td>
				<input type="text" name="user_mobile" id="user_mobile" value="<?php echo esc_attr( get_the_author_meta( 'user_mobile', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Votre n° de mobile. Ne sera pas affiché.', 'cec29-ald-functions'); ?></span>
			</td>
		</tr>
		<!-- user_web_url -->
		<!-- le site web est dans la table wp_users, user_url -->

		<!-- user_meta_image -->
		<!-- thanks to http://s2webpress.com/add-image-uploader-to-profile-admin-page-wordpress/ -->
		<tr>
            <th><label for="user_meta_image"><?php _e( 'Photo', 'cec29-ald-functions' ); ?></label></th>
            <td>
                <!-- Outputs the image after save -->		
				<!-- http://testal.parcours-performance.com/wp-content/uploads/2015/01/screenshot.png -->
				<img src="<?php echo esc_attr( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" style="width:150px;"><br />
				<!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <input type="text" name="user_meta_image" id="user_meta_image" value="<?php echo esc_url( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" class="regular-text" />
                <!-- Outputs the save button -->
                <input type='button' class="additional-user-image button-primary" value="<?php _e( 'Upload Image', 'textdomain' ); ?>" id="uploadimage"/><br />
                <span class="description"><?php _e( 'Charger votre photo.', 'cec29-ald-functions' ); ?></span>
            </td>
        </tr>
		
		<!-- user_meta_logo -->
		<tr>
            <th><label for="user_meta_logo"><?php _e( 'Logo', 'cec29-ald-functions' ); ?></label></th>
            <td>
                <!-- Outputs the logo after save -->		
				<img src="<?php echo esc_attr( get_the_author_meta( 'user_meta_logo', $user->ID ) ); ?>" style="width:150px;"><br />
				<!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <input type="text" name="user_meta_logo" id="user_meta_logo" value="<?php echo esc_url( get_the_author_meta( 'user_meta_logo', $user->ID ) ); ?>" class="regular-text" />
                <!-- Outputs the save button -->
                <input type='button' class="additional-user-logo button-primary" value="<?php _e( 'Upload Image', 'textdomain' ); ?>" id="uploadimage"/><br />
                <span class="description"><?php _e( 'Charger votre logo.', 'cec29-ald-functions' ); ?></span>
            </td>
        </tr>
		
	</table>


	<!-- javascript for the picture uploader button -->
	<script>
	jQuery(document).ready(function($){
	// Uploading files
		var file_frame;
	 
		// for user_meta_image
		$('.additional-user-image').on('click', function( event ){
	 
			event.preventDefault();
		 
			// If the media frame already exists, reopen it.
			if ( file_frame ) {
			  file_frame.open();
			  return;
			}
		 
			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: { text: $( this ).data( 'uploader_button_text' ),  },
				library: { type: 'image' }, 
				multiple: false  // Set to true to allow multiple files to be selected
			});
		 
			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
			  
			  // We set multiple to false so only get one image from the uploader
			  attachment = file_frame.state().get('selection').first().toJSON();
		 
			  // Do something with attachment.id and/or attachment.url here
			  // thanks http://wordpress.stackexchange.com/questions/142589/ !!!!!!! 
			  $('#user_meta_image').val(attachment.url);
			});
	 
			// Finally, open the modal
			file_frame.open();
		});
	 
		// for user_meta_logo
		$('.additional-user-logo').on('click', function( event ){
	 
			event.preventDefault();
		 
			// If the media frame already exists, reopen it.
			if ( file_frame ) {
			  file_frame.open();
			  return;
			}
		 
			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: { text: $( this ).data( 'uploader_button_text' ),  },
				library: { type: 'image' }, 
				multiple: false  // Set to true to allow multiple files to be selected
			});
		 
			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
			  
			  // We set multiple to false so only get one image from the uploader
			  attachment = file_frame.state().get('selection').first().toJSON();
		 
			  // Do something with attachment.id and/or attachment.url here
			  // thanks http://wordpress.stackexchange.com/questions/142589/ !!!!!!! 
			  $('#user_meta_logo').val(attachment.url);
			});
	 
			// Finally, open the modal
			file_frame.open();
		});
		});
	</script>
	<?php 
	
	// see all data for current user
	/*$all_meta_for_user = get_user_meta( $user->ID );
	print_r( $all_meta_for_user ); 
	*/
	
}

function cec29_ald_functions_edit_user_profile( $user_id ) {
	
	if ( !current_user_can( 'edit_user', $user_id ) ) {
		return FALSE;		
	} else {
		update_usermeta( $user_id, 'user_entreprise', $_POST['user_entreprise'] );
		update_usermeta( $user_id, 'user_parrain', $_POST['user_parrain'] );
		update_usermeta( $user_id, 'user_nb_salaries', $_POST['user_nb_salaries'] );
		update_usermeta( $user_id, 'user_adresse', $_POST['user_adresse'] );
		update_usermeta( $user_id, 'user_code_postal', $_POST['user_code_postal'] );
		update_usermeta( $user_id, 'user_ville', $_POST['user_ville'] );
		update_usermeta( $user_id, 'user_tel', $_POST['user_tel'] );
		update_usermeta( $user_id, 'user_mobile', $_POST['user_mobile'] );
		update_usermeta( $user_id, 'user_web_url', $_POST['user_mobile'] );
	}

	if ( !current_user_can( 'upload_files', $user_id ) ) {
		return FALSE;		
	} else {
		update_usermeta( $user_id, 'user_meta_image', $_POST['user_meta_image'] );
		update_usermeta( $user_id, 'user_meta_logo', $_POST['user_meta_logo'] );
	}

	if ( current_user_can( 'manage_options' ) ) {
		/* A user with admin privileges */
		update_usermeta( $user_id, 'show_admin_bar_front', true );
	} else {
		/* A user without admin privileges */
		update_usermeta( $user_id, 'show_admin_bar_front', false );
		}
}

add_action( 'show_user_profile', 'cec29_ald_functions_show_user_profile' );
add_action( 'edit_user_profile', 'cec29_ald_functions_show_user_profile' );

add_action( 'personal_options_update', 'cec29_ald_functions_edit_user_profile' );
add_action( 'edit_user_profile_update', 'cec29_ald_functions_edit_user_profile' );


