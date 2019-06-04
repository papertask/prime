<?php

/**
 * # Get Acitivity Class.
 */
function yz_get_activity_page_class() {

    // New Array
    $activity_class = array();

    // Get Profile Width Type
    $activity_class[] = 'yz-horizontal-layout yz-global-wall';

    // Get Tabs List Icons Style
    $activity_class[] = yz_options( 'yz_tabs_list_icons_style' );

    // Get Profile Scheme
    $activity_class[] = yz_options( 'yz_profile_scheme' );

    // Get Page Buttons Style
    $activity_class[] = 'yz-page-btns-border-' . yz_options( 'yz_buttons_border_style' );

    return yz_generate_class( $activity_class );
}

/**
 * Activity Wall Posts Per page
 */
function yz_activity_wall_posts_per_page( $query ) {
	
	// if its not the activity directory exit.
	if ( ! bp_is_activity_directory() ) {
		return $query;
	}

	// Get Posts Per Page Number.
	$posts_per_page = yz_options( 'yz_activity_wall_posts_per_page' );
	
	if ( ! empty( $query ) ) {
        $query .= '&';
    }

	// Query String.
	$query .= 'per_page=' . $posts_per_page;

	return $query;
}

add_filter( 'bp_legacy_theme_ajax_querystring', 'yz_activity_wall_posts_per_page' );

/**
 * Activity - Default Filter
 */
function yz_activity_default_filter( $retval ) { 
    
    // Youzer Filter Option.
    $use_youzer_filter = yz_options( 'yz_enable_youzer_activity_filter' );

    if ( 'off' == $use_youzer_filter ) {
        return $retval;
    }
    
    $show_everything = yz_wall_show_everything_filter();

    if ( ! isset( $retval['type'] ) || ( isset( $retval['type'] ) && $retval['type'] == $show_everything ) )  {
        $retval['action'] = $show_everything;    
    }
    
    return $retval;    
}

add_filter( 'bp_after_has_activities_parse_args', 'yz_activity_default_filter' );

/**
 * Add profile activity page filter bar.
 */
function yz_profile_activity_tab_filter_bar() {

    if ( ! bp_is_user_activity() ) {
        return;
    }
    
    if ( 'on' == yz_options( 'yz_enable_wall_filter_bar' ) ) :

?>

<div class="item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'youzer' ); ?>" role="navigation">
    <ul>

        <?php bp_get_options_nav(); ?>

        <li id="activity-filter-select" class="last">
            <label for="activity-filter-by"><?php _e( 'Show:', 'youzer' ); ?></label>
            <select id="activity-filter-by">
                <option value="<?php echo yz_wall_show_everything_filter(); ?>"><?php _e( '&mdash; Everything &mdash;', 'youzer' ); ?></option>

                <?php bp_activity_show_filters(); ?>

                <?php

                /**
                 * Fires inside the select input for member activity filter options.
                 *
                 * @since 1.2.0
                 */
                do_action( 'bp_member_activity_filter_options' ); ?>

            </select>
        </li>
    </ul>
</div><!-- .item-list-tabs -->

<?php endif;

}

add_action( 'yz_profile_main_content', 'yz_profile_activity_tab_filter_bar' );

/**
 * Fix Buddypress Time Since
 */
function yz_fix_activity_time_since( $time_since, $activity ) {

    $date_recorded = bp_core_time_since( $activity->date_recorded );
    echo $date_recorded;
    echo $activity->date_recorded;
    return sprintf(
        '<span class="yz-time-since" data-livestamp="%1$s">%2$s</span>',
        bp_core_get_iso8601_date( $activity->date_recorded ),
        $date_recorded
    );
}

// add_filter( 'bp_activity_time_since', 'yz_fix_activity_time_since', 10, 2 );
function yz_get_activity_time_stamp_meta( $content = '' ) {
    global $activities_template;

    // Strip any legacy time since placeholders from BP 1.0-1.1.
    $new_content = str_replace( '<span class="time-since">%s</span>', '', $content );

    // Get the time since this activity was recorded.
    $date_recorded  = bp_core_time_since( $activities_template->activity->date_recorded );

    // Set up 'time-since' <span>.
    $time_since = sprintf(
        '<span class="time-since" data-livestamp="%1$s">%2$s</span>',
        bp_core_get_iso8601_date( $activities_template->activity->date_recorded ),
        $date_recorded
    );

    /**
     * Filters the activity item time since markup.
     *
     * @since 1.2.0
     *
     * @param array $value Array containing the time since markup and the current activity component.
     */
    $time_since = apply_filters_ref_array( 'bp_activity_time_since', array(
        $time_since,
        &$activities_template->activity
    ) );

    // Insert the permalink.
    if ( ! bp_is_single_activity() ) {

        // Setup variables for activity meta.
        $activity_permalink = bp_activity_get_permalink( $activities_template->activity->id, $activities_template->activity );
        $activity_meta      = sprintf( '%1$s <a href="%2$s" class="view activity-time-since bp-tooltip" data-bp-tooltip="%3$s">%4$s</a>',
            $new_content,
            $activity_permalink,
            esc_attr__( 'View Discussion', 'buddypress' ),
            $time_since
        );

        /**
         * Filters the activity permalink to be added to the activity content.
         *
         * @since 1.2.0
         *
         * @param array $value Array containing the html markup for the activity permalink, after being parsed by
         *                     sprintf and current activity component.
         */
        $new_content = apply_filters_ref_array( 'bp_activity_permalink', array(
            $activity_meta,
            &$activities_template->activity
        ) );
    } else {
        $new_content .= str_pad( $time_since, strlen( $time_since ) + 2, ' ', STR_PAD_BOTH );
    }

    /**
     * Filters the activity content after activity metadata has been attached.
     *
     * @since 1.2.0
     *
     * @param string $content Activity content with the activity metadata added.
     */
    return apply_filters( 'bp_insert_activity_meta', $new_content, $content );
}