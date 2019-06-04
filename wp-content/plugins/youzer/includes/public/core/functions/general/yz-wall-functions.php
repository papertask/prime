<?php

/**
 * Edit Activity Slug.
 */
function yz_rename_activity_slug() {

    if ( defined( 'BP_ACTIVITY_SLUG' ) || ! bp_is_active( 'activity' ) ) {
        return false;
    }

    define( 'BP_ACTIVITY_SLUG', 'wall' );
}

add_action( 'init', 'yz_rename_activity_slug', 1 );

/**
 * Check if activity has content.
 */
function yz_activity_has_content( $activity_id = null ) {

	// Get Post Type
	$post_type = bp_activity_get_meta( $activity_id, 'post-type' );

	// Fobidden Post Types
	$fobidden_types = array( 'cover' );

	if ( ! in_array( $post_type, $fobidden_types ) ) {
		return true;
	}

	return false;
}

/**
 * Display Meta.
 */
function yz_display_wall_post_meta() {
	
	if ( is_user_logged_in() ) {
		return true;
	}

	$show = true;
	
	// Get Post Likes
	$post_likes = (int) yz_get_who_liked_activities( bp_get_activity_id() );

	// Get Post Comments
	$post_comments = (int) bp_activity_get_comment_count();

	if ( 0 == $post_comments && $post_likes <= 0 && ! is_user_logged_in() ) {
		return false;
	}

	return true;
}

/**
 * Change Default Upload Directory to the Youzer Directory.
 */
function yz_temporary_upload_directory( $dir ) {
	
	global $YZ_upload_folder, $YZ_upload_url, $YZ_upload_dir;

    return array(
        'path'   => $YZ_upload_dir . '/temp',
        'url'    => $YZ_upload_url . '/temp',
        'subdir' => '/' . $YZ_upload_folder . '/temp',
    ) + $dir;

}

/**
 * Add Activity Shortcode.
 **/
function yz_activitiy_shortcode( $atts ) {
    
    global $yz_activity_shortcode_args;

	// Call Mentions Scripts.
    add_filter( 'bp_activity_maybe_load_mentions_scripts', 'yz_enable_activity_shortcode_mentions' );

    bp_activity_mentions_script();

	do_action( 'yz_before_activity_shortcode' );

	// Get Args.
	$yz_activity_shortcode_args = wp_parse_args( $atts, array( 'show_sidebar' => 'false' ) );

	if ( $yz_activity_shortcode_args['show_sidebar'] == 'false' ) {	
	    // Remove Sidebar.
	    remove_action( 'yz_global_wall_sidebar', 'yz_get_wall_sidebar' );
	}

	$class = $yz_activity_shortcode_args['show_sidebar'] == 'false' ? 'yz-no-sidebar' : 'yz-with-sidebar';

    // Add Filter.
    add_filter( 'bp_after_has_activities_parse_args', 'yz_set_activity_stream_shortcode_atts', 99 );

	ob_start();
    echo "<div class='yz-activity-shortcode $class'>";
    include_once YZ_TEMPLATE . 'activity/index.php';
    echo "</div>";

    // Add Filter.
    remove_filter( 'bp_after_has_activities_parse_args', 'yz_set_activity_stream_shortcode_atts' );
	return ob_get_clean();
}

add_shortcode( 'youzer_activity', 'yz_activitiy_shortcode' );


/**
 * Activity Shortcode.
 */
function yz_set_activity_stream_shortcode_atts( $loop ) {

    global $yz_activity_shortcode_args;
    
    $loop = shortcode_atts( $loop, $yz_activity_shortcode_args, 'yz_activity_stream' );

    return $loop;

}

/*

/**
 * Add Member Directory Shortcode.
function youzer_members_shortcode( $atts ) {
    
    global $Youzer;

    add_filter( 'bp_is_current_component', 'yz_enable_shortcode_md', 10, 2 );

    // Scripts 
    wp_enqueue_style( 'yz-directories', YZ_PA . 'css/yz-directories.min.css', array( 'dashicons' ), $Youzer->version );
    wp_enqueue_script( 'yz-directories', YZ_PA .'js/yz-directories.min.js', array( 'jquery' ), $Youzer->version, true );
    
    global $yz_md_shortcode_atts;

    // Get Args.
    $yz_md_shortcode_atts = shortcode_atts(
        array(
            'per_page' => 12,
            'member_type' => false,
            'show_filter' => false,
        ), $atts, 'youzer_members' );

    // Add Filter.
    add_filter( 'bp_after_has_members_parse_args', 'yz_set_members_directory_shortcode_atts' );

    if ( $yz_md_shortcode_atts['show_filter'] == false ) {
        add_filter( 'yz_display_members_directory_filter', 'yz_disable_md_shortcode_filter' );
    }
    
    ob_start();

    echo "<div class='yz-members-directory-shortcode'>";
    include YZ_TEMPLATE . 'members/index.php';
    echo "</div>";

    // Remove Filter.
    remove_filter( 'bp_after_has_members_parse_args', 'yz_set_members_directory_shortcode_atts' );
   

    if ( $yz_md_shortcode_atts['show_filter'] == false ) {
        remove_filter( 'yz_display_members_directory_filter', 'yz_disable_md_shortcode_filter' );
    }

    // Unset Global Value.
    unset( $yz_md_shortcode_atts );

    remove_filter( 'bp_is_current_component', 'yz_enable_shortcode_md', 10, 2 );

    return ob_get_clean();
}

add_shortcode( 'youzer_members', 'youzer_members_shortcode' );
*/
/**
 * Get Post Like Button.
 */
