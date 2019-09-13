<?php
/**
 * Création et Génération d'un fichier ODT d'un EPI.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk.
 * @since     0.5.0
 * @version   0.6.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class lié à génération d'un fichier ODT d'un EPI.
 */
class EPI_ODT_Class extends \eoxia\ODT_Class {


	/**
	 * Le nom du modèle.
	 *
	 * @var string
	 */
	protected $model_name = '\theepi\EPI_ODT_Model';

	/**
	 * Le type du document.
	 *
	 * @var string
	 */
	protected $type = 'epi_odt';

	/**
	 * La taxonomy du post.
	 *
	 * @todo
	 * @var  string
	 */
	public $attached_taxonomy_type = 'attachment_category';

	/**
	 * La clé principale de l'objet.
	 *
	 * @var string
	 */
	protected $meta_key = '_epi_document_odt';

	/**
	 * La base de l'URI pour la Rest API.
	 *
	 * @var string
	 */
	protected $base = 'epi-odt';

	/**
	 * La version pour la Rest API.
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe pour le champs "unique_key" de l'objet.
	 *
	 * @var string
	 */
	public $element_prefix = 'EPI_ODT';

	/**
	 * Le nom pour le register post type.
	 *
	 * @var string
	 */
	protected $post_type_name = 'EPI_ODT';

	/**
	 * Les types par défaut des modèles.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private $default_types = array( 'model', 'default_model' );


	/**
	 * Le nom de l'ODT sans l'extension; exemple: fiche_modele_EPI.
	 *
	 * @var string
	 */
	protected $odt_name = 'fiche_modele_EPI';

	/**
	 * Le path du fichier ODT.
	 *
	 * @var string
	 */
	protected $path = '';

	/**
	 * Le constructeur.
	 *
	 * @since   0.5.0
	 * @version 0.5.0
	 */
	protected function construct() {
		$this->path = PLUGIN_THEEPI_PATH;

		parent::construct();
	}

	/**
	 * Récupération de la liste des modèles de fichiers disponible pour un type d'élément.
	 *
	 * @since 0.5.0
	 *
	 * @param array $model_type Le type du document.
	 *
	 * @return array ['status']  True si tout s'est bien passé.
	 *               ['id']   	 L'id du modèle.
	 *               ['path']    Le chemin d'accès au modèle.
	 *               ['url']     le lien d'accès au modèle.
	 *               ['message'] Le message indiquant quelle modèle est utilisé.
	 */
	public function get_default_model( $model_type ) {
		if ( 'zip' === $model_type ) {
			return;
		}

		$response = array(
			'status'  => true,
			'id'      => null,
			'path'    => str_replace( '\\', '/', PLUGIN_THEEPI_PATH . 'core/assets/document_template/' . $this->odt_name . '.odt' ),
			'url'     => str_replace( '\\', '/', PLUGIN_THEEPI_URL . 'core/assets/document_template/' . $this->odt_name . '.odt' ),
			// translators: Pour exemple: Le modèle utilisé est: C:\wamp\www\wordpress\wp-content\plugins\digirisk-alpha\core\assets\document_template\document_unique.odt.
			'message' => sprintf( __( 'Le modèle utilisé est: %1$score/assets/document_template/%2$s.odt', 'theepi' ), PLUGIN_THEEPI_PATH, $this->odt_name ),
		);

		// Merge tous les types ensembles.
		$types = array_merge( $this->default_types, (array) $model_type );

		// Préparation de la query pour récupérer le modèle par défaut selon $model_type.
		$tax_query = array(
			'relation' => 'AND',
		);

		if ( ! empty( $types ) ) {
			foreach ( $types as $type ) {
				$tax_query[] = array(
					'taxonomy' => $this->get_attached_taxonomy(),
					'field'    => 'slug',
					'terms'    => $type,
				);
			}
		}

		// Lances la Query pour récupérer le document par défaut selon $model_type.
		$query = new \WP_Query(
			array(
				'fields'         => 'ids',
				'post_status'    => 'inherit',
				'posts_per_page' => 1,
				'tax_query'      => $tax_query,
				'post_type'      => 'attachment',
			)
		);

		// Récupères le document
		if ( $query->have_posts() ) {
			$upload_dir = wp_upload_dir();

			$model_id             = $query->posts[0];
			$attachment_file_path = str_replace( '\\', '/', get_attached_file( $model_id ) );
			$response['id']       = $model_id;
			$response['path']     = str_replace( '\\', '/', $attachment_file_path );
			$response['url']      = str_replace( str_replace( '\\', '/', $upload_dir['basedir'] ), str_replace( '\\', '/', $upload_dir['baseurl'] ), $attachment_file_path );

			// translators: Pour exemple: Le modèle utilisé est: C:\wamp\www\wordpress\wp-content\plugins\digirisk-alpha\core\assets\document_template\document_unique.odt.
			$response['message'] = sprintf( __( 'Le modèle utilisé est: %1$s', 'digirisk' ), $attachment_file_path );
		}

		if ( ! is_file( $response['path'] ) ) {
			$response['status']  = false;
			$response['message'] = 'Le modèle ' . $response['path'] . ' est introuvable.';
		}

		return $response;
	}
}

EPI_ODT_Class::g();
