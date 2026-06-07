<?php
/**
 * The front page template
 *
 * @package baba_farm
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	the_content();
endwhile;
?>

<?php get_footer(); ?>
