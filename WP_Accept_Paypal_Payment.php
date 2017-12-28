<?php
/*
Plugin Name: NRPTT Join and Donate
Version: v0.0.1
Plugin URI: 
Author: Emmanuele Somma (hacked from Tips and Tricks HQ)
Author URI: https://www.tipsandtricks-hq.com/
Description: Plugin for donate and join NRPTT
License: GPL2
*/

//Slug - wpapp

if (!defined('ABSPATH')){//Exit if accessed directly
    exit;
}

define('NRPTT_JAD_PLUGIN_VERSION', '0.0.1');
define('NRPTT_JAD_PLUGIN_URL', plugins_url('', __FILE__));

include_once('nrptt_forms.php');
include_once('shortcode_view.php');
include_once('wpapp_admin_menu.php');
include_once('wpapp_paypal_utility.php');

function nrptt_jad_plugin_install() {
    // Some default options
    add_option('nrptt_pp_payment_email', get_bloginfo('admin_email'));
    add_option('paypal_payment_currency', 'EUR');
    add_option('wp_pp_payment_subject', 'NRPTT Join and Donate');
    add_option('wp_pp_payment_item1', 'Basic Service - $10');
    add_option('wp_pp_payment_value1', '10');
    add_option('wp_pp_payment_item2', 'Gold Service - $20');
    add_option('wp_pp_payment_value2', '20');
    add_option('wp_pp_payment_item3', 'Platinum Service - $30');
    add_option('wp_pp_payment_value3', '30');
    add_option('wp_paypal_widget_title_name', 'NRPTT Join and Donate');
    add_option('payment_button_type', 'https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif');
    add_option('wp_pp_show_other_amount', '-1');
    add_option('wp_pp_show_ref_box', '1');
    add_option('wp_pp_ref_title', 'Your Email Address');
    add_option('wp_pp_return_url', home_url());
    add_option('wp_pp_cancel_url', home_url());
}

register_activation_hook(__FILE__, 'nrptt_jad_plugin_install');

// Define shortcodes

add_shortcode('nrptt_join','nrptt_join_handler');
function nrptt_join_handler($args) { return nrptt_form_join($args); };

function nrptt_form_join($args) {
  ob_start();
  nrptt_join_pre_form($args);
  $output = ob_get_contents();
  ob_end_clean();
  $output .= nrptt_join_paypal_form($args);
  // $output .= nrptt_join_post_form($args);
  return $output;
};

add_shortcode('nrptt_donate','nrptt_donate_handler');
function nrptt_donate_handler($args) { return nrptt_form_donate($args); };





// was wp_paypal_payment_box_for_any_amount
add_shortcode('nrptt_pay', 'nrptt_pay_handler');
function nrptt_pay_handler($args) {
    $output = nrptt_jad_amt($args);
    return $output;
}

