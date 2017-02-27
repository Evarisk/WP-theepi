<?php
/**
 * Ajout le champ pour ajouter un commentaire
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0.0
 * @version 0.1.0.0
 * @copyright 2017 Evarisk
 * @package epi
 * @subpackage view
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul class="comment-container">
	<li class="<?php echo esc_attr( ( 0 !== $epi->id && 0 === $comment->id ) ? 'new' : '' ); ?> comment">
		<!-- Les champs obligatoires pour le formulaire -->
		<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][post_id]" value="<?php echo esc_attr( $epi->id ); ?>" />
		<input type="hidden" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][id]" value="<?php echo esc_attr( $comment->id ); ?>" />

		<span class="user"><?php echo esc_html( $userdata->display_name ); ?>, </span>
		<input type="text" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][date]" class="date" placeholder="04/01/2017" value="<?php echo esc_html( $comment->date ); ?>" />
		<textarea rows="1" name="list_comment[<?php echo esc_attr( $comment->id ); ?>][content]" placeholder="Entrer un commentaire"><?php echo esc_html( $comment->content ); ?></textarea>
		<select name="list_comment[<?php echo esc_attr( $comment->id ); ?>][state]">
			<option>OK</option>
			<option>KO</option>
		</select>
	</li>
</ul>
