<?php
/*
@wordpress-plugin
Plugin Name: NRPTT Join and Donate
Version: 0.0.2
Plugin URI: https://github.com/partito-radicale/nrptt-jad
Author: Emmanuele Somma
Author URI: https://exedre.org
Description: Plugin for donate and join NRPTT
License: GNU General Public License 2.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: nrptt-jad
Domain Path: /languages
*/

//Slug - nrpttapp

if (!defined('WPINC')) {
    die; // Exit if accessed directly
}


if (!defined('ABSPATH')){//Exit if accessed directly
    exit;
}


define('NRPTT_JAD_PLUGIN_VERSION', '0.0.2');

if (!defined('NRPTT_JAD_PLUGIN_URL'))
    define('NRPTT_JAD_PLUGIN_URL', plugin_dir_url('', __FILE__));


/**
 * define plugin basename
 */
if (!defined('NRPTT_JAD_PLUGIN_BASENAME')) {
    define('NRPTT_JAD_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

/**
 * define set_locale path
 */
if (!defined('NRPTT_JAD_PLUGIN_LOCALE')) {
    define('NRPTT_JAD_PLUGIN_LOCALE', dirname(plugin_basename(__FILE__)));
}

/**
 *  define log file path
 */
if (!defined('NRPTT_JAD_LOG_DIR')) {
    $upload_dir = wp_upload_dir();
    define('NRPTT_JAD_LOG_DIR', $upload_dir['basedir'] . '/nrptt-logs/');
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-paypal-ipn-for-wordpress-activator.php
 */
function activate_nrptt_jad() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-nrptt-jad-activator.php';
    NRPTT_JAD_Activator::activate();
}
function deactivate_nrptt_jad() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-nrptt-jad-deactivator.php';
    NRPTT_JAD_Deactivator::deactivate();
}
register_activation_hook(__FILE__, 'activate_nrptt_jad');
register_deactivation_hook(__FILE__, 'deactivate_nrptt_jad');

require plugin_dir_path(__FILE__) . 'includes/class-nrptt-jad.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nrptt_jad() {
    $plugin = new NRPTT_JAD();
    $plugin->run();
}


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

            wp_mail('pr-paypal@nrptt.org','PAYPAL IPN RECEIVED: ' . $item_name,print_r($posted, true));
};


run_nrptt_jad();
