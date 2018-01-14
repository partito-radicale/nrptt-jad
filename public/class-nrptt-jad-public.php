<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    nrptt-jad
 * @subpackage nrptt-jad/includes
 * @author     info@nrptt.org
 */
class NRPTT_JAD_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.6.7
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.6.7
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.6.7
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.6.7
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Paypal_Ipn_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Paypal_Ipn_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        // wp_enqueue_style($this->plugin_name . 'publicDataTablecss', '//cdn.datatables.net/1.10.7/css/jquery.dataTables.css', array(), $this->version, 'all');
        // wp_enqueue_style($this->plugin_name . 'publicDataTablecss', '//cdn.datatables.net/1.10.7/css/jquery.dataTables.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/nrptt-jad-public.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/nrptt-full-stripe.css', array(), $this->version, 'all');
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.6.7
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Paypal_Ipn_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Paypal_Ipn_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        // wp_enqueue_script($this->plugin_name . 'public-bn', plugin_dir_url(__FILE__) . 'js/nrptt-jad-public-bn.js', array('jquery'), $this->version, true);
         

    }

    public function enqueue_scripts_for_shortcode() {
        // wp_enqueue_script($this->plugin_name . 'FontAwesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array('jquery'), $this->version, true);

        // wp_enqueue_script($this->plugin_name . 'DataTablejs', '//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js', array('jquery'), $this->version, true);
        // wp_enqueue_script($this->plugin_name . 'DataTable', '//cdn.datatables.net/responsive/1.0.6/js/dataTables.responsive.js', array('jquery'), $this->version, true);
        // wp_enqueue_script($this->plugin_name . 'public', plugin_dir_url(__FILE__) . 'js/nrptt-jad-public.js', array('jquery'), $this->version, true);


// <i class="fa fa-cc-visa" aria-hidden="true"></i>
        // if (wp_script_is($this->plugin_name . '-plugin-script')) {
        //    wp_localize_script($this->plugin_name . 'DataTablejs', 'nrptt_jad_datatable', 'true');
        // }

        wp_enqueue_script($this->plugin_name . 'public-form', plugin_dir_url(__FILE__) . 'js/nrptt-jad-public-form.js', array('jquery'), $this->version, true);
    }

    private function load_dependencies() {

        /**
         * The class responsible for defining all actions that occur in the FrontEnd
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/nrptt-jad--public-display.php';
    }

    public function nrptt_jad_load_shortcode_asset($posts) {
        if (empty($posts)) {
            return $posts;
        }

        $found = false;

        foreach ($posts as $post) {
            if (strpos($post->post_content, '[nrptt_join') !== false || strpos($post->post_content, '[nrptt_donate') !== false) {
                $found = true;
                break;
            }
        }

        if ($found) {
            $this->enqueue_scripts_for_shortcode();
            $this->enqueue_styles();
        }
        return $posts;
    }
    
    // public function nrptt_jad_private_ipn_post() {
    //     try {
    //         if ( !is_admin() && ( is_post_type_archive( 'paypal_ipn' ) ||  is_tax( 'paypal_ipn_type' ) ) ) {
    //             global $wp_query;
    //             $wp_query->set_404();
    //             status_header( 404 );
    //             nocache_headers();
    //             wp_redirect( home_url() );
    //             exit();
    //         }
    //     } catch (Exception $ex) {

    //     }
    // }
}