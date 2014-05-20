<?php
/*

Plugin Name: Promo Slider
Description: Promo Slider adds a button on right or left of the page that slides out to reveal a promo when you click on it! It is a vertical element that shows on the left or right hand side of your site!
Version: 1.1
Author: Catapult Impact
Pagelines: true

*/

class PageLinesPromoSlider{
	function __construct() {
		$this->base_url = sprintf( '%s/%s', WP_PLUGIN_URL,  basename(dirname( __FILE__ )));
		$this->icon = $this->base_url . '/icon.png';
		$this->base_dir = sprintf( '%s/%s', WP_PLUGIN_DIR,  basename(dirname( __FILE__ )));
		$this->base_file = sprintf( '%s/%s/%s', WP_PLUGIN_DIR,  basename(dirname( __FILE__ )), basename( __FILE__ ));
		// register plugin hooks...		
		$this->plugin_hooks();
	}		
	
	function plugin_hooks(){
		// Always run		
		add_action( 'after_setup_theme', array( &$this, 'options' ));		
		add_action( 'wp_enqueue_scripts', array( &$this, 'promo_css' ) );	
		add_action( 'pagelines_page', array( &$this, 'promo_slider' ));
	}
	
	function promo_css() {
		wp_register_style( 'promo-style', plugins_url( 'maincss.css', __FILE__ ) );
		wp_enqueue_style( 'promo-style' );
	}
	
