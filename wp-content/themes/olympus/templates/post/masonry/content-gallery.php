<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package olympus
 */
$layout       = get_query_var( 'sidebar-conf', array( 'position' => 'full' ) );
$column_class = olympus_get_column_classes( $layout );

$olympus       = Olympus_Options::get_instance();
$post_elements = $olympus->get_option_final( 'blog_post_elements', array() );

$gallery_images = $olympus->get_option( 'gallery_images', array(), Olympus_Options::SOURCE_POST );
$img_width      = 401;
$img_height     = 285;

$column_class[] = 'sorting-item';
?>

<div class="<?php echo esc_attr( implode( ' ', $column_class ) ) ?>">
    <div class="ui-block">
        <!-- Post -->
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post blog-post-v2' ); ?>>
            <?php if ( !empty( $gallery_images ) ) { ?>
                <div class="post-thumb crumina-module-slider">
                    <div class="swiper-container">
                        <div class="swiper-wrapper js-zoom-gallery">
                            <?php foreach ( $gallery_images as $image ) { ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo esc_url( olympus_resize( $image[ 'url' ], $img_width, $img_height, true ) ) ?>"
                                         alt="<?php esc_attr_e( 'Gallery', 'olympus' ); ?>">
                                    <a href="<?php echo esc_url( $image[ 'url' ] ); ?>" class="post-type-icon">
                                        <?php echo olympus_svg_icon( 'olymp-camera-icon' ) ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            <?php } else if ( has_post_thumbnail() ) { ?>
                <div class="post-thumb">
                    <?php olympus_generate_thumbnail( $img_width, $img_height, true ); ?>
                </div>
            <?php } ?>
            <div class="post-content">
                <?php
                if ( 'yes' === olympus_akg( 'blog_post_categories', $post_elements, 'yes' ) ) {
                    echo olympus_post_category_list( get_the_ID(), ' ', true );
                }
                ?>

                <?php the_title( '<h4 class="post-title entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>

                <?php
                if ( 'yes' === olympus_akg( 'blog_post_excerpt/value', $post_elements, 'yes' ) ) {
                    $excerpt_length = olympus_akg( 'blog_post_excerpt/yes/length', $post_elements, '20' );
                    echo olympus_html_tag( 'p', array(), olympus_generate_short_excerpt( get_the_ID(), $excerpt_length, false ) );
                }
                ?>
                <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'olympus' ),
                    'after'  => '</div>',
                ) );
                ?>

                <?php if ( 'yes' === olympus_akg( 'blog_post_meta', $post_elements, 'yes' ) ) { ?>

                    <div class="post__author author vcard inline-items">
                        <?php $author_id = get_the_author_meta( 'ID' ); ?>
                        <?php echo get_avatar( $author_id, 28 ); ?>

                        <div class="author-date not-uppercase">
                            <?php olympus_post_author( false ); ?>
                            <?php olympus_posted_time(); ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="post-additional-info inline-items">
                    <?php
                    if ( 'yes' === olympus_akg( 'blog_post_reactions', $post_elements, 'yes' ) ) {
                        echo olympus_get_post_reactions( 'compact' );
                    }
                    ?>
                    <div class="comments-shared">
                        <?php olympus_comments_count(); ?>
                    </div>
                </div>
            </div>
        </article><!-- #post-<?php the_ID(); ?> -->
    </div>
</div>
