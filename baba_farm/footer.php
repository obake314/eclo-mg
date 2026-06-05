<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package baba_farm
 */

?>

	<footer id="colophon" class="site-footer">
	<div class="container flexbox">
		<div class="left">
			<p class="site-branding"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/footer_logo.svg" alt="三右エ門｜ホワイトアスパラ「白い果実」｜株式会社馬場園芸"></p>
		</div>
		<div class="middle">
			<p class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>company">株式会社馬場園芸</a></p>
			<address>
			<p>〒028-6851 岩手県二戸市浄法寺町小池60-2</p>
			<p><br></p>
			<p><a href="https://sannimon.com/privacypolicy">プライバシーポリシー</a></p>
			</address>
		</div>
		<div class="right">
			<p>ご注文はお電話またはFAXでお受けいたします。</p>
			<p class="contact_tel"><a href="tel:0195433851"><span>TEL.</span>0195-43-3851</a></p>
			<p class="contact_fax"><a><span>FAX.</span>0195-43-3852</a></p>
		</div>
	</div>
	<p class="copy">©︎ 馬場園芸</p>
	</footer><!-- #colophon -->
</div>
<?php wp_footer(); ?>



</body>
</html>