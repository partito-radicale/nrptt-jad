<?php

/**
 * @class       NRPTT_JAD_Public_Display
 * @version	1.0.0
 * @package	nrptt-jad
 * @category	Class
 * @author      info@nrptt.org
 */


class NRPTT_JAD_Public_Display {

    /**
     * Hook in methods
     * @since    1.0.0
     * @access   static
     */
    public static function init() {
        self::setup_vars();
        self::nrptt_add_shortcode();
        add_filter('widget_text', 'do_shortcode');
    }

    public static function nrptt_add_shortcode() {
        // add_shortcode('nrptt_join', array(__CLASS__, 'nrptt_jad_join'));

        //add_shortcode('nrptt_donate', array(__CLASS__, 'nrptt_jad_donate'));
        add_shortcode('nrptt_join_and_donate', array(__CLASS__, 'nrptt_jad'));
    }


    public static function phonecodes_by_country() {
        $arr = array( );
        foreach ( self::$phonecodes  as $id => $info ) {
            if (mb_substr($id, 0, 1) == '-') { 
                $arr[$id] = array( '', $info[0], $info[1] );
            } else {
                $arr[$id] = array( sprintf('data-countrycode="%s"',$id), $info[0], $info[1] );
            }
        }
        return $arr;
    }


    public static function quote_by_country() {
        $arr = array( );
        foreach ( self::$country_quotes as $id => $info ) {
            if (mb_substr($id, 0, 1) == '-') { 
                $arr[$id] = $info ; 
            }
            else {
                $arr[$id] = sprintf(__('%s (minum %d reccomended %d)'), $info[0], $info[1] , $info[2] );
            }
        }
        return $arr;
    }

    public static function country_by_country() {
        $arr = array( );
        foreach ( self::$country_quotes as $id => $info ) {
            if (mb_substr($id, 0, 1) == '-') { 
                $arr[$id] = $info ; 
            } else {
                $arr[$id] = $info[0] ;
            }
        }
        return $arr;
    }

    public static function nrptt_jad__make_form($options) {
        $output = "";
        foreach($options as $elem) {
            $kind = $elem[0];
            $require = FALSE;
            if (count($elem)>4 and $elem[5] == '*') {
                $require = TRUE;
            }
            $dim = 'large';
            if (count($elem)>5) {
                $dim = $elem[6]; 
            }
            $output .= '<div class="element-' . $kind . '">';
            if ($kind == 'separator') {
                $output .= $elem[1];
            } elseif ($kind == 'input') {
                $output .= '<label class="title">' . $elem[1];
                if ($require) $output .= '<span class="required">*</span>';
                $output .= '</label>';
                $output .= '<div class="' . $dim . '"><span>';
                $output .= '<input id="' . $elem[2] . '" ' . $elem[4] . ' name="' . $elem[2] . '"/>';
                if ($elem[3] != FALSE) {
                   $output .= '<label id="label-' . $elem[2] . '" class="subtitle">' . $elem[3] . '</label>';
                }
                $output .= '</span></div>';
            } elseif ($kind == 'checkbox') {
                $output .= '<div class="column column1"><label><input type="checkbox" id="' . $elem[2] . '" name="checkbox[' . $elem[2] . ']" value="1"/ ><span>&nbsp;' . $elem[1] . '</span></label></div><span class="clearfix"></span>';
            } elseif ($kind == 'textarea') {
                $output .= '<label class="title"></label><div class="item-cont"><textarea class="medium" id="' . $elem[2] . '" name="textarea" ' . $elem[4] . ' placeholder="' . $elem[5] . '"></textarea></div><span class="icon-place"></span>';
            } elseif ($kind == 'button') {
                $other = "";
                if (count($elem)>3) {
                    $other = $elem[3];
                }
                $output .= '<button type="button" class="' . $elem[2] . '" id="' . $elem[2] . '" ' . $other . '>' . $elem[1] . '</button>';
            } elseif ($kind == 'select') {
                $output .= '<label class="title">' . $elem[1];
                if ($require) $output .= '<span class="required">*</span>';
                $output .= '</label>';
                $output .= '<div class="' . $dim . '"><span>';
                $output .= '<select id="' . $elem[2] . '" class="' . $elem[2] . '" name="' . $elem[2] . '"';
                if ($require) 
                    $output .= 'required';
                $output .= '>';
                foreach($elem[4] as $key => $val) {
                    $output .= '<option  value="'. $key .'" ';
                    if ($key[0] == '-') { 
                        $output .= 'disabled="disabled"';
                    }
                    $output .= '>' . $val . "</option>";
                }
                $output .= '</select></span></div>';       
            } elseif ($kind == 'select+') {
                $output .= '<label class="title">' . $elem[1];
                if ($require) $output .= '<span class="required">*</span>';
                $output .= '</label>';
                $output .= '<div class="' . $dim . '"><span>';
                $output .= '<select id="' . $elem[2] . '" class="' . $elem[2] . '" name="' . $elem[2] . '"';
                if ($require) 
                    $output .= 'required';
                $output .= '>';
                foreach($elem[4] as $key => $val) {
                    $output .= '<option  value="'. $val[1] .'" ' . $val[0] . ' ';
                    if ($key[0] == '-') { 
                        $output .= 'disabled="disabled"';
                    }
                    $output .= '>' . $val[2] . "</option>";
                }
                $output .= '</select></span></div>';       
            }

            $output .= '</div> <!-- .element-' . $kind . ' -->';
        }
       return $output;
    }

