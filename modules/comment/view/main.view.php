<?php
/**
 * Affichage principale pour les commentaires.
 *
 * @package TheEPI
 * @author Evarisk <dev@evarisk.com>
 * @copyright 2015-2017 Evarisk
 * @since 0.7.0
 * @version 0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="comment-container">
	<?php
	\eoxia\View_Util::exec( 'theepi', 'comment', 'list', array(
		'id' => $id,
		'add_button' => $add_button,
		'comment_new' => $comment_new,
		'comments' => $comments,
		'display' => $display,
		'type' => $type,
		'namespace' => $namespace,
		'display_date' => $display_date,
		'display_user' => $display_user,
	) );
	?>

	<?php
	if ( 'edit' === $display ) :
		\eoxia\View_Util::exec( 'theepi', 'comment', 'item-edit', array(
			'id' => $id,
			'add_button' => $add_button,
			'comment' => $comment_new,
			'type' => $type,
			'namespace' => $namespace,
			'display' => $display,
			'display_date' => $display_date,
			'display_user' => $display_user,
		) );
	endif;
	?>
</ul>
