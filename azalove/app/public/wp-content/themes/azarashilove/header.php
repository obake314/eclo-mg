<!DOCTYPE html>
<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package azarashilove
 */

?>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="アザラブ">
	<meta name="theme-color" content="#5ec2cf;">
	<?php if ( is_category() ) : ?>
	  <meta name="description" content="<?php echo esc_attr( strip_tags( category_description() ) ); ?>">
	<?php endif; ?>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=LINE+Seed+JP:wght@400;700&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const shutter = document.querySelector(".shutter");
    if (!shutter) return;
    if (sessionStorage.getItem("shutterShown")) {
      shutter.style.display = "none";
    } else {
      sessionStorage.setItem("shutterShown", "true");
    }
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const shutter = document.querySelector(".shutter");
    if (!shutter) return; // 念のため保険
    if (sessionStorage.getItem("shutterShown")) {
      shutter.style.display = "none";
    } else {
      sessionStorage.setItem("shutterShown", "true");
    }
  });
</script>
<div class="shutter">
	<svg version="1.1" id="azalove_logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
	 y="0px" viewBox="0 0 362 233.8" style="enable-background:new 0 0 362 233.8;" xml:space="preserve">
	<defs>
	<style>	
	.shutter{
		position:fixed;
		top:0;
		left:0;
		right:0;
		bottom:0;
		background-color:#FFF;
		z-index:9999;
		-webkit-animation: byeShutter 5s forwards;
		animation: byeShutter 5s forwards;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.shutter::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		margin: auto;
		background-color: #fff;
		width: 0;
		height: 1px;
		-webkit-animation: shutterOpen 4s forwards;
		animation: shutterOpen 4s forwards;
		z-index: -1;
	}
@keyframes byeShutter {
	70% {
	  opacity: 1;
	}
	100% {
	  opacity: 0;
	  display: none;
	  z-index: -1;
	}
  }

  @keyframes shutterOpen {
	0% {
	  width: 0;
	  height: 1px;
	}
	50% {
	  width: 100%;
	  height: 1px;
	}
	90% {
	  width: 100%;
	  height: 100%;
	}
	100% {
	  width: 100%;
	  height: 100%;
	}
  }
  .shutter svg{
	  width:250px;
	  height: auto;
  }
