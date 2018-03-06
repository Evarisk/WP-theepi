<?php
/**
 * Ajout le champ pour ajouter un commentaire
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 0.1.0
 * @version 0.4.0
 * @copyright 2018 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$author_id = ! empty( $comment->data['author_id'] ) ? $comment->data['author_id'] : get_current_user_id();
$userdata  = get_userdata( $author_id );
?>

<li class="<?php echo esc_attr( ( 0 !== $epi->data['id'] && 0 === $comment->data['id'] ) ? 'new' : '' ); ?> comment">
	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][post_id]" value="<?php echo esc_attr( $epi->data['id'] ); ?>" />
	<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][id]" value="<?php echo esc_attr( $comment->data['id'] ); ?>" />

	<span class="user"><?php echo esc_html( $userdata->display_name ); ?>, </span>

	<div class="group-date">
		<input type="hidden" class="mysql-date" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][date]" value="<?php echo esc_html( $comment->data['date']['raw'] ); ?>">
		<input type="text" class="date" placeholder="04/01/2017" value="<?php echo esc_html( $comment->data['date']['rendered']['date'] ); ?>">
	</div>

	<textarea rows="1" name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][content]"><?php echo esc_html( $comment->data['content'] ); ?></textarea>

	<select name="list_comment[<?php echo esc_attr( $comment->data['id'] ); ?>][state]">
		<option>OK</option>
		<option>KO</option>
	</select>
</li>