    public static function nrptt_jad($atts) {
        $output = self::nrptt_jad_select($atts);
        $output .= self::nrptt_jad_join($atts);
        $output .= self::nrptt_jad_donate($atts);
        $output .= self::nrptt_jad_payments($atts);
        return $output;
    }

    public static function nrptt_jad_join($atts) {
        $options = array(
            array( 'separator', sprintf('<hr><h3 class="section-break-title">%s</h3>' , __('Membership details','nrptt-jad')) ) , 
            array( 'select' ,  __('Year of membership','nrptt-jad'), 's_year',  FALSE,
                   array( '2018' => '2018', '2019' => '2019' ), '*'),
            array( 'select' ,  __('Minimum, Recommended or Custom quote amount'), 's_kind',  FALSE,
                   array( '-' => __('--- Select kind of membership ---'), '1' => 'Recommended Amount', '0' => 'Minimum Amount', '2' => 'Custom Amount' ), '*'),
            array( 'select' ,  __('Country of the member'), 's_country',  FALSE,
                   self::quote_by_country(), '*' ),
            array( 'input',  __('Amount in Euro','nrptt-jad'), 's_amount', __('Amount is less than minimum fee','nrptt-jad')  , 'type="text" size="35" class="medium required" placeholder="0,00" ', '*' ),
            array( 'separator', sprintf('<hr><h3 class="section-break-title">%s</h3>' , __('Member details','nrptt-jad')) ) , 
            array( 'input',  __('First Name','nrptt-jad'), 'i_first_name', FALSE  , 'type="text" size="8" class="required"', '*' ),
            array( 'input',  __('Last Name','nrptt-jad'), 'i_last_name', FALSE  , 'type="text" size="14" class="required"', '*' ),
            array( 'input',  __('Email','nrptt-jad'), 'i_email', FALSE  , 'type="email" size="14" class="required"', '*' ),
            array( 'select+' ,  __('Phone Code'), 'i_countrycode',  FALSE,
                   self::phonecodes_by_country(), '*' ),
            array( 'input',  __('Phone','nrptt-jad'), 'i_phone', FALSE  , 'type="tel" pattern="[+]?[\.\s\-\(\)\*\#0-9]{3,}" maxlength="24"', '*' ),
            array( 'input',  __('Stret Address','nrptt-jad'), 'i_address1', FALSE  , 'type="text"', '*' ),
            array( 'input',  __('Address Line 2','nrptt-jad'), 'i_address2', FALSE  , 'type="text"', '' ),
            array( 'input',  __('City','nrptt-jad'), 'i_city', FALSE  , 'type="text"', '' ),
            array( 'input',  __('State / Province / Region','nrptt-jad'), 'i_state', FALSE  , 'type="text"', '' ),
            array( 'input',  __('Postal / Zip Code', 'nrptt-jad'), 'i_zip', FALSE  , 'type="text" maxlength=15', '*' ),
            array( 'select' ,  __('Country'), 'i_country',  FALSE, self::country_by_country(), '*' ), 
            array( 'separator', sprintf('<hr><h3 class="section-break-title">%s</h3>' , __('Tell us why you are joining NRPTT','nrptt-jad')) ) , 
            array( 'textarea' ,  __('A message from you'), 'i_say',  FALSE, 'cols="20" rows="5" placeholder="' . __('Tell others why you think supporting the NRPTT is important') .'"', '*' ),
            array( 'checkbox' ,  __('Show this donation in the donor page?'), 'i_show',  FALSE, '', '*' ),
//            array( 'button', __('Pay with CREDIT CARD…') , 'show_credit_card' ),
//            array( 'button', __('… or with PAYPAL'), 'show_paypal' ),
        );       
        $output = '<form id="i_form" class="nrptt-default-skyblue" style="background-color:#f7c44f;font-size:14px;font-family:\'Open Sans\',\'Helvetica Neue\',\'Helvetica\',Arial,Verdana,sans-serif;color:#666666;max-width=80%;min-width:150px" method="post">' ;
        $output .= self::nrptt_jad__make_form($options);
        $output .= '</form>';
        return '<div class="block_join"">'.$output.'</div>';
    }

    public static function nrptt_jad_select($atts) {
        $options = array(
            array( 'button', __('Join') , 'show_join' ),
            array( 'button', __('Donate'), 'show_donate' ),
        );
        $output = '<div class="nrptt_select">';
        $output .= self::nrptt_jad__make_form($options);
        $output .= '</div>';
        return $output;
    }

