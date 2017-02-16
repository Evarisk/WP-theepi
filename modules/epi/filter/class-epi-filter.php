<?php
/**
 * Gestion des filtres relatifs aux EPI
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.0.1.0
 * @version 0.0.1.0
 * @copyright 2015-2017 Evarisk
 * @package EPI
 * @subpackage filter
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion des filtres relatifs aux EPI
 */
class EPI_Filter {

	/**
	 * Utilises le filtre digi_comment_end
	 *
	 * @since 0.0.1.0
	 * @version 0.0.1.0
	 */
	public function __construct() {
		add_filter( 'digi_comment_edit_end', array( $this, 'callback_digi_comment_edit_end' ) );
		add_filter( 'digi_comment_view_end', array( $this, 'callback_digi_comment_view_end' ) );
	}

	/**
	 * Appelle la vue status qui permet d'ajouter le champ select dans les commentaires.
	 *
	 * @param  EPI_Comment_Model $comment Les données du commentaire.
	 * @return void
	 *
	 * @since 0.0.1.0
	 * @version 0.0.1.0
	 */
	public function callback_digi_comment_edit_end( $comment ) {
		View_Util::exec( 'epi', 'edit-status', array(
			'comment' => $comment,
		) );
	}

	/**
	 * Appelle la vue status qui permet de voir le champ select dans les commentaires.
	 *
	 * @param  EPI_Comment_Model $comment Les données du commentaire.
	 * @return void
	 *
	 * @since 0.0.1.0
	 * @version 0.0.1.0
	 */
	public function callback_digi_comment_view_end( $comment ) {
		View_Util::exec( 'epi', 'view-status', array(
			'comment' => $comment,
		) );
	}

}

new EPI_Filter();
