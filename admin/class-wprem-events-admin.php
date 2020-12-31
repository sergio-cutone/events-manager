<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Wprem_Events
 * @subpackage Wprem_Events/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wprem_Events
 * @subpackage Wprem_Events/admin
 * @author     Imran Lakhani <imran.lakhani@yp.ca>
 */
class Wprem_Events_Admin
{

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
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wprem_Events_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wprem_Events_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wprem-events-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wprem_Events_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wprem_Events_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wprem-events-admin.js', array('jquery'), $this->version, false);

    }

    public function add_button($x)
    {
        echo '<a href="#TB_inline?width=480&height=500&inlineId=wp_event_shortcode" class="button thickbox" id="add_div_shortcode">EV</a>';
    }

    public function event_shortcode_popup()
    {
        ?>
		<div id="wp_event_shortcode" style="display:none;">
			<div class="wrap">
				<div>
					<div style="padding:10px">
						<h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;">Event Shortcode</h3>
						<p>Selecting to show all events or a specific event.</p>
						<div class="field-container">
							<div class="label-desc">
								<?php
$args = array(
            'post_status' => 'published',
            'post_type' => 'wprem_events',
            //'meta_key' => '_data_order',
            //'orderby' => 'meta_value',
            'orderby' => 'post_title',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_data_edate',
                    'value' => time(),
                    'compare' => '>',
                ),
            ),
        );
        echo '<select id="wp_event_id"><option value="">Show All Events</option>';
        $items = get_posts($args);
        foreach ($items as $item):
            setup_postdata($item);
            echo "<option value=" . $item->ID . ">" . $item->post_title . "</option>";
        endforeach;
        wp_reset_postdata();
        echo "</select>";
        ?>
							</div>
						</div>
						<p>Select the View you would like to display.</p>
						<div class="field-container">
							<div class="label-desc">
								<?php
$args = array(
            'post_status' => 'published',
            'post_type' => 'wprem_events_view',
            'orderby' => 'post_title',
            'order' => 'ASC',
            'posts_per_page' => -1,
        );
        echo '<select id="wp_eventview_id">';
        $items = get_posts($args);
        //print_r($items);
        foreach ($items as $item):
            setup_postdata($item);
            echo "<option value=" . $item->ID . ">" . $item->post_title . "</option>";
        endforeach;
        wp_reset_postdata();
        echo "</select>";
        ?>
							</div>
						</div>
						<div id="for-list">
						<p>Show all Events or Active one</p>
						<div class="field-container">
							<div class="label-desc">
								<select id="wp_eventshow">
									<option value="all">Show All</option>
									<option value="active">Show Active only</option>
								</select>
							</div>
						</div>
						<p>Ordering of Events</p>
						<div class="field-container">
							<div class="label-desc">
								<select id="wp_eventorder">
									<option value="ASC">Ascending</option>
									<option value="DESC">Desending</option>
								</select>
							</div>
						</div>
					</div>
						<!--<p>Select Staff by Venue</p>-->
						<?php
