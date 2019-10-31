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

    <h1>
    <?php esc_html_e('List of PPE', 'theepi'); ?>
	<?php if ( ( user_can( get_current_user_id(), 'manage_theepi' ) ) || ( user_can( get_current_user_id(), 'create_theepi' ) ) ): ?>
        <div class="wpeo-button button-blue button-radius-3 button-size-small action-request-edit-epi event-keybord wpeo-tooltip-event"
			aria-label="<?php esc_html_e( 'Shortcut CTRL + ENTER', 'theepi' ); ?>"
			data-message = "<?php esc_html_e( 'Do you want to exit edit mode', 'theepi' ); ?>"
            data-action="create_epi"
            data-nonce="<?php echo esc_attr(wp_create_nonce('create_epi')); ?>">
            <span><?php esc_html_e('New', 'theepi'); ?></span>
        </div>

        <div class="wpeo-button button-blue button-radius-3 button-size-small create-mass-epi action-attribute"
            data-action="create_mass_epi"
            data-nonce="<?php echo esc_attr(wp_create_nonce('create_mass_epi')); ?>">
            <span><?php esc_html_e('New from images', 'theepi'); ?></span>
        </div>

		<!-- <a href="<?php echo esc_attr ( admin_url( 'options-general.php?page=theepi-setting' ) ); ?>">
			<div class="wpeo-button button-blue button-radius-3 button-size-small wpeo-tooltip-event"
				aria-label="<?php esc_html_e ( 'Go to the TheEPI Setting Page', 'theepi' ); ?>">
				<i class="fas fa-cog"></i>
			</div>
		</a> -->
	<?php endif; ?>
    </h1>

    <div class="container-content">
    <?php EPI_Class::g()->display();?>
    </div>
</div>
