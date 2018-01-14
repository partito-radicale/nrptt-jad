<?php

/**
 * @class       NRPTT_JAD_Admin
 * @version	1.0.0
 * @package	nrptt-jad
 * @category	Class
 * @author      info@nrptt.org
 */
class NRPTT_JAD_Admin {

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
     * @var      string    $plugin_name       The name of this plugin.
     * @var      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
    }

    /**
     * Register the stylesheets for the Dashboard.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         *
         * An instance of this class should be passed to the run() function
         * defined in NRPTT_JAD_Admin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The NRPTT_JAD_Admin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        // $screen = get_current_screen();
        // if ((isset($screen->id) && ($screen->id == 'nrptt_jad' || $screen->id == 'settings_page_nrptt-jad-option')) && (isset($screen->base) && ($screen->base == 'post' || $screen->id == 'settings_page_nrptt-jad-option' ))) {
        //     wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/nrptt-jad-admin.css', array(), $this->version, 'all');
        // }
    }

    public function admin_enqueue_scripts() {
        /**
         * add code prettify jquery
         */
        // global $post_type;
        // if ($post_type == "nrptt_jad") {
        //     wp_enqueue_script('run_prettify', 'https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js', array('jquery'), $this->version, true);
        //     wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/nrptt-jad-admin.js', array('jquery'), $this->version, true);
        //}
    }

    private function load_dependencies() {

        // /**
        //  * The class responsible for defining all actions that occur in the Dashboard for IPN Listing
        //  */
        // require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-nrptt-jad-post-types.php';

        // /**
        //  * The class responsible for defining all actions that occur in the Dashboard
        //  */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/nrptt-jad-admin-display.php';

        // /**
        //  * The class responsible for defining function for display Html element
        //  */
        // require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-nrptt-jad-html-output.php';

        /**
         * The class responsible for defining function for display general setting tab
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-nrptt-jad-general-setting.php';

        /**
         * The class responsible for defining function for display info tab
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-nrptt-jad-info-setting.php';
    }

}