    public static function nrptt_jad_payments($atts) {
        $options = array(
            array( 'button', __('Pay with CREDIT CARD…') , 'show_credit_card' ),
            array( 'button', __('… or with PAYPAL'), 'show_paypal' ),
        );
        $output = '<div class="nrptt_payments">';
        $output .= self::nrptt_jad__make_form($options);
        $output .= self::nrptt_jad__pay_with_credit_card();
        $output .= self::nrptt_jad__pay_with_paypal();
        $output .= '</div>';
        return $output;
    }

    public static function nrptt_jad__pay_with_credit_card() {
        $output = '<div class="pay_with_credit_card">';
        $output .= '<div class="element-separator"><hr><h3 class="section-break-title">';
        $output .= __('Pay with Credit Cards') ;
        $output .= '</h3></div>' ;
        $output .= do_shortcode("[fullstripe_payment form='join']");
        $output .= '</div>';
        return $output;
    }

    public static function nrptt_jad__pay_with_paypal() {
        $output  = '<div class="pay_with_paypal">';
        $output .= '<div class="element-separator"><hr><h3 class="section-break-title">';
        $output .= __('Pay with Paypal');
        $output .= '</h3></div>';
        $output .= self::nrptt_jad__paypal_form();
        $output .= '<span class="CC"><button id="submit-pay-pp"  type="button" class="btn btn-success" >' . __('Pay') .'</button>';
        $output .= '</div>';
        return $output;
    }

    public static function nrptt_jad__paypal_form($args) {
        $kind = 'text';
        $variables = array(
            'cmd' => '_xclick',
            'business' => 'pr-merch@nrptt.org',
            "custom" => "" ,
            "item_name" => "item name" ,
            "transaction_subject" => "subject" ,
            "address_name" => "" ,
            "currency_code" => "EUR" ,
            "charset" => "utf-8" ,
            "address_override" => "0" ,
            "first_name" => "" ,
            "last_name" => "" ,
            "address1" => "" ,
            "address2" => "-" ,
            "city" => "" ,
            "state" => "" ,
            "zip" => "" ,
            "country" => "" ,
            "night_phone_a" => "" ,
            "night_phone_b" => "" ,
            "night_phone_c" => "" ,
            "email" => "" ,
            "amount" => "" ,
            "on0" => "member-name" ,
            "os0" => "" ,
            "on1" => "membership" ,
            "os1" => "" ,
            "lc" => "it" ,
            "rm" => "2" ,
            "bn" => "TipsandTricks_SP" ,
            "no_shipping" => "0" ,
            "no_note" => "0" ,
            "notify_url" => "http://iscr.nvrp.org/?AngellEYE_Paypal_Ipn_For_Wordpress&action=ipn_handler" ,
            "return" => "http://iscr.nvrp.org/return-page/" ,
            "cancel_return" => "http://iscr.nvrp.org/cancel-page/" ,
        );
        foreach ($variables as $key => $value) {
            $output .= '    <input id="ppf-' . $key . '" name="' . $key . '" type="' . $kind . '" value="'. $value . '" />';
        } 
        $paypal_payment_platform = get_option('paypal_payment_platform');
        $paypal_url = "https://sandbox.paypal.com/cgi-bin/webscr";
        if ( $paypal_payment_platform === 'PROD' ) {
            $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
        }
        $output = '<form id="paypal-payment-form"
         class="nrptt-default-skyblue" 
         style="background-color:#f7c44f;font-size:14px;font-family:\'Open Sans\',\'Helvetica Neue\',\'Helvetica\',Arial,Verdana,sans-serif;color:#666666;max-width:480px;min-width:150px"
         action="' . $paypal_url . '"
         method="post">' . $output ;
        $output .= '<input alt="Make payments with payPal - it\'s fast, free and secure!" name="submit"  src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif"  type="image" />';
        $output .= '</form>';
        $output = '<div class="paypal_join_block">' . $output . '</div>';
        return $output;
    }

