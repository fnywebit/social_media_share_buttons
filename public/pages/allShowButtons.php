<?php
	if ( ! defined( 'ABSPATH' ) ) {
		die();
	}

	require_once(FNY_CORE_PATH.'FNYSocialButtons.php');
	$allSocialButtons = FNYSocialButtons::fnyGetAllSocialButtons();
	$ajaxNonce = wp_create_nonce('fny-delete-action');
?>

<div class="wrap">
	<div class="headers-wrapper">
		<h1 class="h1-for-headers-wrapper">Social Buttons
			<a href="<?php echo admin_url();?>admin.php?page=fny_create_share_button" class="add-new-h2">Add New</a>
		</h1>
	</div>
	<input id="fny-delete-ajax-nonce" type="" name="fny-delete-ajax-nonce" value="<?php echo $ajaxNonce ?>" hidden>
	<table class="wp-list-table widefat fixed striped wp_s">
		<thead>
			<tr>
				<th scope="col" id="id" class="manage-column column-id column-primary sortable desc">
					<a href="">
						<span>ID</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="title" class="manage-column column-title sortable asc">
					<a href="">
						<span>Title</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="shortcode" class="manage-column column-shortcode">Shortcode</th>
				<th scope="col" id="options" class="manage-column column-options">Options</th>
			</tr>
		</thead>

		<tbody id="the-list">
			<?php if(empty($allSocialButtons)): ?>
				<tr class="no-items"><td class="colspanchange" colspan="4">No items found.</td></tr>
			<?php endif; ?>
			<?php foreach ($allSocialButtons as $button): ?>
				<tr>
					<td><?php echo (int)$button['id'] ?></td>
					<td><?php echo esc_html($button['title']) ?></td>
					<td><?php echo '[fny id="'.(int)$button['id'].'"]' ?></td>
					<td>
						<a href="<?php echo admin_url();?>admin.php?page=fny_create_share_button&id=<?php echo (int)$button['id']?>">Edit</a>
						&nbsp;&nbsp;
						<a href="javascript:void(0);" onclick="FNYShareButtons.deleteSocialButtons(<?php echo (int)$button['id']?>)">Delete</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>

		<tfoot>
			<tr>
				<th scope="col" class="manage-column column-id column-primary sortable desc">
					<a href="">
						<span>ID</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" class="manage-column column-title sortable asc">
					<a href="">
						<span>Title</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" class="manage-column column-shortcode">Shortcode</th>
				<th scope="col" class="manage-column column-options">Options</th>
			</tr>
		</tfoot>
	</table>
