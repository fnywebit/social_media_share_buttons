<?php

/**
*
*/
class FNYSocialButtons
{
	private $options;
	private $id;

	public function fnySetOptions($options)
	{
		$this->options = $options;
	}

	public function fnySaveSocialButtons($id, $title)
	{
		global $wpdb;

		$options = sanitize_text_field(json_encode($this->options));
		$id = (int)$id;
		$title = sanitize_text_field($title);


		if(!$id) {

			$sql = $wpdb->prepare( "INSERT INTO ". $wpdb->prefix. FNY_SHAREBUTTON_TABLE_NAME . " (title, options)
		 		VALUES (%s, %s)", $title, $options);
				$res = $wpdb->query($sql);

			if ($res) {
				$this->id = (int)$wpdb->insert_id;
			}

			return $res;
		}
		else {
			$sql = $wpdb->prepare("UPDATE ". $wpdb->prefix .FNY_SHAREBUTTON_TABLE_NAME." SET title=%s,options=%s WHERE id=%d", $title, $options, $id);
			$res = $wpdb->query($sql);
			if(!$wpdb->show_errors()) {
				$res = 1;
			}
			return $res;
		}
	}

	public static function fnyGetAllSocialButtons()
	{
		global $wpdb;

		$query = "SELECT * FROM ". $wpdb->prefix . FNY_SHAREBUTTON_TABLE_NAME;
		$buttons = $wpdb->get_results($query, ARRAY_A);

		return $buttons;
	}

	public static function fnyGetSocialButtonsById($id)
	{
		global $wpdb;
		$st = $wpdb->prepare("SELECT * FROM ". $wpdb->prefix . FNY_SHAREBUTTON_TABLE_NAME ." WHERE id = %d", (int)$id);
		$socialButtons = $wpdb->get_row($st, ARRAY_A);

		if(!$socialButtons) {
			return false;
		}

		return self::parseOptions($socialButtons);
	}

	public function fnyDeleteSocialButtonById($id)
	{
		global $wpdb;
		$res = $wpdb->query(
			$wpdb->prepare("DELETE FROM ". $wpdb->prefix . FNY_SHAREBUTTON_TABLE_NAME ." WHERE id = %d", (int)$id)
		);

		return $res;
	}

	private static function parseOptions($socialButtons)
	{
		$options = array(
			'title' => '',
			'id' => '',
			'float' => '',
			'buttons' => array(),
			'size' => '',
			'theme' => ''
		);

		if (isset($socialButtons['id'])) {
			$options['id'] = (int)$socialButtons['id'];
		}
		if (isset($socialButtons['title'])) {
			$options['title'] = esc_html($socialButtons['title']);
		}

		if (isset($socialButtons['options'])) {
			$socialButtons = json_decode($socialButtons['options'], true);

			if (isset($socialButtons['size'])) {
				$options['size'] = (int)$socialButtons['size'];
			}
			if (isset($socialButtons['float'])) {
				$options['float'] = $socialButtons['float'];
			}
			if(isset($socialButtons['socail_buttons'])) {
				$options['buttons'] = $socialButtons['socail_buttons'];
			}
			if(isset($socialButtons['theme'])) {
				$options['theme'] = (int)$socialButtons['theme'];
			}
		}

		return $options;
	}
}
