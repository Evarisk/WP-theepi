<?php
/**
 * Classe gérant les commentaires des EPI
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0.0
 * @version 0.1.0.0
 * @copyright 2015-2017 Evarisk
 * @package EPI
 * @subpackage class
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant les commentaires des EPI
 */
class EPI_Comment_Class extends Comment_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   = '\evarisk_epi\EPI_Comment_Model';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key     = '_wpdigi_epi_comment';

	/**
	 * Le type
	 *
	 * @var string
	 */
	protected $comment_type	= 'digi-epicomment';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base					= 'digirisk/epi-comment';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version			= '0.1';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\convert_date', '\evarisk_epi\update_control_date' );

	/**
	 * La fonction appelée automatiquement avant la sauvegarde de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\convert_date', '\evarisk_epi\update_control_date' );

	/**
	 * Le constructeur
	 *
	 * @return void
	 *
	 * @since 0.1.0.0
	 * @version 0.1.0.0
	 */
	protected function construct() {}

	public function display( $epi ) {
		View_Util::exec( 'epi', 'comment/list', array(
			'epi' => $epi,
			'comments' => $comments,
			'comment_schema' => $comment_schema,
			'userdata' => $userdata,
		) );
	}

	/**
	 * Affiches la vue pour éditer un commentaires
	 *
	 * @param  EPI_Model $epi Les données de l'EPI.
	 *
	 * @return void
	 *
	 * @since 0.1.0.0
	 * @version 0.1.0.0
	 */
	public function display_edit( $epi ) {
		$comments = EPI_Comment_Class::g()->get( array(
			'post_id' => $epi->id,
			'status' => -34070,
		) );

		$comment_schema = EPI_Comment_Class::g()->get( array(
			'schema' => true,
		) );

		$comment_schema = $comment_schema[0];

		$userdata = get_userdata( get_current_user_id() );

		View_Util::exec( 'epi', 'comment/list', array(
			'epi' => $epi,
			'comments' => $comments,
			'comment_schema' => $comment_schema,
			'userdata' => $userdata,
		) );
	}

	/**
	 * Sauvegardes les commentaires de l'EPI.
	 *
	 * @param  integer $epi_id L'ID de l'EPI.
	 * @param  arrya   $data   Les données des commentaires.
	 *
	 * @return boolean
	 *
	 * @since 0.1.0.0
	 * @version 0.1.0.0
	 */
	public function save_comments( $epi_id, $data ) {
		if ( isset( $epi_id ) ) {
			if ( ! empty( $data ) ) {
				foreach ( $data as $comment ) {
					if ( ! empty( $comment['content'] ) ) {
						$comment['post_id'] = $epi_id;
						EPI_Comment_Class::g()->update( $comment );
					}
				}
			}
		}

		return true;
	}
}

EPI_Comment_Class::g();