/*$args = array(
        'post_type'   => WPREM_SERVICES_CUSTOM_POST_TYPE,
        'orderby' => 'post_title',
        'order' => 'ASC',
        'posts_per_page' => -1
        );
        echo '<select id="wp_allservices_id"><option value="">Select Service</option>';
        $staffviews = get_posts( $args );
        foreach ( $staffviews as $staffview ) :
        setup_postdata( $staffview );
        echo '<option value="'.$staffview->ID.'">'.$staffview->post_title.'</option>';
        endforeach;
        wp_reset_postdata();
        echo "</select>";
         */?>
					</div>
					<hr />
					<div style="padding:15px;">
						<input type="button" class="button-primary" value="Insert" id="event-insert" />
						&nbsp;&nbsp;&nbsp;<a class="button" href="#" onclick="tb_remove(); return false;">Cancel</a>
					</div>
				</div>
			</div>
		</div>
		<?php
}

    public function content_types()
    {

        $exludefromsearch = (esc_attr(get_option('wprem_searchable_wprem-events')) === "1") ? false : true;
        $args = array(
            'exclude_from_search' => $exludefromsearch,
            'has_archive' => true,
            'hierarchical' => true,
            'show_in_nav_menus' => true,
            'menu_icon' => 'dashicons-format-status',
            'rewrite' => array('slug' => 'events'),
            'labels' => array('name' => __('Events', 'cuztom'),
                'menu_name' => __('Events', 'cuztom'),
                'add_new' => __('Add New Event', 'cuztom'),
                'add_new_item' => __('Add New Event', 'cuztom'),
                'all_items' => __('All Events', 'cuztom'),
                'view' => __('View Event', 'cuztom'),
                'view_item' => __('View Event', 'cuztom'),
                'search_items' => __('Search Event', 'cuztom'),
                'not_found' => __('No Event Found', 'cuztom'),
                'not_found_in_trash' => __('No Event found in Trash', 'cuztom')),
            'supports' => array('title', 'editor'),
            'public' => true,
            'show_in_rest' => true);

        $event = register_cuztom_post_type('wprem_events', $args);
        $box = register_cuztom_meta_box(
            'data',
            'wprem_events',
            array(
                'title' => __('Event Information', 'cuztom'),
                'fields' => array(
                    array(
                        'id' => '_data_sdate',
                        'type' => 'date',
                        'label' => 'Start Date',
                        'required' => 'true',
                        'html_attributes' => array('required' => 'on', 'autocomplete' => 'off'),
                        'args' => array(
                            'date_format' => 'Y/m/d',
                        ),
                        'show_admin_column' => false,
                        'admin_column_sortable' => false,
                        'admin_column_filter' => false,
                    ),
                    array(
                        'id' => '_data_edate',
                        'type' => 'date',
                        'label' => 'End Date',
                        'required' => 'true',
                        'html_attributes' => array('required' => 'on', 'autocomplete' => 'off'),
                        'args' => array(
                            'date_format' => 'Y/m/d',
                        ),
                        'show_admin_column' => false,
                        'admin_column_sortable' => false,
                        'admin_column_filter' => false,
                    ),
                    array(
                        'id' => '_data_stime',
                        'type' => 'time',
                        'label' => 'Start Time',
                    ),
                    array(
                        'id' => '_data_etime',
                        'type' => 'time',
                        'label' => 'End Time',
                    ),

                ),
            )
        );

        if (class_exists('woocommerce')) {
            $box = register_cuztom_meta_box(
                'data_ticket',
                'wprem_events',
                array(
                    'title' => __('Event Tickets', 'cuztom'),
                    'fields' => array(
                        array(
                            'id' => '_data_ticket_active',
                            'type' => 'checkbox',
                            'label' => 'Activate tickets for this Event',
                        ),
                        array(
                            'id' => '_data_ticket_type',
                            'type' => 'select',
                            'label' => 'Ticket Type',
                            'options' => array(
                                '1' => 'Simple',
                                '2' => 'Variable',
                            ),
                            'default_value' => 'Simple',
                        ),
                        array(
                            'id' => '_data_ticket_regular_price',
                            'type' => 'text',
                            'label' => 'Ticket Price ($)',
                        ),
                        array(
                            'id' => '_data_ticket_sale_price',
                            'type' => 'text',
                            'label' => 'Ticket Sale Price ($)',
                        ),
                        array(
                            'id' => '_data_ticket_sku',
                            'type' => 'text',
                            'label' => 'Ticket SKU',
                        ),
                        array(
                            'id' => '_data_ticket_woocommerce_product_id',
                            'type' => 'hidden',
                            'label' => 'Woocommerce Product ID',
                            //'html_attributes'  => array(
                            //'disabled' => 'disabled',
                            //),
                        ),

                    ),
                )
            );
        }

        // Let WordPress know to use our action
        //add_action( 'manage_events_posts_custom_column', 'events_custom_column_content',10,3);
        //add_filter('manage_events_posts_custom_column', array($this, 'events_custom_column_content'), 10, 3);

        $args = array(
            'has_archive' => true,
            'hierarchical' => true,
            'show_in_nav_menus' => true,
            'menu_icon' => 'dashicons-format-status',
            'rewrite' => array('slug' => 'venue'),
            'labels' => array('name' => __('Venue', 'cuztom'),
                'menu_name' => __('Venue', 'cuztom'),
                'add_new' => __('Add New Venue', 'cuztom'),
                'add_new_item' => __('Add New Venue', 'cuztom'),
                'all_items' => __('All Venue', 'cuztom'),
                'view' => __('View Venue', 'cuztom'),
                'view_item' => __('View Venue', 'cuztom'),
                'search_items' => __('Search Venue', 'cuztom'),
                'not_found' => __('No Venue Found', 'cuztom'),
                'not_found_in_trash' => __('No Venue found in Trash', 'cuztom')),
            //'supports' => array('title', 'editor'),
            'show_in_rest' => true,
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'show_admin_column' => true,
            'admin_column_sortable' => true,
            'admin_column_filter' => true,
        );

        $taxonomy = register_cuztom_taxonomy('wprem_venue', 'wprem_events', $args);

        $termmeta = register_cuztom_term_meta('data', 'wprem_venue', array(
            'fields' => array(
                array(
                    'id' => '_data_address',
                    'label' => 'Address',
                    'type' => 'text',
                ),
                array(
                    'id' => '_data_city',
                    'label' => 'City',
                    'type' => 'text',
                ),
                array(
                    'id' => '_data_province',
                    'label' => 'Province',
                    'type' => 'text',
                ),
                array(
                    'id' => '_data_postal',
                    'label' => 'Postal Code',
                    'type' => 'text',
                ),
                array(
                    'id' => '_data_latitude',
                    'label' => 'Latitude',
                    'type' => 'text',
                ),
                array(
                    'id' => '_data_longitude',
                    'label' => 'Longitude',
                    'type' => 'text',
                ),
            ),
        ));

        $args_view = array('rewrite' => false,
            'show_ui' => true,
            'publicly_queryable' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'public' => false,
            'show_in_menu' => 'edit.php?post_type=wprem_events',
            'labels' => array("name" => __('Events Views', 'cuztom'),
                "add_new_item" => __('Events View', 'cuztom'),
                'edit_item' => __('Edit Events View', 'cuztom')),
            'supports' => array('title'),
        );

        $view_show_arr = array(
            array(
                'id' => '_data_show_title',
                'type' => 'checkbox',
                'label' => 'Show Title',
            ),
            array(
                'id' => '_data_link_title',
                'type' => 'checkbox',
                'label' => 'Link Title',
            ),
            array(
                'id' => '_data_show_from_date',
                'type' => 'checkbox',
                'label' => 'Show From Date',

            ),
            array(
                'id' => '_data_show_to_date',
                'type' => 'checkbox',
                'label' => 'Show To Date',
            ),
            array(
                'id' => '_data_show_from_time',
                'type' => 'checkbox',
                'label' => 'Show From Time',
            ),
            array(
                'id' => '_data_show_to_time',
                'type' => 'checkbox',
                'label' => 'Show To Time',
            ),
            array(
                'id' => '_data_show_address',
                'type' => 'checkbox',
                'label' => 'Show Address',
            ),
            array(
                'id' => '_data_show_desc',
                'type' => 'checkbox',
                'label' => 'Show Description',
            ),
            array(
                'id' => '_data_show_map',
                'type' => 'checkbox',
                'label' => 'Show Map',
            ),

        );

        if (class_exists('woocommerce')) {
            $view_show_btn_arr = array(
                'id' => '_data_show_buy_button',
                'type' => 'checkbox',
                'label' => 'Show Buy Ticket Button',
            );

            array_push($view_show_arr, $view_show_btn_arr);
        }

        $event_views = register_cuztom_post_type('wprem_events_view', $args_view);
        $events_views_box = register_cuztom_meta_box('data', 'wprem_events_view',
            array(
                'title' => __('Events View Settings', 'cuztom'),
                'fields' => array(

                    array(
                        'id' => '_data_tabs',
                        'type' => 'tabs',
                        'panels' => array(
                            array(
                                'id' => '_data_tabs_panel_1',
                                'title' => 'Layout',
                                'fields' => array(
                                    array(
                                        'id' => '_data_select_columns',
                                        'type' => 'select',
                                        'label' => 'Layout',
                                        'options' => array(
                                            'list' => 'List View',
                                            //'single' => 'Single Centred',
                                            '2-column' => '2 Columns',
                                            '3-column' => '3 Columns',
                                            'calendar' => 'Calendar',
                                        ),
                                    ),
                                    //op_gen('link','Link to Profile'),
                                    array(
                                        'id' => '_data_select_ppp',
                                        'type' => 'select',
                                        'label' => __('Items Per Page', 'cuztom'),
                                        'options' => array(
                                            '-1' => 'All',
                                            '1' => '1',
                                            '2' => '2',
                                            '3' => '3',
                                            '4' => '4',
                                            '5' => '5',
                                            '6' => '6',
                                            '7' => '7',
                                            '8' => '8',
                                            '9' => '9',
                                            '10' => '10',
                                            '11' => '11',
                                            '12' => '12',
                                            '13' => '13',
                                            '14' => '14',
                                            '15' => '15',
                                            '16' => '16',
                                            '17' => '17',
                                            '18' => '18',
                                            '19' => '19',
                                            '20' => '20',
                                            '25' => '25',
                                            '30' => '30',
                                            '35' => '35',
                                            '40' => '40',
                                            '45' => '45',
                                            '50' => '50',
                                            '55' => '55',
                                            '60' => '60',
                                            '65' => '65',
                                            '70' => '70',
                                            '75' => '75',
                                            '80' => '80',
                                            '85' => '85',
                                            '90' => '90',
                                            '95' => '95',
                                            '100' => '100',

                                        ),
                                    ),
                                ),
                            ),

                            array(
                                'id' => '_data_tabs_panel_2',
                                'title' => 'Display',
                                'fields' => $view_show_arr,
                            ),
                        ),
                    ),
                ),
            )
        );
    }

    //Create Matching Ticket Product in Woocommerce
    public function save_ticket_info()
    {
        global $post;
        //if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        //if (defined('DOING_AJAX') && DOING_AJAX) return;

        //if($post->post_type!='wprem_events') return;
        if ($_POST['post_type'] != 'wprem_events') {
            return;
        }

        // if allowing woocommerce ticketing
        if (isset($_POST['cuztom']['_data_ticket_active'])) {
            if (class_exists('woocommerce')) {
                // check if woocommerce product id exist
                $prdID = get_post_meta($post->ID, '_data_ticket_woocommerce_product_id', true);
                if (!empty($prdID)) {
                    $post_exists = $this->post_exist($prdID);
                    // add new
                    if (!$post_exists) {
                        $this->add_new_woocommerce_product($post->ID);
                    } else {
                        $this->update_woocommerce_product($prdID, $post->ID);
                    }
                } else {
                    $this->add_new_woocommerce_product($post->ID);
                }

            } else {
                //add_action('admin_notices', $plugin_admin, 'wc_events_warning');
                //$this->wc_events_warning();
            }

        }
    }

    // ADD NEW matching woocommerce product
    public function add_new_woocommerce_product($post_id)
    {
        $user_ID = get_current_user_id();
        $_date_addition = (!empty($_POST['cuztom']['_data_sdate'])) ? ' - ' . $_POST['cuztom']['_data_sdate'] : null;

        $__sku = !empty($_REQUEST['cuztom']['_sku']) ? '(' . $_REQUEST['cuztom']['_sku'] . ') ' : '';
        $event_title = (!empty($_REQUEST['post_title']) ? $_REQUEST['post_title'] : (!empty($_POST['event_name']) ? $_POST['event_name'] : ''));

        // abort if essential information is not present
        if (empty($_date_addition) && empty($__sku) && empty($event_title)) {
            return false;
        }

        $post = array(
            'post_author' => $user_ID,
            'post_content' => "Event Ticket", //(!empty($_REQUEST['_tx_desc']))? $_REQUEST['_tx_desc']: "Event Ticket",
            'post_status' => "publish",
            'post_title' => 'Ticket: ' . $__sku . $event_title . $_date_addition,
            'post_type' => "product",
        );

        // unhook this function so it doesn't loop infinitely
        //remove_action( 'save_post', 'save_ticket_info',10,2 );

        // create woocommerce product
        $woo_post_id = wp_insert_post($post);

        // re-hook this function
        //add_action( 'save_post', 'save_ticket_info',10,2 );

        if ($woo_post_id) {

            //wp_set_object_terms( $woo_post_id, $product->model, 'product_cat' );
            wp_set_object_terms($woo_post_id, $_REQUEST['cuztom']['_data_ticket_type'], 'product_type');

            //Update Hidden variable
            update_post_meta($post_id, '_data_ticket_woocommerce_product_id', $woo_post_id);
            $_POST['cuztom']['_data_ticket_woocommerce_product_id'] = $woo_post_id;
            $this->save_product_meta_values($woo_post_id, $post_id);

            // add category
            $this->assign_woo_cat($woo_post_id);

            // copy featured event image
            $ft_img_id = get_post_thumbnail_id($post_id);
            if (!empty($ft_img_id)) {
                set_post_thumbnail($post_id, $ft_img_id);
            }

        }
    }

    // Save woocommerce product meta values
    public function save_product_meta_values($woo_post_id, $post_id)
    {

        $update_metas = array(
            '_sku' => $_POST['cuztom']['_data_ticket_sku'],
            '_regular_price' => $_POST['cuztom']['_data_ticket_regular_price'],
            //'_price'=>'_price',
            '_sale_price' => $_POST['cuztom']['_data_ticket_sale_price'],
            '_visibility' => 'hidden', //$_POST['cuztom']['_data_ticket_active'],
            '_virtual' => 'yes',
            '_stock_status' => 'instock',
            '_manage_stock' => 'no',
            '_stock' => '',
            '_backorders' => 'no',
            '_virtual' => 'yes',
            '_sold_individually' => 'yes',
            '_downloadable' => 'no',

            //'evotx_price'=>'_data_ticket'.'_regular_price',
            //'_tx_desc'=>'_tx_desc',
            //'_tx_text'=>'_tx_text',
            '_eventid' => $post_id,
        );

        foreach ($update_metas as $umeta => $umetav) {
            if ($umeta == '_regular_price' || $umeta == '_sale_price' || $umeta == '_price') {
                if (empty($umetav)) {
                    continue;
                }

                if ($umeta == '_regular_price') {
                    $price = str_replace("$", "", $umetav);
                    update_post_meta($woo_post_id, $umeta, $price);
                    update_post_meta($woo_post_id, '_price', $price);
                } elseif ($umeta == '_sale_price') {
                    $price = str_replace("$", "", $umetav);
                    update_post_meta($woo_post_id, $umeta, $price);
                    update_post_meta($woo_post_id, '_price', $price);
                } else {
                    update_post_meta($woo_post_id, $umeta, str_replace("$", "", $umetav));
                }
            } else if ($umeta == '_eventid') {
                update_post_meta($woo_post_id, $umeta, $post_id);
            } else if ($umeta == '_visibility') {
                update_post_meta($woo_post_id, $umeta, $umetav);
                //update_post_meta($post_id, $umeta, $umetav);
            } else if ($umeta == '_virtual') {
                update_post_meta($woo_post_id, $umeta, $umetav);
            } //else if($umeta == 'evotx_price'){
            //    $__price = (!empty($umetav)) ? $umetav : ' ' ;
            //    update_post_meta($post_id, $umeta, $__price);
            //}
            else if ($umeta == '_stock_status') {
                $_stock_status = (!empty($umetav) && $umetav == 'yes') ? 'outofstock' : 'instock';
                update_post_meta($woo_post_id, $umeta, $_stock_status);
            } else if ($umeta == '_sku') {
                // if no sku provided generate random number for sku
                $sku = (!empty($umetav)) ? $umetav : $post_id . '-' . $woo_post_id; //,rand(2000,4000);
                update_post_meta($woo_post_id, $umeta, $sku);
            } else {
                //if(isset($umetav))
                update_post_meta($woo_post_id, $umeta, $umetav);
            }
        }

        // save event image as WC product ft image
        //if(isset($_POST['_tix_image_id'])){
        //    set_post_thumbnail($woo_post_id, $_POST['_tix_image_id']);
        //}
    }
    // create and assign woocommerce product category for foodpress items
    public function assign_woo_cat($post_id)
    {

        // check if term exist
        $terms = term_exists('Ticket', 'product_cat');
        if (!empty($terms) && $terms !== 0 && $terms !== null) {
            wp_set_post_terms($post_id, $terms, 'product_cat');

            //hide product for Woocommerce 3.x.x
            //$terms_arr = array( 'exclude-from-catalog', 'exclude-from-search' );
            //wp_set_object_terms( $post_id, $terms_arr, 'product_visibility' );
        } else {
            // create term
            $new_termid = wp_insert_term(
                'Ticket', // the term
                'product_cat',
                array('slug' => 'ticket')
            );

            // assign term to woo product
            wp_set_post_terms($post_id, $new_termid, 'product_cat');

            //hide product for Woocommerce 3.x.x
            //$terms_arr = array( 'exclude-from-catalog', 'exclude-from-search' );
            //wp_set_object_terms( $post_id, $terms_arr, 'product_visibility' );
        }

        //hide product for Woocommerce 3.x.x
        $terms_arr = array('exclude-from-catalog', 'exclude-from-search');
        wp_set_object_terms($post_id, $terms_arr, 'product_visibility');
    }

    // UPDATE woocommerce ticket product for event
    public function update_woocommerce_product($woo_post_id, $post_id)
    {
        //global $post;

        $user_ID = get_current_user_id();

        $post = array(
            'ID' => $woo_post_id,
            'post_author' => $user_ID,
            'post_status' => "publish",
            //'post_title' => $_REQUEST['post_title'],
            'post_type' => "product",
        );

        //if(!empty($_REQUEST['_tx_desc']))
        //$post['post_content'] = $_REQUEST['_tx_desc'];

        // create woocommerce product
        $woo_post_id = wp_update_post($post);

        //update_post_meta( $post_id, 'tx_woocommerce_product_id', $woo_post_id);
        //wp_set_object_terms( $woo_post_id, $product->model, 'product_cat' );

        wp_set_object_terms($woo_post_id, $_POST['cuztom']['_data_ticket_type'], 'product_type');

        $this->save_product_meta_values($woo_post_id, $post_id);
    }

    // check if post exist for a ID
    public function post_exist($ID)
    {
        global $wpdb;

        //$post_id = $ID;
        $post_exists = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE id = '" . $ID . "'", 'ARRAY_A');
        return $post_exists;
    }

    public function wc_events_warning()
    {
        //if($_POST['post_type'] != 'wprem_events')
        //    return;

        if (!class_exists('woocommerce')) {
            ?>
	        <div class="notice notice-error"><p><?php _e('Events Tickets need woocommerce plugin to function properly. Please install woocommerce', 'wprem_events');?></p></div>
	        <?php
return false;
        }
    }

    //Create Custom Column Labels for Event List
    public function events_modify_columns($columns)
    {

        // Remove unwanted publish date column
        $date = $colunns['date'];
        unset($columns['date']);

        // New columns to add to table
        $new_columns = array(
            'start_date' => __('Start', 'wprem_events'), // custom column added
            'end_date' => __('End', 'wprem_events'), // custom column added
            //'locations' => __('Locations'), // custom column added
            'date' => __('Date'), // existing column
        );

        // Combine existing columns with new columns
        $filtered_columns = array_merge($columns, $new_columns);

        // Return our filtered array of columns
        return $filtered_columns;
    }

    //Render custom column with Data for Events
    public function events_custom_column_content($column)
    {

        // Get the post object for this row so we can output relevant data
        global $post;
        //echo strtotime(get_post_meta($post->ID, '_data_sdate', true));
        // Check to see if $column matches our custom column names
        switch ($column) {

            case 'start_date':
                // Retrieve post meta
                $sdate = new DateTime();
                $sdate->setTimestamp(get_post_meta(get_the_ID(), '_data_sdate', true));
                //$start = strtotime(get_post_meta(get_the_ID(), '_data_sdate', true));
                //echo $start;
                // Echo output and then include break statement
                echo (!empty($sdate) ? $sdate->format('Y/m/d') : '');
                break;

            case 'end_date':
                // Retrieve post meta
                $edate = new DateTime();
                $edate->setTimestamp(get_post_meta(get_the_ID(), '_data_edate', true));

                // Echo output and then include break statement
                echo (!empty($edate) ? $edate->format('Y/m/d') : '');
                break;

                /*case 'locations' :
        // Retrieve post meta
        $location = get_field( 'locations', $post_id );

        // Echo output and then include break statement
        echo ( !empty( $location ) ? $location->post_title : '' );
        break;*/

        }
    }

    // Sort by custom column
    public function custom_event_admin_sort($columns)
    {

        $custom = array(
            'start_date' => 'sdate',
            'end_date' => 'edate',
        );
        return wp_parse_args($custom, $columns);
    }

    //Custom field Date column Sorting Woocommerce Order List

    public function manage_wp_posts_clauses($pieces, $query)
    {
        global $wpdb;

        if ($query->is_main_query() && isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'wprem_events') {

            $orderby = $query->get('orderby');
            $order = strtoupper($query->get('order'));
            if (!in_array($order, array('ASC', 'DESC'))) {
                $order = 'ASC';
            }

            switch ($orderby) {
                case 'sdate':
                    $pieces['join'] .= "LEFT JOIN $wpdb->postmeta pm ON pm.post_id = {$wpdb->posts}.ID AND pm.meta_key = '_data_sdate'";

                    $pieces['orderby'] = "pm.meta_value $order, " . $pieces['orderby'];

                    break;

                case 'edate':
                    $pieces['join'] .= "LEFT JOIN $wpdb->postmeta pm ON pm.post_id = {$wpdb->posts}.ID AND pm.meta_key = '_data_edate'";

                    $pieces['orderby'] = "pm.meta_value $order, " . $pieces['orderby'];

                    break;
            }
        }
        return $pieces;

    }

}
