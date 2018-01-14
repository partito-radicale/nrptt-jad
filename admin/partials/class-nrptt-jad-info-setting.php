<?php

class NRPTT_JAD_Info_Setting {
    public static function init() {
        add_action('nrptt_jad_info_setting', array(__CLASS__, 'info_setting'));
    }
    public static function info_setting() {

        if(!current_user_can('manage_options')){
            wp_die('You do not have permission to access this settings page.');
        }
    
        echo '<div class="wrap">' ;
        echo '<h2>NRPTT Join and Donate: Settings v' . NRPTT_JAD_PLUGIN_VERSION . '</h2>';
        echo '<div id="poststuff"><div id="post-body">';
        echo '<div style="background: none repeat scroll 0 0 #ECECEC;border: 1px solid #CFCFCF;color: #363636;margin: 10px 0 15px;padding:15px;text-shadow: 1px 1px #FFFFFF;">
             For usage documentation and updates, please visit the plugin page at the following URL: ?!?!<br />
             <a href="https://www.tipsandtricks-hq.com/wordpress-easy-paypal-payment-or-donation-accept-plugin-120" target="_blank">https://www.tipsandtricks-hq.com/wordpress-easy-paypal-payment-or-donation-accept-plugin-120</a>
             </div>';
        echo '</div>'; // .post-body
        echo '</div>'; // .poststuff
        echo '</div>'; // .wrap
        echo '</div>';
    }
}

NRPTT_JAD_Info_Setting::init();

