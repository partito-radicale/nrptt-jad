<?php

class NRPTT_JAD_General_Setting {
    public static function init() {
        add_action('nrptt_jad_general_setting', array(__CLASS__, 'general_setting'));
    }
    public static function general_setting() {
        $options = array(
            array( 'input',  __('NRPTT Paypal Email address','nrptt-jad'), 'nrptt_pp_payment_email', __('This is the Paypal Email address where the payments will go','nrptt-jad')  , 'type="text" size="35"' ),
            array( 'select', __('Paypal Platform','nrptt-jad'), 'paypal_payment_platform', __('Working platform for paypal (Test/Production).','nrptt-jad') , 
                   array( 'TEST' => __('Sandbox','nrptt-jad') , 'PROD' => __('Production','nrptt-jad') ) ),            
            array( 'select' , __('Choose Payment Currency','nrptt-jad'), 'paypal_payment_currency', __('This is the currency for your visitors to make Payments or Donations in.','nrptt-jad'), 
                   array( 'GBP' => 'Pound Sterling' , 'EUR' => 'Euro', "AUD" => 'Australian Dollar', "CAD" => 'Canadian Dollar', "NZD" => 'New Zealand Dollar', "HKD" => 'Hong Kong Dollar' ), ),
            array( 'input', __('Return URL from PayPal','nrptt-jad'), 'wp_pp_return_url', __('Enter a return URL (could be a Thank You page). PayPal will redirect visitors to this page after Payment.','nrptt-jad'), 'type="text" size="60"', ),
            array( 'input', __('Cancel URL from PayPal','nrptt-jad'), 'wp_pp_cancel_url', __('Enter a cancel URL PayPal will redirect visitors to this page if they click on the cancel link.','nrptt-jad'), 'type="text" size="60"', ),
        );


        if(!current_user_can('manage_options')){
            wp_die(__('You do not have permission to access this settings page.','nrptt-jad'));
        }
    
        if (isset($_POST['info_update'])) {
            $nonce = $_REQUEST['_wpnonce'];
            if ( !wp_verify_nonce($nonce, 'wp_accept_pp_payment_settings_update')){
                wp_die(__('Error! Nonce Security Check Failed! Go back to settings menu and save the settings again.','nrptt-jad'));
            }

            update_option('nrptt_jad_widget_title_name', sanitize_text_field(stripslashes($_POST["nrptt_jad_widget_title_name"])));
            update_option('nrptt_pp_payment_email', sanitize_email($_POST["nrptt_pp_payment_email"]));
            update_option('paypal_payment_platform', sanitize_text_field($_POST["paypal_payment_platform"]));
            update_option('paypal_payment_currency', sanitize_text_field($_POST["paypal_payment_currency"]));
            update_option('wp_pp_return_url', esc_url_raw(sanitize_text_field($_POST["wp_pp_return_url"])));        
            $cancel_url = esc_url_raw(sanitize_text_field($_POST["wp_pp_cancel_url"]));
            if(empty($cancel_url)){
                $cancel_url = home_url();
            }
            update_option('wp_pp_cancel_url', $cancel_url);

            echo '<div id="message" class="updated fade"><p><strong>';
            echo __('Options Updated!','nrptt-jad');
            echo '</strong></p></div>';
        }

        echo '<div class="wrap">' ;
        echo '<h2>' . __('NRPTT Join and Donate','nrptt-jad') . ': ' . __('Settings','nrptt-jad') . ' v' . NRPTT_JAD_PLUGIN_VERSION . '</h2>';
        echo '<div id="poststuff"><div id="post-body">';
        echo '<div style="background: none repeat scroll 0 0 #ECECEC;border: 1px solid #CFCFCF;color: #363636;margin: 10px 0 15px;padding:15px;text-shadow: 1px 1px #FFFFFF;">';
        echo __('For usage documentation and updates, please visit the plugin page at the following URL:','nrptt-jad') . '<br />
             <a href="https://www.nrptt.org/nrptt-join-and-donate-wordpress-plugin" target="_blank">https://www.nrptt.org/nrptt-join-and-donate-wordpress-plugin</a>
             </div>';
        echo '<form method="post" action="">';
        wp_nonce_field('wp_accept_pp_payment_settings_update');
        echo '<input type="hidden" name="info_update" id="info_update" value="true" />';
        echo '<div class="postbox">';
        echo '<div class="inside">';
        echo '<table class="form-table">';
        foreach ($options as $i => $info) {
            echo ' <tr valign="top"><td width="25%" align="left"><strong>' . $info[1] . ':</strong></td><td align="left">';
            if ($info[0] === 'input') {
                echo '<input name="' . $info[2] . '"' . $info[4] . ' value="' . esc_attr(get_option($info[2])) . '"/>';
            } elseif ( $info[0] === 'select') {
                echo '<select id="' . $info[2] . '" name="'. $info[2]. '">';
                foreach ( $info[4] as $k => $val) {
                    echo '<option value="' . $k . '" ';
                    if (get_option($info[2]) == $k) echo " selected ";
                    echo ' >' . $val . '</option>';                }
                echo "</select>";
            }
            echo '<br/><i>' . $info[3] . '</i><br/>';
            echo '</td></tr>';
        }
        echo '</table>';
        echo '</div>'; // .inside
        echo '</div>'; // .postbox
        echo '<div class="submit"><input type="submit" class="button-primary" name="info_update" value="';
        echo __('Update options','nrptt-jad');  
        echo '&raquo;" /></div>';
        echo '</div>'; // .wrap
        echo '</div>';
    }
}

NRPTT_JAD_General_Setting::init();

