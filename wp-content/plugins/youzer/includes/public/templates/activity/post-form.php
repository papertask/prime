<?php

/**
 * BuddyPress - Activity Post Form
 */

if ( yz_is_wall_posting_form_active() ) :

?>

<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="yz-wall-form" name="whats-new-form" enctype="multipart/form-data">
	
	<div class="yz-wall-options">

		<?php yz_wall_form_post_types_buttons(); ?>

	</div>

	<div id="whats-new-content" class="yz-wall-content" ng-app="YouzerWallApp" ng-controller="YouzerWallController">

		<div class="yz-wall-author" href="<?php echo bp_loggedin_user_domain(); ?>"><?php bp_loggedin_user_avatar(); ?></div>

			<textarea name="status" class="yz-wall-textarea bp-suggestions" id="whats-new" placeholder="<?php if ( bp_is_group() )
		printf( __( "What's new in %s, %s?", 'youzer' ), bp_get_group_name(), bp_get_user_firstname( bp_get_loggedin_user_fullname() ) );
	else
		printf( __( "What's new, %s?", 'youzer' ), bp_get_user_firstname( bp_get_loggedin_user_fullname() ) );
	?>" <?php if ( bp_is_group() ) : ?> data-suggestions-group-id="<?php echo esc_attr( (int) bp_get_current_group_id() ); ?>" <?php endif; ?>
			><?php if ( isset( $_GET['r'] ) ) : ?>@<?php echo esc_textarea( $_GET['r'] ); ?> <?php endif; ?></textarea>

		<?php if ( 'on' == yz_options( 'yz_enable_wall_link' ) ) : ?>
		<div class="yz-wall-custom-form yz-wall-link-form" data-post-type="link">

			<div class="yz-wall-cf-item">
				<input type="text" class="yz-wall-cf-input" name="link_url" placeholder="<?php _e( 'Add Link Url', 'youzer' ); ?>" />
			</div>
			
			<div class="yz-wall-cf-item">
				<input type="text" class="yz-wall-cf-input" name="link_title" placeholder="<?php _e( 'Add Link Title', 'youzer' ); ?>" />
			</div>
			
			<div class="yz-wall-cf-item">
				<textarea name="link_desc" class="yz-wall-cf-input" placeholder="<?php _e( 'Brief Link Description', 'youzer' ); ?>"></textarea>
			</div>

		</div>
		<?php endif; ?>
	
		<?php if ( 'on' == yz_options( 'yz_enable_wall_url_preview' ) ) : ?>
    		<link-preview tpage="%N ➜ %N" iamount="10"/></link-preview>
    	<?php endif; ?>
            
		<?php if ( 'on' == yz_options( 'yz_enable_wall_quote' ) ) : ?>
		<div class="yz-wall-custom-form yz-wall-quote-form" data-post-type="quote">

			<div class="yz-wall-cf-item">
				<input type="text" class="yz-wall-cf-input" name="quote_owner" placeholder="<?php _e( 'Add Quote Owner', 'youzer' ); ?>" />
			</div>

			<div class="yz-wall-cf-item">
				<textarea name="quote_text" class="yz-wall-cf-input" placeholder="<?php _e( 'Add Quote Text', 'youzer' ); ?>"></textarea>
			</div>

		</div>
		<?php endif; ?>

		<?php if ( 'on' == yz_options( 'yz_enable_wall_giphy' ) ) : ?>
		<div class="yz-wall-custom-form yz-wall-giphy-form" data-post-type="giphy">

			<div class="yz-giphy-loading-preview"><i class="fas fa-spin fa-spinner"></i></div>

			<div class="yz-selected-giphy-item">
				<input type="hidden" name="giphy_image" />
				<i class="fas fa-trash yz-delete-giphy-item"></i>
			</div>

			<div class="yz-wall-cf-item">
				<div class="yz-giphy-search-form">
					<input type="text" class="yz-wall-cf-input yz-giphy-search-input" name="giphy_search" placeholder="<?php _e( 'Search for Gifs ...', 'youzer' ); ?>" />
					<div class="yz-giphy-submit-search"><?php _e( 'Search', 'youzer' ); ?></div>
				</div>
				<i class="fas fa-spin fa-spinner yz-cf-input-loader"></i>
				<div class="yz-giphy-items">
					<div class="yz-giphy-items-content"><div class="yz-giphy-grid-sizer"></div></div>
					<div class="yz-load-more-giphys" data-page="2"><i class="fas fa-refresh"></i><?php _e( 'Load More', 'youzer' ); ?></div>
				</div>
			</div>
			
		</div>
		<?php endif; ?>
		
		<?php do_action( 'yz_after_wall_post_form_textarea' ); ?>
	
	</div>
	
	<div class="yz-wall-actions" id="yz-wall-actions">
		
		<?php do_action( 'yz_before_wall_post_form_actions' ); ?>

		<?php if ( bp_is_active( 'groups' ) && ! bp_is_my_profile() && ! bp_is_group() ) : ?>

			<div id="whats-new-post-in-box">
				
				<label for="yz-whats-new-post-in" ><?php _e( 'Post in:', 'youzer' ); ?></label>
				<select id="yz-whats-new-post-in" name="yz-whats-new-post-in">
					<option selected="selected" value="0"><?php _e( 'My Profile', 'youzer' ); ?></option>

					<?php if ( bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0&update_meta_cache=0' ) ) :
						while ( bp_groups() ) : bp_the_group(); ?>

							<option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>

						<?php endwhile;
					endif; ?>

				</select>
			</div>
			<input type="hidden" id="yz-whats-new-post-object" name="yz-whats-new-post-object" value="groups" />

		<?php elseif ( bp_is_group_activity() ) : ?>

			<input type="hidden" id="yz-whats-new-post-object" name="yz-whats-new-post-object" value="groups" />
			<input type="hidden" id="yz-whats-new-post-in" name="yz-whats-new-post-in" value="<?php bp_group_id(); ?>" />

		<?php endif; ?>

		<?php if ( apply_filters( 'yz_allow_wall_upload_attachments', true ) ) : ?>
		<a class="yz-wall-upload-btn">
			<i class="fas fa-paperclip"></i><?php _e( 'upload attachment', 'youzer' ); ?>
		</a>
		<?php endif; ?>

		<button type="submit" name="aw-whats-new-submit" class="yz-wall-post" ><?php esc_attr_e( 'Post', 'youzer' ); ?></button>
		

			<?php

			/**
			 * Fires at the end of the activity post form markup.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_activity_post_form_options' ); ?>

	</div>
	
	<div class="yz-wall-attchments">
		<input hidden="true" id="yz-upload-attachments" type="file" name="attachments[]" multiple>
		<div class="yz-form-attachments"></div>
	</div>

	<?php wp_nonce_field( 'yz_post_update', '_yz_wpnonce_post_update' ); ?>

</form>

<?php endif; ?>