<?php

class YZ_Basic_Infos {

    function __construct() {
    }

    /**
     * # Main Infos Settings .
     */
    function profile_infos() {

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'profile information', 'youzer' ),
                'id'    => 'profile-infos',
                'icon'  => 'fas fa-cogs',
                'type'  => 'open'
            )
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'first name', 'youzer' ),
                'desc'  => __( 'type your first name', 'youzer' ),
                'id'    => 'first_name',
                'type'  => 'text'
            ), true
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'last name', 'youzer' ),
                'id'    => 'last_name',
                'desc'  => __( 'type your last name', 'youzer' ),
                'type'  => 'text'
            ), true
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'country', 'youzer' ),
                'id'    => 'user_country',
                'desc'  => __( 'type your country', 'youzer' ),
                'type'  => 'text'
            ), true
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'city', 'youzer' ),
                'desc'  => __( 'type your city', 'youzer' ),
                'id'    => 'user_city',
                'type'  => 'text'
            ), true
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Biographical Info', 'youzer' ),
                'desc'  => __( 'add your biography', 'youzer' ),
                'id'    => 'description',
                'type'  => 'textarea'
            ), true
        );

        $Yz_Settings->get_field( array( 'type' => 'close' ) );

    }

    /**
     * # Contact Infos Settings.
     */
    function contact_infos() {

      global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'contact information', 'youzer' ),
                'id'    => 'contact-infos',
                'icon'  => 'fas fa-envelope',
                'type'  => 'open'
            )
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'E-mail', 'youzer' ),
                'desc'  => __( 'add your email address', 'youzer' ),
                'id'    => 'email_address',
                'type'  => 'text'
            ), true
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Phone', 'youzer' ),
                'desc'  => __( 'add your phone number', 'youzer' ),
                'id'    => 'phone_nbr',
                'type'  => 'text'
            ), true
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Address', 'youzer' ),
                'desc'  => __( 'add your address', 'youzer' ),
                'id'    => 'user_address',
                'type'  => 'text'
            ), true
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'website', 'youzer' ),
                'desc'  => __( 'add your website url', 'youzer' ),
                'id'    => 'user_url',
                'type'  => 'text'
            ), true
        );

        $Yz_Settings->get_field( array( 'type' => 'close' ) );

    }

    /**
     * # Profile Picture Settings.
     */
    function profile_picture() {
        
        wp_enqueue_style( 'yz-bp-uploader' );

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Profile Picture', 'youzer' ),
                'id'    => 'profile-picture',
                'icon'  => 'fas fa-user-circle',
                'type'  => 'bpDiv'
            )
        );

        echo '<div class="yz-uploader-change-item yz-change-avatar-item">';
        bp_get_template_part( 'members/single/profile/change-avatar' );
        echo '</div>';

        $Yz_Settings->get_field( array( 'type' => 'endbpDiv' ) );

    }

    /**
     * # User Capabilities Settings.
     */
    function user_capabilities() {

        global $Yz_Settings;
        
        do_action( 'bp_before_member_settings_template' );

        $Yz_Settings->get_field(
            array(
                'form_action'   => bp_displayed_user_domain() . bp_get_settings_slug() . '/capabilities/',
                'title'         => __( 'User Capabilities Settings', 'youzer' ),
                'form_name'     => 'account-capabilities-form',
                'submit_id'     => 'capabilities-submit',
                'button_name'   => 'capabilities-submit',
                'id'            => 'capabilities-settings',
                'icon'          => 'fas fa-wrench',
                'type'          => 'open',
            )
        );

        bp_get_template_part( 'members/single/settings/capabilities' );

        $Yz_Settings->get_field(
            array(
                'type' => 'close',
                'hide_action' => true,
                'submit_id'     => 'capabilities-submit',
                'button_name'   => 'capabilities-submit'
            )
        );
        
        do_action( 'bp_after_member_settings_template' );

    }

    /**
     * # Profile Fields Group Settings.
     */
    function group_fields() {
// xprofile_screen_edit_profile();

                    // add_action( 'bp_screens', 'xprofile_screen_edit_profile', 3 );


        global $Yz_Settings, $group;

        $group_data = BP_XProfile_Group::get(
            array( 'profile_group_id' => bp_get_current_profile_group_id() )
        );

        $Yz_Settings->get_field(
            array(
                'icon'  => yz_get_xprofile_group_icon( $group_data[0]->id ),
                'title' => $group_data[0]->name,
                'id'    => 'profile-picture',
                'type'  => 'open'
            )
        );

        bp_get_template_part( 'members/single/profile/edit' );

        $Yz_Settings->get_field( array( 'type' => 'close' ) );

    }

    /**
     * # Account Privacy Settings.
     */
    function account_privacy() {

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Account Privacy', 'youzer' ),
                'id'    => 'account-privacy',
                'icon'  => 'fas fa-user-secret',
                'type'  => 'open'
            )
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Private Account', 'youzer' ),
                'desc'  => __( "make your profile private, only friends can access.", 'youzer' ),
                'id'    => 'yz_enable_private_account',
                'type'  => 'checkbox',
                'std'   => 'off',
            ), true
        );

        do_action( 'yz_user_account_privacy_settings', $Yz_Settings );

        $Yz_Settings->get_field( array( 'type' => 'close' ) );

    }

    /**
     * # Delete Account Settings.
     */
    function data() {

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Export Data', 'youzer' ),
                'id'    => 'export-data',
                'icon'  => 'fas fa-file-export',
                'type'  => 'bpDiv'
            )
        );

        bp_get_template_part( 'members/single/settings/data' );

        $Yz_Settings->get_field( array( 'type' => 'endbpDiv' ) );

    }

    /**
     * # Delete Account Settings.
     */
    function delete_account() {

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Delete Account', 'youzer' ),
                'id'    => 'delete-account',
                'icon'  => 'fas fa-trash-alt',
                'type'  => 'bpDiv'
            )
        );

        echo '<div class="yz-delete-account-item">';
        bp_get_template_part( 'members/single/settings/delete-account' );
        echo '</div>';

        $Yz_Settings->get_field( array( 'type' => 'endbpDiv' ) );

    }

    /**
     * # Profile Notifications Settings.
     */
    function notifications_settings() {

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Notifications Settings', 'youzer' ),
                'id'    => 'notifications-settings',
                'icon'  => 'fas fa-bell',
                'type'  => 'open'
            )
        );

        // # Activity Notifications.

        if ( bp_is_active( 'activity' ) ) :
                
            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Mentions Notifications', 'youzer' ),
                    'desc'  => __( 'Email me when a member mentions me in a post', 'youzer' ),
                    'id'    => 'yz_notification_activity_new_mention',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Replies Notifications', 'youzer' ),
                    'desc'  => __( "Email me when a member replies to a post or comment i have posted", 'youzer' ),
                    'id'    => 'yz_notification_activity_new_reply',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

        endif;

        // # Messages Notifications.

        if ( bp_is_active( 'messages' ) ) :
            
            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Messages Notifications', 'youzer' ),
                    'desc'  => __( "Email me when a member sends me a new message", 'youzer' ),
                    'id'    => 'yz_notification_messages_new_message',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

        endif;

        // # Friends Notifications.

        if ( bp_is_active( 'friends' ) ) :

            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Friendship Requested Notifications', 'youzer' ),
                    'desc'  => __( "Email me when a member sends me a friendship request", 'youzer' ),
                    'id'    => 'yz_notification_friends_friendship_request',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Friendship Accepted Notifications', 'youzer' ),
                    'desc'  => __( 'Email me when a member accepts my friendship request', 'youzer' ),
                    'id'    => 'yz_notification_friends_friendship_accepted',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

        endif;

        // # Groups Notifications.

        if ( bp_is_active( 'groups' ) ) :

            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Group Invitations Notifications', 'youzer' ),
                    'desc'  => __( 'Email me when a member invites me to join a group', 'youzer' ),
                    'id'    => 'yz_notification_groups_invite',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Group information Notifications', 'youzer' ),
                    'desc'  => __( 'Email me when A Group information is updated', 'youzer' ),
                    'id'    => 'yz_notification_groups_group_updated',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Group Admin Promotion Notifications', 'youzer' ),
                    'desc'  => __( 'Email me when i promoted to a group administrator or moderator', 'youzer' ),
                    'id'    => 'yz_notification_groups_admin_promotion',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Join Group Notifications', 'youzer' ),
                    'desc'  => __( 'Email me when a member requests to join a private group for which i am an admin', 'youzer' ),
                    'id'    => 'yz_notification_groups_membership_request',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

            $Yz_Settings->get_field(
                array(
                    'title' => __( 'Group Membership Request Notifications', 'youzer' ),
                    'desc'  => __( 'Email me when my request to join a group has been approved or denied', 'youzer' ),
                    'id'    => 'yz_notification_membership_request_completed',
                    'type'  => 'checkbox',
                    'std'   => 'on',
                ), true, 'youzer_notifications'
            );

        endif;

        $Yz_Settings->get_field( array( 'type' => 'close' ) );

    }

    /**
     * # Profile Cover Settings.
     */
    function profile_cover() {

        // Cover Image Uploader Script.
        wp_enqueue_style( 'yz-bp-uploader' );
        bp_attachments_enqueue_scripts( 'BP_Attachment_Cover_Image' );
            
        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Profile Cover', 'youzer' ),
                'id'    => 'profile-cover',
                'icon'  => 'fas fa-camera-retro',
                'type'  => 'bpDiv'
            )
        );

        echo '<div class="yz-uploader-change-item yz-change-cover-item">';
        bp_get_template_part( 'members/single/profile/change-cover-image' );
        echo '</div>';
        
        $Yz_Settings->get_field( array( 'type' => 'endbpDiv' ) );

    }

    /**
     * # Password Settings.
     */
    function change_password() {

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'change password', 'youzer' ),
                'id'    => 'change-password',
                'icon'  => 'fas fa-lock',
                'type'  => 'open'
            )
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'New Password', 'youzer' ),
                'desc'  => __( 'type your new password', 'youzer' ),
                'id'    => 'new_password',
                'type'  => 'password' ), true
            );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Confirm Password', 'youzer' ),
                'desc'  => __( 'confirm your new password', 'youzer' ),
                'id'    => 'confirm_password',
                'type'  => 'password'
            ), true
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Current Password', 'youzer' ),
                'desc'  => __( 'enter your current password', 'youzer' ),
                'id'    => 'current_password',
                'type'  => 'password'
            ), true
        );

        $Yz_Settings->get_field( array( 'type' => 'close' ) );

    }

    /**
     * Block Members Plugin.
     */
    function members_block() {

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Block Members', 'youzer' ),
                'id'    => 'block-member',
                'icon'  => 'fas fa-ban',
                'type'  => 'bpDiv'
            )
        );
        
        bp_my_blocked_members_screen();

        $Yz_Settings->get_field( array( 'type' => 'endbpDiv' ) );

    }

    /**
     * Change Username Plugin.
     */
    function change_username() {

        $bp = buddypress();

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Change Username', 'youzer' ),
                'button_name' => 'change_username_submit',
                'id'    => 'change-username',
                'form_name' => 'username_changer',
                'icon'  => 'fas fa-sync-alt',
                'type'  => 'open'
            )
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Current Username', 'bp-username-changer' ),
                'desc'  => __( 'this is your current username', 'bp-username-changer' ),
                'id'    => 'current_user_name',
                'no_options' => true,
                'type'  => 'text',
                'disabled' => true,
                'std'   => esc_attr( $bp->displayed_user->userdata->user_login )
            ), true
        );

        $Yz_Settings->get_field(
            array(
                'title' => __( 'New Username', 'bp-username-changer' ),
                'desc'  => __( 'Enter the new Username of your choice', 'bp-username-changer' ),
                'id'    => 'new_user_name',
                'no_options' => true,
                'type'  => 'text'
            ), true
        );
        
        wp_nonce_field( 'bp-change-username' );

        $Yz_Settings->get_field( array( 'type' => 'close', 'button_name' => 'change_username_submit', 'hide_action' => true ) );

    }

    /**
     * Buddypress Deactivator Plugin.
     */
    function account_deactivator() {

        $user_id = bp_displayed_user_id();

        // not used is_displayed_user_inactive to avoid conflict.
        $is_inactive = bp_account_deactivator()->is_inactive( $user_id ) ? 1 : 0;

        if ( $is_inactive ) {
            $class= 'inactive';
            $message = __( 'Activate your account', 'bp-deactivate-account' );
            $status  = __( 'Deactivated', 'bp-deactivate-account' );
            update_user_meta( bp_displayed_user_id(), '_bp_account_deactivator_status', 0 );

        } else {

            $class= 'active';
            $message = __( 'Deactivate your account', 'bp-deactivate-account' );
            $status  = __( 'Active', 'bp-deactivate-account' );
            update_user_meta( bp_displayed_user_id(), '_bp_account_deactivator_status', 1 );
        }

        $bp = buddypress();

        global $Yz_Settings;

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Account Status', 'bp-deactivate-account' ),
                'button_name' => 'bp_account_deactivator_update_settings',
                'id'    => 'bp-account-deactivator-settings',
                'form_name' => 'bp-account-deactivator-settings',
                'icon'  => 'fas fa-user-cog',
                'button_value' => 'save',
                'type'  => 'open'
            )
        );

        echo '<div class="yz-bp-deactivator-' . $class . '">' . __( 'Your current account status: ', 'bp-deactivate-account' ) . '<span>' . $status . '</span></div>';

        $Yz_Settings->get_field(
            array(
                'title' => __( 'Update status', 'bp-deactivate-account' ),
                'desc'  => __( 'If you select deactivate, You will be hidden from the users.', 'bp-deactivate-account' ),
                'id'    => '_bp_account_deactivator_status',
                'opts'  => array( '1' => __( 'Activate', 'bp-deactivate-account' ), '0' => __( 'Deactivate', 'bp-deactivate-account' )),
                'no_options' => true,
                'type'  => 'radio',
            ), true
        );
        
        wp_nonce_field( 'bp-account-deactivator' );
        
        $Yz_Settings->get_field( array( 'type' => 'close', 'button_name' => 'bp_account_deactivator_update_settings', 'hide_action' => true, 'button_value' => 'save' ) );

    }
}
