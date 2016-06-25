<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://grit-oyster.co.uk/
 * @since      1.0.0
 *
 * @package    OSS_Sitename
 * @subpackage OSS_Sitename/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap wrap cmb2-options-page <?php echo $key; ?>">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<?php $this->display_tabs($action); ?>
	<?php cmb2_metabox_form( $metabox_id, $key ); ?>
</div>