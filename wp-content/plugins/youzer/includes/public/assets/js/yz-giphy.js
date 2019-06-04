( function( $ ) {

	'use strict';

	$( document ).ready( function() {

		var giphy_search = $( '.yz-giphy-submit-search' ),
			gihpy_grid_sizer = '<div class="yz-giphy-grid-sizer"></div>',
			giphy_load_more = $( '.yz-load-more-giphys' ),
			selected_giphy = $( '.yz-selected-giphy-item' ),
			masonryOptions = {
			    itemSelector: '.yz-giphy-item',
			    columnWidth: '.yz-giphy-grid-sizer',
			      percentPosition: true,

			    // columnWidth: 175,
			    gutter: 10
		  	}, $container, is_giphy_selected = false;

		/**
		 * Delete GIF Process.
		 */
		$( '.yz-delete-giphy-item' ).on( 'click', function() {

			$( '.yz-selected-giphy-item' ).fadeOut( 400, function() {

				// Clear Selected Gif Data
				$( this ).find( 'img' ).remove();
				$( this ).find( 'input' ).val( '' );

				// Display Search Form.
				$( '.yz-wall-giphy-form .yz-wall-cf-item' ).fadeIn(200, function() {
					$container = $( '.yz-giphy-items-content' ).masonry( masonryOptions );
				});

			});

		});

		/**
		 * Select GIF Process
		 */
		$( document ).on( 'click', '.yz-giphy-item img', function ( e ) {

			if ( is_giphy_selected === true ) {
				return;
			}

			is_giphy_selected = true;


			// Init Var.
			var img_url = $( this ).attr( 'data-original' );

			// Hide Search Form.
			$( '.yz-wall-giphy-form .yz-wall-cf-item' ).fadeOut( 400, function(){
				
				// Display Loader.
				$( '.yz-giphy-loading-preview' ).fadeIn();

				// Add Selected Image.
				selected_giphy.find( 'input' ).val( img_url );

				// Get Selected Image.
				var selected_image = $( '<img>' ).attr( { src: img_url } );
				
				// Add Image3
				selected_giphy.prepend( selected_image );
				
				// Wait Untill Image Is loaded.
				$( selected_image).on('load', function( e ){

					// Hide Loader.					
					$( '.yz-giphy-loading-preview' ).fadeOut( 100, function() {
						// Display Image.
						selected_giphy.fadeIn().css( 'display', 'inline-block' );
						// Reset Giphy Selection.
						is_giphy_selected = false;
					});
				});

			});

		});

		/**
		 * Display Gifs On Input.
		 */
		$( '.yz-giphy-submit-search' ).on( 'click', function() {

			var search_query = $( this ).prev( '.yz-giphy-search-input' ).val();

			// Hide & Change Load More Query & Page.
			giphy_load_more.fadeOut( 1 );
			giphy_load_more.attr( 'data-query', search_query );
			giphy_load_more.attr( 'data-page', 2 );

		    // Reset Giphy Items.
			$( '.yz-giphy-items-content' ).html( gihpy_grid_sizer );

			// Init Masonry.
			$container = $( '.yz-giphy-items-content' ).masonry( masonryOptions );

			if ( search_query != '' ) {
	
				// Display Loader.
				giphy_search.addClass( 'loading' );
				giphy_search.html( '<i class="fas fa-spin fa-spinner"></i>' );

			  	// Get Giphy Items Through An Ajax Call.
				$.yz_LoadGiphyItems( { q : search_query } );

			}

		});

		// Set Enter On Submit Search Button.
		$( '.yz-giphy-search-input' ).keypress( function( e ) {
			if( e.keyCode == 13 ) {
				e.preventDefault();
				giphy_search.click();
			}
		});

		/**
		 * Load More GIFs Process
		 */
		$( document ).on( 'click', '.yz-load-more-giphys', function ( e ) {

			// Display Loader.
			giphy_load_more.addClass( 'loading' );
			giphy_load_more.html( '<i class="fas fa-spinner fa-spin"></i>' );

			var page_number = parseInt( $( this ).attr( 'data-page' ) );

			// Ars.
			var args = {
			    q: $( this ).attr( 'data-query' ),
			    offset:  ( page_number * Yz_Wall.giphy_limit ) - 2
		  	};

		  	// Get Giphy Items Through An Ajax Call.
			var $items = $.yz_LoadGiphyItems( args );

			$( this ).attr( 'data-page', page_number + 1  );

		});

		/**
		 * Get Images After Loading.
		 */
		$.fn.yz_giphy_masonryImagesReveal = function( $items, display_load_more ) {
			
			var msnry = this.data('masonry');
			
			var itemSelector = msnry.options.itemSelector;

			// hide by default
			$items.hide();

			// append to container
			this.append( $items );
		
			$items.imagesLoaded().progress( function( imgLoad, image ) {
				
				// get item : image is imagesLoaded class, not <img>, <img> is image.img.
				var $item = $( image.img ).parents( itemSelector );
				
				// un-hide item
				$item.show( 1, function() {
					
					// masonry does its thing
					msnry.appended( $( this ) );

					if ( display_load_more == true ) {
					    giphy_load_more.fadeIn();
					}

					// Hide Search Loader
					if ( giphy_search.hasClass( 'loading' ) ) {
						giphy_search.removeClass( 'loading' );
						giphy_search.html( 'Search' );
					}

					// Hide Load More Loader
					if ( giphy_load_more.hasClass( 'loading' ) ) {
						giphy_load_more.removeClass( 'loading' );
						giphy_load_more.html( 'Load More' );
					}

					// Scroll Dwon On load More.
					$( '.yz-giphy-items-content' ).animate({ scrollTop: $( '.yz-giphy-items-content' ).prop( 'scrollHeight' )}, 1000 );

				});

			});

			return this;
		};
		
		/**
		 * Get Giphy Items
		 */
		$.yz_LoadGiphyItems = function( options ) {
		
			// Get Giphy API Args.
			var args = $.extend( {
			    api_key: "aFFKTuSMjd6j0wwjpFCPXZipQbcnw3vB",
			    limit: Yz_Wall.giphy_limit,
			    fmt: "json"
        	}, options ), i, items = '', display_load_more;

			$.ajax({
				url: 'https://api.giphy.com/v1/gifs/search?' + $.param( args ),
				method: "GET",
				success: function( r ) {
					if ( r.data.length === 0 ) {
						return;
					}
					
					if ( typeof( args.offset ) === 'undefined' ) {
						$( '.yz-giphy-items-content' ).html( gihpy_grid_sizer );
					}

					for ( i = 0; i < args.limit; i++ ) {
						// Get Image Data.
						var gif = r.data[i].images;
						// Get Image Item.
						items += '<div class="yz-giphy-item"><img src="' + gif.fixed_height.url + '" data-original="' + gif.original.url + '"></div>';
					}

					display_load_more = r.pagination.total_count > args.limit ? true : false;

				    $container.yz_giphy_masonryImagesReveal( $( items ), display_load_more );

				}

			});
		}


	});

})( jQuery );