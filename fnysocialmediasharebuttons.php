<?php

/*
* Plugin name: Social Media Share Buttons
* Plugin URI: http://fny-webit.com
* Descriptiom: Share Buttons for WordPress is the best choice for WordPress based websites
* Author: FNY Web-IT
* Author URI: http://fny-webit.com
* Version: 1.8
* License: GPL-2.0+
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

define('FNY_SMSB_PLUGIN_VERSION', '1.6');

require_once plugin_dir_path(__FILE__).'public/boot.php';
// activation or install and uninstall hooks
register_activation_hook(__FILE__, "fny_install_share_buttons");
register_uninstall_hook(__FILE__, 'fny_uninstall_share_buttons');
// share buttons install and uninsltall functions
function fny_install_share_buttons()
{
	FNYCore::install();
}

function fny_uninstall_share_buttons()
{
	FNYCore::uninstall();
}
//share buttons menu, which is included submenu
add_action('admin_menu', 'fny_share_buttons_menu');
function fny_share_buttons_menu()
{
	add_menu_page("share buttons", "ShareButtons", "manage_options", "fny_share_buttons_admin", "fny_share_buttons_admin_page", "dashicons-share");
	add_submenu_page("fny_share_buttons_admin", "All Share Buttons", "All Share Buttons", 'manage_options', "fny_share_buttons_admin", "");
	add_submenu_page("fny_share_buttons_admin", "Add New", "Add New", 'manage_options', "fny_create_share_button", "fny_create_share_button");
    add_submenu_page("fny_share_buttons_admin", "Other plugins from developer", "Products", 'manage_options', "fny_smsb_other_products", "fny_smsb_other_products");
}

function fny_smsb_other_products()
{
    wp_enqueue_style('fny-bootstrap-css', plugin_dir_url( __FILE__ ).'public//css/bootstrap.min.css');
    
    require_once(plugin_dir_path( __FILE__ ).'/public/pages/smsbOtherProducts.php');
}

function fny_share_buttons_admin_page()
{
	wp_enqueue_script('fny-all-sharebuttons-js', plugin_dir_url(__FILE__).'public/js/allShareButtons.js', array('jquery'), '1.0.0', true);
	wp_enqueue_style('fny-bootstrap-css', plugin_dir_url( __FILE__ ).'public//css/bootstrap.min.css');
    require_once(plugin_dir_path( __FILE__ ).'/public/pages/allShowButtons.php');
}

function fny_create_share_button()
{
    wp_enqueue_style('fny-sharebuttons-css', plugin_dir_url( __FILE__ ).'public/css/sharebuttons.css');
	wp_enqueue_style('fny-bootstrap-social-css', plugin_dir_url( __FILE__ ).'public/bootstrap/bootstrap-social.css');
	wp_enqueue_style('fny-bootstrap-css', plugin_dir_url( __FILE__ ).'public//css/bootstrap.min.css');
	wp_enqueue_style('fny-font-awesome-css', plugin_dir_url( __FILE__ ).'public/fonts/fonts-awesome/css/font-awesome.css');

	wp_enqueue_script('fny-addNewSahreButtons-js', plugin_dir_url( __FILE__ ).'public/js/addNewShareButtons.js', array( 'jquery' ), '1.0.0', true );

	$imagesUrl = array(
		'images_ulr'  => FNY_IMAGES_URL
	);
	wp_localize_script('fny-addNewSahreButtons-js', 'sharebuttons_obj', $imagesUrl);

	require_once(plugin_dir_path( __FILE__ ).'/public/pages/addNewSocialButtons.php');
}

function fny_smsb_general_admin_notice(){
	if (isset($_GET['page'])) {
	    $page = $_GET['page'];
	    
	    if ( $page == 'fny_share_buttons_admin') {
	        echo '<div class="notice notice-success is-dismissible"><h3>Hey, I noticed you just use Social Media Share Buttons by FNY Web-IT – that’s awesome! Thank You!</h3><p><strong>Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.</strong></p><div><a class="btn btn-primary" href="https://wordpress.org/support/plugin/fny-social-media-share-buttons/reviews/#new-post" target="_blank" role="button">Rate Now!</a></div></div>';
	        
        }
        
         if ( $page == 'fny_create_share_button') {
	        echo '<div class="notice notice-success is-dismissible" style="background-color:#23282d; color:white;"><h3>Hey, I noticed you just use Social Media Share Buttons by FNY Web-IT – that’s awesome! Thank You!</h3><p><strong>Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.</strong></p><div><a class="btn btn-danger" href="https://wordpress.org/support/plugin/fny-social-media-share-buttons/reviews/#new-post" target="_blank" role="button">Rate Now!</a></div></div>';
	        
        }
	    
	}
}
add_action('admin_notices', 'fny_smsb_general_admin_notice');

//save section
add_action('wp_ajax_save_share_button_options', 'fny_save_share_button_options');
function fny_save_share_button_options()
{
	$retrieved_nonce = $_POST['_ajax_nonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'fny-create-action' ) ) {
		die( 'Failed security check' );
	}

	require_once(FNY_AJAX_PATH.'saveSocialButtons.php');
}

add_action('wp_ajax_delete_share_buttons', 'fny_delete_share_button');
function fny_delete_share_button()
{
	$retrieved_nonce = $_POST['_ajax_nonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'fny-delete-action' ) ) {
		die( 'Failed security check' );
	}

	require_once(FNY_AJAX_PATH.'deleteSocialButtons.php');
}

add_shortcode('fny', 'fny_sharebuttons_shortcode_handler');
function fny_sharebuttons_shortcode_handler($params)
{
	$id = (int)$params['id'];
	require_once(FNY_CORE_PATH.'FNYSocialButtons.php');

	wp_enqueue_style('fny-shortcode.css', plugin_dir_url( __FILE__ ).'public/css/shortcode.css');
	wp_enqueue_script('fny-social-button-shortcode-js', plugin_dir_url( __FILE__ ).'public/js/FnySocialButtonShortcode.js', array( 'jquery' ), '1.0.0', true );

	$socialButtonsParams = FNYSocialButtons::fnyGetSocialButtonsById($id);

	$fny_url='';
//APIs for sharing to facebook, twitter, google (google-plus), linkedin and vk (vkontakte). 
	$htmlContent = '<p id=fny_share class="fny_'.$socialButtonsParams['float'].'">';
	foreach ( $socialButtonsParams['buttons'] as $fny_soc_button) {
		switch ($fny_soc_button) {
			case "facebook":
				$fny_url = 'https://www.facebook.com/sharer.php?u=' . fny_curPageURL();
				break;
			case "twitter":
				$fny_url = 'https://twitter.com/intent/tweet?url=' . fny_curPageURL();
				break;
			case "google":
				$fny_url = 'https://plus.google.com/share?url=' .  fny_curPageURL();
				break;
			case "linkedin";
				$fny_url = 'https://www.linkedin.com/shareArticle?url=' .  fny_curPageURL();
				break;
			case "vk";
				$fny_url = 'http://vk.com/share.php?url=' . fny_curPageURL();
				break;               
            default:
				echo "No social button chusen!!!";
		}
		$fny_soc_button = esc_html($fny_soc_button);
//section for settings | size and theme for sharing buttons
		$htmlContent.="<img class=fny_img_pointer onclick=fny_shortcode_content('".$fny_url."') style='width:".(int)$socialButtonsParams['size']."px' src='".FNY_IMAGES_URL."logo/theme".(int)$socialButtonsParams['theme']."/".$fny_soc_button.".svg"."'></img>";
	}

	$htmlContent.='</p>';
	
	return $htmlContent;
}
//checking http and https to have correct link for all web sites 
function fny_curPageURL() {
    
    $fny_pageURL = 'http';
    if (isset($_SERVER["HTTPS"])) {$fny_pageURL.="s";}
    $fny_pageURL.="://";
    if ($_SERVER["SERVER_PORT"]!="80") {
        $fny_pageURL.=$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
                
    } else {
        $fny_pageURL.=$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $fny_pageURL;
}

