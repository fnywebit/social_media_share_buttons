<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$retrieved_nonce = $_POST['_ajax_nonce'];
if (!wp_verify_nonce($retrieved_nonce, 'fny-delete-action' ) ) {
	die( 'Failed security check' );
}

$id = (int)$_POST['id'];

if ($id) {
	require_once(FNY_CORE_PATH.'FNYSocialButtons.php');

	$fnySocialButtons = new FNYSocialButtons();
	$res = $fnySocialButtons->fnyDeleteSocialButtonById($id);

	if ($res != false) {
		die("success");
	}

	die("error");
}
