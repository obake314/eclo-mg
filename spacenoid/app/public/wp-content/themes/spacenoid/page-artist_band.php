<?php
/*
Template Name: アーティスト(バンド)テンプレート
*/
?>

<?php get_header(); ?>


<div id="content-wrapper" class="wrapper member_wrapper">
<h2><?php the_title(); ?></h2>
	
<?php $ctm = get_post_meta($post->ID, 'role', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<p class="rolebox"><?php echo post_custom('role');?></p>
<?php endif;?>

<p class="artist_photo">
<img src="<?php the_field('photo'); ?>" alt=""></p>
<div class="flexbox artist_outline">
<div class="leftbox">
<?php the_field('biography2'); ?>			
</div>
<div class="rightbox">
<?php the_field('biography'); ?>
</div>
</div>
<?php $ctm = get_post_meta($post->ID, 'photo', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<?php endif;?>
<?php $ctm = get_post_meta($post->ID, 'photo2', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<div class="rightbox">			
<?php endif;?>
<?php if(have_rows('discography')): ?>
<h3 class="member_headline">Discography</h3>
<div class="flexbox pf_list_wrap">
<?php while(have_rows('discography')): the_row(); ?>
<div class="pf_list">
<h4><?php the_sub_field('disc_name'); ?>　<small><?php the_sub_field('disc_time'); ?></small></h4>
<ul class="img_box">
<a class="modal" href="#modal_<?php the_sub_field('disc_slug'); ?>"><img src="<?php the_sub_field('disc_img'); ?>"></a>
<li class="box">
<?php the_sub_field('disc_img'); ?>
<div id="modal_<?php the_sub_field('disc_slug'); ?>" style="display:none;">
<div class="flexbox">
<div class="left">
<h4><?php the_sub_field('disc_name'); ?>　<small><?php the_sub_field('disc_time'); ?></small></h4>
<p><?php the_sub_field('disc_memo'); ?></p>
<p class="price">価格：<?php the_sub_field('disc_price'); ?>円</p>
<p><a class="btn" href="<?php the_sub_field('disc_url'); ?>">取扱ページ</a></p>
</div>
<ul class="right">
<li class="box2"><img src="<?php the_sub_field('disc_img'); ?>"></li>
</ul>
</div>
</div>
</li>
</ul>
</div>
<?php endwhile; ?>
</div>
<?php endif; ?>	
<?php while ( have_posts() ) : the_post(); 
		
			wp_dequeue_script( 'spacenoid-photostack' );
			get_template_part( 'inc/format/content', 'page' );
					

		endwhile; // end of the loop. ?>
		</div><!-- wrapper -->
<script>
jQuery(function(){
  jQuery('.modal').modaal();
});
</script>		
<?php get_footer(); ?>