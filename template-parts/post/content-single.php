<?php
/**
 * The template for displaying single posts
 *
 * @version 1.0
 * @package GT Modern
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="post-header entry-header">

		<?php gt_modern_post_image(); ?>

		<?php gt_modern_entry_meta(); ?>

		<?php the_title( '<h1 class="post-title entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
		<?php gt_modern_entry_tags(); ?>

	</div><!-- .entry-content -->

	<?php gt_modern_widget_area( 'after-posts' ); ?>
	<?php do_action( 'gt_modern_after_posts' ); ?>

</article>
