<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/public
 * @author     Woodpecker Team
 */
class Woodpecker_For_Wordpress_Connector_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The url of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $url
	 */
	private $url;

	/**
	 * The form ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $formId
	 */
	private $formId;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $url ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->url = $url;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wfw-public.css', array(), $this->version.rand(), 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.5.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wfw-public.min.js', array( 'jquery' ), $this->version.rand(), false );
	}

	/**
	 * Registers shortcodes at once
	 *
	 * @since    1.0.0
	 */

	public function register_shortcodes() {
		add_shortcode( 'woodpecker-connector', array( $this, 'shortocde_Woodpecker_For_Wordpress_Connector' ) );
	}

	/**
	 * Registers shortcode
	 *
	 * @since    1.0.0
	 */
	public function shortocde_Woodpecker_For_Wordpress_Connector( $atts = array() ) {
		define('woodpecker-shortcode', TRUE);
		$formId = abs(crc32(uniqid()));
		$atts = shortcode_atts( array(
			'form_name' => $this->plugin_name . '-form-' . $formId,
			'id' => 0,
		), $atts );

		ob_start();

		include( 'partials/wfw-public-shortcode.php' );

		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}

	/**
	 * Registers function to add prospects
	 *
	 * @since    1.0.0
	 */

	public function add_prospect_to_campaing() {
		global $wpdb;

		$data = $wpdb->get_row( "SELECT success_message, error_message, already_exist_message, api_key FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");

		$parameters = (array) $_POST['parameters'];
		$remsomestring = strlen($this->plugin_name.'-');
		$prospect = array();
		$campaign = 0;
		$isValid = true;

		foreach ($parameters as $k => $v) {
			if (substr(sanitize_text_field($v['name']), $remsomestring) == 'accept_policy' && $v['val'] != 1) {
				$isValid = false;
			} else {
				if (substr(sanitize_text_field($v['name']), $remsomestring) == 'campaign') {
					$campaign = (int) sanitize_text_field($v['val']);
				} else {
					$prospect[substr(sanitize_text_field($v['name']), $remsomestring)] = sanitize_text_field($v['val']);
				}
			}
		}

		if ($isValid) {
			if ($campaign > 0) {
				$linkToAPI = '/rest/v1/add_prospects_campaign';
				$addprospecjson = '{
					"campaign":{
						"campaign_id": '.$campaign.'
					},
							"update": "true",'.'
							"prospects": ['.json_encode($prospect, true).']
						}';
			} else {
				$linkToAPI = '/rest/v1/add_prospects_list';
				$addprospecjson = '{
							"update": "true",'.'
							"prospects": ['.json_encode($prospect, true).']
						}';
			}

			$addprospects = new Woodpecker_For_Wordpress_Connector_Curl($linkToAPI, $data->api_key, $addprospecjson);
			$getaddprospects = $addprospects->getJson();
			$getaddprospectObject = $getaddprospects->prospects;
			$response = array();

			if ($getaddprospectObject[0]->status == 'ERROR' ) {
				$response['action'] = 'ERROR';
				$response['message'] = 	__(stripslashes_deep($data->error_message), $this->plugin_name);
				$response['code'] = $getaddprospectObject[0]->code;
			} else if ($getaddprospectObject[0]->prospect_campaign == 'DUPLICATE') {
				$response['action'] = 'DUPLICATE';
				$response['message'] = 	__(stripslashes_deep($data->already_exist_message), $this->plugin_name);
			} else {
				$response['action'] = 'SUCCESS';
				$response['message'] = 	__(stripslashes_deep($data->success_message), $this->plugin_name);
			}

		} else {
			$response['action'] = 'ERROR';
			$response['message'] = 	__(stripslashes_deep($data->error_message), $this->plugin_name);
			$response['code'] = 'POLICY';
		}


		echo json_encode($response, JSON_HEX_QUOT | JSON_HEX_TAG);

		wp_die();
	}


	/**
	 * Save prospect in database
	 *
	 * @since    2.0.0
	 */

	public function addProspectsToDatabase() {
		$fields = $_POST['fields'];
		global $wpdb;

		$email = '';
		$firstName = '';
		$lastName = '';
		$company = '';
		$www = '';
		$linkedin = '';
		$title = '';
		$phone = '';
		$address = '';
		$tag = '';
		$city = '';
		$state = '';
		$country = '';
		$industry = '';
		$snippet1 = '';
		$snippet2 = '';
		$snippet3 = '';
		$snippet4 = '';
		$snippet5 = '';
		$snippet6 = '';
		$snippet7 = '';
		$snippet8 = '';
		$snippet9 = '';
		$snippet10 = '';
		$snippet11 = '';
		$snippet12 = '';
		$snippet13 = '';
		$snippet14 = '';
		$snippet15 = '';

		foreach ($fields as $k => $v) {
			if ($v['name'] == 'wfw-email') {
				$email = $v['val'];
			}
			if ($v['name'] == 'wfw-first_name') {
				$firstName = $v['val'];
			}
			if ($v['name'] == 'wfw-last_name') {
				$lastName = $v['val'];
			}
			if ($v['name'] == 'wfw-company') {
				$company = $v['val'];
			}
			if ($v['name'] == 'wfw-website') {
				$www = $v['val'];
			}
			if ($v['name'] == 'wfw-linkedin_url') {
				$linkedin = $v['val'];
			}
			if ($v['name'] == 'wfw-title') {
				$title = $v['val'];
			}
			if ($v['name'] == 'wfw-phone') {
				$phone = $v['val'];
			}
			if ($v['name'] == 'wfw-address') {
				$address = $v['val'];
			}
			if ($v['name'] == 'wfw-tags') {
				$tag = $v['val'];
			}
			if ($v['name'] == 'wfw-city') {
				$city = $v['val'];
			}
			if ($v['name'] == 'wfw-state') {
				$state = $v['val'];
			}
			if ($v['name'] == 'wfw-country') {
				$country = $v['val'];
			}
			if ($v['name'] == 'wfw-industry') {
				$industry = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet1') {
				$snippet1 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet2') {
				$snippet2 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet3') {
				$snippet3 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet4') {
				$snippet4 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet5') {
				$snippet5 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet6') {
				$snippet6 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet7') {
				$snippet7 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet8') {
				$snippet8 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet9') {
				$snippet9 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet10') {
				$snippet10 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet11') {
				$snippet11 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet12') {
				$snippet12 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet13') {
				$snippet13 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet14') {
				$snippet14 = $v['val'];
			}
			if ($v['name'] == 'wfw-snippet15') {
				$snippet15 = $v['val'];
			}
		}

		$table = $wpdb->prefix . 'wfw_forms_prospects';
		$data = array(
			'id' => '',
			'email' => sanitize_text_field($email),
			'first_name' => sanitize_text_field($firstName),
			'last_name' => sanitize_text_field($lastName),
			'company' => sanitize_text_field($company),
			'www' => sanitize_text_field($www),
			'linkedin_url' => sanitize_text_field($linkedin),
			'title' => sanitize_text_field($title),
			'phone' => sanitize_text_field($phone),
			'address' => sanitize_text_field($address),
			'tag' => sanitize_text_field($tag),
			'city' => sanitize_text_field($city),
			'state' => sanitize_text_field($state),
			'country' => sanitize_text_field($country),
			'industry' => sanitize_text_field($industry),
			'snippet_1' => sanitize_text_field($snippet1),
			'snippet_2' => sanitize_text_field($snippet2),
			'snippet_3' => sanitize_text_field($snippet3),
			'snippet_4' => sanitize_text_field($snippet4),
			'snippet_5' => sanitize_text_field($snippet5),
			'snippet_6' => sanitize_text_field($snippet6),
			'snippet_7' => sanitize_text_field($snippet7),
			'snippet_8' => sanitize_text_field($snippet8),
			'snippet_9' => sanitize_text_field($snippet9),
			'snippet_10' => sanitize_text_field($snippet10),
			'snippet_11' => sanitize_text_field($snippet11),
			'snippet_12' => sanitize_text_field($snippet12),
			'snippet_13' => sanitize_text_field($snippet13),
			'snippet_14' => sanitize_text_field($snippet14),
			'snippet_15' => sanitize_text_field($snippet15),
			'form_id' => 1,
			'timestamp' => date("Y-m-d")
		);

		$wpdb->insert($table, $data);
		// global $wpdb;
		// echo $parameters;
	}

}
