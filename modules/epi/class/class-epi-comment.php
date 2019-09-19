<?php
/**
 * Handle EPI Comments
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     0.1.0
 * @version   0.4.0
 * @copyright 2015-2018 Evarisk
 * @package   TheEPI
 */
namespace theepi;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Handle EPI Comments
 */
class EPI_Comment_Class extends \eoxia\Comment_Class {
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\theepi\EPI_Comment_Model';
	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_theepi_epi_comment';
	/**
	 * Le type
	 *
	 * @var string
	 */
	protected $type = 'theepi-epi-comment';
	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'theepi/epi-comment';
	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';
	/**
	 * L'option pour enregistrer le commentaire par défault.
	 *
	 * @var string
	 */
	public $option_name_default_comment = 'theepi_default_comment';
	/**
	 * La donnée par défaut du commentaire.
	 * Initialisé dans le constructeur.
	 *
	 * @var string
	 */
	public $default_data_comment;
	/**
	 * Constructeur
	 *
	 * @since   0.3.0
	 * @version 0.3.0
	 *
	 * @return void
	 */
	protected function construct() {

	}

	/**
	 * Sauvegardes les commentaires de l'EPI.
	 *
	 * @since   0.1.0
	 * @version 0.3.0
	 *
	 * @param integer $epi_id L'ID de l'EPI.
	 * @param array   $data   Les données des commentaires.
	 *
	 * @return boolean
	 */
	public function save_comments( $epi_id, $data ) {
		if ( isset( $epi_id ) ) {
			if ( ! empty( $data ) ) {
				foreach ( $data as $comment_data ) {
					if ( ! empty( $comment_data['content'] ) ) {
						$comment_data['post_id'] = $epi_id;
						$comment_data['date']    = $comment_data['date'];
						$comment_data['id']      = (int) $comment_data['id'];
						$comment_data['content'] = sanitize_text_field( $comment_data['content'] );
						$comment_data['state']   = sanitize_text_field( $comment_data['state'] );
						$comment                 = self::g()->update( $comment_data );
						\eoxia\LOG_Util::g()->log( sprintf( 'Add comments on EPI "%d" with data %s, saved comment %s', $epi_id, wp_json_encode( $comment_data ), wp_json_encode( $comment ) ), 'theepi' );
					}
				}
			}
		}
		return true;
	}
}

EPI_Comment_Class::g();