	function promo_slider(){
		$show_promo_slider = pl_setting('show_promoslider');
		if( $show_promo_slider ){
			$slider_buttontitle = pl_setting('promoslider_title');
			$slider_buttonorentation = strtolower(pl_setting('promoslider_orientation'));
			$slider_buttonposition = pl_setting('promoslider_top_position');
			$slider_contentbox = stripslashes(pl_setting('promoslider_content'));
			
			if($slider_buttonorentation == "left"){
				$sliderdivname = "QuickContentSlider-left";
				$buttondivname = "QuickContentSlider-button-left";
				$contentdivname = "QuickContentSlider-content-left";
				$button_position = $slider_buttonposition;
				$sliderbuttonbutton ='
					<script>
						var $j = jQuery.noConflict();
						$j(window).load(function(){
							if($j.browser.msie && $j.browser.version <= 8.0){
								$j(".'.$buttondivname.'").addClass("QuickContentSlider-button-left-ie");
								var content_width = $j(".'.$contentdivname.'").outerWidth(); 
								var button_height = $j(".'.$buttondivname.'").outerHeight();
								var button_inner_height = $j(".'.$buttondivname.'").height();
								var content_height = $j(".'.$contentdivname.'").outerHeight(); 
								var content_inner_height = $j(".'.$contentdivname.'").height(); 
								$j("#'.$sliderdivname.'").css({"left":"-"+content_width+"px","top":"'.$button_position.'"});
								$j("#'.$sliderdivname.'").css("z-index", "1035");
								if(button_height > content_height){
									var button_left = $j(".'.$buttondivname.'").outerHeight();
									$j(".'.$buttondivname.'").css("right","-"+button_left+"px");			
									var paddint_top = parseInt($j(".'.$contentdivname.'").css("padding-top"), 10);
									var paddint_bottom = parseInt($j(".'.$contentdivname.'").css("padding-bottom"), 10);
									var new_content_height = button_height - (paddint_top + paddint_bottom);
									$j(".'.$contentdivname.'").css("height",new_content_height+"px");
								}else{
									var paddint_top = parseInt($j(".'.$buttondivname.'").css("padding-top"), 10);
									var paddint_bottom = parseInt($j(".'.$buttondivname.'").css("padding-bottom"), 10);
									var button_update_height = content_height - (paddint_top + paddint_bottom);
									$j(".'.$buttondivname.'").css("width",button_update_height+"px");
									var button_left = $j(".'.$buttondivname.'").outerHeight();
									$j(".'.$buttondivname.'").css("right","-"+button_left+"px");
								}
							}else{
								var content_width = $j(".'.$contentdivname.'").outerWidth(); 
								var button_height = $j(".'.$buttondivname.'").outerWidth();
								var button_inner_height = $j(".'.$buttondivname.'").width();
								var content_height = $j(".'.$contentdivname.'").outerHeight(); 
								var content_inner_height = $j(".'.$contentdivname.'").height();
								$j("#'.$sliderdivname.'").css({"left":"-"+content_width+"px","top":"'.$button_position.'"});
								$j("#'.$sliderdivname.'").css("z-index", "1035");
								if(button_height > content_height){
									var new_but_top = button_inner_height - 21;
									$j(".'.$buttondivname.'").css("right","0px");
									var paddint_top = parseInt($j(".'.$contentdivname.'").css("padding-top"), 10);
									var paddint_bottom = parseInt($j(".'.$contentdivname.'").css("padding-bottom"), 10);
									var new_content_height = button_height - (paddint_top + paddint_bottom);
									$j(".'.$contentdivname.'").css("height",new_content_height+"px");
									$j(".'.$buttondivname.'").css("top",new_but_top+"px");
								}else{
									var paddint_top = parseInt($j(".'.$buttondivname.'").css("padding-top"), 10);
									var paddint_bottom = parseInt($j(".'.$buttondivname.'").css("padding-bottom"), 10);
									var button_update_height = content_height - (paddint_top + paddint_bottom);
									$j(".'.$buttondivname.'").css("width",button_update_height+"px");
									$j(".'.$buttondivname.'").css("right","0px");
									var new_cont_top = button_update_height - 21;
									$j(".'.$buttondivname.'").css("top",new_cont_top+"px");
								}
							}
							$j(".'.$buttondivname.'").click(function(){
								$j("#'.$sliderdivname.'").animate({"left":"0px"},1000);
							});
							
							$j(".'.$contentdivname.'").hover("",function(){	
								$j("#'.$sliderdivname.'").stop().delay(500).animate({"left":"-"+content_width+"px"},1000);
							});
							$j(".'.$contentdivname.'").css("visibility","visible");
							$j(".'.$buttondivname.'").css("visibility","visible");
						});
					</script>
				';
			}elseif($slider_buttonorentation == "right"){
				$sliderdivname = "QuickContentSlider-right";
				$buttondivname = "QuickContentSlider-button-right";
				$contentdivname = "QuickContentSlider-content-right";
				$button_position = $slider_buttonposition;
				$sliderbuttonbutton ='
					<script>
						var $j = jQuery.noConflict();
						$j(window).load(function(){
							if($j.browser.msie && $j.browser.version <= 8.0){
								$j(".'.$buttondivname.'").addClass("QuickContentSlider-button-right-ie");
								var content_width = $j(".'.$contentdivname.'").outerWidth(); 
								var button_height = $j(".'.$buttondivname.'").outerHeight();
								var button_inner_height = $j(".'.$buttondivname.'").height();
								var content_height = $j(".'.$contentdivname.'").outerHeight(); 
								var content_inner_height = $j(".'.$contentdivname.'").height(); 
								$j("#'.$sliderdivname.'").css({"right":"-"+content_width+"px","top":"'.$button_position.'"});
								$j("#'.$sliderdivname.'").css("z-index", "1035");
								if(button_height > content_height){
									var button_left = $j(".'.$buttondivname.'").outerWidth();
									$j(".'.$buttondivname.'").css("left","-"+button_left+"px");			
									var paddint_top = parseInt($j(".'.$contentdivname.'").css("padding-top"), 10);
									var paddint_bottom = parseInt($j(".'.$contentdivname.'").css("padding-bottom"), 10);
									var new_content_height = button_height - (paddint_top + paddint_bottom);
									$j(".'.$contentdivname.'").css("height",new_content_height+"px");
								}else{
									var button_update_height = content_height - 24;
									$j(".'.$buttondivname.'").css("width",button_update_height+"px");
									var button_left = $j(".'.$buttondivname.'").outerWidth();
									$j(".'.$buttondivname.'").css("left","-"+button_left+"px");
								}
							}else{
								var content_width = $j(".'.$contentdivname.'").outerWidth(); 
								var button_height = $j(".'.$buttondivname.'").outerWidth();
								var button_inner_height = $j(".'.$buttondivname.'").width();
								var content_height = $j(".'.$contentdivname.'").outerHeight(); 
								var content_inner_height = $j(".'.$contentdivname.'").height(); 
								$j("#'.$sliderdivname.'").css({"right":"-"+content_width+"px","top":"'.$button_position.'"});
								$j("#'.$sliderdivname.'").css("z-index", "1035");
								if(button_height > content_height){
									$j(".'.$buttondivname.'").css("left","-"+button_height+"px");			
									var paddint_top = parseInt($j(".'.$contentdivname.'").css("padding-top"), 10);
									var paddint_bottom = parseInt($j(".'.$contentdivname.'").css("padding-bottom"), 10);
									var new_content_height = button_height - (paddint_top + paddint_bottom);
									$j(".'.$contentdivname.'").css("height",new_content_height+"px");
								}else{
									var button_update_height = content_height - 24;
									$j(".'.$buttondivname.'").css("width",button_update_height+"px");
									$j(".'.$buttondivname.'").css("left","-"+content_height+"px");
								}
							}
							
							$j(".'.$buttondivname.'").click(function(){
								$j("#'.$sliderdivname.'").animate({right:0},1000);
							});
							
							$j(".'.$contentdivname.'").hover("",function(){	
								$j("#'.$sliderdivname.'").stop().animate({right:-content_width},1000);
							});
							$j(".'.$contentdivname.'").css("visibility","visible");
							$j(".'.$buttondivname.'").css("visibility","visible");
						});
					</script>
				';
			}
			$sliderbuttonbutton .= '<div id="'.$sliderdivname.'">
										<div class="'.$buttondivname.'">'.$slider_buttontitle.'</div>
										<div class="'.$contentdivname.'">'.wpautop(do_shortcode("$slider_contentbox")).'</div>
									</div>';
			echo $sliderbuttonbutton;
		}
	}
	
