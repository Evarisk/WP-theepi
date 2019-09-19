<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @since     0.1.0
 * @version   0.7.0
 * @copyright 2019 Evarisk
 * @package   TheEPI
 */

namespace theepi;

if (! defined('ABSPATH') ) {
    exit;
} ?>

<div class="wrap wpeo-wrap wrap-theepi">

    <h1 style="margin-bottom : 20px">
    <?php esc_html_e('List of PPE', 'theepi'); ?>
	<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'create_theepi' ) ) ): ?>
        <div class="wpeo-button button-blue button-radius-3 action-request-edit-epi" style="margin-left : 15px"
			data-message = "<?php esc_html_e( 'Do you want to exit edit mode', 'theepi' ); ?>"
            data-action="create_epi"
            data-nonce="<?php echo esc_attr(wp_create_nonce('create_epi')); ?>">
            <span><?php esc_html_e('New', 'theepi'); ?></span>
        </div>

        <div class="wpeo-button button-blue button-radius-3 create-mass-epi action-attribute" style="margin-left : 10px"
            data-action="create_mass_epi"
            data-nonce="<?php echo esc_attr(wp_create_nonce('create_mass_epi')); ?>">
            <span><?php esc_html_e('New from images', 'theepi'); ?></span>
        </div>
	<?php endif; ?>
    </h1>

    <div class="container-content">
    <?php EPI_Class::g()->display();?>
    </div>
</div>
