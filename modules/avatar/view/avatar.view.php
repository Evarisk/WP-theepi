<?php
/**
 * Affiches l'avatar et l'initiale des utilisateurs.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
if ( ! empty( $users ) ) :
	foreach ( $users as $user ) :
		?>
		<div class="tm-avatar wpeo-tooltip-event" aria-label="<?php echo esc_attr( $user->data['displayname'] ); ?>"  style="width: <?php echo esc_attr( $size ); ?>px; height: <?php echo esc_attr( $size ); ?>px;">
			<img class="avatar avatar-<?php echo esc_attr( $size ); ?>" src="<?php echo esc_url( $user->data['avatar_url'] ); ?> " />
			<div class="wpeo-avatar-initial"><span><?php echo esc_html( $user->data['initial'] ); ?></span></div>
		</div>
		<?php
	endforeach;
endif;
