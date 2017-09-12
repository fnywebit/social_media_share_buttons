<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$retrieved_nonce = $_POST['_ajax_nonce'];
if (!wp_verify_nonce($retrieved_nonce, 'fny-create-action' ) ) {
	die( 'Failed security check' );
}

require_once(FNY_CORE_PATH.'FNYSocialButtons.php');

$options = array(
	'size'            => isset( $_POST['size'] ) ? (int)$_POST['size'] : 18,
	'float'            => isset( $_POST['float'] ) ? $_POST['float'] : '11',
	'socail_buttons'  => isset( $_POST['socailButtons'] ) ? array_map( 'sanitize_text_field', $_POST['socailButtons'] ): array(),
	'theme' 		  => isset( $_POST['theme'] ) ? (int) $_POST['theme']: 1,
	'customSize'      => ''
);

$id = '';
$title = '';
if (isset($_POST['id'])) {
	$id = (int)$_POST['id'];
}

if (isset($_POST['title'])) {
	$title = sanitize_text_field($_POST['title']);
}

$fnySocialButtons = new FNYSocialButtons();
$fnySocialButtons->fnySetOptions($options);
$fnySocialButtons->fnySaveSocialButtons($id, $title);
