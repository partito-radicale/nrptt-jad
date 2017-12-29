<?php 

function nrptt_join_stripe_from($args) {
    $output = '<form id="payment-form" action="buy.php" method="POST"><div id="payment-errors"></div>';
    $output .= '<label>Card Number</label>
<input type="text" size="20" autocomplete="off">
<span>Enter the number without spaces or hyphens.</span>
<label>CVC</label>
<input type="text" size="4" autocomplete="off">
<label>Expiration (MM/YYYY)</label>
<input type="text" size="2">
<span> / </span>
<input type="text" size="4">';
    $output .= '</form>';
    return $output;
}

function nrptt_join_paypal_form($args) {
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
	 $output .= '<input alt="Make payments with payPal - it\'s fast, free and secure!" name="submit"  src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif"  type="image" /> </form>';
	 $output = '<div class="block_paypal">' . $output . '</div>';
	 return $output;
};

function nrptt_join_post_form($args) {
	 return '<script type="text/javascript" src="'. NRPTT_JAD_PLUGIN_URL . '/nrptt-join/nrptt-default-skyblue.js"></script>
	         <script type="text/javascript" src="'. NRPTT_JAD_PLUGIN_URL . '/nrptt-join/nrptt-join.js"></script>';
};

function nrptt_join_pre_form($args) {

?>
<form id="i_form" class="nrptt-default-skyblue" 
      style="background-color:#f7c44f;font-size:14px;font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;color:#666666;max-width:480px;min-width:150px" 
      method="post">
  <div class="title"><h2>Join NRPTT</h2></div>
  <div class="element-separator"><hr><h3 class="section-break-title">Membership details</h3></div>
  <div class="element-select">
      <label class="title">Year of membership<span class="required">*</span></label>
      <div class="large">
        <span>
          <select id="i_year" class="i_year" name="i_year" required="required">
            <option id="i_yeary_select" selected="selected" value="" disabled="disabled">--- Select year of membership ---</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
          </select>
        </span>
      </div>
    </div>
    <div class="element-select">
      <label class="title">Minimum, Recommended or Custom quote amount<span class="required">*</span></label>
      <div class="large">
        <span>
          <select id="i_kind" class="i_kind" name="i_kind" required="required">
            <option selected="selected" value="-" disabled="disabled">--- Select kind of quote ---</option>
            <option value="1">recommended amount</option>
            <option value="0">minimum amount</option>
            <option value="2">custom amount</option>
          </select>
        </span>
      </div>
    </div>
    <div class="element-select">
      <label class="title">Member's country<span class="required">*</span></label>
      <div class="large">
        <span>
          <select id="i_country" name="i_country" required="required">
            <option selected="selected" value="" disabled="disabled">--- Select a country ---</option>
                    <option value="IT">Italy (minimum 200€- reccomended 590€)</option>
                    <option value="GB">United Kingdom (minimum 200€- reccomended 590€)</option>
                    <option value="US">United States (minimum 200€- reccomended 590€)</option>
            <option value="" disabled="disabled">--- Others ----</option>
            <option value="AF">Afghanistan (minimum 4€- reccomended 12€)</option>
                    <option value="AL">Albania (minimum 27€- reccomended 80€)</option>
                    <option value="DZ">Algeria (minimum 29€- reccomended 86€)</option>
                    <option value="AO">Angola (minimum 27€- reccomended 80€)</option>
                    <option value="AG">Antigua and Barbuda (minimum 97€- reccomended 286€)</option>
                    <option value="AR">Argentina (minimum 91€- reccomended 268€)</option>
                    <option value="AM">Armenia (minimum 24€- reccomended 71€)</option>
                    <option value="AU">Australia (minimum 200€- reccomended 590€)</option>
                    <option value="AT">Austria (minimum 200€- reccomended 590€)</option>
                    <option value="AZ">Azerbaijan (minimum 38€- reccomended 112€)</option>
                    <option value="BS">Bahamas (minimum 160€- reccomended 472€)</option>
                    <option value="BH">Bahrain (minimum 157€- reccomended 463€)</option>
                    <option value="BD">Bangladesh (minimum 9€- reccomended 27€)</option>
                    <option value="BB">Barbados (minimum 106€- reccomended 313€)</option>
                    <option value="BY">Belarus (minimum 38€- reccomended 112€)</option>
                    <option value="BE">Belgium (minimum 200€- reccomended 590€)</option>
                    <option value="BZ">Belize (minimum 32€- reccomended 94€)</option>
                    <option value="BJ">Benin (minimum 5€- reccomended 15€)</option>
                    <option value="BT">Bhutan (minimum 19€- reccomended 56€)</option>
                    <option value="BO">Bolivia, Plurinational State of (minimum 19€- reccomended 56€)</option>
                    <option value="BA">Bosnia and Herzegovina(minimum 27€- reccomended 80€)</option>
                    <option value="BW">Botswana (minimum 40€- reccomended 118€)</option>
                    <option value="BR">Brazil (minimum 58€- reccomended 171€)</option>
                    <option value="BN">Brunei Darussalam (minimum 189€- reccomended 558€)</option>
                    <option value="BG">Bulgaria (minimum 46€- reccomended 136€)</option>
                    <option value="BF">Burkina Faso (minimum 4€- reccomended 12€)</option>
                    <option value="BI">Burundi (minimum 2€- reccomended 6€)</option>
                    <option value="KH">Cambodia (minimum 8€- reccomended 24€)</option>
                    <option value="CM">Cameroon (minimum 8€- reccomended 24€)</option>
                    <option value="CA">Canada (minimum 200€- reccomended 590€)</option>
                    <option value="CV">Cape Verde (minimum 20€- reccomended 59€)</option>
                    <option value="CF">Central African Republic (minimum 2€- reccomended 6€)</option>
                    <option value="TD">Chad (minimum 6€- reccomended 18€)</option>
                    <option value="CL">Chile (minimum 89€- reccomended 263€)</option>
                    <option value="CN">China (minimum 54€- reccomended 159€)</option>
                    <option value="CO">Colombia (minimum 41€- reccomended 121€)</option>
                    <option value="KM">Comoros (minimum 5€- reccomended 15€)</option>
                    <option value="CG">Congo (minimum 14€- reccomended 41€)</option>
                    <option value="CD">Congo, the Democratic Republic of the (minimum 3€- reccomended 9€)</option>
                    <option value="CR">Costa Rica (minimum 73€- reccomended 215€)</option>
                    <option value="HR">Croatia (minimum 77€- reccomended 227€)</option>
                    <option value="CY">Cyprus (minimum 151€- reccomended 445€)</option>
                    <option value="CZ">Czech Republic (minimum 116€- reccomended 342€)</option>
                    <option value="CI">Côte d&#8217;Ivoire (minimum 9€- reccomended 27€)</option>
                    <option value="DK">Denmark (minimum 200€- reccomended 590€)</option>
                    <option value="DJ">Djibouti (minimum 12€- reccomended 35€)</option>
                    <option value="DM">Dominica (minimum 47€- reccomended 139€)</option>
                    <option value="DO">Dominican Republic (minimum 45€- reccomended 133€)</option>
                    <option value="EC">Ecuador (minimum 41€- reccomended 121€)</option>
                    <option value="EG">Egypt (minimum 25€- reccomended 74€)</option>
                    <option value="SV">El Salvador (minimum 27€- reccomended 80€)</option>
                    <option value="ER">Eritrea (minimum 5€- reccomended 15€)</option>
                    <option value="EE">Estonia (minimum 116€- reccomended 342€)</option>
                    <option value="ET">Ethiopia (minimum 5€- reccomended 15€)</option>
                    <option value="FJ">Fiji (minimum 36€- reccomended 106€)</option>
                    <option value="FI">Finland (minimum 200€- reccomended 590€)</option>
                    <option value="FR">France (minimum 200€- reccomended 590€)</option>
                    <option value="GA">Gabon (minimum 52€- reccomended 153€)</option>
                    <option value="GM">Gambia (minimum 3€- reccomended 9€)</option>
                    <option value="GE">Georgia (minimum 25€- reccomended 74€)</option>
                    <option value="DE">Germany (minimum 200€- reccomended 590€)</option>
                    <option value="GH">Ghana (minimum 9€- reccomended 27€)</option>
                    <option value="GR">Greece (minimum 121€- reccomended 357€)</option>
                    <option value="GD">Grenada (minimum 60€- reccomended 177€)</option>
                    <option value="GT">Guatemala (minimum 26€- reccomended 77€)</option>
                    <option value="GN">Guinea (minimum 4€- reccomended 12€)</option>
                    <option value="GN">Guinea (minimum 79€- reccomended 233€)</option>
                    <option value="GW">Guinea-Bissau (minimum 4€- reccomended 12€)</option>
                    <option value="GY">Guyana (minimum 28€- reccomended 83€)</option>
                    <option value="HT">Haiti (minimum 5€- reccomended 15€)</option>
                    <option value="HN">Honduras (minimum 16€- reccomended 47€)</option>
                    <option value="HK">Hong Kong (minimum 200€- reccomended 590€)</option>
                    <option value="HU">Hungary (minimum 82€- reccomended 242€)</option>
                    <option value="IS">Iceland (minimum 200€- reccomended 590€)</option>
                    <option value="IN">India (minimum 11€- reccomended 32€)</option>
                    <option value="ID">Indonesia (minimum 23€- reccomended 68€)</option>
                    <option value="IR">Iran, Islamic Republic of (minimum 33€- reccomended 97€)</option>
                    <option value="IQ">Iraq (minimum 32€- reccomended 94€)</option>
                    <option value="IE">Ireland (minimum 200€- reccomended 590€)</option>
                    <option value="IL">Israel (minimum 200€- reccomended 590€)</option>
                    <option value="JM">Jamaica (minimum 33€- reccomended 97€)</option>
                    <option value="JP">Japan (minimum 200€- reccomended 590€)</option>
                    <option value="JO">Jordan (minimum 37€- reccomended 109€)</option>
                    <option value="KZ">Kazakhstan (minimum 66€- reccomended 195€)</option>
                    <option value="KE">Kenya (minimum 9€- reccomended 27€)</option>
                    <option value="KI">Kiribati (minimum 10€- reccomended 30€)</option>
                    <option value="KR">Korea, Republic of (minimum 182€- reccomended 537€)</option>
                    <option value="KW">Kuwait (minimum 197€- reccomended 581€)</option>
                    <option value="KG">Kyrgyzstan (minimum 7€- reccomended 21€)</option>
                    <option value="LA">Lao People&#8217;s Democratic Republic (minimum 12€- reccomended 35€)</option>
                    <option value="LV">Latvia (minimum 91€- reccomended 268€)</option>
                    <option value="LB">Lebanon (minimum 75€- reccomended 221€)</option>
                    <option value="LS">Lesotho (minimum 7€- reccomended 21€)</option>
                    <option value="LR">Liberia (minimum 3€- reccomended 9€)</option>
                    <option value="LY">Libya (minimum 41€- reccomended 121€)</option>
                    <option value="LT">Lithuania (minimum 95€- reccomended 280€)</option>
                    <option value="LU">Luxembourg (minimum 200€- reccomended 590€)</option>
                    <option value="MK">Macedonia, the Former Yugoslav Republic of (minimum 32€- reccomended 94€)</option>
                    <option value="MG">Madagascar (minimum 3€- reccomended 9€)</option>
                    <option value="MW">Malawi (minimum 2€- reccomended 6€)</option>
                    <option value="MY">Malaysia (minimum 64€- reccomended 189€)</option>
                    <option value="MV">Maldives (minimum 60€- reccomended 177€)</option>
                    <option value="ML">Mali (minimum 5€- reccomended 15€)</option>
                    <option value="MT">Malta (minimum 153€- reccomended 451€)</option>
                    <option value="MH">Marshall Islands (minimum 22€- reccomended 65€)</option>
                    <option value="MR">Mauritania (minimum 9€- reccomended 27€)</option>
                    <option value="MU">Mauritius (minimum 62€- reccomended 183€)</option>
                    <option value="MX">Mexico (minimum 60€- reccomended 177€)</option>
                    <option value="FM">Micronesia, Federated States of (minimum 21€- reccomended 62€)</option>
                    <option value="MD">Moldova, Republic of (minimum 12€- reccomended 35€)</option>
                    <option value="MN">Mongolia (minimum 26€- reccomended 77€)</option>
                    <option value="ME">Montenegro (minimum 43€- reccomended 127€)</option>
                    <option value="MA">Morocco (minimum 21€- reccomended 62€)</option>
                    <option value="MZ">Mozambique (minimum 4€- reccomended 12€)</option>
                    <option value="MM">Myanmar (minimum 9€- reccomended 27€)</option>
                    <option value="NA">Namibia (minimum 39€- reccomended 115€)</option>
                    <option value="NP">Nepal (minimum 5€- reccomended 15€)</option>
                    <option value="NL">Netherlands (minimum 200€- reccomended 590€)</option>
                    <option value="NZ">New Zealand (minimum 200€- reccomended 590€)</option>
                    <option value="NI">Nicaragua (minimum 13€- reccomended 38€)</option>
                    <option value="NE">Niger (minimum 3€- reccomended 9€)</option>
                    <option value="NG">Nigeria (minimum 18€- reccomended 53€)</option>
                    <option value="NO">Norway (minimum 200€- reccomended 590€)</option>
                    <option value="OM">Oman (minimum 102€- reccomended 301€)</option>
                    <option value="PK">Pakistan (minimum 10€- reccomended 30€)</option>
                    <option value="PW">Palau (minimum 108€- reccomended 319€)</option>
                    <option value="PA">Panama (minimum 87€- reccomended 257€)</option>
                    <option value="PG">Papua New Guinea (minimum 14€- reccomended 41€)</option>
                    <option value="PY">Paraguay (minimum 27€- reccomended 80€)</option>
                    <option value="PE">Peru (minimum 40€- reccomended 118€)</option>
                    <option value="PH">Philippines (minimum 19€- reccomended 56€)</option>
                    <option value="PL">Poland (minimum 84€- reccomended 248€)</option>
                    <option value="PT">Portugal (minimum 128€- reccomended 378€)</option>
                    <option value="QA">Qatar (minimum 200€- reccomended 590€)</option>
                    <option value="RO">Romania (minimum 60€- reccomended 177€)</option>
                    <option value="RU">Russian Federation (minimum 61€- reccomended 180€)</option>
                    <option value="RW">Rwanda (minimum 5€- reccomended 15€)</option>
                    <option value="KN">Saint Kitts and Nevis (minimum 108€- reccomended 319€)</option>
                    <option value="LC">Saint Lucia (minimum 55€- reccomended 162€)</option>
                    <option value="VC">Saint Vincent and the Grenadines (minimum 46€- reccomended 136€)</option>
                    <option value="WS">Samoa (minimum 29€- reccomended 86€)</option>
                    <option value="SM">San Marino (minimum 200€- reccomended 590€)</option>
                    <option value="ST">Sao Tome and Principe (minimum 11€- reccomended 32€)</option>
                    <option value="SA">Saudi Arabia (minimum 139€- reccomended 410€)</option>
                    <option value="SN">Senegal (minimum 6€- reccomended 18€)</option>
                    <option value="RS">Serbia (minimum 34€- reccomended 100€)</option>
                    <option value="SC">Seychelles (minimum 100€- reccomended 295€)</option>
                    <option value="SL">Sierra Leone (minimum 4€- reccomended 12€)</option>
                    <option value="SG">Singapore (minimum 200€- reccomended 590€)</option>
                    <option value="SK">Slovakia (minimum 107€- reccomended 316€)</option>
                    <option value="SI">Slovenia (minimum 139€- reccomended 410€)</option>
                    <option value="SB">Solomon Islands (minimum 13€- reccomended 38€)</option>
                    <option value="SO">Somalia (minimum 1€- reccomended 3€)</option>
                    <option value="ZA">South Africa (minimum 38€- reccomended 112€)</option>
                    <option value="SS">South Sudan (minimum 1€- reccomended 3€)</option>
                    <option value="ES">Spain (minimum 173€- reccomended 510€)</option>
                    <option value="LK">Sri Lanka (minimum 26€- reccomended 77€)</option>
                    <option value="SD">Sudan (minimum 15€- reccomended 44€)</option>
                    <option value="SR">Suriname (minimum 62€- reccomended 183€)</option>
                    <option value="SZ">Swaziland (minimum 21€- reccomended 62€)</option>
                    <option value="SE">Sweden (minimum 200€- reccomended 590€)</option>
                    <option value="CH">Switzerland (minimum 200€- reccomended 590€)</option>
                    <option value="TW">Taiwan, Province of China (minimum 149€- reccomended 440€)</option>
                    <option value="TJ">Tajikistan (minimum 6€- reccomended 18€)</option>
                    <option value="TZ">Tanzania, United Republic of (minimum 6€- reccomended 18€)</option>
                    <option value="TH">Thailand (minimum 38€- reccomended 112€)</option>
                    <option value="TL">Timor-Leste (minimum 15€- reccomended 44€)</option>
                    <option value="TG">Togo (minimum 4€- reccomended 12€)</option>
                    <option value="TO">Tonga (minimum 27€- reccomended 80€)</option>
                    <option value="TT">Trinidad and Tobago (minimum 121€- reccomended 357€)</option>
                    <option value="TN">Tunisia (minimum 26€- reccomended 77€)</option>
                    <option value="TR">Turkey (minimum 63€- reccomended 186€)</option>
                    <option value="TM">Turkmenistan (minimum 44€- reccomended 130€)</option>
                    <option value="TV">Tuvalu (minimum 20€- reccomended 59€)</option>
                    <option value="UG">Uganda (minimum 4€- reccomended 12€)</option>
                    <option value="UA">Ukraine (minimum 13€- reccomended 38€)</option>
                    <option value="AE">United Arab Emirates (minimum 200€- reccomended 590€)</option>
                    <option value="UY">Uruguay (minimum 105€- reccomended 310€)</option>
                    <option value="UZ">Uzbekistan (minimum 14€- reccomended 41€)</option>
                    <option value="VU">Vanuatu (minimum 19€- reccomended 56€)</option>
                    <option value="VE">Venezuela, Bolivarian Republic of (minimum 52€- reccomended 153€)</option>
                    <option value="VN">Viet Nam (minimum 14€- reccomended 41€)</option>
                    <option value="YE">Yemen (minimum 9€- reccomended 27€)</option>
                    <option value="ZM">Zambia (minimum 9€- reccomended 27€)</option>
                    <option value="ZW">Zimbabwe (minimum 7€- reccomended 21€)</option>
          </select>
      </span>
      </div>
    </div>
    <div class="element-input"><label class="title">Amount in Euros<span class="required">*</span></label>
      <input id="amount" class="medium required" data-validation="number" type="text" name="input" required="required"/>
      <label id="amount-less" class="subtitle">Amount is less than minimal fee.</label>
    </div>
    <div class="element-checkbox"><label class="title"></label></div>
    <div class="element-separator"><hr><h3 class="section-break-title">Member details</h3></div>
    <div class="element-name">
      <label class="title">Member Name<span class="required">*</span> </label>
      <span class="nameFirst">
        <input  id="i_first_name" type="text" size="8" name="name[first]" />
        <label class="subtitle">First</label>
      </span><span class="nameLast">
        <input  id="i_last_name"  type="text" size="14" name="name[last]" />
        <label class="subtitle">Last</label>
      </span>
    </div>
    <div class="element-email">
      <label class="title">Email<span class="required">*</span></label>
      <input id="i_email" class="large" type="email" data-validation="email" name="email" value="" />
    </div>
    <div class="element-phone">
      <label class="title">Phone<span class="required">*</span></label>
      <select id="i_countrycode" class="onethird">
        <option data-countryCode="US" value="1" selected>USA (+1)</option>
        <option data-countryCode="GB" value="44">UK (+44)</option>
        <option disabled="disabled">Other Countries</option>
        <option data-countryCode="DZ" value="213">Algeria (+213)</option>
        <option data-countryCode="AD" value="376">Andorra (+376)</option>
        <option data-countryCode="AO" value="244">Angola (+244)</option>
        <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
        <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
        <option data-countryCode="AR" value="54">Argentina (+54)</option>
        <option data-countryCode="AM" value="374">Armenia (+374)</option>
        <option data-countryCode="AW" value="297">Aruba (+297)</option>
        <option data-countryCode="AU" value="61">Australia (+61)</option>
        <option data-countryCode="AT" value="43">Austria (+43)</option>
        <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
        <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
        <option data-countryCode="BH" value="973">Bahrain (+973)</option>
        <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
        <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
        <option data-countryCode="BY" value="375">Belarus (+375)</option>
        <option data-countryCode="BE" value="32">Belgium (+32)</option>
        <option data-countryCode="BZ" value="501">Belize (+501)</option>
        <option data-countryCode="BJ" value="229">Benin (+229)</option>
        <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
        <option data-countryCode="BT" value="975">Bhutan (+975)</option>
        <option data-countryCode="BO" value="591">Bolivia (+591)</option>
        <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
        <option data-countryCode="BW" value="267">Botswana (+267)</option>
        <option data-countryCode="BR" value="55">Brazil (+55)</option>
        <option data-countryCode="BN" value="673">Brunei (+673)</option>
        <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
        <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
        <option data-countryCode="BI" value="257">Burundi (+257)</option>
        <option data-countryCode="KH" value="855">Cambodia (+855)</option>
        <option data-countryCode="CM" value="237">Cameroon (+237)</option>
        <option data-countryCode="CA" value="1">Canada (+1)</option>
        <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
        <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
        <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
        <option data-countryCode="CL" value="56">Chile (+56)</option>
        <option data-countryCode="CN" value="86">China (+86)</option>
        <option data-countryCode="CO" value="57">Colombia (+57)</option>
        <option data-countryCode="KM" value="269">Comoros (+269)</option>
        <option data-countryCode="CG" value="242">Congo (+242)</option>
        <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
        <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
        <option data-countryCode="HR" value="385">Croatia (+385)</option>
        <!-- <option data-countryCode="CU" value="53">Cuba (+53)</option> -->
        <option data-countryCode="CY" value="90">Cyprus - North (+90)</option>
        <option data-countryCode="CY" value="357">Cyprus - South (+357)</option>
        <option data-countryCode="CZ" value="420">Czech Republic (+420)</option>
        <option data-countryCode="DK" value="45">Denmark (+45)</option>
        <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
        <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
        <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
        <option data-countryCode="EC" value="593">Ecuador (+593)</option>
        <option data-countryCode="EG" value="20">Egypt (+20)</option>
        <option data-countryCode="SV" value="503">El Salvador (+503)</option>
        <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
        <option data-countryCode="ER" value="291">Eritrea (+291)</option>
        <option data-countryCode="EE" value="372">Estonia (+372)</option>
        <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
        <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
        <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
        <option data-countryCode="FJ" value="679">Fiji (+679)</option>
        <option data-countryCode="FI" value="358">Finland (+358)</option>
        <option data-countryCode="FR" value="33">France (+33)</option>
        <option data-countryCode="GF" value="594">French Guiana (+594)</option>
        <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
        <option data-countryCode="GA" value="241">Gabon (+241)</option>
        <option data-countryCode="GM" value="220">Gambia (+220)</option>
        <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
        <option data-countryCode="DE" value="49">Germany (+49)</option>
        <option data-countryCode="GH" value="233">Ghana (+233)</option>
        <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
        <option data-countryCode="GR" value="30">Greece (+30)</option>
        <option data-countryCode="GL" value="299">Greenland (+299)</option>
        <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
        <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
        <option data-countryCode="GU" value="671">Guam (+671)</option>
        <option data-countryCode="GT" value="502">Guatemala (+502)</option>
        <option data-countryCode="GN" value="224">Guinea (+224)</option>
        <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
        <option data-countryCode="GY" value="592">Guyana (+592)</option>
        <option data-countryCode="HT" value="509">Haiti (+509)</option>
        <option data-countryCode="HN" value="504">Honduras (+504)</option>
        <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
        <option data-countryCode="HU" value="36">Hungary (+36)</option>
        <option data-countryCode="IS" value="354">Iceland (+354)</option>
        <option data-countryCode="IN" value="91">India (+91)</option>
        <option data-countryCode="ID" value="62">Indonesia (+62)</option>
        <option data-countryCode="IQ" value="964">Iraq (+964)</option>
        <!-- <option data-countryCode="IR" value="98">Iran (+98)</option> -->
        <option data-countryCode="IE" value="353">Ireland (+353)</option>
        <option data-countryCode="IL" value="972">Israel (+972)</option>
        <option data-countryCode="IT" value="39">Italy (+39)</option>
        <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
        <option data-countryCode="JP" value="81">Japan (+81)</option>
        <option data-countryCode="JO" value="962">Jordan (+962)</option>
        <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
        <option data-countryCode="KE" value="254">Kenya (+254)</option>
        <option data-countryCode="KI" value="686">Kiribati (+686)</option>
        <!-- <option data-countryCode="KP" value="850">Korea - North (+850)</option> -->
        <option data-countryCode="KR" value="82">Korea - South (+82)</option>
        <option data-countryCode="KW" value="965">Kuwait (+965)</option>
        <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
        <option data-countryCode="LA" value="856">Laos (+856)</option>
        <option data-countryCode="LV" value="371">Latvia (+371)</option>
        <option data-countryCode="LB" value="961">Lebanon (+961)</option>
        <option data-countryCode="LS" value="266">Lesotho (+266)</option>
        <option data-countryCode="LR" value="231">Liberia (+231)</option>
        <option data-countryCode="LY" value="218">Libya (+218)</option>
        <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
        <option data-countryCode="LT" value="370">Lithuania (+370)</option>
        <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
        <option data-countryCode="MO" value="853">Macao (+853)</option>
        <option data-countryCode="MK" value="389">Macedonia (+389)</option>
        <option data-countryCode="MG" value="261">Madagascar (+261)</option>
        <option data-countryCode="MW" value="265">Malawi (+265)</option>
        <option data-countryCode="MY" value="60">Malaysia (+60)</option>
        <option data-countryCode="MV" value="960">Maldives (+960)</option>
        <option data-countryCode="ML" value="223">Mali (+223)</option>
        <option data-countryCode="MT" value="356">Malta (+356)</option>
        <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
        <option data-countryCode="MQ" value="596">Martinique (+596)</option>
        <option data-countryCode="MR" value="222">Mauritania (+222)</option>
        <option data-countryCode="YT" value="269">Mayotte (+269)</option>
        <option data-countryCode="MX" value="52">Mexico (+52)</option>
        <option data-countryCode="FM" value="691">Micronesia (+691)</option>
        <option data-countryCode="MD" value="373">Moldova (+373)</option>
        <option data-countryCode="MC" value="377">Monaco (+377)</option>
        <option data-countryCode="MN" value="976">Mongolia (+976)</option>
        <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
        <option data-countryCode="MA" value="212">Morocco (+212)</option>
        <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
        <option data-countryCode="MN" value="95">Myanmar (+95)</option>
        <option data-countryCode="NA" value="264">Namibia (+264)</option>
        <option data-countryCode="NR" value="674">Nauru (+674)</option>
        <option data-countryCode="NP" value="977">Nepal (+977)</option>
        <option data-countryCode="NL" value="31">Netherlands (+31)</option>
        <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
        <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
        <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
        <option data-countryCode="NE" value="227">Niger (+227)</option>
        <option data-countryCode="NG" value="234">Nigeria (+234)</option>
        <option data-countryCode="NU" value="683">Niue (+683)</option>
        <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
        <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
        <option data-countryCode="NO" value="47">Norway (+47)</option>
        <option data-countryCode="OM" value="968">Oman (+968)</option>
        <option data-countryCode="PK" value="92">Pakistan (+92)</option>
        <option data-countryCode="PW" value="680">Palau (+680)</option>
        <option data-countryCode="PA" value="507">Panama (+507)</option>
        <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
        <option data-countryCode="PY" value="595">Paraguay (+595)</option>
        <option data-countryCode="PE" value="51">Peru (+51)</option>
        <option data-countryCode="PH" value="63">Philippines (+63)</option>
        <option data-countryCode="PL" value="48">Poland (+48)</option>
        <option data-countryCode="PT" value="351">Portugal (+351)</option>
        <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
        <option data-countryCode="QA" value="974">Qatar (+974)</option>
        <option data-countryCode="RE" value="262">Reunion (+262)</option>
        <option data-countryCode="RO" value="40">Romania (+40)</option>
        <option data-countryCode="RU" value="7">Russia (+7)</option>
        <option data-countryCode="RW" value="250">Rwanda (+250)</option>
        <option data-countryCode="SM" value="378">San Marino (+378)</option>
        <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
        <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
        <option data-countryCode="SN" value="221">Senegal (+221)</option>
        <option data-countryCode="CS" value="381">Serbia (+381)</option>
        <option data-countryCode="SC" value="248">Seychelles (+248)</option>
        <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
        <option data-countryCode="SG" value="65">Singapore (+65)</option>
        <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
        <option data-countryCode="SI" value="386">Slovenia (+386)</option>
        <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
        <option data-countryCode="SO" value="252">Somalia (+252)</option>
        <option data-countryCode="ZA" value="27">South Africa (+27)</option>
        <option data-countryCode="ES" value="34">Spain (+34)</option>
        <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
        <option data-countryCode="SH" value="290">St. Helena (+290)</option>
        <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
        <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
        <option data-countryCode="SR" value="597">Suriname (+597)</option>
        <option data-countryCode="SD" value="249">Sudan (+249)</option>
        <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
        <option data-countryCode="SE" value="46">Sweden (+46)</option>
        <option data-countryCode="CH" value="41">Switzerland (+41)</option>
        <!-- <option data-countryCode="SY" value="963">Syria (+963)</option> -->
        <option data-countryCode="TW" value="886">Taiwan (+886)</option>
        <option data-countryCode="TJ" value="992">Tajikistan (+992)</option>
        <option data-countryCode="TH" value="66">Thailand (+66)</option>
        <option data-countryCode="TG" value="228">Togo (+228)</option>
        <option data-countryCode="TO" value="676">Tonga (+676)</option>
        <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
        <option data-countryCode="TN" value="216">Tunisia (+216)</option>
        <option data-countryCode="TR" value="90">Turkey (+90)</option>
        <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
        <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
        <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
        <option data-countryCode="UG" value="256">Uganda (+256)</option>
        <option data-countryCode="UA" value="380">Ukraine (+380)</option>
        <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
        <option data-countryCode="UY" value="598">Uruguay (+598)</option>
        <option data-countryCode="UZ" value="998">Uzbekistan (+998)</option>
        <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
        <option data-countryCode="VA" value="379">Vatican City (+379)</option>
        <option data-countryCode="VE" value="58">Venezuela (+58)</option>
        <option data-countryCode="VN" value="84">Vietnam (+84)</option>
        <option data-countryCode="VG" value="1">Virgin Islands - British (+1)</option>
        <option data-countryCode="VI" value="1">Virgin Islands - US (+1)</option>
        <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
        <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
        <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
        <option data-countryCode="ZM" value="260">Zambia (+260)</option>
        <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
      </select>
      <input id="i_phone" class="twothird" type="tel" 
             pattern="[+]?[\.\s\-\(\)\*\#0-9]{3,}" maxlength="24" name="phone"  value=""/>
    </div>
    <div class="element-address">
      <label class="title">Address</label>
      <span class="addr1">
        <input id="i_address1" type="text" name="address[addr1]" />
        <label class="subtitle">Street Address</label>
      </span><span class="addr2">
        <input id="i_address2" type="text" name="address[addr2]" />
        <label class="subtitle">Address Line 2</label>
      </span><span class="city">
        <input id="i_city" type="text" name="address[city]" />
        <label class="subtitle">City</label>
      </span><span class="state">
        <input  id="i_state" type="text" name="address[state]" />
        <label class="subtitle">State / Province / Region</label>
      </span><span class="zip">
        <input id="i_zip" type="text" maxlength="15" name="address[zip]" />
        <label class="subtitle">Postal / Zip Code</label>
      </span><div class="country">
        <select id="x_country" name="address[country]" >
          <option selected="selected" value="" disabled="disabled">--- Select a country ---</option>
          <option value="AF">Afghanistan</option><option value="AX">Åland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BQ">Bonaire, Sint Eustatius and Saba</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="CV">Cabo Verde</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CD">Congo (Democratic Republic)</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="CI">Côte d'Ivoire</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CW">Curaçao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands (Malvinas)</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island and McDonald Islands</option><option value="VA">Holy See</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KP">Korea (Democratic People's Republic of)</option><option value="KR">Korea (Republic of)</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestine</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Réunion</option><option value="RO">Romania</option><option value="RU">Russian Federation</option><option value="RW">Rwanda</option><option value="BL">Saint Barthélemy</option><option value="SH">Saint Helena, Ascension and Tristan da Cunha</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome and Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SX">Sint Maarten</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia and the South Sandwich Islands</option><option value="SS">South Sudan</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TL">Timor-Leste</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VE">Venezuela</option><option value="VN">Viet Nam</option><option value="VG">Virgin Islands (British)</option><option value="VI">Virgin Islands (U.S.)</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option>
        </select>
        <label class="subtitle">Country</label>
      </div>
    </div>
    <div class="element-paychoice"><label class="title"></label>
      <span class="CC">
        <button type="button" class="show_credit_card btn btn-success">Credit Card</button>
      </span>
      <div class="pay_with_credit_card">
          <div class="element-separator"><hr><h3 class="section-break-title">Pay with Credit Cards</h3></div>        
	        <div class="element-input"><label class="title">Cardholder Name<span class="required">*</span></label><input class="large" type="text" name="input1" /></div>
		      <div class="element-input"><label class="title">Card Number<span class="required">*</span></label><input class="large" type="text" name="input2" /></div>
		            <div class="element-CC"><label class="title"></label>
            <span class="CVV">
              <input class="CVV" type="text" name="CVV" />
              <label class="subtitle">CVV<span class="required">*</span></label>
            </span>
            <span class="CC_Month">
              <select name="cc_month" required="required">
	      	              <option value="Jan">Jan</option>
			      	              <option value="Feb">Feb</option>
					      	              <option value="Mar">Mar</option>
							      	              <option value="Apr">Apr</option>
									      	              <option value="Maj">Maj</option>
											      	              <option value="Jun">Jun</option>
													      	              <option value="Jul">Jul</option>
															      	              <option value="Aug">Aug</option>
																	      	              <option value="Sep">Sep</option>
																			      	              <option value="Oct">Oct</option>
																					      	              <option value="Nov">Nov</option>
																							      	              <option value="Dic">Dic</option>
              </select>
              <label class="subtitle">Month<span class="required">*</span></label>
            </span>
            <span class="CC_Year">
              <select name="cc_year">
	      	              <option value="2017">2017</option>
			      	              <option value="2018">2018</option>
					      	              <option value="2019">2019</option>
							      	              <option value="2020">2020</option>
									      	              <option value="2021">2021</option>
											      	              <option value="2022">2022</option>
													      	              <option value="2023">2023</option>
															      	              <option value="2024">2024</option>
																	      	              <option value="2025">2025</option>
																			      	              <option value="2026">2026</option>
																					      	              <option value="2027">2027</option>
																							      	              <option value="2028">2028</option>
																									      	              <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2033">2033</option>
                <option value="2034">2034</option>
                <option value="2035">2035</option>
                <option value="2036">2036</option> 
              </select>
              <label class="subtitle">Year<span class="required">*</span></label>
            </span>
            </div>
	          <div class="element-input">
            <button type="button" class="btn btn-success">Join</button>
          </div>        
        </div>
      <div class="payment_with_paypal">

          <div class="element-separator"><hr><h3 class="section-break-title">Payment with Paypal</h3></div>        
        <span class="CC">
          <button id="submit-pay-pp"  type="button" class="btn btn-success">Pay</button>
        </span> 
      </div>
    </div>    
</form>
    <?php
}
