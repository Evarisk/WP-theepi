<?php
/**
 * Ajout le champ pour ajouter un commentaire
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
}

$author_id = ! empty( $comment->author_id ) ? $comment->author_id : get_current_user_id();
$userdata  = get_userdata( $author_id );
?>

<li class="<?php echo esc_attr( ( 0 !== $epi->id && 0 === $comment->id ) ? 'new' : '' ); ?> comment">
	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][post_id]" value="<?php echo esc_attr( $epi->id ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][id]" value="<?php echo esc_attr( $comment->id ); ?>" />

	<span class="user"><?php echo esc_html( $userdata->display_name ); ?>, </span>
	<div class="group-date">
		<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][date]" value="<?php echo esc_html( $comment->date['date_input']['date'] ); ?>">
		<input type="text" class="date" placeholder="04/01/2017" value="<?php echo esc_html( $comment->date['date_input']['fr_FR']['date'] ); ?>">
	</div>

	<textarea rows="1" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][content]"><?php echo esc_html( $comment->content ); ?></textarea>

	<select name="list_comment[<?php echo esc_attr( $comment->id ); ?>][state]">
		<option>OK</option>
		<option>KO</option>
	</select>
</li>
