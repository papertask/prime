( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		
		if ( jQuery().viewportChecker ) {

			/**
			 * Init Wall Posts Effects.
			 */		
			$.yz_init_wall_posts_effect = function() {

				if ( $( '.yz_effect' )[0] ) {
					$( '.yz_effect' ).viewportChecker( {
					    classToAdd: 'animated',
					    classToRemove: 'invisible',
					    removeClassAfterAnimation: true,
					    offset:'10%',
					    callbackFunction: function( elem, action ) {
							elem.addClass( elem.data( 'effect' ) );
					    }
					}, 500 );
				}
			}

			// Init Posts Effect.
			$.yz_init_wall_posts_effect();

			// Init Effect On the appended elements also.
			$( 'body' ).on( 'append', '#activity-stream', function( e ) {
				$.yz_init_wall_posts_effect();
	        });

			if ( $( '.yz-column-content div.activity' )[0] ) {
				// Init Effect On Activity Filters
				var yz_observer = new MutationObserver(function( mutations ) {
					$.yz_init_wall_posts_effect();
				});
				 
				// Pass in the target node, as well as the observer options
				yz_observer.observe( $( '.yz-column-content div.activity' )[0] , { attributes: false, childList: true, subtree:false, characterData: false } );
			}

			if ( $( 'div.activity #activity-stream' )[0] ) {
				// Init Effect On Activity Filters
				var yz_observer = new MutationObserver(function( mutations ) {
					$.yz_init_wall_posts_effect();
				});
				 
				// Pass in the target node, as well as the observer options
				yz_observer.observe( $( 'div.activity #activity-stream' )[0] , { attributes: false, childList: true, subtree:false, characterData: false } );
			}

		}
		
		/**
		 * # Modal.
		 */
		$( document ).on( 'click', '.yz-trigger-who-modal' , function( e ) {
			
			$( '.yz-wall-modal-overlay' ).fadeIn( 500, function() {
				$( this ).find( '.yz-modal-loader' ).fadeIn( 400 );
			});

			e.preventDefault();

			var post_id = $( this ).data( 'who-liked' );
			var data = {
				'action': 'yz_get_who_liked_post',
				'post_id': post_id
			};

			// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.post( Youzer.ajax_url, data, function( response ) {
				var $new_modal = $( '#yz-wall-modal' ).append( response );		
			    // Display Modal
				$new_modal.find( '.yz-wall-modal' ).addClass( 'yz-wall-modal-show' );
				// Hide Loader
				$( '.yz-wall-modal-overlay' ).find( '.yz-modal-loader' ).hide();
			});

		});

		// Hide Modal If User Clicked Escape Button
		$( document ).keyup( function( e ) {
			if ( $( '.yz-wall-modal-show' )[0] ) {
			    if ( e.keyCode === 27 ) {
				    $( '.yz-wall-modal-close' ).trigger( 'click' );
			    }
			}
		});

		// # Hide Modal if User Clicked Outside
		$( document ).mouseup( function( e ) {
		    if ( $( '.yz-wall-modal-overlay' ).is( e.target ) && $( '.yz-wall-modal-show' )[0] ) {
				$( '.yz-wall-modal-close' ).trigger( 'click' );
		    }
		});

		if ( Youzer.activity_autoloader == 'on' ) {
			
			// Hide Load More Button.
			// $( '.youzer .activity li.load-more' ).css( 'visibility', 'hidden' );

		   var $window = $( window );

			// Check the window scroll event.
			$window.scroll( function () {
				// Find the visible "load more" button.
				// since BP does not remove the "load more" button, we need to find the last one that is visible.
				var $load_more_btn = $( '#activity-stream .load-more:visible' );
				// If there is no visible "load more" button, we've reached the last page of the activity stream.
				// If data attribute is set, we already triggered request for ths specific button.
				if ( ! $load_more_btn.get( 0 ) || $load_more_btn.data( 'yz-autoloaded' ) ) {
					return;
				}

				// Find the offset of the button.
				var pos = $load_more_btn.offset();
				var offset = pos.top - 3000;// 50 px before we reach the button.

				// If the window height+scrollTop is greater than the top offset of the "load more" button,
				// we have scrolled to the button's position. Let us load more activity.
				if ( $window.scrollTop() + $window.height() > offset ) {
					$load_more_btn.data( 'yz-autoloaded', 1 );
					$load_more_btn.find( 'a' ).trigger( 'click' );
				}

			});
		}
		
		/* Add / Remove friendship buttons */
		$( '#activity-stream' ).on('click', '.friendship-button a', function() {
			$(this).parent().addClass('loading');
			var fid   = $(this).attr('id'),
				nonce   = $(this).attr('href'),
				thelink = $(this);

			fid = fid.split('-');
			fid = fid[1];

			nonce = nonce.split('?_wpnonce=');
			nonce = nonce[1].split('&');
			nonce = nonce[0];

			jq.post( ajaxurl, {
				action: 'addremove_friend',
				'cookie': bp_get_cookies(),
				'fid': fid,
				'_wpnonce': nonce
			},
			function(response)
			{
				var action  = thelink.attr('rel');
				var parentdiv = thelink.parent();

				if ( action === 'add' ) {
					$(parentdiv).fadeOut(200,
						function() {
							parentdiv.removeClass('add_friend');
							parentdiv.removeClass('loading');
							parentdiv.addClass('pending_friend');
							parentdiv.fadeIn(200).html(response);
						}
						);

				} else if ( action === 'remove' ) {
					$(parentdiv).fadeOut(200,
						function() {
							parentdiv.removeClass('remove_friend');
							parentdiv.removeClass('loading');
							parentdiv.addClass('add');
							parentdiv.fadeIn(200).html(response);
						}
						);
				}
			});
			return false;
		} );

		$('#activity-stream').on('click', '.group-button a', function( e ) {

			if( ! $( this ).hasClass( 'membership-requested') ) {
				$( this ).addClass( 'yz-btn-loading' );
			}
			
			var gid   = $(this).parent().attr('id'),
				nonce   = $(this).attr('href'),
				thelink = $(this);

			gid = gid.split('-');
			gid = gid[1];

			nonce = nonce.split('?_wpnonce=');
			nonce = nonce[1].split('&');
			nonce = nonce[0];

			// Leave Group confirmation within directories - must intercept
			// AJAX request
			if ( thelink.hasClass( 'leave-group' ) && false === confirm( BP_DTheme.leave_group_confirm ) ) {
				return false;
			}

			jq.post( ajaxurl, {
				action: 'joinleave_group',
				'cookie': bp_get_cookies(),
				'gid': gid,
				'_wpnonce': nonce
			},
			function(response) {
				var parentdiv = thelink.parent();

				$(parentdiv).fadeOut(200,
					function() {
						parentdiv.fadeIn(200).html(response);

						var mygroups = $('#groups-personal span'),
							add        = 1;

						if( thelink.hasClass( 'leave-group' ) ) {
							// hidden groups slide up
							if ( parentdiv.hasClass( 'hidden' ) ) {
								parentdiv.closest('li').slideUp( 200 );
							}

							add = 0;
						} else if ( thelink.hasClass( 'request-membership' ) ) {
							add = false;
						}

						// change the "My Groups" value
						if ( mygroups.length && add !== false ) {
							if ( add ) {
								mygroups.text( ( mygroups.text() >> 0 ) + 1 );
							} else {
								mygroups.text( ( mygroups.text() >> 0 ) - 1 );
							}
						}

					}
				);
			});
			return false;
		} );
	
	$("audio").on("play", function() {
        $("audio").not(this).each(function(index, audio) {
            audio.pause();
        });
    });

	});

})( jQuery );