add_shortcode('wp_paypal_payment_box', 'wpapp_buy_now_button_shortcode');
function wpapp_buy_now_button_shortcode($args) {
    ob_start();
    wppp_render_paypal_button_form($args);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function Paypal_payment_accept() {
    $paypal_email = get_option('nrptt_pp_payment_email');
    $paypal_payment_platform = get_option('paypal_payment_platform');
    $payment_currency = get_option('paypal_payment_currency');
    $paypal_subject = get_option('wp_pp_payment_subject');

    $itemName1 = get_option('wp_pp_payment_item1');
    $value1 = get_option('wp_pp_payment_value1');
    $itemName2 = get_option('wp_pp_payment_item2');
    $value2 = get_option('wp_pp_payment_value2');
    $itemName3 = get_option('wp_pp_payment_item3');
    $value3 = get_option('wp_pp_payment_value3');
    $itemName4 = get_option('wp_pp_payment_item4');
    $value4 = get_option('wp_pp_payment_value4');
    $itemName5 = get_option('wp_pp_payment_item5');
    $value5 = get_option('wp_pp_payment_value5');
    $itemName6 = get_option('wp_pp_payment_item6');
    $value6 = get_option('wp_pp_payment_value6');
    $payment_button = get_option('payment_button_type');
    $wp_pp_show_other_amount = get_option('wp_pp_show_other_amount');
    $wp_pp_show_ref_box = get_option('wp_pp_show_ref_box');
    $wp_pp_ref_title = get_option('wp_pp_ref_title');
    $wp_pp_return_url = get_option('wp_pp_return_url');
    $wp_pp_cancel_url = get_option('wp_pp_cancel_url');

    /* === Paypal form === */
    $output = '';
    $output .= '<div id="accept_paypal_payment_form">';
    $paypal_url = "https://sandbox.paypal.com/cgi-bin/webscr";
    if ( $paypal_payment_platform === 'PROD' ) {
        $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
    }
    $output .= '<form action="' . $paypal_url . '" method="post" class="wp_accept_pp_button_form_classic">';
    $output .= '<input type="hidden" name="cmd" value="_xclick" />';
    $output .= '<input type="hidden" name="business" value="'.esc_attr($paypal_email).'" />';
    $output .= '<input type="hidden" name="item_name" value="'.esc_attr($paypal_subject).'" />';
    $output .= '<input type="hidden" name="currency_code" value="'.esc_attr($payment_currency).'" />';
    $output .= '<div class="wpapp_payment_subject"><span class="payment_subject"><strong>'.esc_attr($paypal_subject).'</strong></span></div>';
    $output .= '<select id="amount" name="amount" class="">';
    $output .= '<option value="'.esc_attr($value1).'">'.esc_attr($itemName1).'</option>';
    if (!empty($value2)) {
        $output .= '<option value="'.esc_attr($value2).'">'.esc_attr($itemName2).'</option>';
    }
    if (!empty($value3)) {
        $output .= '<option value="'.esc_attr($value3).'">'.esc_attr($itemName3).'</option>';
    }
    if (!empty($value4)) {
        $output .= '<option value="'.esc_attr($value4).'">'.esc_attr($itemName4).'</option>';
    }
    if (!empty($value5)) {
        $output .= '<option value="'.esc_attr($value5).'">'.esc_attr($itemName5).'</option>';
    }
    if (!empty($value6)) {
        $output .= '<option value="'.esc_attr($value6).'">'.esc_attr($itemName6).'</option>';
    }

    $output .= '</select>';

    // Show other amount text box
    if ($wp_pp_show_other_amount == '1') {
        $output .= '<div class="wpapp_other_amount_label"><strong>Other Amount:</strong></div>';
        $output .= '<div class="wpapp_other_amount_input"><input type="number" min="1" step="any" name="other_amount" title="Other Amount" value="" class="wpapp_other_amt_input" style="max-width:80px;" /></div>';
    }

    // Show the reference text box
    if ($wp_pp_show_ref_box == '1') {
        $output .= '<div class="wpapp_ref_title_label"><strong>'.esc_attr($wp_pp_ref_title).':</strong></div>';
        $output .= '<input type="hidden" name="on0" value="'.apply_filters('wp_pp_button_reference_name','Reference').'" />';
        $output .= '<div class="wpapp_ref_value"><input type="text" name="os0" maxlength="60" value="'.apply_filters('wp_pp_button_reference_value','').'" class="wp_pp_button_reference" /></div>';
    }

    $output .= '<input type="hidden" name="no_shipping" value="0" /><input type="hidden" name="no_note" value="1" /><input type="hidden" name="bn" value="TipsandTricks_SP" />';
    
    if (!empty($wp_pp_return_url)) {
        $output .= '<input type="hidden" name="return" value="' . esc_url($wp_pp_return_url) . '" />';
    } else {
        $output .='<input type="hidden" name="return" value="' . home_url() . '" />';
    }

    if (!empty($wp_pp_cancel_url)) {
        $output .= '<input type="hidden" name="cancel_return" value="' . esc_url($wp_pp_cancel_url) . '" />';
    }
    
    $output .= '<div class="wpapp_payment_button">';
    $output .= '<input type="image" src="'.esc_url($payment_button).'" name="submit" alt="Make payments with payPal - it\'s fast, free and secure!" />';
    $output .= '</div>';
    
    $output .= '</form>';
    $output .= '</div>';
    $output .= <<<EOT
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.wp_accept_pp_button_form_classic').submit(function(e){
        var form_obj = $(this);
        var other_amt = form_obj.find('input[name=other_amount]').val();
        if (!isNaN(other_amt) && other_amt.length > 0){
            options_val = other_amt;
            //insert the amount field in the form with the custom amount
            $('<input>').attr({
                type: 'hidden',
                id: 'amount',
                name: 'amount',
                value: options_val
            }).appendTo(form_obj);
        }		
        return;
    });
});
</script>
EOT;
    /* = end of paypal form = */
    return $output;
}

