
// $().ready(function($) {
//   $('#i_form').validate();
// });

$(function() {

  // define functions
  var distribute = function($from,$to,$other) {
    var $inval = $($from).val()
    $($to).val($inval);
    $($other).val($inval);
  };

  var fill = function($value,$to) {
    $($to).val($value);
    $($to).trigger('change');
  };

  var fill_person_info = function() {
    var $fn = $('#i_last_name').val()  + ", " + $('#i_first_name').val() + "|" + $("#i_country").val() + "|" + $("#i_state").val() + "|" + $("#i_city").val() + "|" + $("#i_zip").val() + "|" + $("#i_address1").val() + "|" + $("#i_address2").val() ;
    fill($fn,'#ppf-os0'); 
  };

  var fill_name = function() {
    var $fn = $('#i_first_name').val()  + " " + $('#i_last_name').val() ;
    fill($fn,'#ppf-address_name'); 
    fill($fn,'#fullstripe-custom-input__join__1');
  };

  var fill_person_contacts = function() { 
    var $fn = "TEL: "  + $("#i_phone").val() + " | EMAIL: " + $("#i_email").val();  
    fill($fn,'#ppf-os1');
  };

  var fill_custom = function() {
    if ( $("#i_show").is(':checked') ) {
      $show = "X";
    } else {
      $show = "O";
    };
    var $fn = $show  + $("#i_message").val() ;
    fill($fn,'#ppf-custom');
  };

  var fill_item = function() {
    var $kind = "CUST";
    if ( $("#i_kind").val()  === "1" ) {
      $kind = "RACC";
    } else {
      $kind = "MIN";
    };
    if ( $("#i_show").is(':checked') ) {
      $show = "SHOW";
    } else {
      $show = "NO-SHOW";
    };
    var $item = "Membership: " + $("#i_year").val() + " " + $kind + "(" + $("#amount").val() + " EUR )" + " " + $("#i_country").val() + " | " + $("#i_first_name").val() + " | " + $("#i_last_name").val() + "| " + $show;
    fill( $item ,'#ppf-item_name');
  };

  // Fill Inner forms
  var copy_to_inner_forms = function() {
    fill_name();
    fill_person_info();
    fill_person_contacts();
    fill_item();
    fill_custom();
    fill($('#i_email').val(),'#ppf-email'); 
    fill($('#i_email').val(),'input#fullstripe_email__join');
    fill($('#i_phone').val(),'#ppf-phone'); 
    fill($('#i_phone').val(),'input#fullstripe-custom-input__join__2');
    fill($('#i_address1').val(),'#ppf-address1'); 
    fill($('#i_address1').val(),'fullstripe_address_line1__join'); 
    fill($('#i_address2').val(),'#ppf-address2'); 
    fill($('#i_address2').val(),'fullstripe_address_line2__join'); 
    fill($('#i_state').val(),'#ppf-state'); 
    fill($('#i_state').val(),'fullstripe_address_state__join'); 
    fill($('#i_zip').val(),'#ppf-zip'); 
    fill($('#i_zip').val(),'fullstripe_address_zip__join'); 
    fill($('#i_city').val(),'#ppf-city'); 
    fill($('#i_city').val(),'fullstripe_address_city__join'); 
    fill($('#i_country').val(),'#ppf-country'); 
    fill($('#i_country').val(),'fullstripe-address-country__join'); 
    fill($('#i_countrycode').val(),'#ppf-countrycode');
    // CC info
    fill($('#i_input1').val(),'#fullstripe_name__join');  
    fill($('#i_input2').val(),'input[data-stripe=number]'); 
    fill($('#i_input3').val(),'input[data-stripe=cvc]');  
    fill($('#i_cc_month').val(),'select[data-stripe=exp-month]');  
    fill($('#i_cc_year').val(),'select[data-stripe=exp-year]');     
  };

  // hide paying elements
  $("div.pay_with_credit_card").hide();
  $("div.pay_with_paypal").hide();
  $("div.stripe_join_block").show();
  $("div.paypal_join_block").show();
  $("div.stripe_donate").hide();

  // Define initial values
  $('#i_show').prop( "checked", true ).trigger('change');

  var $QUOTE = {
    "0": {
      "AE": 200,
      "AF": 4,
      "AG": 97,
      "AL": 27,
      "AM": 24,
      "AO": 27,
      "AR": 91,
      "AT": 200,
      "AU": 200,
      "AZ": 38,
      "BA": 27,
      "BB": 106,
      "BD": 9,
      "BE": 200,
      "BF": 4,
      "BG": 46,
      "BH": 157,
      "BI": 2,
      "BJ": 5,
      "BN": 189,
      "BO": 19,
      "BR": 58,
      "BS": 160,
      "BT": 19,
      "BW": 40,
      "BY": 38,
      "BZ": 32,
      "CA": 200,
      "CD": 3,
      "CF": 2,
      "CG": 14,
      "CH": 200,
      "CI": 9,
      "CL": 89,
      "CM": 8,
      "CN": 54,
      "CO": 41,
      "CR": 73,
      "CV": 20,
      "CY": 151,
      "CZ": 116,
      "DE": 200,
      "DJ": 12,
      "DK": 200,
      "DM": 47,
      "DO": 45,
      "DZ": 29,
      "EC": 41,
      "EE": 116,
      "EG": 25,
      "ER": 5,
      "ES": 173,
      "ET": 5,
      "FI": 200,
      "FJ": 36,
      "FM": 21,
      "FR": 200,
      "GA": 52,
      "GB": 200,
      "GD": 60,
      "GE": 25,
      "GH": 9,
      "GM": 3,
      "GN": 4,
      "GN": 79,
      "GR": 121,
      "GT": 26,
      "GW": 4,
      "GY": 28,
      "HK": 200,
      "HN": 16,
      "HR": 77,
      "HT": 5,
      "HU": 82,
      "ID": 23,
      "IE": 200,
      "IL": 200,
      "IN": 11,
      "IQ": 32,
      "IR": 33,
      "IS": 200,
      "IT": 200,
      "JM": 33,
      "JO": 37,
      "JP": 200,
      "KE": 9,
      "KG": 7,
      "KH": 8,
      "KI": 10,
      "KM": 5,
      "KN": 108,
      "KR": 182,
      "KW": 197,
      "KZ": 66,
      "LA": 12,
      "LB": 75,
      "LC": 55,
      "LK": 26,
      "LR": 3,
      "LS": 7,
      "LT": 95,
      "LU": 200,
      "LV": 91,
      "LY": 41,
      "MA": 21,
      "MD": 12,
      "ME": 43,
      "MG": 3,
      "MH": 22,
      "MK": 32,
      "ML": 5,
      "MM": 9,
      "MN": 26,
      "MR": 9,
      "MT": 153,
      "MU": 62,
      "MV": 60,
      "MW": 2,
      "MX": 60,
      "MY": 64,
      "MZ": 4,
      "NA": 39,
      "NE": 3,
      "NG": 18,
      "NI": 13,
      "NL": 200,
      "NO": 200,
      "NP": 5,
      "NZ": 200,
      "OM": 102,
      "PA": 87,
      "PE": 40,
      "PG": 14,
      "PH": 19,
      "PK": 10,
      "PL": 84,
      "PT": 128,
      "PW": 108,
      "PY": 27,
      "QA": 200,
      "RO": 60,
      "RS": 34,
      "RU": 61,
      "RW": 5,
      "SA": 139,
      "SB": 13,
      "SC": 100,
      "SD": 15,
      "SE": 200,
      "SG": 200,
      "SI": 139,
      "SK": 107,
      "SL": 4,
      "SM": 200,
      "SN": 6,
      "SO": 1,
      "SR": 62,
      "SS": 1,
      "ST": 11,
      "SV": 27,
      "SZ": 21,
      "TD": 6,
      "TG": 4,
      "TH": 38,
      "TJ": 6,
      "TL": 15,
      "TM": 44,
      "TN": 26,
      "TO": 27,
      "TR": 63,
      "TT": 121,
      "TV": 20,
      "TW": 149,
      "TZ": 6,
      "UA": 13,
      "UG": 4,
      "US": 200,
      "UY": 105,
      "UZ": 14,
      "VC": 46,
      "VE": 52,
      "VN": 14,
      "VU": 19,
      "WS": 29,
      "YE": 9,
      "ZA": 38,
      "ZM": 9,
      "ZW": 7,
    },
    "1": {
      "AE": 590,
      "AF": 12,
      "AG": 286,
      "AL": 80,
      "AM": 71,
      "AO": 80,
      "AR": 268,
      "AT": 590,
      "AU": 590,
      "AZ": 112,
      "BA": 80,
      "BB": 313,
      "BD": 27,
      "BE": 590,
      "BF": 12,
      "BG": 136,
      "BH": 463,
      "BI": 6,
      "BJ": 15,
      "BN": 558,
      "BO": 56,
      "BR": 171,
      "BS": 472,
      "BT": 56,
      "BW": 118,
      "BY": 112,
      "BZ": 94,
      "CA": 590,
      "CD": 9,
      "CF": 6,
      "CG": 41,
      "CH": 590,
      "CI": 27,
      "CL": 263,
      "CM": 24,
      "CN": 159,
      "CO": 121,
      "CR": 215,
      "CV": 59,
      "CY": 445,
      "CZ": 342,
      "DE": 590,
      "DJ": 35,
      "DK": 590,
      "DM": 139,
      "DO": 133,
      "DZ": 86,
      "EC": 121,
      "EE": 342,
      "EG": 74,
      "ER": 15,
      "ES": 510,
      "ET": 15,
      "FI": 590,
      "FJ": 106,
      "FM": 62,
      "FR": 590,
      "GA": 153,
      "GB": 590,
      "GD": 177,
      "GE": 74,
      "GH": 27,
      "GM": 9,
      "GN": 12,
      "GN": 233,
      "GR": 357,
      "GT": 77,
      "GW": 12,
      "GY": 83,
      "HK": 590,
      "HN": 47,
      "HR": 227,
      "HT": 15,
      "HU": 242,
      "ID": 68,
      "IE": 590,
      "IL": 590,
      "IN": 32,
      "IQ": 94,
      "IR": 97,
      "IS": 590,
      "IT": 590,
      "JM": 97,
      "JO": 109,
      "JP": 590,
      "KE": 27,
      "KG": 21,
      "KH": 24,
      "KI": 30,
      "KM": 15,
      "KN": 319,
      "KR": 537,
      "KW": 581,
      "KZ": 195,
      "LA": 35,
      "LB": 221,
      "LC": 162,
      "LK": 77,
      "LR": 9,
      "LS": 21,
      "LT": 280,
      "LU": 590,
      "LV": 268,
      "LY": 121,
      "MA": 62,
      "MD": 35,
      "ME": 127,
      "MG": 9,
      "MH": 65,
      "MK": 94,
      "ML": 15,
      "MM": 27,
      "MN": 77,
      "MR": 27,
      "MT": 451,
      "MU": 183,
      "MV": 177,
      "MW": 6,
      "MX": 177,
      "MY": 189,
      "MZ": 12,
      "NA": 115,
      "NE": 9,
      "NG": 53,
      "NI": 38,
      "NL": 590,
      "NO": 590,
      "NP": 15,
      "NZ": 590,
      "OM": 301,
      "PA": 257,
      "PE": 118,
      "PG": 41,
      "PH": 56,
      "PK": 30,
      "PL": 248,
      "PT": 378,
      "PW": 319,
      "PY": 80,
      "QA": 590,
      "RO": 177,
      "RS": 100,
      "RU": 180,
      "RW": 15,
      "SA": 410,
      "SB": 38,
      "SC": 295,
      "SD": 44,
      "SE": 590,
      "SG": 590,
      "SI": 410,
      "SK": 316,
      "SL": 12,
      "SM": 590,
      "SN": 18,
      "SO": 3,
      "SR": 183,
      "SS": 3,
      "ST": 32,
      "SV": 80,
      "SZ": 62,
      "TD": 18,
      "TG": 12,
      "TH": 112,
      "TJ": 18,
      "TL": 44,
      "TM": 130,
      "TN": 77,
      "TO": 80,
      "TR": 186,
      "TT": 357,
      "TV": 59,
      "TW": 440,
      "TZ": 18,
      "UA": 38,
      "UG": 12,
      "US": 590,
      "UY": 310,
      "UZ": 41,
      "VC": 136,
      "VE": 153,
      "VN": 41,
      "VU": 56,
      "WS": 86,
      "YE": 27,
      "ZA": 112,
      "ZM": 27,
      "ZW": 21,
    }
  };

  // Show parts of form
  $(".show_credit_card").click(function() {
    $("section.page-heading").hide();             // ---------------
    $("div.pay_with_paypal").hide();
    $("div.pay_with_credit_card").show();
    $("button.show_credit_card").prop('disabled',true).css('opacity',0.5);
    $("button.show_paypal").prop('disabled',false).css('opacity',1.0);
  });

  $(".show_paypal").click(function() {
    $("section.page-heading").hide();             // ---------------
    $("div.pay_with_paypal").show();
    $("div.pay_with_credit_card").hide();
    $("button.show_paypal").prop('disabled',true).css('opacity',0.5);
    $("button.show_credit_card").prop('disabled',false).css('opacity',1.0);
  });

  // Submit payments
  $("#submit-pay-pp").click(function() {
    // $('#i_form').validate();
    copy_to_inner_forms();
    // $("form#paypal-payment-form").submit();
  });

  // Submit payments
  $("#submit-pay-stripe").click(function() {
    copy_to_inner_forms();
    // $("form#paypal-payment-form").submit();
  });

  // field change
  $("#i_year").change(function() {    
    distribute("#i_year","#amount","#pp-year");
    fill($(this).val(),'#ppf-year');
  });

  $("#i_kind").change(function() {
    if ($("#i_kind").val() === "2") {
      $("#amount").val("<your amount here>");
    } else {
      if ($('#i_country').val() !== "") {
        var val = $QUOTE[$("#i_kind").val()][$("#i_country").val()];
        $("#amount").val(val); 
        distribute("#amount","#stripe-amount","#pp-payment-form #amount");
      }
    }
    fill($(this).val(),'#ppf-kind');
  });

  $("#i_country").change(function() {
    var $year = $("#i_year").val();
    var $kind = $("#i_kind").val();
    var $country = $("#i_country").val();
    $("#i_year").val('2018');
    if ($year == null) {
      $("#i_year").val('2018');
      $("#i_year").trigger('change');
    }
    if ($kind == null) {
      $("#i_kind").val('1');
      $("#i_kind").trigger('change');
      $kind = "1";
      fill($kind,'#ppf-kind');
    };
    if ($kind === "2") {
      $("#amount").val("<your amount here>");
    } else {
      var $val = $QUOTE[$kind][$country];
      $("#amount").val($val);    
      $("#amount").trigger('change');
      distribute("#amount","#stripe-amount","#ppf-amount");
    };
    fill($(this).val(),'#x_country');
    $('#i_countrycode option[data-countryCode='+$country+']').prop('selected','selected');
    $('#t_countrycode').trigger('change');
    fill($('#x_country').text(),'#ppf-country');
    fill($(this).val(),'#ppf-countrycode');
  });

  $("#amount").change(function() {
    if ($('#i_country').val() !== "") {
      var $val = $QUOTE["0"][$("#i_country").val()];
      if ( Number($val) > Number($(this).val()) ) {
        $("#amount-less").show();
      } else {
        $("#amount-less").hide();
      }
    };
    fill($(this).val(),'#ppf-amount');
    fill($(this).val(),'#fullstripe-custom-amount__join');
    $('#submit-pay-pp').text('Pay with Paypal — ('+ $(this).val() + ' € )').trigger('change');    
  });

  $('#i_email').change(function() { fill($(this).val(),'#ppf-email'); fill($(this).val(),'input#fullstripe_email__join');   });
  $('#i_phone').change(function() { fill($(this).val(),'#ppf-phone'); fill($(this).val(),'input#fullstripe-custom-input__join__2');   });
  $('#i_first_name').change(function() { fill_name();  });
  $('#i_first_name').change(function() { fill($(this).val(),'#ppf-first_name');  });
  $('#i_last_name').change(function() { fill_name();  });
  $('#i_last_name').change(function() { fill($(this).val(),'#ppf-last_name');  });
  $('#i_address1').change(function() { fill($(this).val(),'#ppf-address1');  fill($(this).val(),'fullstripe_address_line1__join')}); 
  $('#i_address2').change(function() { fill($(this).val(),'#ppf-address2');  fill($(this).val(),'fullstripe_address_line2__join')}); 
  $('#i_state').change(function() { fill($(this).val(),'#ppf-state');  fill($(this).val(),'fullstripe_address_state__join')}); 
  $('#i_zip').change(function() { fill($(this).val(),'#ppf-zip');  fill($(this).val(),'fullstripe_address_zip__join')}); 
  $('#i_city').change(function() { fill($(this).val(),'#ppf-city');  fill($(this).val(),'fullstripe_address_city__join')}); 
  $('#i_country').change(function() { fill($(this).val(),'#ppf-country');  fill($(this).val(),'fullstripe-address-country__join')}); 
  $('#i_countrycode').change(function() { fill($(this).val(),'#ppf-countrycode');  });
  $('#i_input1').change(function() { fill($(this).val(),'#fullstripe_name__join');  }); 
  $('#i_input2').change(function() { fill($(this).val(),'input[data-stripe=number]');  });
  $('#i_input3').change(function() { fill($(this).val(),'input[data-stripe=cvc]');  }); 
  $('#i_cc_month').change(function() { fill($(this).val(),'select[data-stripe=exp-month]');  });
  $('#i_cc_year').change(function() { fill($(this).val(),'select[data-stripe=exp-year]');  });
  

});

// new Card({
//   form: 'form',
//   container: '.card',
//   formSelectors: {
//     numberInput: 'input[name=number]',
//     expiryInput: 'input[name=expiry]',
//     cvcInput: 'input[name=cvv]',
//     nameInput: 'input[name=name]'
//   },

//   width: 390, // optional — default 350px
//   formatting: true,

//   placeholders: {
//     number: '•••• •••• •••• ••••',
//     name: 'Full Name',
//     expiry: '••/••',
//     cvc: '•••'
//   }
// })


// jQuery.validator.setDefaults({
//   debug: true,
//   success: "valid"
// });
// $( "#amount" ).validate({
//   rules: {
//     field: {
//       required: true,
//       number: true
//     }
//   }
// });

