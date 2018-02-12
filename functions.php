<?php

add_action('after_setup_theme', 'theme_setup');
function theme_setup(){

	add_theme_support('title-tag');
	add_theme_support('custom-header',array(
		'default-image' => get_template_directory_uri().'/images/bagoni.png',

	));
	add_theme_support('custom-background');

	add_theme_support('post-thumbnails');

	load_theme_textdomain('basictheme',get_template_directory().'/language');

	register_nav_menu('main-menu',__('Main Menu','basictheme') );

	register_post_type('basic-testimonial',array(
			'labels' => array(
			'name' => 'Testimonials',
			'add_new_item' => 'Add New Testimonial',
			// 'view_item' => 'View Testimonials', 
			'edit_item' => 'Edit Testimonial',

		),
		'public' => true,
		'menu_icon' => 'dashicons-carrot',
		'menu_position' => 4,
		'supports' => array('title','thumbnail'),
	));
}

add_action('wp_enqueue_scripts','basic_theme_style');
function basic_theme_style () {
	wp_enqueue_style('style', get_stylesheet_uri());
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/css/font-awesome.css');
}

add_action('widgets_init', function(){
	register_sidebar(array(
	'name' => 'Right Sidebar',
	'description' => 'Keep Your Right Sidebar Widget Here',
	'id' => 'right-sidebar',
	'before_widget' => '<section class="right-sidebar">',
	'after_widget' => '</section>',
	'before_title' => '<div class="contentTitle">',
	'after_title' => '</div>',

));

});


// add_action('admin_enqueue_scripts','admin_basic_theme_style');
// function admin_basic_theme_style() {
// 	wp_enqueue_style('font-awesome', get_template_directory_uri().'/css/font-awesome.css');
// }

//cmb2 adding

if(file_exists(dirname(__FILE__).'/metabox/init.php')){
	require_once(dirname(__FILE__).'/metabox/init.php');
}


if(file_exists(dirname(__FILE__).'/metabox/custom-metabox.php')){
	require_once(dirname(__FILE__).'/metabox/custom-metabox.php');
}

//class-2 of tbtd
add_shortcode( 'ami', 'output_shortcode' );

function output_shortcode($first,$content){

	$output = shortcode_atts(array(
		"kalar" => 'red',
		"kondika" => '',
		"f_size" => '',
		"margin" => '',
		"text_t" => '',


		),$first);
	extract($output);

	return "<h1 style='text-align:".$kondika."; color:".$kalar."; font-size:".$f_size.";text-transform:".$text_t.";'>".do_shortcode($content)."</h1>";
}

add_shortcode( 'abar', function(){
	return "<h1>Output</h1>";
} );






if (function_exists('kc_add_map')) 
{ 
kc_add_map(array(
	'team' => array(

		'name' =>'TF TEAM',
		'category' => 'TF',
		'icon' => 'fa fa-facebook',
		'params' => array(

			array(
			'name' => 'style',
			'label' => 'Style',
		 
			'type' => 'select',  // USAGE SELECT TYPE
			'options' => array(  // THIS FIELD REQUIRED THE PARAM OPTIONS
				'yes_image' => 'YES Image',
				'no_image' => 'No Image',
			)
		 
			),

			array(
			'name' => 'name',
			'type' => 'text',
			'label' => 'name',
			'value' => 'Your Name Here',
			),

			array(
			'name' => 'des',
			'type' => 'text',
			'label' => 'Designation',
			'value' => 'Desc',
			),

			array(
			'name' => 'cont',
			'type' => 'textarea',
			'label' => 'Content',
			'value' => 'write Some Text',
			),

			array(
			'name' => 'email',
			'type' => 'text',
			'label' => 'Email',
			'value' => '',
			),

			array(
			'name' => 'btn_text',
			'type' => 'text',
			'label' => 'Button text',
			'value' => '',
			),

			array(
			'name' => 'btn_color',
			'type' => 'color_picker',
			'label' => 'Button Color',
			'value' => '#ebebeb',
			),

			array(
			'name' => 'btn_link',
			'type' => 'link',
			'label' => 'Button LInk',
			),

			array(
			'name' => 'image',
			'type' => 'attach_image',
			'label' => 'Member Photo',
			),
		)
	)
));
}


add_shortcode( 'team', 'team_shortcode' );

function team_shortcode($first,$second){
	$output = shortcode_atts(array(
				'name' => '',
				'des' => '',
				'cont' => '',
				'email' => '',
				'btn_text' => '',
				'btn_color' => '',
				'btn_link' => '',
				'image' => '',
				'style' => '',


		),$first);
		extract($output);
		$btn_link = kc_parse_link($btn_link);
		$btn_href = $btn_link['url'];
		$btn_target = $btn_link['target'];
		//print_r($btn_link);
			?>

	
	<?php if ($style == 'yes_image') {?>
	<div class="column">
	    <div class="card">

	    	<?php
	    	$img_src = wp_get_attachment_image_src($image,'medium');
	    	//print_r($img_src);

	    	?>

	      <img src="<?php echo $img_src[0]?>" alt="Jane" style="width:100%">
	      <div class="container">
	        <h2><?php echo $output ['name'];?></h2>
	        <p class="title"><?php echo $des;?></p>
	        <p><?php echo $cont;?></p>
	        <p><?php echo $email;?></p>
	        <p><a target="<?php echo $btn_target;?>" href="<?php echo $btn_href;?>"><button class="button" style="background: <?php echo $btn_color;?>"><?php echo $btn_text?></button></a></p>
	      </div>
	    </div>
	</div>
	<?php } ?>

	<?php if ($style == 'no_image') {?>
	<div class="column">
	    <div class="card">
	      <div class="container">
	        <h2><?php echo $output ['name'];?></h2>
	        <p class="title"><?php echo $des;?></p>
	        <p><?php echo $cont;?></p>
	        <p><?php echo $email;?></p>
	        <p><button class="button" style="background: <?php echo $btn_color;?>"><?php echo $btn_text?></button></p>
	      </div>
	    </div>
	</div>
	<?php } ?>

<?php }



add_filter( 'widget_text', 'do_shortcode' );

add_shortcode( 'testimonial', function (){
?>

<?php ob_start();?>
<div class="contentBox">
  	<div class="innerBox">

	<?php

	$testimonial = new WP_Query(array(
		'post_type' => 'basic-testimonial',
		'post_per_page' => 1,
	));

	?>
	<?php while($testimonial->have_posts()):$testimonial->the_post();?>

	<h2><?php the_title();?></h2>
	<p><?php the_post_thumbnail();?></p>
	<p><?php echo get_post_meta(get_the_id(),'desig',true);?></p>
	<p><?php echo get_post_meta(get_the_id(),'text-box',true);?></p>

	<?php endwhile;?>
	</div>
</div>

<?php return ob_get_clean();?>

<?php });



?>