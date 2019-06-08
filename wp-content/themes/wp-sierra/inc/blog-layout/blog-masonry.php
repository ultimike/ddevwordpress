<?php

/**
 * The default template for displaying blog masonry
 *
 * @package WordPress
 * @subpackage WP Sierra Theme
 */

if ( have_posts() ) {
    ?>

<div class="masonry-container <?php do_action( 'wpsierra_masonry_blog_class' ) ;?>">
<?php
    while ( have_posts() ) {
        the_post();
        ?>

<?php $featured_post = get_post_meta( $post->ID, 'featured_post', true ); ?>

<?php if ( is_sticky() ) { ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="item <?php do_action( 'wpsierra_large_sticky_post' ); ?> <?php do_action( 'wpsierra_archive_columns' ) ; ?>">

				<?php wpsierra_blog_style_2( 'large' ); ?>

			</div><!--/.item-->

		</article>

<?php } elseif ( $featured_post ) { ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="item <?php do_action( 'wpsierra_archive_columns' ) ; ?>">

			<?php wpsierra_blog_style_2( 'large' ); ?>

		</div><!--/.item-->

	</article>

<?php } else { ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="item <?php do_action( 'wpsierra_archive_columns' ) ; ?>">

			<?php do_action( 'wpsierra_post_style' ); ?>

		</div><!--/.item-->

	</article>

<?php
  }

?>

<?php wp_reset_postdata(); ?>

<?php
}
?>

</div><!--/.masonry-container-->

<?php the_posts_pagination(); ?>


<?php
} else {
    get_template_part( 'content', 'none' );
}
