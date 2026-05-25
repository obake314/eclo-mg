<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package okberlin
 */

?>
<li>
<a class="flexbox" href="<?php the_permalink() ?>">

							<figure>
								<?php if(has_post_thumbnail()) : ?><?php the_post_thumbnail('full'); ?>
								<?php else: ?>
								<img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/cropped-ogp.jpg">
								<?php endif; ?>
							</figure>
							<figcaption>
								<h3><?php the_title(); ?></h3>
								<p class="post_meta"><time><?php the_time('Y/m/d') ?></time></p>
								<div class="content"><?php the_excerpt(); ?></div>
							</figcaption>
								</a>					
						</li>
