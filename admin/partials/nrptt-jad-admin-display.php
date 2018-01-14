<?php

/**
 * @class       NRPTT_JAD_Admin_Display
 * @version	1.0.0
 * @package	nrptt-jad
 * @category	Class
 * @author      info@nrptt.org
 */
class NRPTT_JAD_Admin_Display {

    /**
     * Hook in methods
     * @since    1.0.0
     * @access   static
     */
    public static function init() {
        add_action('admin_menu', array(__CLASS__, 'add_settings_menu'));
    }

    /**
     * add_settings_menu helper function used for add menu for pluging setting
     * @since    1.0.0
     * @access   public
     */
    public static function add_settings_menu() {
        add_options_page('NRPTT Join and Donate Options', 'NRPTT JAD', 'manage_options', 'nrptt-jad-option', 
                         array(__CLASS__, 'nrptt_jad_options'));
    }

    /**
     * nrptt_jad_options helper will trigger hook and handle all the settings section
     * @since    1.0.0
     * @access   public
     */
    public static function nrptt_jad_options() {
        $setting_tabs = apply_filters('nrptt_jad_setting_tab', array('general' => __('General'), 'info' => __('Info')));
        $current_tab = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';
        ?>
        <h2 class="nav-tab-wrapper">
            <?php
            foreach ($setting_tabs as $name => $label)
                echo '<a href="' . admin_url('admin.php?page=nrptt-jad-option&tab=' . $name) . '" class="nav-tab ' . ( $current_tab == $name ? 'nav-tab-active' : '' ) . '">' . $label . '</a>';
            ?>
        </h2>
        <?php
        foreach ($setting_tabs as $setting_tabkey => $setting_tabvalue) {
            switch ($setting_tabkey) {
                case $current_tab:
                    do_action('nrptt_jad_' . $setting_tabkey . '_setting_save_field');
                    do_action('nrptt_jad_' . $setting_tabkey . '_setting');
                    break;
            }
        }
    }

    public static function display_short_content($content, $numberOfWords = 10) {
        if( isset($content) && !empty($content) ) {
            $contentWords = substr_count($content," ") + 1;
            $words = explode(" ",$content,($numberOfWords+1));
            if( $contentWords > $numberOfWords ){
                $words[count($words) - 1] = '...';
            }
            $excerpt = join(" ",$words);
            return $excerpt;
        }
    }

}

NRPTT_JAD_Admin_Display::init();
