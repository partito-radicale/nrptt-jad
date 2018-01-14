<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    nrptt-jad
 * @subpackage nrptt-jad/includes
 * @author     info@nrptt.org
 */
class NRPTT_JAD_i18n {

    /**
     * The domain specified for this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $domain    The domain identifier for this plugin.
     */
    private $domain;

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {


        $locale = apply_filters('plugin_locale', get_locale(), $this->domain);

        load_textdomain($this->domain, WP_LANG_DIR . '/' . $this->domain . '/' . $this->domain . '-' . $locale . '.mo');

        load_plugin_textdomain(
                $this->domain, false, NRPTT_JAD_PLUGIN_LOCALE . '/languages/'
        );
    }

    /**
     * Set the domain equal to that of the specified domain.
     *
     * @since    1.0.0
     * @param    string    $domain    The domain that represents the locale of this plugin.
     */
    public function set_domain($domain) {
        $this->domain = $domain;
    }

}
