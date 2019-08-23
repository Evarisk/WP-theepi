<?php
/**
 * Ajout le champ status "OK/KO".
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2018 Evarisk
 * @since     0.1.0
 * @version   0.4.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
$author_id = ! empty( $comment->data['author_id'] ) ? $comment->data['author_id'] : get_current_user_id();
$userdata  = get_userdata( $author_id );
?>

<li class="comment">
	<span class="date"><?php echo esc_html( $comment->data['date']['rendered']['date'] ); ?>,</span>
	<span class="user"><?php echo esc_html( ! empty( $userdata->display_name ) ? $userdata->display_name : __( 'No user', 'theepi' ) ); ?>: </span>
	<span class="content"><?php echo esc_html( empty( $comment->data['content'] ) ? __( 'No comment', 'theepi' ) : $comment->data['content'] ); ?></span>
	<span class="right state"><?php echo esc_html( $comment->data['state'] ); ?></span>
	<span></span>
</li>
