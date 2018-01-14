<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    nrptt-jad
 * @subpackage nrptt-jad/includes
 * @author     info@nrptt.org
 */
class NRPTT_JAD {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      NRPTT_JAD_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the Dashboard and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'nrptt-jad';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_constants();
        $this->define_public_hooks();

        // register API endpoints
        add_action('init', array($this, 'add_endpoint'), 0);
        // handle nrptt-jad-api endpoint requests
        add_action('parse_request', array($this, 'handle_api_requests'), 0);
        // Create folder and file if not exist
        add_action('init', array($this, 'create_required_files'), 0);

        // add_action('nrptt_jad_api_ipn_handler', array($this, 'nrptt_jad_api_ipn_handler'));
        
        /**
         * Add action links
         * http://stackoverflow.com/questions/22577727/problems-adding-action-links-to-wordpress-plugin
         */
        $prefix = is_network_admin() ? 'network_admin_' : '';
        add_filter("{$prefix}plugin_action_links_" . NRPTT_JAD_PLUGIN_BASENAME, array($this, 'plugin_action_links'), 10, 4);
    }

    /**
     * Return the plugin action links.  This will only be called if the plugin
     * is active.
     *
     * @since 1.0.0
     * @param array $actions associative array of action names to anchor tags
     * @return array associative array of plugin action links
     */
    public function plugin_action_links($actions, $plugin_file, $plugin_data, $context) {
        $custom_actions = array(
            'configure' => sprintf('<a href="%s">%s</a>', admin_url('options-general.php?page=nrptt-jad-option'), __('Configure', 'nrptt-jad')),
            'docs' => sprintf('<a href="%s" target="_blank">%s</a>', 'http://www.angelleye.com/category/docs/nrptt-jad/?utm_source=nrptt_jad&utm_medium=docs_link&utm_campaign=nrptt_jad', __('Docs', 'nrptt-jad')),
            'support' => sprintf('<a href="%s" target="_blank">%s</a>', 'http://wordpress.org/support/plugin/nrptt-jad/', __('Support', 'nrptt-jad')),
            'review' => sprintf('<a href="%s" target="_blank">%s</a>', 'http://wordpress.org/support/view/plugin-reviews/nrptt-jad', __('Write a Review', 'nrptt-jad')),
        );

        // add the links to the front of the actions list
        return array_merge($custom_actions, $actions);
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - NRPTT_JAD_Loader. Orchestrates the hooks of the plugin.
     * - NRPTT_JAD_i18n. Defines internationalization functionality.
     * - NRPTT_JAD_Admin. Defines all hooks for the dashboard.
     * - NRPTT_JAD_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-nrptt-jad-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-nrptt-jad-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the Dashboard.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-nrptt-jad-admin.php'; // ?

        /**
         * The class responsible for defining all function related to log file
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-nrptt-jad-logger.php';

        /**
         * The class responsible for defining all action for logger
         * side of the site.
         */
        // require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-nrptt-jad-paypal-helper.php';

        /**
         * The class responsible for defining all action for IPN forwarder related functon
         * side of the site.
         */
        //require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-nrptt-jad-paypal-ipn-forwarder.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-nrptt-jad-public.php'; // ?
        $this->loader = new NRPTT_JAD_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the NRPTT_JAD_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new NRPTT_JAD_i18n();
        $plugin_i18n->set_domain($this->get_plugin_name());

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the dashboard functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new NRPTT_JAD_Admin($this->get_plugin_name(), $this->get_version());
        // $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        // $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'admin_enqueue_scripts');
        //$this->loader->add_action('posts_where_request', $plugin_admin, 'nrptt_jad_modify_wp_search');
        //$this->loader->add_action('post_row_actions', $plugin_admin, 'nrptt_jad_remove_row_actions', 10, 2);
        //$this->loader->add_action( 'delete_post', $plugin_admin, 'nrptt_jad_remove_postmeta', 10 );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.6.7
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new NRPTT_JAD_Public($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('the_posts', $plugin_public, 'nrptt_jad_load_shortcode_asset', 10, 1);
        // $this->loader->add_action('wp', $plugin_public, 'nrptt_jad_private_ipn_post', 10);
        
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    NRPTT_JAD_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * API request - Trigger any API requests
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    public function handle_api_requests() {
        global $wp;

        if (isset($_GET['action']) && $_GET['action'] == 'nrptt_handler') {
            $wp->query_vars['NRPTT_JAD'] = $_GET['action'];
        }

        // nrptt-jad-api endpoint requests
        if (!empty($wp->query_vars['NRPTT_JAD'])) {

            // Buffer, we won't want any output here
            ob_start();

            // Get API trigger
            $api = strtolower(esc_attr($wp->query_vars['NRPTT_JAD']));

            // Trigger actions
            do_action('nrptt_jad_api_' . $api);

            // Done, clear buffer and exit
            ob_end_clean();
            die('1');
        }
    }

    /**
     * add_endpoint function.
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    public function add_endpoint() {

        // nrptt-jad API for PayPal gateway IPNs, etc
        add_rewrite_endpoint('NRPTT_JAD', EP_ALL);
    } 

    // public function nrptt_jad_api_ipn_handler() {

    //     /**
    //      * The class responsible for defining all actions related to paypal ipn listener 
    //      */
    //     require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-nrptt-jad-paypal-helper.php';
    //     $NRPTT_JAD_Paypal_Helper_Object = new NRPTT_JAD_Paypal_Helper();

    //     /**
    //      * The check_ipn_request function check and validation for ipn response
    //      */
    //     if ($NRPTT_JAD_Paypal_Helper_Object->check_ipn_request()) {
    //         $NRPTT_JAD_Paypal_Helper_Object->successful_request($IPN_status = true);
    //     } else {
    //         $NRPTT_JAD_Paypal_Helper_Object->successful_request($IPN_status = false);
    //     }
    // }

    /**
     * Define NRPTT_JAD Constants
     */
    private function define_constants() {
        if (!defined('NRPTT_JAD_LOG_DIR')) {
            define('NRPTT_JAD_LOG_DIR', ABSPATH . 'nrptt-jad-logs/');
        }
    }

    /**
     * Create folder and file if not exist
     *
     */
    public function create_required_files() {
        // Install files and folders for uploading files and prevent hotlinking
        $upload_dir = wp_upload_dir();

        $files = array(
            array(
                'base' => NRPTT_JAD_LOG_DIR,
                'file' => '.htaccess',
                'content' => 'deny from all'
            ),
            array(
                'base' => NRPTT_JAD_LOG_DIR,
                'file' => 'index.html',
                'content' => ''
            )
        );

        foreach ($files as $file) {
            if (wp_mkdir_p($file['base']) && !file_exists(trailingslashit($file['base']) . $file['file'])) {
                if ($file_handle = @fopen(trailingslashit($file['base']) . $file['file'], 'w')) {
                    fwrite($file_handle, $file['content']);
                    fclose($file_handle);
                }
            }
        }
    }

}
