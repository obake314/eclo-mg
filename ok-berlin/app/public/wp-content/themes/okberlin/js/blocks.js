(function () {
	var registerBlockType = wp.blocks.registerBlockType;
	var el                = wp.element.createElement;

	/* エディタ用プレースホルダー */
	function placeholder( label, desc ) {
		return el( 'div', {
				style: {
					border:     '2px dashed #b5c0c8',
					borderRadius: '4px',
					padding:    '16px 20px',
					background: '#f8f9fa',
					fontFamily: 'sans-serif',
				},
			},
			el( 'strong', { style: { display: 'block', marginBottom: '4px', color: '#1e1e1e' } }, label ),
			el( 'span',   { style: { fontSize: '12px', color: '#606672' } }, desc )
		);
	}

	/* 属性なしの SSR ブロックを登録するヘルパー */
	function singleBlock( name, title, icon, desc ) {
		registerBlockType( name, {
			title:    title,
			icon:     icon,
			category: 'widgets',
			edit: function () {
				return placeholder( title, desc );
			},
			save: function () { return null; },
		} );
	}

	/* ------------------------------------------------------------------ */
	/*  okberlin/sec-vis  — ヒーローセクション                              */
	/* ------------------------------------------------------------------ */
	singleBlock(
		'okberlin/sec-vis',
		'OK Berlin: ヒーローセクション',
		'admin-home',
		'ロゴ・説明文・為替・天気・時計・スライダー'
	);

	/* ------------------------------------------------------------------ */
	/*  okberlin/sec-news  — ニュースセクション                              */
	/* ------------------------------------------------------------------ */
	singleBlock(
		'okberlin/sec-news',
		'OK Berlin: ニュースセクション',
		'rss',
		'掲示板RSSフィード + コラム最新記事'
	);

	/* ------------------------------------------------------------------ */
	/*  okberlin/sec-contents  — コンテンツセクション                        */
	/* ------------------------------------------------------------------ */
	singleBlock(
		'okberlin/sec-contents',
		'OK Berlin: コンテンツセクション',
		'grid-view',
		'カテゴリリンク + ベルリン生活TIPS'
	);

	/* ------------------------------------------------------------------ */
	/*  okberlin/sec-interview  — インタビューセクション                      */
	/* ------------------------------------------------------------------ */
	singleBlock(
		'okberlin/sec-interview',
		'OK Berlin: インタビューセクション',
		'admin-users',
		'ベルリン在住者インタビュー（interview_name ACFフィールド表示）'
	);

}());
