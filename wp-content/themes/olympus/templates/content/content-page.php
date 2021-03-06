<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package olympus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    $olympus = Olympus_Options::get_instance();
    $stunning_visibility = $olympus->get_option_final( 'header-stunning-visibility', 'yes' );
    ?>
    <?php if ( $stunning_visibility !== 'yes' && !olympus_is_composer() ) { ?>
        <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php } ?>

    <div class="page-content">
        <?php
        the_content();

        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'olympus' ),
            'after'  => '</div>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <?php if ( get_edit_post_link() ) : ?>
        <footer class="entry-footer">
            <?php
            edit_post_link(
                    sprintf(
                            wp_kses(
                                    /* translators: %s: Name of current post. Only visible to screen readers */
                                    __( 'Edit <span class="screen-reader-text">%s</span>', 'olympus' ),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                            ),
                            get_the_title()
                    ),
                    '<span class="edit-link">',
                    '</span>'
            );
            ?>
        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #apge-<?php the_ID(); ?> -->
