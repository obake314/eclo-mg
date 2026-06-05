<?php
/**
 * Custom template tags for this theme
 *
 * @package okberlin
 */

if ( ! function_exists( 'okberlin_entry_footer' ) ) :
	/**
	 * Prints category, tag links and comment count for the current post.
	 * Used in: single-facility.php, single-interview.php, template-parts/content.php
	 */
	function okberlin_entry_footer() {
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( esc_html__( ', ', 'okberlin' ) );
			if ( $categories_list ) {
				printf( '<span class="cat-links">%1$s</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'okberlin' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'okberlin' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'okberlin' ),
						array( 'span' => array( 'class' => array() ) )
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}
	}
endif;