function yz_get_post_like_button() {

	// Get Activity ID.
	$activity_id = bp_get_activity_id();
	
	if ( ! bp_get_activity_is_favorite() ) {

		// Get Like Link.
		$like_link = bp_get_activity_favorite_link();

		// Get Like Button.
		$button = '<a href="'. $like_link .'" class="button fav bp-secondary-action">' . __( 'Like', 'youzer' ) . '</a>';

		// Filter.
		$button = apply_filters( 'yz_filter_post_like_button', $button, $like_link, $activity_id );

	} else {

		// Get Unlike Link.
		$unlike_link = bp_get_activity_unfavorite_link();

		// Get Like Button.
		$button = '<a href="'. $unlike_link .'" class="button unfav bp-secondary-action">' . __( 'Unlike', 'youzer' ) . '</a>';

		// Filter.
		$button = apply_filters( 'yz_filter_post_unlike_button', $button, $unlike_link, $activity_id );

	}
	
	return $button;

}

/**
 * Wall Post - Get Comment Button Title.
 */
function yz_wall_get_comment_button_title() {

	// Get Comments Number.
	$comments_nbr = bp_activity_get_comment_count();

	if ( $comments_nbr == '0' ) {
		$button_title = __( '<span></span> Comment', 'youzer' );
	} else {
		$button_title = sprintf( _n( '<span>%s</span> Comment', '<span>%s</span> Comments', $comments_nbr, 'youzer' ), $comments_nbr );
	}

	echo $button_title;
}

/**
 * Register Wall New Actions.
 */
function yz_add_new_wall_post_actions() {

	// Init Vars
	$bp = buddypress();

	bp_activity_set_action(
		$bp->activity->id,
		'activity_status',
		__( 'Posted a new status', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'status', 'youzer' ),
		array( 'activity', 'group', 'member', 'member_groups' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'activity_quote',
		__( 'Posted a new quote', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'quotes', 'youzer' ),
		array( 'activity', 'group', 'member', 'member_groups' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'activity_photo',
		__( 'Posted a new photo', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'photos', 'youzer' ),
		array( 'activity', 'group', 'member', 'member_groups' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'activity_video',
		__( 'Posted a new video', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'videos', 'youzer' ),
		array( 'activity', 'group', 'member', 'member_groups' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'activity_audio',
		__( 'Posted a new audio', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'audios', 'youzer' ),
		array( 'activity', 'group', 'member', 'member_groups' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'activity_slideshow',
		__( 'Posted a new slideshow', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'slideshows', 'youzer' ),
		array( 'activity', 'group', 'member', 'member_groups' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'activity_link',
		__( 'Posted a new link', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'links', 'youzer' ),
		array( 'activity', 'group', 'member', 'member_groups' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'activity_file',
		__( 'uploaded a new file', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'files', 'youzer' ),
		array( 'activity', 'group', 'member', 'member_groups' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'update_avatar',
		__( 'changed their profile avatar', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'avatar', 'youzer' ),
		array( 'activity', 'member' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'new_cover',
		__( 'changed their profile cover', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'cover', 'youzer' ),
		array( 'activity', 'member' )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'new_avatar',
		__( 'changed their profile avatar', 'youzer' ),
		'yz_activity_action_wall_posts',
		__( 'avatar', 'youzer' ),
		array( 'activity', 'member', )
	);

	bp_activity_set_action(
		$bp->activity->id,
		'activity_giphy',
		__( 'Added a new Gif', 'youzer' ),
		'yz_activity_action_wall_giphy',
		__( 'giphy', 'youzer' ),
		array( 'activity', 'group', 'member', 'member_groups' )
	);

}

add_action( 'bp_register_activity_actions', 'yz_add_new_wall_post_actions' );