	function options(){
		
		if( !function_exists('pl_setting') )			
			return;		
			
		$options = array();
		$options[] = array(
			'key'		=> 'promoslider_show_settings',
			'type'		=> 'multi',			
			'title'		=> __('PromoSlider Main Options', 'pagelines'),			
			'col'		=> 1,			
			'opts'	=> array(
				array(
					'key'	=> 'show_promoslider',					
					'type' 	=> 'check',					
					'label' => 'Activate the PromoSlider globally?',					
					'help'	=> 'This option will activate the PromoSlider globally.'
				),
				array(
					'key'	=> 'promoslider_orientation',
					'type' 	=> 'select',
					'label' => 'Select Slider Orientation',
					'opts'	=> array(
						'right'	=> array('name'	=>'Right (Default)'),
						'left'			=> array('name'	=>'Left'),
					),
				),
				array(
					'key'	  => 'promoslider_top_position',
					'type'    => 'text',
					'label'	  => 'PromoSlider top position.'
				),
			),
		);
		
		$options[] = array(
			'key'		=> 'promoslider_setup',
			'type'		=> 'multi',
			'col'		=> 2,
			'title'		=> 'PromoSlider Title',
			'opts'	=> array(

				 array(
					'key'			=> 'promoslider_title',
					'type' 			=> 'text',
					'label'	=> 'PromoSlider Title'
				),
				array(
					'key'			=> 'promoslider_content',
					'type' 			=> 'textarea',
					'label' 	=> 'PromoSlider Content'
				),
			),
		);
		
		$option_args = array(
			'name'		=> 'PromoSlider',			
			'opts'		=> $options,			
			'icon'		=> 'icon-tag',			
			'pos'		=> 12		
		);
		
		pl_add_options_page( $option_args );
	}
	
}

new PageLinesPromoSlider;
?>