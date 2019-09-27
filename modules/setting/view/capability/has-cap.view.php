<?php
/**
 * Affiches les rôles qui ont les capacités "manage_theepi".
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com>
 * @copyright 2015-2017 Evarisk
 * @since     0.2.0
 * @version   0.2.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $role_subscriber->capabilities['read_theepi'] ) ) :
	?>
	<p class="red"><?php esc_html_e( 'The "manage_theepi" capability is applied to all users whose role is subscribed. You must delete the "manage_theepi" ability on this one to manually manage this right per user', 'theepi' ); ?></p>
	<?php
endif;
