<?php

/**
 * @link       http://webnus.biz
 * @since      1.0.0
 *
 * @package    Depper Comment
 */

class Depc_Controller_Admin_Settings extends Depc_Controller_Admin {

	private $settings_api;

	const SETTINGS_PAGE_URL = Depc_Core::DEPC_ID;
	const REQUIRED_CAPABILITY = 'manage_options';


	/**
	 * Constructor
	 *
	 * @since    1.0.0
	 */
	protected function __construct() {

		$this->settings_api = Depc_Model_Admin_Settings::get_instance();
		add_action( 'admin_init', array($this, 'register_hook_callbacks') );
        add_action( 'admin_menu', array($this, 'admin_menu') );

	}

	/**
	 * Register callbacks for actions and filters
	 *
	 * @since    1.0.0
	 */
	public function register_hook_callbacks() {
        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );
        $this->settings_api->child_set_fields( $this->get_child_settings_fields() );
        //initialize settings
        $this->settings_api->admin_init();

	}

	function admin_menu() {

		add_menu_page( 'Deeper Comment', 'Deeper Comment', 'delete_posts', 'deeper_comment', array($this, 'plugin_page'), 'dashicons-admin-comments' );
	}

	function get_settings_sections() {
		$sections = array(
			array(
				'id'        => 'general_setting',
                'title'     => __( 'General Settings', 'depc' ),
				'icon'     => __( 'General Settings', 'depc' ),
                'submenu'   => array(
                        'id' => __( 'Comment_Link_option', 'depc' ),
                        'id1' => __( 'Flag_and_report_option', 'depc' )
                        )
				),
			array(
				'id'    => 'disscustion_settings',
				'title' => __( 'Discussion Settings', 'depc' ),
                'icon'  => 'sl-social-twitter'
				)
			);
		return $sections;
	}

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
    	$settings_fields = array(
    		'general_setting' => array(
    			array(
    				'name'              => 'text_val',
    				'label'             => __( 'Text Input', 'depc' ),
    				'desc'              => __( 'Text input description', 'depc' ),
    				'type'              => 'color',
    				'default'           => 'Title',
    				'sanitize_callback' => 'sanitize_text_field'
    				),
    			array(
    				'name'              => 'number_input',
    				'label'             => __( 'Number Input', 'depc' ),
    				'desc'              => __( 'Number field with validation callback `floatval`', 'depc' ),
    				'placeholder'       => __( '1.99', 'depc' ),
    				'min'               => 0,
    				'max'               => 100,
    				'step'              => '0.01',
    				'type'              => 'number',
    				'default'           => 'Title',
    				'sanitize_callback' => 'floatval'
    				),
    			array(
    				'name'        => 'textarea',
    				'label'       => __( 'Textarea Input', 'depc' ),
    				'desc'        => __( 'Textarea description', 'depc' ),
    				'placeholder' => __( 'Textarea placeholder', 'depc' ),
    				'type'        => 'textarea'
    				),
    			array(
    				'name'        => 'html',
    				'desc'        => __( 'HTML area description. You can use any <strong>bold</strong> or other HTML elements.', 'depc' ),
    				'type'        => 'html'
    				),
    			array(
    				'name'  => 'checkbox',
    				'label' => __( 'Checkbox', 'depc' ),
    				'desc'  => __( 'Checkbox Label', 'depc' ),
    				'type'  => 'checkbox'
    				),
    			array(
    				'name'    => 'radio',
    				'label'   => __( 'Radio Button', 'depc' ),
    				'desc'    => __( 'A radio button', 'depc' ),
    				'type'    => 'radio',
    				'options' => array(
    					'yes' => 'Yes',
    					'no'  => 'No'
    					)
    				),
    			array(
    				'name'    => 'selectbox',
    				'label'   => __( 'A Dropdown', 'depc' ),
    				'desc'    => __( 'Dropdown description', 'depc' ),
    				'type'    => 'select',
    				'default' => 'no',
    				'options' => array(
    					'yes' => 'Yes',
    					'no'  => 'No'
    					)
    				),
    			array(
    				'name'    => 'password',
    				'label'   => __( 'Password', 'depc' ),
    				'desc'    => __( 'Password description', 'depc' ),
    				'type'    => 'password',
    				'default' => ''
    				),
    			array(
    				'name'    => 'file',
    				'label'   => __( 'File', 'depc' ),
    				'desc'    => __( 'File description', 'depc' ),
    				'type'    => 'file',
    				'default' => '',
    				'options' => array(
    					'button_label' => 'Choose Image'
    					)
    				)
    			),
    		'wedevs_advanced' => array(
                'newgroup' => array(
        			array(
        				'name'    => 'color',
        				'label'   => __( 'Color', 'depc' ),
        				'desc'    => __( 'Color description', 'depc' ),
        				'type'    => 'color',
        				'default' => ''
        				),
        			array(
        				'name'    => 'password',
        				'label'   => __( 'Password', 'depc' ),
        				'desc'    => __( 'Password description', 'depc' ),
        				'type'    => 'password',
        				'default' => ''
        				)
                ),
    			array(
    				'name'    => 'wysiwyg',
    				'label'   => __( 'Advanced Editor', 'depc' ),
    				'desc'    => __( 'WP_Editor description', 'depc' ),
    				'type'    => 'wysiwyg',
    				'default' => ''
    				),
    			array(
    				'name'    => 'multicheck',
    				'label'   => __( 'Multile checkbox', 'depc' ),
    				'desc'    => __( 'Multi checkbox description', 'depc' ),
    				'type'    => 'multicheck',
    				'default' => array('one' => 'one', 'four' => 'four'),
    				'options' => array(
    					'one'   => 'One',
    					'two'   => 'Two',
    					'three' => 'Three',
    					'four'  => 'Four'
    					)
    				),
    			)
    		);

    	return $settings_fields;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_child_settings_fields() {
        $settings_fields = array(
            'Comment_Link_option' => array(
                array(
                    'name'              => 'hiiii',
                    'label'             => __( 'Text Input', 'depc' ),
                    'desc'              => __( 'Text input description', 'depc' ),
                    'placeholder'       => __( 'Text Input placeholder', 'depc' ),
                    'type'              => 'text',
                    'default'           => 'Title',
                    'sanitize_callback' => 'sanitize_text_field'
                    ),
                array(
                    'name'              => 'hs',
                    'label'             => __( 'Number Input', 'depc' ),
                    'desc'              => __( 'Number field with validation callback `floatval`', 'depc' ),
                    'placeholder'       => __( '1.99', 'depc' ),
                    'min'               => 0,
                    'max'               => 100,
                    'step'              => '0.01',
                    'type'              => 'number',
                    'default'           => 'Title',
                    'sanitize_callback' => 'floatval'
                    )
                ),
            'Flag_and_report_option' => array(
                array(
                    'name'    => 'fs',
                    'label'   => __( 'Advanced Editor', 'depc' ),
                    'desc'    => __( 'WP_Editor description', 'depc' ),
                    'type'    => 'wysiwyg',
                    'default' => ''
                    ),
                array(
                    'name'    => 'az',
                    'label'   => __( 'Multile checkbox', 'depc' ),
                    'desc'    => __( 'Multi checkbox description', 'depc' ),
                    'type'    => 'multicheck',
                    'default' => array('one' => 'one', 'four' => 'four'),
                    'options' => array(
                        'one'   => 'One',
                        'two'   => 'Two',
                        'three' => 'Three',
                        'four'  => 'Four'
                        )
                    ),
                )
            );

        return $settings_fields;
    }

    function plugin_page() {
    	echo ' 
            <div id="wrap">
                <div class="container">
                <hr class="vertical-space5">
                    <div class="dpr-be-container">';

                	$this->settings_api->show_navigation();
                	$this->settings_api->show_forms();

    	echo '       </div>
                </div>
            </div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
    	$pages = get_pages();
    	$pages_options = array();
    	if ( $pages ) {
    		foreach ($pages as $page) {
    			$pages_options[$page->ID] = $page->post_title;
    		}
    	}

    	return $pages_options;
    }

	/**
	 * Creates the markup for the Settings page
	 *
	 * @since    1.0.0
	 */
	public function markup_settings_page() {

		if ( current_user_can( static::REQUIRED_CAPABILITY ) ) {

			echo static::render_template(
				'page-settings/page-settings.php',
				array(
					'page_title' 	=> Depc_Core::DEPC_NAME,
					'settings_name' => Depc_Model_Admin_Settings::SETTINGS_NAME
					)
				);

		} else {

			wp_die( __( 'Access denied.' ) );

		}

	}

	/**
	 * Adds the section introduction text to the Settings page
	 *
	 * @param array $section
	 *
	 * @since    1.0.0
	 */
	public function markup_section_headers( $section ) {

		echo static::render_template(
			'page-settings/page-settings-section-headers.php',
			array(
				'section'      => $section,
				'text_example' => __( 'This is a text example for section header',Depc_Core::DEPC_ID )
				)
			);

	}

	/**
	 * Delivers the markup for settings fields
	 *
	 * @param array $args
	 *
	 * @since    1.0.0
	 */
	public function markup_fields( $field_args ) {

		$field_id = $field_args['id'];
		$settings_value = static::get_model()->get_settings( $field_id );

		echo static::render_template(
			'page-settings/page-settings-fields.php',
			array(
				'field_id'       => esc_attr( $field_id ),
				'settings_name'  => Depc_Model_Admin_Settings::SETTINGS_NAME,
				'settings_value' => ! empty( $settings_value ) ? esc_attr( $settings_value ) : ''
				),
			'always'
			);

	}

}
