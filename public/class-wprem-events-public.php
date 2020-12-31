<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Wprem_Events
 * @subpackage Wprem_Events/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wprem_Events
 * @subpackage Wprem_Events/public
 * @author     Imran Lakhani <imran.lakhani@yp.ca>
 */
define('UI_VERSION', '1.11'); //jQuery 1.11.x
class Wprem_Events_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wprem-events-public.css', array(), $this->version, 'all');

        wp_enqueue_style('fullcalendar', plugin_dir_url(__FILE__) . 'css/main.css', array(), $this->version, 'all');

        //wp_enqueue_style( 'fullcalendar', plugin_dir_url( __FILE__ ) . 'css/fullcalendar.min.css', array(), $this->version, 'all' );

        /*wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jquery-ui/smoothness/theme.css', array(), $this->version, 'all' );*/

        $min = '.min'; //defined('WP_DEBUG') && WP_DEBUG ? '':'.min';
        $_theme = 'custom'; //get_option('wpfc_theme_css');

        if (preg_match('/\.css$/', $_theme)) {
            //user-defined style within the themes/themename/plugins/wp-fullcalendar/ folder
            //if you're using jQuery UI Theme-Roller, you need to include the jquery-ui-css framework file too, you could do this using the @import CSS rule or include it all in your CSS file
            if (file_exists(get_stylesheet_directory() . "/plugins/wprem-events/public/css/" . $_theme)) {
                $_theme_css = get_stylesheet_directory_uri() . "/plugins/wprem-events/public/css/" . $_theme;
                wp_deregister_style('jquery-ui');
                wp_enqueue_style($this->plugin_name, $_theme_css, array(), $this->version);
            }
        } elseif (!empty($_theme)) {
            //We'll find the current jQuery UI version and attempt to load the right version of jQuery UI, otherwise we'll load the default. This allows backwards compatability from 3.6 onwards.
            global $wp_scripts;

            $jquery_ui_version = preg_replace('/\.[0-9]+$/', '', $wp_scripts->registered['jquery-ui-core']->ver);
            if ($jquery_ui_version != UI_VERSION) {
                $jquery_ui_css_versions = glob($plugin_path = plugin_dir_path(__FILE__) . "css/jquery-ui-" . $jquery_ui_version . '*', GLOB_ONLYDIR);

                if (!empty($jquery_ui_css_versions)) {
                    //use backwards compatible theme
                    $jquery_ui_css_folder = str_replace(plugin_dir_path(__FILE__), '', array_pop($jquery_ui_css_versions));
                    $jquery_ui_css_uri = plugins_url(trailingslashit($jquery_ui_css_folder) . $_theme . "/jquery-ui$min.css", __FILE__);
                    $_theme_css = plugins_url(trailingslashit($jquery_ui_css_folder) . $_theme . '/theme.css', __FILE__);
                }
            }

            if (empty($_theme_css)) {
                //use default theme
                $jquery_ui_css_uri = plugins_url('/css/jquery-ui/' . $_theme . "/jquery-ui$min.css", __FILE__);
                $_theme_css = plugins_url('/css/jquery-ui/' . $_theme . '/theme.css', __FILE__);
                //echo 'here '.$_theme_css;
            }
            if (!empty($_theme_css)) {
                wp_deregister_style('jquery-ui');
                wp_enqueue_style('jquery-ui', $jquery_ui_css_uri, array(), $this->version);
                wp_enqueue_style('jquery-ui-theme', $_theme_css, array(), $this->version);
            }
        }

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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
        //if ( is_page( array( 'my-events'))){
        wp_enqueue_script('fullcalendar', plugin_dir_url(__FILE__) . 'js/main.js', array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position', 'jquery-ui-selectmenu'), $this->version, true);

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wprem-events-public.js', array('jquery'), $this->version, true);
        //}

        //wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/moment.min.js', array( 'jquery' ), $this->version, true );

    }

    public function single_event_content($content)
    {
        global $post;
        if (is_singular('wprem_events')) {
            $content = do_shortcode('[wp_events id=' . get_the_ID() . ']');
        } elseif (is_post_type_archive('wprem_events')) {
            $content = do_shortcode('[wp_events]');
        }
        return $content;
    }

    // create shortcode to list
    public function events_list_shortcode($atts)
    {
        ob_start();
        global $post, $v_id, $query;
        // define attributes and their defaults
        extract(shortcode_atts(array(
            'type' => 'wprem_events',
            'order' => '',
            'orderby' => '',
            'display' => '',
            'posts_per_page' => -1,
            'view' => '',
            'id' => '',
        ), $atts));
        $v_id = $view;
        //if (isset($view))
        $vu = get_post_custom($v_id);
        //print_r($vu);

        $ppp = isset($vu["_data_select_ppp"][0]) ? $vu["_data_select_ppp"][0] : 1;

        Wprem_Events_Public::localize_script();

        $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

        /*$options = array(
        'post_type' => 'wprem_events',
        'post_status' => 'publish',
        'meta_key' => '_data_sdate',
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'posts_per_page' => $ppp,
        'paged' => $paged,
        //'display' => $display,
        //'view' => $view,
        'p' => $id,
        'meta_query' => array(
        array(
        'key' => '_data_edate',
        'value'   => time(),
        'compare' => '>'
        ),
        ),
        );*/
        $active = array(
            array(
                'key' => '_data_edate',
                'value' => time(),
                'compare' => '>',
            ),
        );

        $options = array(
            'post_type' => 'wprem_events',
            'post_status' => 'publish',
            'meta_key' => '_data_sdate',
            'orderby' => 'meta_value',
            'order' => $order,
            'posts_per_page' => $ppp,
            'paged' => $paged,
            'view' => $view,
            'p' => $id,
            'meta_query' => $display == 'active' ? $active : '',
        );

        wp_reset_query();
        $query = new WP_Query($options);
        if ($query->have_posts()) {

            //print_r(isset($vu['_data_show_title'][0]));
            if (isset($vu['_data_show_title'][0])) {
                $showtitle = $vu['_data_show_title'][0] == 'on' ? 1 : 0;
            } else {
                $showtitle = 0;
            }

            if (isset($vu['_data_link_title'][0])) {
                $showlink = $vu['_data_link_title'][0] == 'on' ? 1 : 0;
            } else {
                $showlink = 0;
            }

            if (isset($vu['_data_show_from_date'][0])) {
                $showfromdate = $vu['_data_show_from_date'][0] == 'on' ? 1 : 0;
            } else {
                $showfromdate = 0;
            }

            if (isset($vu['_data_show_to_date'][0])) {
                $showtodate = $vu['_data_show_to_date'][0] == 'on' ? 1 : 0;
            } else {
                $showtodate = 0;
            }

            if (isset($vu['_data_show_from_time'][0])) {
                $showfromtime = $vu['_data_show_from_time'][0] == 'on' ? 1 : 0;
            } else {
                $showfromtime = 0;
            }

            if (isset($vu['_data_show_to_time'][0])) {
                $showtotime = $vu['_data_show_to_time'][0] == 'on' ? 1 : 0;
            } else {
                $showtotime = 0;
            }

            if (isset($vu['_data_show_address'][0])) {
                $showaddress = $vu['_data_show_address'][0] == 'on' ? 1 : 0;
            } else {
                $showaddress = 0;
            }

            if (isset($vu['_data_show_desc'][0])) {
                $showdescription = $vu['_data_show_desc'][0] == 'on' ? 1 : 0;
            } else {
                $showdescription = 0;
            }

            if (isset($vu['_data_show_map'][0])) {
                $showmap = $vu['_data_show_map'][0] == 'on' ? 1 : 0;
            } else {
                $showmap = 0;
            }

            if (class_exists('woocommerce')) {
                $showbuybutton = $vu['_data_show_buy_button'][0] == 'on' ? 1 : 0;
            }

            $event = array();

            ?>

	    	<div class="<?php echo $this->plugin_name ?>_container">
				<?php
if ($vu['_data_select_columns'][0] != 'calendar') {
                ?>
					<div id="events-list" class="<?php echo $this->plugin_name ?>">

						<div id="event-wrap" class="wprem_inner">
							<?php
//pagination
                Wprem_Events_Public::bootstrap_paginate_links();

                if (class_exists('woocommerce') && $showbuybutton == 1) {?>
						<!-- Display add to cart successful notification -->
						<?php do_action('woocommerce_before_single_product');?>
						<?php }?>
						<div id="post-<?php the_ID();?>" <?php post_class('');?>>
							<div class="row">
				<?php

                $query = new WP_Query($options);
                while ($query->have_posts()): $query->the_post();
                    global $product;
                    if (class_exists('woocommerce') && $showbuybutton == 1) {
                        $product = wc_get_product(get_post_meta(get_the_ID(), '_data_ticket_woocommerce_product_id', true));
                    }

                    $sdate = new DateTime();
                    if ($showfromdate == 1) {
                        $sdate->setTimestamp(get_post_meta(get_the_ID(), '_data_sdate', true));
                    }

                    $edate = new DateTime();
                    if ($showtodate == 1) {
                        $edate->setTimestamp(get_post_meta(get_the_ID(), '_data_edate', true));
                    }

                    $stime = new DateTime();
                    if ($showfromtime == 1) {
                        $data_stime = get_post_meta(get_the_ID(), '_data_stime', true);
                        if (!empty($data_stime)) {
                            $stime->setTimestamp($data_stime);
                        }
                    }

                    $etime = new DateTime();
                    if ($showtotime == 1) {
                        $etime->setTimestamp(get_post_meta(get_the_ID(), '_data_etime', true));
                    }

                    //Get the venue associate with it
                    $term_list = wp_get_post_terms(get_the_ID(), 'wprem_venue', array("fields" => "ids"));
                    if (sizeof($term_list) > 0) {
                        $address = get_term_meta($term_list[0], '_data_address', true);
                        $city = get_term_meta($term_list[0], '_data_city', true);
                        $province = get_term_meta($term_list[0], '_data_province', true);
                        $postal = get_term_meta($term_list[0], '_data_postal', true);
                        $lat = get_term_meta($term_list[0], '_data_latitude', true);
                        $long = get_term_meta($term_list[0], '_data_longitude', true);

                    }

                    if (class_exists('woocommerce') && $showbuybutton == 1) {
                        $event["title"] = $showtitle == 1 ? '<div class="wprem_title"><a href="' . get_the_permalink() . '">' . get_the_title() . '-' . $product->get_id() . '</a></div>' : '';
                    } elseif ($showtitle == 1 && $showlink == 1) {
                    $event["title"] = $showtitle == 1 ? '<span class="wprem_title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></span>' : '';
                } else {
                    $event["title"] = $showtitle == 1 ? '<span class="wprem_title">' . get_the_title() . '</span>' : '';
                }

                $event["from_date"] = '';
                if ($showfromdate == 1) {
                    $start = new DateTime($sdate->format('Y-m-d'));
                    $event["from_date"] = '<label class="wprem_label"></label><span class="wprem_date">' . $start->format('F d, Y') . '</span> ';
                }

                $event["to_date"] = '';
                if ($showtodate == 1) {
                    $end = new DateTime($edate->format('Y-m-d') . ' ' . $etime->format('H:i:s'));
                    $event["to_date"] = $showtodate == 1 ? '<span class="wprem_date">' . $end->format('F d, Y') . '</span>' : '';
                }

                $event["from_time"] = $showfromtime == 1 ? '<label class="wprem_label"></label><span class="wprem_time">' . $stime->format('g:i a') . '</span> ' : '';

                $event["to_time"] = $showtotime == 1 ? '<span class="wprem_time">' . $etime->format('g:i a') . '</span>' : '';

                $event["address"] = ($showaddress == 1 && sizeof($term_list) > 0) ? '<div><label class="wprem_label"></label><span class="wprem_address">' . $address . '</span>  <span class="wprem_city">' . $city . '</span>, <span class="wprem_province">' . $province . '</span> <span class="wprem_postalcode">' . $postal . '</span></div>' : '';

                $event["description"] = $showdescription == 1 ? '<span class="wprem_content">' . get_the_content() . '</span>' : '';

                $event["shortdescription"] = $showdescription == 1 ? '<div class="wprem_content">' . substr(get_the_content(), 0, 100) . '...' . '</div>' : '';

                $event["map"] = ($showmap == 1 && sizeof($term_list) > 0) ? '<div id="map-' . get_the_ID() . '" class="wprem_map" data-lat="' . $lat . '" data-lng="' . $long . '"></div>' : '';

                if (class_exists('woocommerce') && $showbuybutton == 1) {
                    $add_to_cart_link = esc_url($product->add_to_cart_url());
                    $button = sprintf('<button type="submit" data-product_id="%s" data-product_sku="%s" data-quantity="1" class="%s btn product_type_simple"><i class="fa fa-plus hidden-xs"></i> %s</button><div class="clear"></div>', esc_attr($product->get_id()),
                        esc_attr($product->get_sku()),
                        esc_attr(apply_filters('add_to_cart_class', 'add_to_cart_button')),
                        esc_html(__('Buy Ticket', 'woocommerce')));

                    $event["buy_button"] = '<div class="wprem_button"><form action="' . $add_to_cart_link . '" class="cart" method="post" enctype="multipart/form-data">' . woocommerce_quantity_input(array(), $product, false) . $button . '</form></div>';
                } else {
                    $event["buy_button"] = '';
                }

                // Which item to display first, need to code here
                $event_info = $event["from_date"] . ' - ' . $event["title"] . ' ' . $event["description"] . $event["from_time"] . $event["to_time"] . $event["address"] . $event["map"] . $event["buy_button"];

                $event_info_single = $event["title"] . $event["from_date"] . $event["to_date"] . $event["from_time"] . $event["to_time"] . $event["address"] . $event["description"] . $event["map"] . $event["buy_button"];

                switch ($vu['_data_select_columns'][0]) {
                    case 'list': ?>
								<?php if (is_singular('wprem_events')) {?>
										<div class="col-sm-12"><div id="post-<?php the_ID();?>" <?php post_class('');?>><?php echo $event_info_single; ?></div></div>
									<?php } else {?>
										<div class="col-sm-12"><div id="post-<?php the_ID();?>" <?php post_class('');?>><?php echo $event_info; ?></div></div>
									<?php }?>
								<?php break;

                    case '2-column': ?>
								<div class="child-2"><div id="post-<?php the_ID();?>" <?php post_class('');?>><?php echo $event_info; ?></div></div>
								<?php break;

                    case '3-column': ?>
								<div class="child-3"><div id="post-<?php the_ID();?>" <?php post_class('');?>><?php echo $event_info; ?></div></div>
							<?php break;

                        //case 'calendar': ?>
	            				<!--<div id='calendar'></div>-->
	            			<?php
//    break;
                }
                //$item++;
                endwhile;

                echo '</div></div>';
                //pagination
                Wprem_Events_Public::bootstrap_paginate_links();
                echo '</div></div>';
            } else {
                echo '<div id="calendar"></div>';
            }

            wp_reset_query();
            wp_reset_postdata();

            echo '</div>';

        } else {
            //echo '<div class="no-event">No Event found</div>';
        }
        $myvariable = ob_get_clean();
        return $myvariable;
    }

    public function get_bootstrap_paginate_links()
    {
        ob_start();

        global $query;

        $big = 999999999;
        $pagination = paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $query->max_num_pages,
            'type' => 'array',
            'prev_next' => true,
            'prev_text' => sprintf('%1$s', __('&laquo;', 'fl-automator')),
            'next_text' => sprintf('%1$s', __('&raquo;', 'fl-automator')),
        ));

        if (!empty($pagination)): ?>
		        <nav aria-label="Page navigation" class="text-center">
		        	<ul class="pagination">
		        		<?php foreach ($pagination as $key => $page_link): ?>
							<li class="<?php if (strpos($page_link, 'current') !== false) {echo 'active';}?>"><?php echo $page_link ?></li>
						<?php endforeach?>
					</ul>
				</nav>
		<?php endif;

        $links = ob_get_clean();
        return apply_filters('bootstap_paginate_links', $links);
    }

    public function bootstrap_paginate_links()
    {
        echo Wprem_Events_Public::get_bootstrap_paginate_links();
    }

    public function event_ajax()
    {

/*echo '[{"title":"Term One Begins","color":"","start":"2018-09-05","end":"2018-09-07","url":"https:\/\/academycanada.wpengine.com\/events\/term-one-begins\/","post_id":508},{"title":"Thanksgiving Day","color":"","start":"2018-10-08","end":"2018-10-08","url":"https:\/\/academycanada.wpengine.com\/events\/thanksgiving-day\/","post_id":1093},{"title":"Term 1 Ends","color":"","start":"2018-10-26","end":"2018-10-26","url":"https:\/\/academycanada.wpengine.com\/events\/term-1-ends\/","post_id":510},{"title":"Term 2 Begins","color":"","start":"2018-10-29","end":"2018-10-29","url":"https:\/\/academycanada.wpengine.com\/events\/term-2-begins\/","post_id":511}]';
die();*/
        global $post;
        $items = array();

        $color = "#ccc";

        if (isset($_REQUEST)) {
            $v = $_REQUEST['view'];
            $vu = get_post_custom($v);
        }

        if (isset($vu['_data_link_title'][0])) {
            $showlink = $vu['_data_link_title'][0] == 'on' ? 1 : 0;
        } else {
            $showlink = 0;
        }

        $options = array(
            'post_type' => 'wprem_events',
            'post_status' => 'publish',
            'mets_key' => '_data_sdate',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            //'posts_per_page' => $posts_per_page,
            //'paged' => $paged,
            //'p' => $id,
            /*'meta_query' => array(
        array(
        'key' => '_data_edate',
        'value'   => time(),
        'compare' => '>'
        ),
        ),*/
        );

        $query = new WP_Query($options);
        while ($query->have_posts()): $query->the_post();

            $title = get_the_title(); //$post->post_title;

            $sdate = new DateTime();
            $sdate->setTimestamp(get_post_meta(get_the_ID(), '_data_sdate', true));

            $edate = new DateTime();
            $edate->setTimestamp(get_post_meta(get_the_ID(), '_data_edate', true));

            $start_time = get_post_meta(get_the_ID(), '_data_stime', true);
            if ($start_time) {
                $stime = new DateTime();
                $stime->setTimestamp($start_time);
            }

            $end_time = get_post_meta(get_the_ID(), '_data_etime', true);
            if ($end_time) {
                $etime = new DateTime();
                $etime->setTimestamp($end_time);
            }
            $start = new DateTime($sdate->format('Y-m-d')); // .' ' .$stime->format('H:i:s'));
            $end = new DateTime($edate->format('Y-m-d')); // .' ' .$etime->format('H:i:s'));

            $item = array("title" => $title,
                "color" => '#ccc',
                "start" => $start->format('Y-m-d'),
                "end" => $end->format('Y-m-d'),
                "url" => $showlink == 1 ? get_permalink(get_the_ID()) : '',
                'post_id' => get_the_ID());

            $items[] = $item;
        endwhile;

        echo json_encode($items);
        die('');
    }

    /**
     * Called during AJAX request for qtip content for a calendar item
     */
    public function qtip_content()
    {
        $content = '';
        if (!empty($_REQUEST['post_id'])) {
            $post = get_post($_REQUEST['post_id']);
            if ($post->post_type == 'attachment') {
                $content = wp_get_attachment_image($post->ID, 'thumbnail');
            } else {
                $content = (!empty($post)) ? $post->post_content : '';
                /*if( get_option('wpfc_qtips_image',1) ){
            $post_image = get_the_post_thumbnail($post->ID, array(get_option('wpfc_qtip_image_w',75),get_option('wpfc_qtip_image_h',75)));
            if( !empty($post_image) ){
            $content = '<div style="float:left; margin:0px 5px 5px 0px;">'.$post_image.'</div>'.$content;
            }
            }*/
            }
        }
        echo apply_filters('wpfc_qtip_content', $content);
        die('');
    }

    public function localize_script()
    {
        global $v_id;
        $js_vars = array();
        $schema = is_ssl() ? 'https' : 'http';
        $js_vars['ajaxurl'] = admin_url('admin-ajax.php', $schema);
        $js_vars['data'] = 'event_ajax_callback';
        $js_vars['view'] = $v_id;
        $js_vars['pagination'] = 'pagination_ajax_callback';
        $js_vars['firstDay'] = 1; //get_option('start_of_week');
        $js_vars['wpfc_theme'] = 'smoothness'; //get_option('wpfc_theme_css'); ? true:false;
        $js_vars['wpfc_limit'] = 3; //get_option('wpfc_limit',3);
        $js_vars['wpfc_limit_txt'] = 'more ...'; //get_option('wpfc_limit_txt','more ...');
        $js_vars['month'] = date('m', current_time('timestamp'));
        $js_vars['year'] = date('Y', current_time('timestamp'));
        //FC options
        $js_vars['timeFormat'] = ''; //'h(:mm)A';//get_option('wpfc_timeFormat', 'h(:mm)t');
        $js_vars['defaultView'] = 'month'; //get_option('wpfc_defaultView', 'month');
        $js_vars['weekends'] = true; //get_option('wpfc_weekends',true) ? 'true':'false';
        $js_vars['header'] = new stdClass();
        $js_vars['header']->left = 'prev,next today';
        $js_vars['header']->center = 'title';
        $js_vars['header']->right = 'month,basicWeek,basicDay'; //implode(',', get_option('wpfc_available_views', array('month','basicWeek','basicDay')));
        //$js_vars['header'] = apply_filters('wpfc_calendar_header_vars', $js_vars['header']);
        //qtip options
        $js_vars['wpfc_qtips'] = true; //get_option('wpfc_qtips',true) == true;
        if ($js_vars['wpfc_qtips']) {
            $js_vars['wpfc_qtips_classes'] = 'ui-tooltip-default ui-tooltip-rounded';
            $js_vars['wpfc_qtips_style'] = 'default'; //get_option('wpfc_qtips_style','light');
            $js_vars['wpfc_qtips_my'] = 'top center'; //get_option('wpfc_qtips_my','top center');
            $js_vars['wpfc_qtips_at'] = 'bottom center'; //get_option('wpfc_qtips_at','bottom center');
            /*if( get_option('wpfc_qtips_rounded', false) ){
        $js_vars['wpfc_qtips_classes'] .= " ui-tooltip-rounded";
        }
        if( get_option('wpfc_qtips_shadow', true) ){
        $js_vars['wpfc_qtips_classes'] .= " ui-tooltip-shadow";
        }*/
        }
        //calendar translations
        //if ( is_page( array( 'my-events'))){
        wp_localize_script($this->plugin_name, 'event_obj', $js_vars);
        wp_enqueue_script($this->plugin_name);
        //}
    }

    public function register_events_venues()
    {
        register_rest_field('wprem_events', 'wprem_venue',
            array(
                'get_callback' => function ($comment_arr) {
                    $custom_fields = get_post_custom($comment_arr['id']);
                    return $custom_fields;
                },
            )
        );
    }

}
