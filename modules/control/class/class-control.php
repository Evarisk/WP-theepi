<?php
/**
 * Handle Control.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle Control.
 */
class Control_Class extends \eoxia\Post_Class {


	/**
	 * Le nom du modèle.
	 *
	 * @var string
	 */
	protected $model_name = '\theepi\Control_Model';

	/**
	 * Le post type.
	 *
	 * @var string
	 */
	protected $type = 'theepi-epi-control';

	/**
	 * La clé principale du modèle.
	 *
	 * @var string
	 */
	protected $meta_key = '_theepi_epi_control';

	/**
	 * La route pour accéder à l'objet dans la rest API.
	 *
	 * @var string
	 */
	protected $base = 'epi-control';

	/**
	 * Le préfixe de l'objet dans TheEPI pour les contrôles.
	 *
	 * @var string
	 */
	public $element_prefix = 'CTRL';

	/**
	 * La version de l'objet.
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La limite des Control a affiché par page.
	 *
	 * @var integer
	 */
	protected $limit_control = 10;

	/**
	 * le nom de l'option pour enregistrer le nombre d'epi par page (défault).
	 *
	 * @var string
	 */
	public $option_name_per_page = 'control_per_page';

	/**
	 * Le nom pour le register post type.
	 *
	 * @var string
	 */
	protected $post_type_name = 'Control EPI';

	/**
	 * Constructeur.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	protected function construct() {
		parent::construct();
	}

	/**
	 * Appel la vue principale pour afficher le tableau HTML contenant les contrôles.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param string $term Terme de la recherche. Défault ''.
	 *
	 * @return void
	 */
	public function display( ) {

		$controls_schema = self::g()->get(
			array(
				'schema' => true,
			), true
		);

		return $controls_schema;

	}

	/**
	 * Récupères la liste des contrôles.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param EPI_Model $epi      Les données de l'EPI.
	 *
	 * @return array ['controls'] (array)   La liste des contrôles.
	 */
	public function get_controls( $epi ) {
		$id = $epi->data['id'];
		$controls = self::g()->get( array( 'post_parent' => $id ) );
		return $controls;
	}

	/**
	 * Affiches la liste des contrôles.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param EPI_Model $epi      Les données de l'EPI.
	 * @param bool   $frontend    L'état du site - $frontend = true.
	 *
	 * @return void
	 */
	public function display_control_list( $epi, $frontend ) {

		$controls = $this->get_controls( $epi );
		\eoxia\View_Util::exec(
			'theepi', 'control', 'list', array(
				'controls' => $controls,
				'frontend' => $frontend

			)
		);
	}

	/**
	 * Affiches la vue contenu de la modal contrôle ( tableau header + liste des contrôles ).
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param EPI_Model $epi      Les données de l'EPI.
	 * @param bool   $frontend    L'état du site - $frontend = true.
	 *
	 * @return void
	 */
	public function display_modal_content( $epi, $frontend ) {

		\eoxia\View_Util::exec(
			'theepi', 'control', 'modal-content', array(
				'epi' => $epi,
				'frontend' => $frontend
			)
		);
	}

	/**
	 * Récupère le dernier control lié à un EPI.
	*
	* @since   0.7.0
	* @version 0.7.0
	*
	* @param array  $controls      Les données des contrôles.
	*
	* @return array $controls[key]  retourne le control le plus récent.
	*/
	public function last_control_epi( $controls ) {

	 	if ( empty( $controls ) ) {
	 		return array();
	 	}

	 	$date_start        = 0;
	 	$date_last_control = 0;
	 	$key_last_control  = 0;
	 	foreach ( $controls as $key => $control ) {
	 		$date_start = strtotime( $control->data['date']['rendered']['mysql'] );
	 		if ( $date_last_control < $date_start ) {
	 			$date_last_control = $date_start;
	 			$key_last_control  = $key;
	 		}
	 	}
	 	return $controls[ $key_last_control ];
	}

	/**
	 * Supprimes un contrôle.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param integer    $id L'ID d'un contrôle.
	 *
	 * @return EPI_Model $epi  Les données de l'EPI avec son status trash.
	 */
	public function delete( $id ) {
		$control = $this->get( array( 'id' => $id ), true );
		$epi = EPI_Class::g()->get( array( 'id' => $control->data[ 'parent_id' ] ),true );

		$control->data['status'] = 'trash';

		$control = $this->update( $control->data );
		\eoxia\LOG_Util::g()->log( sprintf( ' Control "%d" is now trashed, Control data %s', $control->data['id'], wp_json_encode( $control ) ), 'theepi' );

		return $epi;
	}

	/**
	 * récupère le média rattaché au contrôle.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param integer $id  L'ID d'un contrôle.
	 *
	 * @return view  $view La vue contenant le média.
	 */
	public function get_media( $id ) {

		$control = Control_Class::g()->get( array( 'id' => $id ), true );
		$media_id = end( $control->data['associated_document_id']['media'] );
		$media = get_post( $media_id );

		if ( ! empty ( $media ) ) {
			$filelink      = get_attached_file( $media_id );
			$filename_only = basename( $filelink );
			$fileurl_only = $media->guid;

			ob_start();
			\eoxia\View_Util::exec(
				'theepi', 'control', 'attached-file', array(
					'file_id' => $media_id,
					'field_name' => "",
					'filename_only' => $filename_only,
					'fileurl_only' => $fileurl_only
				)
			);
			$view = ob_get_clean();
			return $view;
		}else {
			// return esc_html_e( 'No file attached', 'wpeo-upload' );
		}

	}

	/**
	 * Récupère l'état du site.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @param bool   $frontend   L'état du site - $frontend = true.
	 *
	 * @return string $namespace Le namespace à utilisé.
	 */
	public function frontend( $frontend ) {
		if ( $frontend == 'true' ) {
			return 'theEPIFrontEnd';
		}else {
			return 'theEPI';
		}
	}

	/**
	 * Crée un post en status draft.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return POST $post les données du post.
	 */
	public function draft() {
		$post = $this->get( array( 'post_status' => 'draft' ), true );
		if ( ! empty ( $post ) ) {
			$post = $this->delete( $post->data['id'] );
		}
		$post = $this->get( array( 'schema' => true ), true );
		$post->data['post_status'] = 'draft';
		$post = $this->update( $post->data );
		$post = $this->get( array( 'post_status' => 'draft' ), true );
		return $post;
	}

	/**
	 * Crée un identifiant unique pour les contrôles.
	 *
	 * @since   0.7.0
	 * @version 0.7.0
	 *
	 * @return integer $unique_identifier l'identifiant unique.
	 */
	public function unique_identifier( $epi ) {
		$controls = $this->get_controls( $epi );
		$nb_controls = count( $controls ) + 1;
		$unique_identifier = 'CTRL' . $nb_controls;
		return $unique_identifier;
	}


}

Control_Class::g();
