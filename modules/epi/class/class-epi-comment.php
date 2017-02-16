<?php
/**
 * Classe gérant les commentaires des EPI
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.0.1.0
 * @version 0.0.1.0
 * @copyright 2015-2017 Evarisk
 * @package EPI
 * @subpackage class
 */
namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

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
	 * Le constructeur
	 *
	 * @return void
	 *
	 * @since 0.0.1.0
	 * @version 0.0.1.0
	 */
	protected function construct() {}

	/**
	 * Sauvegardes les commentaires de l'EPI.
	 *
	 * @param  integer $epi_id L'ID de l'EPI.
	 * @param  arrya   $data   Les données des commentaires.
	 *
	 * @return boolean
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
