<h2>現在生息が確認されているアザラシ</h2>
<?php
$parent = get_page_by_path('species'); // /type/
if ($parent) {
  $children = get_pages([
    'parent'      => $parent->ID,
    'sort_column' => 'menu_order,post_title',
    'sort_order'  => 'ASC',
    'exclude'     => [6268],
  ]);
  if ($children) : ?>
    <ul class="list_azarashi">
      <?php foreach ($children as $p) : 
        // ACF: チェックボックスの返り値(Value/Label/Both)に対応して正規化
        $raw = get_field('azarashi_location', $p->ID);
        $vals = [];
        foreach ((array)$raw as $i) {
          $vals[] = is_array($i) ? ($i['value'] ?? $i['label'] ?? '') : $i;
        }
        $classes = implode(' ', array_map('sanitize_html_class', $vals));
      ?>
        <li class="prun">
          <a href="<?php echo get_permalink($p->ID); ?>"><span class="screen-reader-text"><?php echo esc_html(get_the_title($p->ID)); ?></span></a>
            <figure class="az-auto <?php echo esc_attr($classes); ?>"></figure>
            <p><?php echo esc_html(get_the_title($p->ID)); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif;
}
?>

<h2>絶滅したアザラシ</h2>
<ul class="list_azarashi">
<li><a href="https://azarashi.love/species/karibumonku"><span class="screen-reader-text">カリブモンクアザラシ</span></a>
<figure class="az-auto"></figure><p>カリブモンクアザラシ</p></li>
</ul>