<?php
/**
 * Title: Site Footer
 * Slug: azarashilove/site-footer
 * Categories: azarashilove-site, footer
 * Block Types: core/template-part/footer
 * Inserter: true
 *
 * @package azarashilove
 */
?>
<!-- wp:html -->
<footer id="colophon" class="site-footer">
	<section class="sec_about">
		<div class="wrap flexbox">
			<figcaption>
				<h2 class="title-section">About us<span>アザラブとは</span></h2>
				<figure class="sp_only">
					<img src="/wp-content/uploads/2021/11/azarashi_img06.jpg" alt="あざ活の促進" loading="lazy">
				</figure>
				<p>アザラブとはあざらしを愛する「アザラー」のためのアザラシ総合情報サイトです。<br>
				水族館や動物園で飼育されているアザラシ、野生のアザラシ、ともに支援して、アザラシを取り巻く環境が良くなる手助けができたらと思い運営しています。<br>
				管理人の可愛いと思った動画やグッズなどの情報を共有して、あざらし活動（あざ活）の促進になればと思います。皆様とあざらしのいい出会いがあったらうれしいです。</p>
				<div class="flexbox btn">
					<p class="btn_donation"><a class="prun" href="/donation">あざらしを支援する</a></p>
					<p class="btn_contact"><a class="prun" target="_blank" href="https://x.com/_azalove" rel="noopener">X</a></p>
				</div>
			</figcaption>
			<figure class="pc_only">
				<img src="/wp-content/uploads/seal01.jpg" loading="lazy" alt="あざらしを支援する">
			</figure>
		</div>
	</section>
	<nav>
		<ul class="flexbox">
			<li><a href="/about">このサイトについて</a></li>
			<li><a href="/policy">プライバシーポリシー</a></li>
			<li><a href="/contact">お問い合わせ</a></li>
		</ul>
	</nav>
	<aside class="azarashi-feed" style="display:none;">
		<p class="wp-block-heading">
			<button
				id="azarashi-toggle"
				class="azarashi-toggle"
				type="button"
				aria-expanded="false"
				aria-controls="azarashi-feed-content">
				<span>アザラシニュース</span>
				<svg class="icon" aria-hidden="true" focusable="false">
					<use class="u-arm" href="#icon-azarashi-arm"></use>
					<use href="#icon-azarashi"></use>
				</svg>
			</button>
		</p>
		<div id="azarashi-feed-content" class="footer-widgets" hidden inert aria-hidden="true"></div>
	</aside>
	<p class="site-info">© アザラブ</p>
</footer>
<!-- /wp:html -->