    public static function nrptt_jad_donate($atts) {
        $options = array(
            array( 'input',  __('Amount in Euro','nrptt-jad'), 'd_amount', FALSE  , 'type="text" size="35" class="medium required" placeholder="0,00"', '*' ),
            array( 'input',  __('Email','nrptt-jad'), 'j_email', FALSE  , 'type="email" size="14" ', '*' ),
            array( 'separator', sprintf('<hr><h3 class="section-break-title">%s</h3>' , __('Donor details (optional)','nrptt-jad')) ) , 
            array( 'input',  __('First Name','nrptt-jad'), 'j_first_name', FALSE  , 'type="text" size="8"' ),
            array( 'input',  __('Last Name','nrptt-jad'), 'j_last_name', FALSE  , 'type="text" size="14"' ),
            array( 'select+' ,  __('Phone Code'), 'j_countrycode',  FALSE,
                   self::phonecodes_by_country(), '' ),
            array( 'input',  __('Phone','nrptt-jad'), 'j_phone', FALSE  , 'type="tel" pattern="[+]?[\.\s\-\(\)\*\#0-9]{3,}" maxlength="24"', '' ),
            array( 'input',  __('Stret Address','nrptt-jad'), 'j_address1', FALSE  , 'type="text"', '' ),
            array( 'input',  __('Address Line 2','nrptt-jad'), 'j_address2', FALSE  , 'type="text"', '' ),
            array( 'input',  __('City','nrptt-jad'), 'j_city', FALSE  , 'type="text"', '' ),
            array( 'input',  __('State / Province / Region','nrptt-jad'), 'j_state', FALSE  , 'type="text"', '' ),
            array( 'input',  __('Postal / Zip Code', 'nrptt-jad'), 'j_zip', FALSE  , 'type="text" maxlength=15', '' ),
            array( 'select' ,  __('Country'), 'j_country',  FALSE, self::country_by_country(), '' ), 
            array( 'separator', sprintf('<hr><h3 class="section-break-title">%s</h3>' , __('Tell us why you are donating to NRPTT','nrptt-jad')) ) , 
            array( 'textarea' ,  __('A message from you'), 'j_say',  FALSE, 'cols="20" rows="5" placeholder="' . __('Tell others why you think supporting the NRPTT is important') .'"', '*' ),
            array( 'checkbox' ,  __('Show this donation in the donor page?'), 'j_show',  FALSE, '', '*' ),
//            array( 'button', __('Donate with CREDIT CARD…'), 'show_credit_card' ),
//            array( 'button', __('… or with PAYPAL'), 'show_paypal' ),
        );
        $output = '<form id="j_form" class="nrptt-default-skyblue" style="background-color:#f7c44f;font-size:14px;font-family:\'Open Sans\',\'Helvetica Neue\',\'Helvetica\',Arial,Verdana,sans-serif;color:#666666;min-width:150px" method="post">' ;
        // $output .= ' <div class="title"><h2>' . __('Join form for NRPTT') . '</h2></div>';
        $output .= self::nrptt_jad__make_form($options);
        $output .= '</form>';
//        $output .= self::nrptt_jad__pay_with_credit_card('donate');
//        $output .= self::nrptt_jad__pay_with_paypal('donate');
        return '<div class="block_donate"">'.$output.'</div>';
        return $output;
    }

    static $phonecodes;
    static $country_quotes;

                                // <!-- "CU" => array("53", 'Cuba (+53)'), --> 
                                // <!-- "IR" => array("98", 'Iran (+98)'), --> 
                                // <!-- "KP" => array("850", 'Korea - North (+850)'), --> 
                                // <!-- "SY" => array("963", 'Syria (+963)'), --> 