.shutter .st0{fill:#5EC2CF;}
.shutter .st1{fill:#CCCCCC;}
.shutter .st2{fill:#262F5D;}
.shutter .st3{fill:#EF8EA2;}
.shutter path {
	stroke:transparent;
	fill:transparent;
}
.shutter .st1,
.shutter .st2{
	stroke-dasharray: 2000;
	stroke-dashoffset: 0;
	stroke-width: .5;
}
.shutter .st1{
	stroke:#CCCCCC;
	stroke-dashoffset: 2000;
	animation: st1_anime 2s ease-in 0s forwards; 
}
.shutter .st2{
	stroke:#262F5D;
	animation: st2_anime 2s ease-in 0s forwards; 
}
.svg_logo{
	stroke-dashoffset: 2000;
	animation: poyoyon 1s linear 0s forwards; 
}
@keyframes st1_anime {
	  0% {
		stroke-dashoffset: 2000;
		fill:transparent  
	  }
	  50% {
		fill:transparent;
	  }
	  100% {
		stroke-dashoffset: 0;
		fill:#CCCCCC;
	  }
	}
	@keyframes st2_anime {
	  0% {
		opacity:0;
	  }
	  100% {
		opacity:1;
	  }
	}

	@keyframes poyoyon {
0%   { transform: scale(1.0, 1.0) translate(0%, 0%); }
  15%  { transform: scale(0.9, 0.9) translate(0%, 3%); }
  30%  { transform: scale(1.1, 0.9) translate(0%, 7%); }
  50%  { transform: scale(0.9, 1.1) translate(0%, -7%); }
  70%  { transform: scale(1.1, 0.9) translate(0%, 3%); }
  100% { transform: scale(1.0, 1.0) translate(0%, 0%); }
	}
</style>
		</defs>
	<!--アザ-->
	<g class="svg_logo">
		<path class="st0" d="M48.7,154c-2.8,6.1-7,12.1-15.6,13.8c-2.1,0.4-3.2-1.7-2.5-2.9c1.3-2.5,2-8.8,2-11.4c-0.1-0.5-0.4-0.8-1-0.8
			h-25c-2,0-3.6-1.7-3.6-3.6c0-2,1.5-3.5,3.6-3.5h34.2C47.3,145.6,50.8,149.6,48.7,154z"/>
		<path class="st0" d="M29,165.6c1.1-3.7-0.7-7.5-6.6-8.7c-5.3-1-9.6,1.2-9.8,5.7c-0.1,5-1.5,12.3-2.4,16.5c-0.5,2.3,3.1,4.1,5.8,2.6
			C20.7,179.2,26.9,172.8,29,165.6z"/>
		<path class="st0" d="M103.4,155.9c0,2-1.6,3.6-3.6,3.6h-3.5c-1,0-1.1,1-1.1,1c0,7.7-8.6,19.5-18.1,22.6c-3.2,1.1-5.3-0.9-3.7-3.6
			c2.3-3.9,5.8-13.5,5.8-19.1c0,0,0.1-0.9-1-0.9c-1.1,0-3.3,0-3.3,0c-0.7,0-1.3,0.5-1.3,1v3.5c0,3-3.1,5.5-6.9,5.5S60,167,60,164
			v-3.8c0-0.4-0.4-0.7-0.9-0.7h-3.7c-2,0-3.5-1.6-3.5-3.6c0-2,1.5-3.6,3.5-3.6h3.7c0.5,0,0.9-0.3,0.9-0.7v-4.4c0-3,3.1-5.5,6.9-5.5
			s6.9,2.5,6.9,5.5v4.2c0,0.5,0.5,0.9,1.1,0.9c0,0,2.5,0,3.4,0c1,0,1-0.9,1-0.9v-3.5c-0.1-3.5,3.5-6.3,7.9-6.4c4.5-0.1,8,2.7,8,6.3
			v3.6c0,0,0,0.9,1,0.9s3.6,0,3.6,0C101.9,152.3,103.4,153.9,103.4,155.9z"/>
		<circle class="st0" cx="92.7" cy="134.4" r="3.7"/>
		<circle class="st0" cx="104.1" cy="132.3" r="3.7"/>
	</g>
	<path class="st1" d="M361.6,201.9c-3.8-9.1-13.9-12.4-21.4-12.4c-1,0-2,0.1-2.9,0.2c-0.8,0.1-1.6,0.1-2.2,0.1c-3.2,0-5.2-1.1-7-3.7
		c-1.3-1.9-2.6-3.9-4.1-5.7c-2.8-3.4-1.9-6.3-0.6-9.3l0.1-0.2c3.4-8.2,6.9-16.6,8.5-25.1c3.2-16.9,0.8-33.4-4-53
		c-6.8-28.4-14.7-50.6-24.7-69.9C295.2,7.5,282.9,0,265.7,0c-1,0-2.1,0-3.2,0.1c-22.3,1.1-37.2,13.1-42,33.8
		c-2.3,10.1-3.9,21.1-5.1,35.9c-1.2,14.1-2.2,16.4-15.8,21.4l-0.6,0.2c-0.4,0.2-0.9,0.3-1.2,0.5c-5,2.3-10.2,4.7-15.2,6.9
		c-11.3,5.1-23,10.3-34,16.3c-18,9.7-34.3,23.9-51.1,44.9c-11.1,13.8-24.8,21.2-39.6,21.2c-3.2,0-6.6-0.4-9.9-1
		c-1.8-0.4-3.7-0.6-5.5-0.6c-5.8,0-11,1.8-16.4,3.8c-2.4,0.8-4.8,1.7-7.2,2.4l-1.9,0.5c-3.6,1.3-4.4,4.3-4.4,9.2l0,1.1l0.4,0.1
		c-1.2,0.1-2.4,0.2-3.5,0.4c-0.8,0.1-1.8,0.2-2.9,0.5L2.6,199c-1.7,1.1-2.8,2.9-2.6,5.8c0.4,5,5.2,5.3,8.3,5.4c0.5,0,0.9,0,1.3,0.1
		c0.2,0,0.5,0,0.7,0l0.9,0h54.3c44.8,0,89.6,0,134.5,0c1.1,0,2.1-0.1,3.1-0.2c0.4,0,0.8-0.1,1.2-0.1l2.7-0.2l-1.6-2.2
		c-1.3-1.6-2.5-3.2-3.8-4.8c-2.8-3.5-5.5-6.9-7.8-10.5c-1.4-2.1-1.8-4.4-1.3-6.6c0.5-2.2,1.9-4.2,4-6c0.1,0.8,0.1,1.5-0.1,2
		c-2.3,5.8,0.3,10.1,2.4,12.9c9.3,12.2,20.4,21.6,32.9,27.7c2.6,1.3,7.8,3.5,12.9,3.5c0.9,0,1.8-0.1,2.7-0.2c1.1-0.2,2.1-0.3,3-0.3
		c3.2,0,5.6,1.1,8.5,3.8c1.7,1.5,3.7,2.5,6.1,3.6l5.7-0.1v-8l0.2-0.2c0.5,1.2,1,2.4,1.9,3.5c1.2,1.5,2.9,3.2,4.9,4.4l0.3,0.2
		c0.1,0.1,0.2,0.1,0.3,0.2c0.1,0.1,0.2,0.1,0.4,0.2c1.2,0.6,2.3,0.9,3.2,0.9c1.2,0,2.2-0.4,2.9-1.2c1-1.1,1.4-2.8,1.2-5
		c-0.1-0.8-0.2-1.6-0.4-2.5c0.6,0.6,1.1,1.3,1.6,2c1.3,1.7,2.6,3.4,4.5,4.4l5.7-0.1l0.5,0c0.6-1.1,1-2.8,1.1-4.3
		c0.2-8.6-4.9-14.5-13.7-15.6l-12.8-1.7l-0.3-2.8c2.3-0.8,4.6-1.5,6.7-2.1c4.7-1.5,9.2-2.8,13.3-4.7c2-0.9,3.6-1.3,5.2-1.3
		c1.8,0,3.6,0.5,5.6,1.7c7,4.1,14.5,6.1,22.1,6.1c5.5,0,11.4-1.1,17.3-3.2c0.9-0.3,1.8-0.4,2.9-0.4c1.5,0,3,0.3,4.4,0.5
		c0.9,0.1,1.7,0.3,2.5,0.4c1.1,0.1,2.1,0.3,3.1,0.6c1.1,0.2,2.1,0.4,3.1,0.5c-0.3-0.1-0.6-0.2-0.9-0.2l0,0l3.7-0.1
		c0.1-0.1,0.3-0.2,0.4-0.3C362.1,203.9,362,203,361.6,201.9z M355,204.1c-0.4-0.1-0.9-0.3-1.3-0.5C354.1,203.8,354.6,204,355,204.1z"
		/>
	<!--ラブ-->
	<g class="svg_logo">
		<path class="st3" d="M163.3,165.4c-0.2,0.4-0.4,0.8-0.6,1.2c-2.8,6.2-11.6,14.2-20.1,16.5c-4.2,1.1-6.8-1.3-5-3.8
			c4-5.2,6.1-13.2,6.6-16c0.1-0.5-0.5-0.9-1.2-0.9h-20.7c-2,0-3.6-1.4-3.6-3.4c0-2,1.5-3.8,3.6-3.8h29.8
			C159.3,155.3,165.5,160.1,163.3,165.4z"/>
		<path class="st3" d="M153,151c2,0,3.6-1.6,3.6-3.6c0-2-1.5-3.5-3.6-3.5h-24.5c-2,0-3.6,1.5-3.6,3.5c0,2,1.6,3.6,3.6,3.6H153z"/>
		<path class="st3" d="M181,182.1c-3.3,0.9-5.1-2.3-2.9-4.3c1.7-1.7,7.7-11.8,12.1-23.8c0.2-0.5-0.2-0.9-0.7-0.9h-20.1
			c-2,0-3.6-1.6-3.6-3.6s1.5-3.6,3.6-3.6h28.1c6.8,0,12,4.6,11,9.9C207.4,161,197.4,177.8,181,182.1z"/>
		<circle class="st3" cx="195.8" cy="137.7" r="3.7"/>
		<circle class="st3" cx="207.1" cy="135.7" r="3.7"/>
	</g>
	<g>
		<path class="st2" d="M20.7,192.3c1.7,0,3,0.8,4,2.5c0.3,0.7,0.4,1.3,0.4,2.1v3.9c0,0.2-0.1,0.3-0.4,0.4h0c-0.2,0-0.3-0.1-0.4-0.3v0
			l0-0.8v-0.6c-1.2,1.1-2.4,1.7-3.4,1.7h-0.3c-1.5,0-2.7-0.8-3.7-2.3c-0.4-0.7-0.5-1.4-0.5-2.2c0-1.6,0.8-2.9,2.4-3.9
			C19.4,192.5,20.1,192.3,20.7,192.3z M17.2,196.7L17.2,196.7c0,1.5,0.7,2.6,2.2,3.4c0.5,0.2,0.9,0.3,1.2,0.3h0.3
			c1.2,0,2.2-0.6,3-1.8c0.3-0.6,0.4-1.1,0.4-1.6v-0.1c0-1.4-0.7-2.5-2-3.2c-0.5-0.2-1-0.3-1.5-0.3h0c-1.5,0-2.6,0.8-3.3,2.3
			C17.2,195.9,17.2,196.3,17.2,196.7z"/>
		<path class="st2" d="M30,192.5L30,192.5l5.9,0l0.3,0c0.3,0.1,0.4,0.2,0.4,0.3v0.2c0,0.1-0.2,0.4-0.7,0.9l-5.1,6.4h5.5
			c0.3,0.1,0.4,0.2,0.4,0.4v0.1c0,0.2-0.1,0.3-0.4,0.4h-6.3c-0.2,0-0.4-0.2-0.4-0.5c0-0.1,0.4-0.7,1.3-1.7l4.5-5.7h-5l-0.5,0
			c-0.2-0.1-0.4-0.2-0.4-0.4C29.4,192.6,29.6,192.5,30,192.5L30,192.5z"/>
		<path class="st2" d="M44.5,192.3c1.7,0,3,0.8,4,2.5c0.3,0.7,0.4,1.3,0.4,2.1v3.9c0,0.2-0.1,0.3-0.4,0.4h0c-0.2,0-0.3-0.1-0.4-0.3v0
			l0-0.8v-0.6c-1.2,1.1-2.4,1.7-3.4,1.7h-0.3c-1.5,0-2.7-0.8-3.7-2.3c-0.4-0.7-0.5-1.4-0.5-2.2c0-1.6,0.8-2.9,2.4-3.9
			C43.2,192.5,43.9,192.3,44.5,192.3z M41,196.7L41,196.7c0,1.5,0.7,2.6,2.2,3.4c0.5,0.2,0.9,0.3,1.2,0.3h0.3c1.2,0,2.2-0.6,3-1.8
			c0.3-0.6,0.4-1.1,0.4-1.6v-0.1c0-1.4-0.7-2.5-2-3.2c-0.5-0.2-1-0.3-1.5-0.3h0c-1.5,0-2.6,0.8-3.3,2.3C41.1,195.9,41,196.3,41,196.7
			z"/>
		<path class="st2" d="M53.8,192.3c0.3,0.1,0.5,0.2,0.5,0.4v1.3c1.2-1.1,2.4-1.6,3.4-1.6c0.6,0,1.2,0.1,1.8,0.4
			c0.1,0.1,0.2,0.2,0.2,0.4v0c0,0.3-0.2,0.4-0.4,0.4c-0.6-0.2-1.1-0.3-1.4-0.3h-0.2c-1.4,0-2.5,0.7-3.1,2.2c-0.1,0.4-0.2,0.8-0.2,1.3
			v4c0,0.2-0.1,0.3-0.4,0.4h0c-0.2,0-0.4-0.2-0.4-0.5v-7.9C53.4,192.4,53.5,192.3,53.8,192.3z"/>
		<path class="st2" d="M66.4,192.3c1.7,0,3,0.8,4,2.5c0.3,0.7,0.4,1.3,0.4,2.1v3.9c0,0.2-0.1,0.3-0.4,0.4h0c-0.2,0-0.3-0.1-0.4-0.3v0
			l0-0.8v-0.6c-1.2,1.1-2.4,1.7-3.4,1.7h-0.3c-1.5,0-2.7-0.8-3.7-2.3c-0.4-0.7-0.5-1.4-0.5-2.2c0-1.6,0.8-2.9,2.4-3.9
			C65.1,192.5,65.7,192.3,66.4,192.3z M62.8,196.7L62.8,196.7c0,1.5,0.7,2.6,2.2,3.4c0.5,0.2,0.9,0.3,1.2,0.3h0.3
			c1.2,0,2.2-0.6,3-1.8c0.3-0.6,0.4-1.1,0.4-1.6v-0.1c0-1.4-0.7-2.5-2-3.2c-0.5-0.2-1-0.3-1.5-0.3h0c-1.5,0-2.6,0.8-3.3,2.3
			C62.9,195.9,62.8,196.3,62.8,196.7z"/>
		<path class="st2" d="M78.5,192.4c1.5,0,2.6,0.7,3.4,2l0,0.2v0c0,0.2-0.2,0.4-0.5,0.4c-0.2,0-0.4-0.2-0.7-0.7c-0.7-0.7-1.4-1-2.3-1
			c-1.1,0-2,0.5-2.7,1.6l0,0.2c0,0.4,0.4,0.7,1.2,0.8c2.6,0.6,3.9,1,4.2,1c0.6,0.4,0.8,0.8,0.8,1.4v0c0,0.8-0.6,1.6-1.9,2.4
			c-0.6,0.2-1.1,0.4-1.8,0.4c-1.3,0-2.4-0.6-3.3-1.8c-0.1-0.1-0.1-0.2-0.1-0.2v-0.2c0-0.2,0.2-0.3,0.5-0.3c0.1,0,0.4,0.3,0.7,0.8
			c0.7,0.6,1.4,0.9,2.2,0.9c1,0,1.9-0.5,2.6-1.5l0.1-0.3v-0.1c0-0.4-0.3-0.7-0.8-0.7c-3-0.7-4.5-1.1-4.7-1.2
			c-0.5-0.4-0.8-0.8-0.8-1.4c0-0.8,0.6-1.5,1.7-2.2C77.2,192.6,77.9,192.4,78.5,192.4z"/>
		<path class="st2" d="M86,188.6h0.1c0.3,0.1,0.4,0.2,0.4,0.3v4.7c1.1-0.9,2.1-1.4,3-1.4c1.4,0,2.6,0.7,3.5,2
			c0.3,0.6,0.5,1.2,0.5,1.7v4.8c0,0.2-0.1,0.3-0.4,0.4h0c-0.2,0-0.4-0.1-0.4-0.4v-4.6c0-1.3-0.7-2.3-2.1-2.9c-0.3-0.1-0.7-0.1-1-0.1
			c-1.4,0-2.3,0.7-2.9,2.2c-0.1,0.3-0.1,0.8-0.1,1.5v3.9c0,0.2-0.1,0.3-0.4,0.4h0c-0.2,0-0.4-0.1-0.4-0.4v-11.7
			C85.7,188.8,85.8,188.6,86,188.6z"/>
		<path class="st2" d="M97.6,192.3c0.3,0.1,0.5,0.2,0.5,0.4v8.1c0,0.2-0.1,0.3-0.4,0.4h0c-0.2,0-0.4-0.2-0.4-0.5v-7.9
			C97.2,192.5,97.4,192.3,97.6,192.3z M97.6,189.9c0.3,0.1,0.5,0.2,0.5,0.4v0.2c0,0.2-0.2,0.3-0.5,0.4c-0.2,0-0.3-0.2-0.4-0.5
			C97.3,190.1,97.4,189.9,97.6,189.9z"/>
		<path class="st2" d="M103.7,188.7h0.1c0.3,0.1,0.4,0.2,0.4,0.3v11.3h0.9c0.2,0,0.3,0.2,0.4,0.5v0c0,0.3-0.2,0.4-0.4,0.4h-1.3
			c-0.2,0-0.4-0.2-0.4-0.5v-11.5C103.4,188.8,103.5,188.7,103.7,188.7z"/>
		<path class="st2" d="M113.3,192.4c1.1,0,2.2,0.4,3.1,1.3c0.9,0.9,1.3,2,1.3,3.1c0,1.6-0.8,2.9-2.3,3.9c-0.7,0.3-1.3,0.5-1.9,0.5
			h-0.3c-1.2,0-2.3-0.6-3.3-1.7c-0.6-0.9-0.9-1.8-0.9-2.7c0-1.4,0.6-2.6,1.9-3.6C111.6,192.6,112.4,192.4,113.3,192.4z M109.8,196.7
			v0.2c0,1.3,0.6,2.3,1.9,3.1c0.5,0.2,1,0.4,1.5,0.4h0.2c1.4,0,2.4-0.7,3.1-2.1c0.2-0.4,0.3-0.9,0.3-1.3v-0.2c0-1.1-0.5-2-1.5-2.8
			c-0.6-0.4-1.3-0.6-2-0.6c-1.5,0-2.6,0.8-3.3,2.3C109.9,196,109.8,196.3,109.8,196.7z"/>
		<path class="st2" d="M120.6,192.3L120.6,192.3c0.3,0,0.5,0.3,0.8,1l3.1,6.4c2.2-4.8,3.4-7.2,3.5-7.3c0.1-0.1,0.2-0.1,0.3-0.1
			c0.3,0.1,0.5,0.2,0.5,0.4v0c0,0.1-0.5,1.1-1.5,3.2l-2.5,5.1c-0.1,0.1-0.2,0.1-0.3,0.1h0c-0.3,0-0.5-0.4-0.8-1.2
			c-2.2-4.5-3.3-6.9-3.5-7.2v-0.1C120.2,192.4,120.4,192.3,120.6,192.3z"/>
		<path class="st2" d="M135.6,192.3c1.7,0,3,0.8,4,2.4c0.3,0.6,0.5,1.3,0.5,2.1v0.2c-0.1,0.3-0.2,0.5-0.4,0.5h-7.5
			c0.3,1.2,1,2,1.9,2.5c0.5,0.2,1.1,0.3,1.6,0.3c0.6,0,1.2-0.2,1.9-0.5h0.1c0.3,0.1,0.4,0.2,0.4,0.4v0.1c0,0.4-0.7,0.7-2.2,0.9h-0.2
			c-1.6,0-2.9-0.7-3.8-2.2c-0.4-0.7-0.6-1.4-0.6-2.2c0-1.6,0.8-2.9,2.3-3.9C134.3,192.5,135,192.3,135.6,192.3z M132.1,196.6h7
			c0-0.7-0.3-1.4-0.9-2.2c-0.8-0.8-1.6-1.1-2.4-1.1h-0.4c-1.2,0-2.1,0.6-2.9,1.7C132.4,195.4,132.2,195.9,132.1,196.6z"/>
	</g>
	<g>
		<path class="st2" d="M242.7,27.1c-1.4,0-3-0.5-5.3-1.7c0.1-3.5,1.5-5.7,2.8-7c1.8-1.9,4.4-3,7-3c2,0,3.9,0.7,5.5,1.9
			C248.1,24.7,245.6,27.1,242.7,27.1z"/>
		<path class="st2" d="M269.7,33.6c1-0.9,1.8-2.1,2.3-3.9c0.1-0.2,0.1-0.4,0.2-0.7c0.3,0.5,0.7,0.9,1.1,1.4c0.7,0.8,1.7,1.3,2.7,1.7
			L269.7,33.6z M270.2,22.2c-1.1-1.2-2.7-2.4-4.8-3.8l6.8-1.3C271.1,18.8,270.4,20.5,270.2,22.2z"/>
		<path class="st2" d="M284.7,17.3c-0.2,0-0.3,0-0.3,0c-1.9-0.9-3.8-2.1-5.7-3.5c-0.4-0.3-0.7-0.5-1.1-0.8c1.5-1.3,3-2,4.5-2
			c2.1,0,3.6,1.5,4.4,2.8c0.5,0.7,0.7,2.3,0.5,2.7C286.7,16.8,285.6,17.3,284.7,17.3z"/>
		<path class="st2" d="M246.9,31.5c2.8-2.2,6.6-3.7,9.9-3.7c1,0,1.8,0.1,2.6,0.4L246.9,31.5z"/>
		<path class="st2" d="M248.2,36.6c2.8-3.6,7.3-5.7,11.7-7.2c-0.2,0.4-0.4,0.7-0.6,0.8c-3.4,2-6.8,4-10.1,5.8L248.2,36.6z"/>
	</g>
	</svg>
</div>
<div id="page" class="site">
<header id="masthead" class="site-header" id="site-header-second">
<div class="wrap flexbox">
<div class="site-branding">
	<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/header_logo-1.svg" alt="アザラブ アザラーのためのアザラシ総合情報サイト"></a></p></div>
	<button class="drawer-toggle" aria-expanded="false" aria-controls="site-drawer" aria-label="メニューを開く">
		<span></span>
		<span></span>
		<span></span>
	</button>
<nav id="site-drawer" class="drawer-nav" aria-label="ヘッダーグローバルナビゲーション">
		<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'menu_class' => 'flexbox',

				)
			);
		?>
		<p class="btn btn_donation"><a class="prun" href="<?php echo esc_url( home_url('/') ); ?>donation">あざらしを支援する<img src="<?php echo esc_url( home_url('/') ); ?>wp-content/uploads/btn_azarashi01.svg" alt="あざらしへの寄付リンク"></a></p>
	</nav>
<div class="drawer-overlay"></div>
</div>
<a class="skip-link" href="#primary">メインコンテンツへスキップ</a>
<script>
document.addEventListener('DOMContentLoaded', function () {
	const toggle = document.querySelector('.drawer-toggle');
	const drawer = document.querySelector('#site-drawer');
	const overlay = document.querySelector('.drawer-overlay');
	if (!toggle || !drawer || !overlay) return;
	function openDrawer() {
		document.body.classList.add('drawer-open');
		toggle.setAttribute('aria-expanded', 'true');
		toggle.setAttribute('aria-label', 'メニューを閉じる');
	}
	function closeDrawer() {
		document.body.classList.remove('drawer-open');
		toggle.setAttribute('aria-expanded', 'false');
		toggle.setAttribute('aria-label', 'メニューを開く');
	}
	function toggleDrawer() {
		if (document.body.classList.contains('drawer-open')) {
			closeDrawer();
		} else {
			openDrawer();
		}
	}
	toggle.addEventListener('click', toggleDrawer);
	overlay.addEventListener('click', closeDrawer);
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			closeDrawer();
		}
	});
	window.addEventListener('resize', function () {
		if (window.innerWidth > 1024) {
			closeDrawer();
		}
	});
});
</script>
</header>