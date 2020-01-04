<?php

namespace ElementorListslides;

/**
 * Class Plugin
 * 
 * Main Plugin Class
 * @since 1.0.0
 */
class Plugin {

    /**
     * Instance
     * 
     * @since 1.0.0
     * @access private
     * @static
     * 
     * @var Plugin The Single instance of the class
     */
    private static $_instance = null;

    /**
     * Instance
     * 
     * Ensures only one instance of the class is loaded or can be loaded.
     * 
     * @since 1.2.0
     * @access public
     * 
     * @return Plugin an instance of the class
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
    * Create Widget Category
    * 
    * @return custom-category
    */
    function add_elementor_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'custom-category',
            [
                'title' => __( 'Custom Category', 'custom-category' ),
                'icon' => 'fa fa-plug',
            ]
        );

    }

    /**
     * Widget_scripts
     * 
     * Load required plugin core files.
     * 
     * @since 1.2.0
     * @access public
     */
    public function widget_scripts() {
        wp_register_script( 'listslides', plugins_url( 'assets/js/slick.js', __FILE__ ), [ 'jquery' ], '1.8', true );
        wp_register_script( 'listslides-main', plugins_url( 'assets/js/listslides.js', __FILE__ ), [ 'jquery' ], '1.2', true );

        wp_enqueue_script( 'listslides' );
        wp_enqueue_script( 'listslides-main' );
    }

    public function widget_styles() {

        wp_register_style( 'listslides-slick', plugins_url( 'assets/css/slick.css', __FILE__ ) );
        wp_register_style( 'listslides-theme', plugins_url( 'assets/css/slick-theme.css', __FILE__ ) );
        wp_register_style( 'listslick-styles', plugins_url( 'assets/css/listslick-styles.css', __FILE__ ) );

        wp_enqueue_style( 'listslides-slick' );
        wp_enqueue_style( 'listslides-theme' );
        wp_enqueue_style( 'listslick-styles' );
	}

    /**
     * Include Widgets Files
     * 
     * Load widgets files
     * 
     * @since 1.2.0
     * @access private
     */
    private function include_widgets_files() {
        require_once( __DIR__ . '/widgets/listslides.php' );
    }

    /**
     * Register Widgets
     * 
     * Register new Elementor Widgets.
     * 
     * @since 1.2.0
     * @access public
     */
    public function register_widgets() {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();
        
        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Listslides() );
    }

    /**
     * Plugin class constructor
     * 
     * Register plugin action hooks and filters
     * 
     * @since 1.2.0
     * @access public
     */
    public function __construct() {

    // Create Widget Category
    add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

    // Register widget scripts
    add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'widget_scripts' ] );
    add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'widget_scripts' ] );
    //add_action( 'elementor/frontend/before_register_scripts', [ $this, 'widget_scripts' ] );
    //add_action( 'elementor/editor/before_register_scripts', [ $this, 'widget_scripts' ] );
    
    // Register Widget Styles
    add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
	add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'widget_styles' ] );
 
    // Register widgets
    add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
    }
}

//Instantiate Plugin Class
Plugin::instance();

?>