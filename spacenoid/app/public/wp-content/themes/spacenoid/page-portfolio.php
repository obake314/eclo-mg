<?php
/*
Template Name: ポートフォリオーテンプレート
*/
?>

<?php get_header(); ?>


		<div id="content-wrapper" class="wrapper member_wrapper">

			<h2 class="sp_only"><?php the_title(); ?>
			<?php if( get_field('english') ) { ?>
			<span><?php the_field('english'); ?></span>
			<?php } ?></h2>
			<div class="flexbox">

		
<div class="leftbox">
	<h2 class="pc_only"><?php the_title(); ?>
			<?php if( get_field('english') ) { ?>
			<span><?php the_field('english'); ?></span>
			<?php } ?></h2>
			
<?php $ctm = get_post_meta($post->ID, 'role', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<p class="rolebox"><?php echo post_custom('role');?></p>
<?php endif;?>
	
	<dl>				
<?php $ctm = get_post_meta($post->ID, 'sex', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
	<dt>性別</dt><dd><?php echo post_custom('sex');?></dd>
<?php endif;?>
			
<?php $ctm = get_post_meta($post->ID, 'birth', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>生年月日</dt><dd><?php echo post_custom('birth');?></dd>
<?php endif;?>

<?php $ctm = get_post_meta($post->ID, 'place', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>出身地</dt><dd><?php echo post_custom('place');?></dd>
<?php endif;?>		
			
<?php $ctm = get_post_meta($post->ID, 'blood', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>血液型</dt><dd><?php echo post_custom('blood');?></dd>
<?php endif;?>

<?php $ctm = get_post_meta($post->ID, 'height/weight', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>身長<span class="weight">／体重</span></dt><dd><?php echo post_custom('height/weight');?></dd>
<?php endif;?>
		
<?php $ctm = get_post_meta($post->ID, 'size', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>サイズ</dt><dd><?php echo post_custom('size');?></dd>
<?php endif;?>	
	
<?php $ctm = get_post_meta($post->ID, 'headsize', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>頭のサイズ</dt><dd><?php echo post_custom('headsize');?></dd>
<?php endif;?>

<?php $ctm = get_post_meta($post->ID, 'shoesize', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>靴のサイズ</dt><dd><?php echo post_custom('shoesize');?></dd>
<?php endif;?>

<?php $ctm = get_post_meta($post->ID, 'hobby', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>趣味</dt><dd><?php echo post_custom('hobby');?></dd>
<?php endif;?>
			
<?php $ctm = get_post_meta($post->ID, 'skill', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>特技</dt><dd><?php echo post_custom('skill');?></dd>
<?php endif;?>

<?php $ctm = get_post_meta($post->ID, 'licence', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
<dt>資格</dt><dd><?php echo post_custom('licence');?></dd>
<?php endif;?>
	
	<?php $ctm = get_post_meta($post->ID, 'outline', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
	<?php echo post_custom('outline');?>
<?php endif;?>
</dl>
				</div>

				<?php $ctm = get_post_meta($post->ID, 'photo', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
	<div class="rightbox">
			<p class="profile_photo">
				<img src="<?php the_field('photo'); ?>" alt=""></p>
			</div>
<?php endif;?>
			<?php $ctm = get_post_meta($post->ID, 'photo2', true);?>
<?php if(empty($ctm)):?>
<?php else:?>
	<div class="rightbox">
			<p class="profile_photo">
				<img src="<?php the_field('photo2'); ?>" alt=""></p>
			</div>
<?php endif;?>
				
				
				
					</div>
			<h3 class="member_headline">出演履歴</h3>
			<h3 class="uozumi_headline">活動実績</h3>
		<?php while ( have_posts() ) : the_post(); 
		
			wp_dequeue_script( 'spacenoid-photostack' );
			get_template_part( 'inc/format/content', 'page' );
					

		endwhile; // end of the loop. ?>
			
<script>
jQuery(function(){
  jQuery('.modal').modaal();
});
</script>			
			
			
<?php if(have_rows('pf')): ?>
			<h3 class="uozumi_headline">ポートフォリオ</h3>
			<h3 class="mikasano_headline">公開脚本</h3>
			<div class="flexbox pf_list_wrap">
<?php while(have_rows('pf')): the_row(); ?>

<div class="pf_list">
<h4><?php the_sub_field('pf_name'); ?>　<small><?php the_sub_field('pf_time'); ?></small></h4>

<ul class="img_box">
<?php $images = get_sub_field('pf_img');
if( $images ): ?>
<?php foreach( $images as $image ): ?>
<li class="box">
<a class="modal" href="#modal_<?php the_sub_field('pf_slug'); ?>">
<img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
</a>
<div id="modal_<?php the_sub_field('pf_slug'); ?>" style="display:none;">
<div class="flexbox">
<div class="left">
<h4><?php the_sub_field('pf_name'); ?>　<small><?php the_sub_field('pf_time'); ?></small></h4>
<p><?php the_sub_field('pf_memo'); ?></p>
</div>
<ul class="right">
<?php $imagess = get_sub_field('pf_img');
if( $imagess ): ?>
<?php foreach( $imagess as $image2 ): ?>
<li class="box2"><img src="<?php echo $image2['sizes']['thumbnail']; ?>" alt="<?php echo $image2['alt']; ?>" /></li>
<?php endforeach; ?>
<?php endif; ?>
</ul>
</div>
	</div>
		</li>
<?php endforeach; ?>

<?php endif; ?>

</ul>
		</div>
<?php endwhile; ?>
						</div>
<?php endif; ?>
	
		</div><!-- wrapper -->


<?php get_footer(); ?>