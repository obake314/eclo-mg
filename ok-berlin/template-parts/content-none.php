<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package okberlin
 */

?>

<section class="no-results not-found">
	<?php esc_html_e( '何も見つかりません', 'okberlin' ); ?>

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'okberlin' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p><?php esc_html_e( '申し訳ありませんが、検索用語に一致するものはありません。異なるキーワードで再試行してください。', 'okberlin' ); ?></p>
			<?php
		else :
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'okberlin' ); ?></p>
			<?php
		endif;
		?>
		<div class="trade_search flexbox">
<h3 class="title-section">Suche<span>取引検索</span></h3><form role="search" method="get" id="searchform" class="searchform" action="https://ok-berlin.life/">
		<label class="screen-reader-text" for="s"></label>
		<input type="text" value="" name="s" id="s">
		<input type="submit" id="searchsubmit" value=" 検索">
</form></div>
	</div><!-- .page-content -->
</section><!-- .no-results -->
