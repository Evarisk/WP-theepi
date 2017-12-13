<?php
/**
 * Ajout le champ status "OK/KO".
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.2.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
$author_id = ! empty( $comment->author_id ) ? $comment->author_id : get_current_user_id();
$userdata  = get_userdata( $author_id );
?>

<li class="comment">
	<span class="date"><?php echo esc_html( $comment->date['date_input']['fr_FR']['date'] ); ?>,</span>
	<span class="user"><?php echo esc_html( ! empty( $userdata->display_name ) ? $userdata->display_name : __( 'No user', 'theepi' ) ); ?>: </span>
	<span class="content"><?php echo esc_html( empty( $comment->content ) ? __( 'No comment', 'theepi' ) : $comment->content ); ?></span>
	<span class="right state"><?php echo esc_html( $comment->state ); ?></span>
	<span></span>
</li>