        static private function setup_vars() {
            
            self::$phonecodes = array( "-1" => array("--", '--- Select ---'), "IT" => array("39", 'Italy (+39)'), "US" => array("1", 'USA (+1)'), "GB" => array("44", 'UK (+44)'), "-2" => array("--", '--- Other Countries ---'), "DZ" => array("213", 'Algeria (+213)'), "AD" => array("376", 'Andorra (+376)'), "AO" => array("244", 'Angola (+244)'), "AI" => array("1264", 'Anguilla (+1264)'), "AG" => array("1268", 'Antigua &amp; Barbuda (+1268)'), "AR" => array("54", 'Argentina (+54)'), "AM" => array("374", 'Armenia (+374)'), "AW" => array("297", 'Aruba (+297)'), "AU" => array("61", 'Australia (+61)'), "AT" => array("43", 'Austria (+43)'), "AZ" => array("994", 'Azerbaijan (+994)'), "BS" => array("1242", 'Bahamas (+1242)'), "BH" => array("973", 'Bahrain (+973)'), "BD" => array("880", 'Bangladesh (+880)'), "BB" => array("1246", 'Barbados (+1246)'), "BY" => array("375", 'Belarus (+375)'), "BE" => array("32", 'Belgium (+32)'), "BZ" => array("501", 'Belize (+501)'), "BJ" => array("229", 'Benin (+229)'), "BM" => array("1441", 'Bermuda (+1441)'), "BT" => array("975", 'Bhutan (+975)'), "BO" => array("591", 'Bolivia (+591)'), "BA" => array("387", 'Bosnia Herzegovina (+387)'), "BW" => array("267", 'Botswana (+267)'), "BR" => array("55", 'Brazil (+55)'), "BN" => array("673", 'Brunei (+673)'), "BG" => array("359", 'Bulgaria (+359)'), "BF" => array("226", 'Burkina Faso (+226)'), "BI" => array("257", 'Burundi (+257)'), "KH" => array("855", 'Cambodia (+855)'), "CM" => array("237", 'Cameroon (+237)'), "CA" => array("1", 'Canada (+1)'), "CV" => array("238", 'Cape Verde Islands (+238)'), "KY" => array("1345", 'Cayman Islands (+1345)'), "CF" => array("236", 'Central African Republic (+236)'), "CL" => array("56", 'Chile (+56)'), "CN" => array("86", 'China (+86)'), "CO" => array("57", 'Colombia (+57)'), "KM" => array("269", 'Comoros (+269)'), "CG" => array("242", 'Congo (+242)'), "CK" => array("682", 'Cook Islands (+682)'), "CR" => array("506", 'Costa Rica (+506)'), "HR" => array("385", 'Croatia (+385)'), "CY" => array("90", 'Cyprus - North (+90)'), "CY" => array("357", 'Cyprus - South (+357)'), "CZ" => array("420", 'Czech Republic (+420)'), "DK" => array("45", 'Denmark (+45)'), "DJ" => array("253", 'Djibouti (+253)'), "DM" => array("1809", 'Dominica (+1809)'), "DO" => array("1809", 'Dominican Republic (+1809)'), "EC" => array("593", 'Ecuador (+593)'), "EG" => array("20", 'Egypt (+20)'), "SV" => array("503", 'El Salvador (+503)'), "GQ" => array("240", 'Equatorial Guinea (+240)'), "ER" => array("291", 'Eritrea (+291)'), "EE" => array("372", 'Estonia (+372)'), "ET" => array("251", 'Ethiopia (+251)'), "FK" => array("500", 'Falkland Islands (+500)'), "FO" => array("298", 'Faroe Islands (+298)'), "FJ" => array("679", 'Fiji (+679)'), "FI" => array("358", 'Finland (+358)'), "FR" => array("33", 'France (+33)'), "GF" => array("594", 'French Guiana (+594)'), "PF" => array("689", 'French Polynesia (+689)'), "GA" => array("241", 'Gabon (+241)'), "GM" => array("220", 'Gambia (+220)'), "GE" => array("7880", 'Georgia (+7880)'), "DE" => array("49", 'Germany (+49)'), "GH" => array("233", 'Ghana (+233)'), "GI" => array("350", 'Gibraltar (+350)'), "GR" => array("30", 'Greece (+30)'), "GL" => array("299", 'Greenland (+299)'), "GD" => array("1473", 'Grenada (+1473)'), "GP" => array("590", 'Guadeloupe (+590)'), "GU" => array("671", 'Guam (+671)'), "GT" => array("502", 'Guatemala (+502)'), "GN" => array("224", 'Guinea (+224)'), "GW" => array("245", 'Guinea - Bissau (+245)'), "GY" => array("592", 'Guyana (+592)'), "HT" => array("509", 'Haiti (+509)'), "HN" => array("504", 'Honduras (+504)'), "HK" => array("852", 'Hong Kong (+852)'), "HU" => array("36", 'Hungary (+36)'), "IS" => array("354", 'Iceland (+354)'), "IN" => array("91", 'India (+91)'), "ID" => array("62", 'Indonesia (+62)'), "IQ" => array("964", 'Iraq (+964)'), "IE" => array("353", 'Ireland (+353)'), "IL" => array("972", 'Israel (+972)'), "JM" => array("1876", 'Jamaica (+1876)'), "JP" => array("81", 'Japan (+81)'), "JO" => array("962", 'Jordan (+962)'), "KZ" => array("7", 'Kazakhstan (+7)'), "KE" => array("254", 'Kenya (+254)'), "KI" => array("686", 'Kiribati (+686)'), "KR" => array("82", 'Korea - South (+82)'), "KW" => array("965", 'Kuwait (+965)'), "KG" => array("996", 'Kyrgyzstan (+996)'), "LA" => array("856", 'Laos (+856)'), "LV" => array("371", 'Latvia (+371)'), "LB" => array("961", 'Lebanon (+961)'), "LS" => array("266", 'Lesotho (+266)'), "LR" => array("231", 'Liberia (+231)'), "LY" => array("218", 'Libya (+218)'), "LI" => array("417", 'Liechtenstein (+417)'), "LT" => array("370", 'Lithuania (+370)'), "LU" => array("352", 'Luxembourg (+352)'), "MO" => array("853", 'Macao (+853)'), "MK" => array("389", 'Macedonia (+389)'), "MG" => array("261", 'Madagascar (+261)'), "MW" => array("265", 'Malawi (+265)'), "MY" => array("60", 'Malaysia (+60)'), "MV" => array("960", 'Maldives (+960)'), "ML" => array("223", 'Mali (+223)'), "MT" => array("356", 'Malta (+356)'), "MH" => array("692", 'Marshall Islands (+692)'), "MQ" => array("596", 'Martinique (+596)'), "MR" => array("222", 'Mauritania (+222)'), "YT" => array("269", 'Mayotte (+269)'), "MX" => array("52", 'Mexico (+52)'), "FM" => array("691", 'Micronesia (+691)'), "MD" => array("373", 'Moldova (+373)'), "MC" => array("377", 'Monaco (+377)'), "MN" => array("976", 'Mongolia (+976)'), "MS" => array("1664", 'Montserrat (+1664)'), "MA" => array("212", 'Morocco (+212)'), "MZ" => array("258", 'Mozambique (+258)'), "MN" => array("95", 'Myanmar (+95)'), "NA" => array("264", 'Namibia (+264)'), "NR" => array("674", 'Nauru (+674)'), "NP" => array("977", 'Nepal (+977)'), "NL" => array("31", 'Netherlands (+31)'), "NC" => array("687", 'New Caledonia (+687)'), "NZ" => array("64", 'New Zealand (+64)'), "NI" => array("505", 'Nicaragua (+505)'), "NE" => array("227", 'Niger (+227)'), "NG" => array("234", 'Nigeria (+234)'), "NU" => array("683", 'Niue (+683)'), "NF" => array("672", 'Norfolk Islands (+672)'), "NP" => array("670", 'Northern Marianas (+670)'), "NO" => array("47", 'Norway (+47)'), "OM" => array("968", 'Oman (+968)'), "PK" => array("92", 'Pakistan (+92)'), "PW" => array("680", 'Palau (+680)'), "PA" => array("507", 'Panama (+507)'), "PG" => array("675", 'Papua New Guinea (+675)'), "PY" => array("595", 'Paraguay (+595)'), "PE" => array("51", 'Peru (+51)'), "PH" => array("63", 'Philippines (+63)'), "PL" => array("48", 'Poland (+48)'), "PT" => array("351", 'Portugal (+351)'), "PR" => array("1787", 'Puerto Rico (+1787)'), "QA" => array("974", 'Qatar (+974)'), "RE" => array("262", 'Reunion (+262)'), "RO" => array("40", 'Romania (+40)'), "RU" => array("7", 'Russia (+7)'), "RW" => array("250", 'Rwanda (+250)'), "SM" => array("378", 'San Marino (+378)'), "ST" => array("239", 'Sao Tome &amp; Principe (+239)'), "SA" => array("966", 'Saudi Arabia (+966)'), "SN" => array("221", 'Senegal (+221)'), "CS" => array("381", 'Serbia (+381)'), "SC" => array("248", 'Seychelles (+248)'), "SL" => array("232", 'Sierra Leone (+232)'), "SG" => array("65", 'Singapore (+65)'), "SK" => array("421", 'Slovak Republic (+421)'), "SI" => array("386", 'Slovenia (+386)'), "SB" => array("677", 'Solomon Islands (+677)'), "SO" => array("252", 'Somalia (+252)'), "ZA" => array("27", 'South Africa (+27)'), "ES" => array("34", 'Spain (+34)'), "LK" => array("94", 'Sri Lanka (+94)'), "SH" => array("290", 'St. Helena (+290)'), "KN" => array("1869", 'St. Kitts (+1869)'), "SC" => array("1758", 'St. Lucia (+1758)'), "SR" => array("597", 'Suriname (+597)'), "SD" => array("249", 'Sudan (+249)'), "SZ" => array("268", 'Swaziland (+268)'), "SE" => array("46", 'Sweden (+46)'), "CH" => array("41", 'Switzerland (+41)'), "TW" => array("886", 'Taiwan (+886)'), "TJ" => array("992", 'Tajikistan (+992)'), "TH" => array("66", 'Thailand (+66)'), "TG" => array("228", 'Togo (+228)'), "TO" => array("676", 'Tonga (+676)'), "TT" => array("1868", 'Trinidad &amp; Tobago (+1868)'), "TN" => array("216", 'Tunisia (+216)'), "TR" => array("90", 'Turkey (+90)'), "TM" => array("993", 'Turkmenistan (+993)'), "TC" => array("1649", 'Turks &amp; Caicos Islands (+1649)'), "TV" => array("688", 'Tuvalu (+688)'), "UG" => array("256", 'Uganda (+256)'), "UA" => array("380", 'Ukraine (+380)'), "AE" => array("971", 'United Arab Emirates (+971)'), "UY" => array("598", 'Uruguay (+598)'), "UZ" => array("998", 'Uzbekistan (+998)'), "VU" => array("678", 'Vanuatu (+678)'), "VA" => array("379", 'Vatican City (+379)'), "VE" => array("58", 'Venezuela (+58)'), "VN" => array("84", 'Vietnam (+84)'), "VG" => array("1", 'Virgin Islands - British (+1)'), "VI" => array("1", 'Virgin Islands - US (+1)'), "WF" => array("681", 'Wallis &amp; Futuna (+681)'), "YE" => array("969", 'Yemen (North)(+969)'), "YE" => array("967", 'Yemen (South)(+967)'), "ZM" => array("260", 'Zambia (+260)'), "ZW" => array("263", 'Zimbabwe (+263)'), );

            self::$country_quotes = array( '-1' => __('--- Select a country ---'), 'US' => array('United States', '200', '590'), 'IT' => array('Italy', '200', '590'), '-2' => __('--- Others ---'), 'AF' => array('Afghanistan', '4', '12'), 'AL' => array('Albania', '27', '80'), 'DZ' => array('Algeria', '29', '86'), 'AO' => array('Angola', '27', '80'), 'AG' => array('Antigua and Barbuda', '97', '286'), 'SA' => array('Saudi Arabia', '139', '410'), 'AR' => array('Argentina', '91', '268'), 'AM' => array('Armenia', '24', '71'), 'AU' => array('Australia', '200', '590'), 'AT' => array('Austria', '200', '590'), 'AZ' => array('Azerbaijan', '38', '112'), 'BS' => array('Bahamas', '160', '472'), 'BH' => array('Bahrain', '157', '463'), 'BD' => array('Bangladesh', '9', '27'), 'BB' => array('Barbados', '106', '313'), 'BE' => array('Belgium', '200', '590'), 'BZ' => array('Belize', '32', '94'), 'BJ' => array('Benin', '5', '15'), 'BT' => array('Bhutan', '19', '56'), 'BY' => array('Belarus', '38', '112'), 'MM' => array('Myanmar', '9', '27'), 'BO' => array('Bolivia, Plurinational State of', '19', '56'), 'BA' => array('Bosnia and Herzegovina', '27', '80'), 'BW' => array('Botswana', '40', '118'), 'BR' => array('Brazil', '58', '171'), 'BN' => array('Brunei Darussalam', '189', '558'), 'BG' => array('Bulgaria', '46', '136'), 'BF' => array('Burkina Faso', '4', '12'), 'BI' => array('Burundi', '2', '6'), 'KH' => array('Cambodia', '8', '24'), 'CM' => array('Cameroon', '8', '24'), 'CA' => array('Canada', '200', '590'), 'CV' => array('Cape Verde', '20', '59'), 'TD' => array('Chad', '6', '18'), 'CL' => array('Chile', '89', '263'), 'CN' => array('China', '54', '159'), 'CY' => array('Cyprus', '151', '445'), 'CO' => array('Colombia', '41', '121'), 'KM' => array('Comoros', '5', '15'), 'KR' => array('Korea, Republic of', '182', '537'), 'CI' => array('Côte d\'Ivoire', '9', '27'), 'CR' => array('Costa Rica', '73', '215'), 'HR' => array('Croatia', '77', '227'), 'DK' => array('Denmark', '200', '590'), 'DM' => array('Dominica', '47', '139'), 'EC' => array('Ecuador', '41', '121'), 'EG' => array('Egypt', '25', '74'), 'SV' => array('El Salvador', '27', '80'), 'AE' => array('United Arab Emirates', '200', '590'), 'ER' => array('Eritrea', '5', '15'), 'EE' => array('Estonia', '116', '342'), 'ET' => array('Ethiopia', '5', '15'), 'FJ' => array('Fiji', '36', '106'), 'PH' => array('Philippines', '19', '56'), 'FI' => array('Finland', '200', '590'), 'FR' => array('France', '200', '590'), 'GA' => array('Gabon', '52', '153'), 'GM' => array('Gambia', '3', '9'), 'GE' => array('Georgia', '25', '74'), 'DE' => array('Germany', '200', '590'), 'GH' => array('Ghana', '9', '27'), 'JM' => array('Jamaica', '33', '97'), 'JP' => array('Japan', '200', '590'), 'DJ' => array('Djibouti', '12', '35'), 'JO' => array('Jordan', '37', '109'), 'GR' => array('Greece', '121', '357'), 'GD' => array('Grenada', '60', '177'), 'GT' => array('Guatemala', '26', '77'), 'GN' => array('Guinea', '4', '12'), 'GN' => array('Guinea', '79', '233'), 'GW' => array('Guinea-Bissau', '4', '12'), 'GY' => array('Guyana', '28', '83'), 'HT' => array('Haiti', '5', '15'), 'HN' => array('Honduras', '16', '47'), 'HK' => array('Hong Kong', '200', '590'), 'IN' => array('India', '11', '32'), 'ID' => array('Indonesia', '23', '68'), 'IR' => array('Iran, Islamic Republic of', '33', '97'), 'IQ' => array('Iraq', '32', '94'), 'IE' => array('Ireland', '200', '590'), 'IS' => array('Iceland', '200', '590'), 'MH' => array('Marshall Islands', '22', '65'), 'SB' => array('Solomon Islands', '13', '38'), 'IL' => array('Israel', '200', '590'), 'KZ' => array('Kazakhstan', '66', '195'), 'KE' => array('Kenya', '9', '27'), 'KG' => array('Kyrgyzstan', '7', '21'), 'KI' => array('Kiribati', '10', '30'), 'KW' => array('Kuwait', '197', '581'), 'LA' => array('Lao People\'s Democratic Republic', '12', '35'), 'LS' => array('Lesotho', '7', '21'), 'LV' => array('Latvia', '91', '268'), 'LB' => array('Lebanon', '75', '221'), 'LR' => array('Liberia', '3', '9'), 'LY' => array('Libya', '41', '121'), 'LT' => array('Lithuania', '95', '280'), 'LU' => array('Luxembourg', '200', '590'), 'MK' => array('Macedonia, the Former Yugoslav Republic of', '32', '94'), 'MG' => array('Madagascar', '3', '9'), 'MW' => array('Malawi', '2US', '6'), 'MV' => array('Maldives', '60', '177'), 'MY' => array('Malaysia', '64', '189'), 'ML' => array('Mali', '5', '15'), 'MT' => array('Malta', '153', '451'), 'MA' => array('Morocco', '21', '62'), 'MR' => array('Mauritania', '9', '27'), 'MU' => array('Mauritius', '62', '183'), 'MX' => array('Mexico', '60', '177'), 'FM' => array('Micronesia, Federated States of', '21', '62'), 'MD' => array('Moldova, Republic of', '12', '35'), 'MN' => array('Mongolia', '26', '77'), 'ME' => array('Montenegro', '43', '127'), 'MZ' => array('Mozambique', '4', '12'), 'NA' => array('Namibia', '39', '115'), 'NP' => array('Nepal', '5', '15'), 'NI' => array('Nicaragua', '13', '38'), 'NE' => array('Niger', '3', '9'), 'NG' => array('Nigeria', '18', '53'), 'NO' => array('Norway', '200', '590'), 'NZ' => array('New Zealand', '200', '590'), 'OM' => array('Oman', '102', '301'), 'NL' => array('Netherlands', '200', '590'), 'PK' => array('Pakistan', '10', '30'), 'PW' => array('Palau', '108', '319'), 'PA' => array('Panama', '87', '257'), 'PG' => array('Papua New Guinea', '14', '41'), 'PY' => array('Paraguay', '27', '80'), 'PE' => array('Peru', '40', '118'), 'PL' => array('Poland', '84', '248'), 'PT' => array('Portugal', '128', '378'), 'QA' => array('Qatar', '200', '590'), 'GB' => array('United Kingdom', '200', '590'), 'CZ' => array('Czech Republic', '116', '342'), 'CF' => array('Central African Republic', '2', '6'), 'CG' => array('Congo', '14', '41'), 'CD' => array('Congo, the Democratic Republic of the', '3', '9'), 'DO' => array('Dominican Republic', '45', '133'), 'RO' => array('Romania', '60', '177'), 'RW' => array('Rwanda', '5', '15'), 'RU' => array('Russian Federation', '61', '180'), 'KN' => array('Saint Kitts and Nevis', '108', '319'), 'VC' => array('Saint Vincent and the Grenadines', '46', '136'), 'WS' => array('Samoa', '29', '86'), 'SM' => array('San Marino', '200', '590'), 'LC' => array('Saint Lucia', '55', '162'), 'ST' => array('Sao Tome and Principe', '11', '32'), 'SN' => array('Senegal', '6', '18'), 'RS' => array('Serbia', '34', '100'), 'SC' => array('Seychelles', '100', '295'), 'SL' => array('Sierra Leone', '4', '12'), 'SG' => array('Singapore', '200', '590'), 'SK' => array('Slovakia', '107', '316'), 'SI' => array('Slovenia', '139', '410'), 'SO' => array('Somalia', '1', '3'), 'ES' => array('Spain', '173', '510'), 'LK' => array('Sri Lanka', '26', '77'), 'ZA' => array('South Africa', '38', '112'), 'SD' => array('Sudan', '15', '44'), 'SS' => array('South Sudan', '1', '3'), 'SR' => array('Suriname', '62', '183'), 'SE' => array('Sweden', '200', '590'), 'CH' => array('Switzerland', '200', '590'), 'SZ' => array('Swaziland', '21', '62'), 'TJ' => array('Tajikistan', '6', '18'), 'TW' => array('Taiwan, Province of China', '149', '440'), 'TZ' => array('Tanzania, United Republic of', '6', '18'), 'TH' => array('Thailand', '38', '112'), 'TL' => array('Timor-Leste', '15', '44'), 'TG' => array('Togo', '4', '12'), 'TO' => array('Tonga', '27', '80'), 'TT' => array('Trinidad and Tobago', '121', '357'), 'TN' => array('Tunisia', '26', '77'), 'TR' => array('Turkey', '63', '186'), 'TM' => array('Turkmenistan', '44', '130'), 'TV' => array('Tuvalu', '20', '59'), 'UA' => array('Ukraine', '13', '38'), 'UG' => array('Uganda', '4', '12'), 'HU' => array('Hungary', '82', '242'), 'UY' => array('Uruguay', '105', '310'), 'UZ' => array('Uzbekistan', '14', '41'), 'VU' => array('Vanuatu', '19', '56'), 'VE' => array('Venezuela, Bolivarian Republic of', '52', '153'), 'VN' => array('Viet Nam', '14', '41'), 'YE' => array('Yemen', '9', '27'), 'ZM' => array('Zambia', '9', '27'), 'ZW' => array('Zimbabwe', '7', '21') ); 

            }

}

NRPTT_JAD_Public_Display::init();
