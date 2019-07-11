<?php
/**
 * La vue déclarant le modal audit.
 *
 * @author Nicolas Domenech <nicolas@eoxia.com>
 * @since 0.5.0
 * @version 0.5.0
 * @copyright 2019 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input type="text" name="title" value="<?php echo esc_attr( $audit->data['title'] ); ?>" />

<div class="wpeo-button button-main button-radius-3 action-attribute"
	data-parent-id="<?php echo esc_attr( $audit->data['id'] ); ?>"
	data-action="create_task_audit"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'create_task_audit' ) ); ?>">
	<span><i class="fas fa-plus "></i></span>
</div>

<div class="wpeo-button button-main button-radius-3 ">
	<span><i class="fas fa-download"></i></span>
</div>

<input type="text" name="github"  value="" />
<span><i class="fab fa-github"></i></span>

<div class="wpeo-button button-main button-radius-3 ">
	<span><i class="fas fa-download"></i></span>
</div>

<span><?php esc_html_e( 'KO', 'theepi' ); ?></span>
<span><i class="button-toggle fas fa-toggle-on"></i></span>
<span><?php esc_html_e( 'OK', 'theepi' ); ?></span>