function wp_ppp_process($content) {
    if (strpos($content, "<!-- wp_paypal_payment -->") !== FALSE) {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('<!-- wp_paypal_payment -->', Paypal_payment_accept(), $content);
    }
    return $content;
}

function show_wp_paypal_payment_widget($args) {
    extract($args);

    $wp_paypal_payment_widget_title_name_value = get_option('wp_paypal_widget_title_name');
    echo $before_widget;
    echo $before_title . $wp_paypal_payment_widget_title_name_value . $after_title;
    echo Paypal_payment_accept();
    echo $after_widget;
}

function wp_paypal_payment_widget_control() {
    ?>
    <p>
    <? _e("Set the Plugin Settings from the Settings menu"); ?>
    </p>
    <?php
}

function wp_paypal_payment_init() {
    wp_register_style('wpapp-styles', NRPTT_JAD_PLUGIN_URL . '/wpapp-styles.css');
    wp_enqueue_style('wpapp-styles');
    wp_register_style('nrptt-styles', NRPTT_JAD_PLUGIN_URL . '/nrptt-join/nrptt-default-skyblue.css');
    wp_enqueue_style('nrptt-styles');

    //Widget code
    $widget_options = array('classname' => 'widget_wp_paypal_payment', 'description' => __("Display WP Paypal Payment."));
    wp_register_sidebar_widget('wp_paypal_payment_widgets', __('WP Paypal Payment'), 'show_wp_paypal_payment_widget', $widget_options);
    wp_register_widget_control('wp_paypal_payment_widgets', __('WP Paypal Payment'), 'wp_paypal_payment_widget_control');
    
    //Listen for IPN and validate it
    if (isset($_REQUEST['wpapp_paypal_ipn']) && $_REQUEST['wpapp_paypal_ipn'] == "process") {
        wpapp_validate_paypl_ipn();
        exit;
    }
}

