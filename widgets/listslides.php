<?php

namespace ElementorListslides\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Listslides extends Widget_Base {

    /**
     * Retrieve the widget name.
     * 
     * @since 1.1.0
     * @access public
     * 
     * @return string Widget name.
     */
    public function get_name(){
        return 'listslides';
    }

    /**
   * Retrieve the widget title.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __( 'ListSlides', 'elementor-listslides' );
  }
 
  /**
   * Retrieve the widget icon.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'eicon-slideshow';
  }
 
  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * Used to determine where to display the widget in the editor.
   *
   * Note that currently Elementor supports only one category.
   * When multiple categories passed, Elementor uses the first one.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return array Widget categories.
   */
  public function get_categories() {
    return [ 'custom-category' ];
  }

  public function get_keywords() {
		return [ 'slides', 'carousel', 'image', 'title', 'slider' ];
  }

  public function get_script_depends() {

  }
 
  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function _register_controls() {
    
  	$this->start_controls_section(
  		'section_listing_posts',
  		[
  			'label' => __( 'Listing Posts', 'listslides' ),
  			'tab' => Controls_Manager::TAB_CONTENT,
  		]
  	);  

  	$this->add_control(
  		'item_per_page',
  		[
  			'label' => __( 'Number of Listings', 'listslides' ),
  			'type' => Controls_Manager::SELECT,
  			'default' => 5,
  			'options' => [
  				2 => __( 'Two', 'listslides' ),
  				3 => __( 'Three', 'listslides' ),
  				4 => __( 'Four', 'listslides' ),
  				5 => __( 'Five', 'listslides')
  			]
  		]
  	);

  	$this->end_controls_section();

  	$this->start_controls_section(
			'slide_settings',
			[
				'label' => __( 'Slides Settings', 'listslides' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'nav',
			[
				'label'        => __( 'Navigation Arrow', 'listslides' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'listslides' ),
				'label_off'    => __( 'Hide', 'listslides' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'        => __( 'Dots', 'listslides' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'listslides' ),
				'label_off'    => __( 'Hide', 'listslides' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => __( 'Auto Play', 'listslides' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'listslides' ),
				'label_off'    => __( 'No', 'listslides' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_control(
			'loop',
			[
				'label'        => __( 'Loop', 'listslides' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'listslides' ),
				'label_off'    => __( 'No', 'listslides' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_control(
			'mouseDrag',
			[
				'label'        => __( 'Mouse Drag', 'listslides' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'listslides' ),
				'label_off'    => __( 'No', 'listslides' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_control(
			'touchDrag',
			[
				'label'        => __( 'Touch Motion', 'listslides' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'listslides' ),
				'label_off'    => __( 'No', 'listslides' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_control(
			'autoplayTimeout',
			[
				'label'     => __( 'Autoplay Timeout', 'listslides' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3000',
				'condition' => [
					'autoplay' => 'true',
				],
				'options' => [
					'2000'  => __( '2 Seconds', 'listslides' ),
					'3000' => __( '3 Seconds', 'listslides' ),
					'5000' => __( '5 Seconds', 'listslides' ),
					'10000' => __( '10 Seconds', 'listslides' ),
					'15000' => __( '15 Seconds', 'listslides' ),
					'20000' => __( '20 Seconds', 'listslides' ),
				],
			]
		);

		$this->end_controls_section();

  }
 
  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function render() {
		$settings = $this->get_settings_for_display();

    $nav = $settings['nav'];
    $dots = $settings['dots'];
    $autoplay = $settings['autoplay'];
    $loop = $settings['loop'];
    $autoplayTimeout = $settings['autoplayTimeout'];
    $mouseDrag       = $settings['mouseDrag'];
    $touchDrag       = $settings['touchDrag'];

    $this->add_render_attribute(
      'slider-wrapper',
      [
        'class' => 'pnw-slider-wrapper',
        'data-nav' => $nav,
        'data-dots' => $dots,
        'data-autoplay' => $autoplay,
        'data-loop' => $loop,
        'data-autoplay-timeout' => $autoplayTimeout,
        'data-mouse-drag' => $mouseDrag,
        'data-touch-drag' => $touchDrag
      ]
    );

    $args = array(
			'numberposts' => $settings['item_per_page'],
			'post_type' => 'listing'
		);
                
      ?>
			<div <?php echo $this->get_render_attribute_string('slider-wrapper'); ?>>
				<?php
					$recents = wp_get_recent_posts($args);

          if (is_array($recents) || is_object($recents) ) {

					foreach($recents as $recent) { 
            $price = get_post_meta( $recent['ID'], 'lcf_PriceList', true );
					?>
						<div class="listing-cont">
              <a href="<?php echo get_post_permalink( $recent['ID'] ); ?>">
              <img src="<?php echo get_the_post_thumbnail_url( $recent['ID'] ); ?>" alt="<?php echo get_the_title( $recent['ID'] ); ?>"></a>
              <a href="<?php echo get_post_permalink( $recent['ID'] ); ?>">
              <h3 class="list-address"><?php echo get_the_title( $recent['ID'] ); ?></h3></a>
              <a href="<?php echo get_post_permalink( $recent['ID'] ); ?>">
              <h4 class="list-price"> <?php echo $price; ?></h4></a>
            </div>
					<?php } 
          } ?>
			</div>

    		<?php	
	}
 
  /**
   * Render the widget output in the editor.
   *
   * Written as a Backbone JavaScript template and used to generate the live preview.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function _content_template() {
    
  }
}
?>