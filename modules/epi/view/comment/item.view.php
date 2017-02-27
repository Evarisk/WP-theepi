<?php
/**
 * Ajout le champ status "OK/KO".
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0.0.0
 * @version 1.0.0.0
 * @copyright 2017 Evarisk
 * @package epi
 * @subpackage view
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
$author_id = ! empty( $comment->author_id ) ? $comment->author_id : get_current_user_id();
$userdata = get_userdata( $author_id );
?>

<li class="comment">
	<span class="user"><?php echo ! empty( $userdata->display_name ) ? $userdata->display_name : 'Indéfini'; ?>, </span>
	<span class="date"><?php echo $comment->date; ?> : </span>
	<span class="content"><?php echo $comment->content; ?></span>
	<span></span>
</li>