function nrptt_plugin_enqueue_jquery() {
    wp_deregister_script('jquery');
    wp_deregister_script('jquery-form');
    wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js', false, null, true);
    wp_register_script('jquery-form', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js', false, null, true);
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'jquery-form');
    wp_enqueue_style(  'bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' );
    wp_enqueue_script( 'bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
    wp_enqueue_script( 'cookie_js', 'https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js');
    wp_enqueue_script( 'jqvalidate_js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js');
    wp_enqueue_script( 'jqvalidate_add_js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js');
    wp_enqueue_script( 'bootstrapselect_js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js');
//    wp_enqueue_script( 'card_js', 'https://cdnjs.cloudflare.com/ajax/libs/card/1.3.1/js/card.min.js');
//    wp_enqueue_script( 'nrptt_sb_js', NRPTT_JAD_PLUGIN_URL . '/nrptt-join/nrptt-default-skyblue.js' );
    wp_enqueue_script( 'nrptt_js', NRPTT_JAD_PLUGIN_URL . '/nrptt-join/nrptt-join.js' );
}


add_filter('the_content', 'wp_ppp_process');
add_shortcode('wp_paypal_payment', 'Paypal_payment_accept');
if (!is_admin()) {
    add_filter('widget_text', 'do_shortcode');
}

add_action('init', 'nrptt_plugin_enqueue_jquery');
add_action('init', 'wp_paypal_payment_init');


// wp_enqueue_script('jquery_js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js');

add_action('paypal_ipn_for_wordpress_ipn_response_handler', 'nrptt_ipn_handler', 10, 3);
function nrptt_ipn_handler($posted) {

              // Parse data from IPN $posted array

              $IPN_status = isset($posted['IPN_status']) ? $posted['IPN_status'] : '';
              $address_city = isset($posted['address_city']) ? $posted['address_city'] : '';
              $address_country = isset($posted['address_country']) ? $posted['address_country'] : '';
              $address_country_code = isset($posted['address_country_code']) ? $posted['address_country_code'] : '';
              $address_name = isset($posted['address_name']) ? $posted['address_name'] : '';
              $address_state = isset($posted['address_state']) ? $posted['address_state'] : '';
              $address_status = isset($posted['address_status']) ? $posted['address_status'] : '';
              $address_street = isset($posted['address_street']) ? $posted['address_street'] : '';
              $address_zip = isset($posted['address_zip']) ? $posted['address_zip'] : '';
              $business = isset($posted['business']) ? $posted['business'] : '';
              $charset = isset($posted['charset']) ? $posted['charset'] : '';
              $custom = isset($posted['custom']) ? $posted['custom'] : '';
              $first_name = isset($posted['first_name']) ? $posted['first_name'] : '';
              $ipn_track_id = isset($posted['ipn_track_id']) ? $posted['ipn_track_id'] : '';
              $item_name = isset($posted['item_name']) ? $posted['item_name'] : '';
              $last_name = isset($posted['last_name']) ? $posted['last_name'] : '';
              $mc_currency = isset($posted['mc_currency']) ? $posted['mc_currency'] : '';
              $mc_fee = isset($posted['mc_fee']) ? $posted['mc_fee'] : '';
              $mc_gross = isset($posted['mc_gross']) ? $posted['mc_gross'] : '';
              $notify_version = isset($posted['notify_version']) ? $posted['notify_version'] : '';
              $option_name1 = isset($posted['option_name1']) ? $posted['option_name1'] : '';
              $option_name2 = isset($posted['option_name2']) ? $posted['option_name2'] : '';
              $option_selection1 = isset($posted['option_selection1']) ? $posted['option_selection1'] : '';
              $option_selection2 = isset($posted['option_selection2']) ? $posted['option_selection2'] : '';
              $payer_email = isset($posted['payer_email']) ? $posted['payer_email'] : '';
              $payer_id = isset($posted['payer_id']) ? $posted['payer_id'] : '';
              $payer_status = isset($posted['payer_status']) ? $posted['payer_status'] : '';
              $payment_date = isset($posted['payment_date']) ? $posted['payment_date'] : '';
              $payment_status = isset($posted['payment_status']) ? $posted['payment_status'] : '';
              $payment_type = isset($posted['payment_type']) ? $posted['payment_type'] : '';
              $protection_eligibility = isset($posted['protection_eligibility']) ? $posted['protection_eligibility'] : '';
              $quantity = isset($posted['quantity']) ? $posted['quantity'] : '';
              $receiver_email = isset($posted['receiver_email']) ? $posted['receiver_email'] : '';
              $receiver_id = isset($posted['receiver_id']) ? $posted['receiver_id'] : '';
              $residence_country = isset($posted['residence_country']) ? $posted['residence_country'] : '';
              $test_ipn = isset($posted['test_ipn']) ? $posted['test_ipn'] : '';
              $txn_id = isset($posted['txn_id']) ? $posted['txn_id'] : '';
              $txn_type = isset($posted['txn_type']) ? $posted['txn_type'] : '';
              $verify_sign = isset($posted['verify_sign']) ? $posted['verify_sign'] : '';

            /**
            * At this point you can use the data to generate email notifications,
            * update your local database, hit 3rd party web services, or anything
            * else you might want to automate based on this type of IPN.
            */

            wp_mail('exedre@gmail.com','PAYPAL IPN RECEIVED: ' . $item_name,print_r($posted, true));
}
