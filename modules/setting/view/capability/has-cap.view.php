<?php
/**
 * Affiches les rôles qui ont les capacités "manage_digirisk_epi".
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.2.0
 * @copyright 2015-2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $role_subscriber->capabilities['manage_digirisk_epi'] ) ) :
	?>
	<p class="red"><?php esc_html_e( 'La capacité "manage_digirisk_epi" est appliqué sur tous les utilisateurs dont le rôle est abonnés. Vous devez supprimer la capacité "manage_digirisk_epi" sur celui-ci pour pouvoir gérer manuellement ce droit par utilisateur', 'digirisk-epi' ); ?></p>
	<?php
endif;
