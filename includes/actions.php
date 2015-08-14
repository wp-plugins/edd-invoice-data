<?php

function bpmj_edd_invoice_data_enable_forms() {

    global $edd_options;

    $options = edd_get_payment_gateways();

    foreach ( $options as $key => $option ) :
        if ( isset( $edd_options[ 'edd_id_gateways' ][ $key ] ) )
            add_action('edd_' . $key . '_cc_form', 'bpmj_edd_invoice_data_cc_form', 1);
    endforeach;
}
add_action( 'plugins_loaded', 'bpmj_edd_invoice_data_enable_forms' );


function bpmj_edd_invoice_data_cc_form() {

    global $edd_options;

    //Definiujemy nazwy

    $type = __('Invoice', 'bpmj-edd-invoice-data');
    $invoice_checkbox_label = __('I want to receive an invoice', 'bpmj-edd-invoice-data');
    $invoice_data_label = __('Invoice data', 'bpmj-edd-invoice-data');

    $force = bpmj_edd_invoice_data_get_cb_setting( 'edd_id_force' );
    $person = bpmj_edd_invoice_data_get_cb_setting( 'edd_id_person' );

    ob_start();
    if( ! $force ) {
    ?>
        <fieldset class="bpmj_edd_invoice_data_invoice_check">
                <label for="bpmj_edd_invoice_data_invoice_check" class="edd-label">
                    <input type="checkbox" value="1" name="bpmj_edd_invoice_data_invoice_check" id="bpmj_edd_invoice_data_invoice_check" /><?php echo $invoice_checkbox_label; ?>
                </label>
        </fieldset>
    <?php
    } else {
    ?>
        <input type="hidden" value="1" name="bpmj_edd_invoice_data_invoice_check" id="bpmj_edd_invoice_data_invoice_check" />
    <?php
    }
    ?>

    <div class="bpmj_edd_invoice_data_invoice<?php if( $force ) echo '_force'; ?>">

        <fieldset>
            <span><legend><?php echo $invoice_data_label; ?></legend></span>

            <?php
            if( $person ) {
            ?>
                <p>
                    <label for="bpmj_edd_invoice_data_invoice_type" class="edd-label"><?php _e('I order as', 'bpmj-edd-invoice-data'); ?>
                        <span class="edd-required-indicator">*</span>
                    </label>
                    <select name="bpmj_edd_invoice_data_invoice_type">
                        <option value="person"><?php _e('Individual', 'bpmj-edd-invoice-data'); ?></option>
                        <option value="company"><?php _e('Company / Organization', 'bpmj-edd-invoice-data'); ?></option>
                    </select>
                </p>

                <p id="bpmj_edd_invoice_data_person_name_p">
                    <label for="bpmj_edd_invoice_data_invoice_person_name" class="edd-label"><?php _e('Name', 'bpmj-edd-invoice-data'); ?>
                        <span class="edd-required-indicator">*</span>
                    </label>
                    <span class="edd-description"><?php _e('Enter a name for the invoice', 'bpmj-edd-invoice-data'); ?></span>
                    <input type="text" value=""  name="bpmj_edd_invoice_data_invoice_person_name" class="edd-input">
                </p>
            <?php
            }else {
            ?>
                <input type="hidden" value="company" name="bpmj_edd_invoice_data_invoice_type" id="bpmj_edd_invoice_data_invoice_type" />
            <?php
            }
            ?>

            <p id="bpmj_edd_invoice_data_company_name_p<?php if( ! $person ) echo '_show'; ?>">
                <label for="bpmj_edd_invoice_data_invoice_company_name" class="edd-label"><?php _e('Company', 'bpmj-edd-invoice-data'); ?>
                    <span class="edd-required-indicator">*</span>
                </label>
                <span class="edd-description"><?php _e('Enter a company name for the invoice', 'bpmj-edd-invoice-data'); ?></span>
                <input type="text" value=""  name="bpmj_edd_invoice_data_invoice_company_name" class="edd-input">
            </p>

            <p id="bpmj_edd_invoice_data_nip_p<?php if( ! $person ) echo '_show'; ?>">
                <label for="bpmj_edd_invoice_data_invoice_nip" class="edd-label"><?php _e('Tax ID', 'bpmj-edd-invoice-data'); ?>
                    <span class="edd-required-indicator">*</span>
                </label>
                <input type="text" value=""  name="bpmj_edd_invoice_data_invoice_nip" class="edd-input">
            </p>

            <p>
                <label for="bpmj_edd_invoice_data_invoice_street" class="edd-label"><?php _e('Street', 'bpmj-edd-invoice-data'); ?>
                    <span class="edd-required-indicator">*</span>
                </label>
                <span class="edd-description"><?php _e('Enter the street name and number', 'bpmj-edd-invoice-data'); ?>
                    <span class="edd-required-indicator">*</span>
                </span>
                <input type="text" value=""  name="bpmj_edd_invoice_data_invoice_street" class="edd-input">
            </p>

            <p>
                <label for="bpmj_edd_invoice_data_invoice_postcode" class="edd-label"><?php _e('Postal Code', 'bpmj-edd-invoice-data'); ?>
                    <span class="edd-required-indicator">*</span>
                </label>
                <input type="text" value=""  name="bpmj_edd_invoice_data_invoice_postcode" class="edd-input">
            </p>

            <p>
                <label for="bpmj_edd_invoice_data_invoice_city" class="edd-label"><?php _e('City', 'bpmj-edd-invoice-data'); ?>
                    <span class="edd-required-indicator">*</span>
                </label>
                <input type="text" value=""  name="bpmj_edd_invoice_data_invoice_city" class="edd-input">
            </p>
        </fieldset>

    </div>



    <script>

        // Ukrywanie i pokazywanie danych do faktury/rachunku

        jQuery("input[name=bpmj_edd_invoice_data_invoice_check]").on("click", function() {

            if (jQuery('input[name=bpmj_edd_invoice_data_invoice_check]:checked').val() == '1') {
                jQuery('.bpmj_edd_invoice_data_invoice').slideDown();

            } else {
                jQuery('.bpmj_edd_invoice_data_invoice').slideUp();
            }

        });

        // Ukrywanie i pokazywanie danych w zależności od wyboru: osoba fiz. / firma

        if( jQuery("select[name=bpmj_edd_invoice_data_invoice_type]").length > 0 ) {
            jQuery("select[name=bpmj_edd_invoice_data_invoice_type]").on("change", function() {

                if (jQuery('select[name=bpmj_edd_invoice_data_invoice_type]').val() == 'person') {
                    jQuery('#bpmj_edd_invoice_data_person_name_p').slideDown();
                    jQuery('#bpmj_edd_invoice_data_company_name_p').slideUp();
                    jQuery('#bpmj_edd_invoice_data_nip_p').slideUp();
                } else {
                    jQuery('#bpmj_edd_invoice_data_person_name_p').slideUp();
                    jQuery('#bpmj_edd_invoice_data_company_name_p').slideDown();
                    jQuery('#bpmj_edd_invoice_data_nip_p').slideDown();
                }

            });
        }
    </script>

    <?php
    echo ob_get_clean();

}

/*
 * Zapisuje do bazy dane potrzebne do faktury lub rachunku
 */

function bpmj_edd_invoice_data_save_invoice($payment_meta) {
    
    if( isset($_POST['bpmj_edd_invoice_data_invoice_check'] ) && $_POST['bpmj_edd_invoice_data_invoice_check'] == 1 ) {

        $payment_meta['bpmj_edd_invoice_check'] = isset($_POST['bpmj_edd_invoice_data_invoice_check']) ? sanitize_text_field($_POST['bpmj_edd_invoice_data_invoice_check']) : '';
        $payment_meta['bpmj_edd_invoice_type'] = isset($_POST['bpmj_edd_invoice_data_invoice_type']) ? sanitize_text_field($_POST['bpmj_edd_invoice_data_invoice_type']) : '';
        $payment_meta['bpmj_edd_invoice_person_name'] = isset($_POST['bpmj_edd_invoice_data_invoice_person_name']) ? sanitize_text_field($_POST['bpmj_edd_invoice_data_invoice_person_name']) : '';
        $payment_meta['bpmj_edd_invoice_company_name'] = isset($_POST['bpmj_edd_invoice_data_invoice_company_name']) ? sanitize_text_field($_POST['bpmj_edd_invoice_data_invoice_company_name']) : '';
        $payment_meta['bpmj_edd_invoice_nip'] = isset($_POST['bpmj_edd_invoice_data_invoice_nip']) ? sanitize_text_field($_POST['bpmj_edd_invoice_data_invoice_nip']) : '';
        $payment_meta['bpmj_edd_invoice_street'] = isset($_POST['bpmj_edd_invoice_data_invoice_street']) ? sanitize_text_field($_POST['bpmj_edd_invoice_data_invoice_street']) : '';
        $payment_meta['bpmj_edd_invoice_postcode'] = isset($_POST['bpmj_edd_invoice_data_invoice_postcode']) ? sanitize_text_field($_POST['bpmj_edd_invoice_data_invoice_postcode']) : '';
        $payment_meta['bpmj_edd_invoice_city'] = isset($_POST['bpmj_edd_invoice_data_invoice_city']) ? sanitize_text_field($_POST['bpmj_edd_invoice_data_invoice_city']) : '';
    }

    return $payment_meta;
}
add_filter('edd_payment_meta', 'bpmj_edd_invoice_data_save_invoice');

/*
 * Sprawdza dane potrzebne do faktury lub rachunku
 */

function bpmj_edd_invoice_data_validate_invoice($valid_data, $data) {

    global $edd_options;

    // Sprawdzaj dane tylko wtedy, gdy zaznaczony jest checkbox z chęcią otrzymania faktury lub rachunku (ewentulnie, gdy włączona jest opcja wymuszenia)
    if( isset( $_POST['bpmj_edd_invoice_data_invoice_check'] ) && $_POST['bpmj_edd_invoice_data_invoice_check'] == 1 ) {

        $is_company = ( 'person' !== $_POST['bpmj_edd_invoice_data_invoice_type'] ) ? true : false;

        // Sprawdzamy imię i nazwisko
        if ( ! $is_company && empty( $data['bpmj_edd_invoice_data_invoice_person_name'] ) ) {
            edd_set_error( 'edd_invoice_data_invalid_person', __( 'Please enter a name for the invoice', 'bpmj-edd-invoice-data' ) );
        }

        // Sprawdzamy nazwę firmy
        if( $is_company && empty( $data['bpmj_edd_invoice_data_invoice_company_name'] ) ) {
            edd_set_error( 'bpmj_edd_invoice_data_invalid_company', __( 'Please enter a company name', 'bpmj-edd-invoice-data' ) );
        }

        // Sprawdzamy NIP
        if( $is_company && empty( $data['bpmj_edd_invoice_data_invoice_nip'] ) ) {
            edd_set_error( 'bpmj_edd_invoice_data_invalid_nip', __( 'Please enter a Tax ID', 'bpmj-edd-invoice-data' ) );
        }//else if( $is_company && ! bpmj_edd_invoice_data_check_nip( $data['bpmj_edd_invoice_data_invoice_nip'] ) ) { // TODO: VAT ID
        //    edd_set_error( 'bpmj_edd_invoice_data_invalid_nip_format', __( 'Tax ID number is invalid', 'bpmj-edd-invoice-data' ) );
        //}

        // Sprawdzamy nazwę ulicy
        if( empty( $data['bpmj_edd_invoice_data_invoice_street'] ) ) {
            edd_set_error( 'bpmj_edd_invoice_data_invalid_street', __( 'Please enter the name and street number', 'bpmj-edd-invoice-data' ) );
        }

        // Sprawdzamy kod pocztowy
        if( empty( $data['bpmj_edd_invoice_data_invoice_postcode'] ) ) {
            edd_set_error( 'bpmj_edd_invoice_data_postcode', __( 'Please enter a postal code', 'bpmj-edd-invoice-data' ) );
        }

        // Sprawdzamy miejscowość
        if( empty( $data['bpmj_edd_invoice_data_invoice_city'] ) ) {
            edd_set_error( 'bpmj_edd_invoice_data_city', __( 'Please enter a city name', 'bpmj-edd-invoice-data' ) );
        }
    }
}
add_action( 'edd_checkout_error_checks', 'bpmj_edd_invoice_data_validate_invoice', 10, 2 );

/*
 * Wyswietla dane potrzebne do wystawienia faktury lub  rachunku
 * 
 * Dane widoczne są w metaboxie dane kupującego w historii płatności
 */

function bpmj_edd_invoice_data_show_invoice_data($payment_meta, $user_info) {
    
    // Wyświetla dane do faktury lub rachunku tylko wtedy, gdy klient wybrał je podczas składania zamówienia
    if( isset( $payment_meta['bpmj_edd_invoice_company_name'] ) || isset( $payment_meta['bpmj_edd_invoice_person_name'] ) ) {

        $is_company = ( 'person' !== $payment_meta['bpmj_edd_invoice_type'] ) ? true : false;

        $person_name = isset($payment_meta['bpmj_edd_invoice_person_name']) ? $payment_meta['bpmj_edd_invoice_person_name'] : 'none';
        $company_name = isset($payment_meta['bpmj_edd_invoice_company_name']) ? $payment_meta['bpmj_edd_invoice_company_name'] : 'none';
        $nip = isset($payment_meta['bpmj_edd_invoice_nip']) ? $payment_meta['bpmj_edd_invoice_nip'] : 'none';
        $street = isset($payment_meta['bpmj_edd_invoice_street']) ? $payment_meta['bpmj_edd_invoice_street'] : 'none';
        $postcode = isset($payment_meta['bpmj_edd_invoice_postcode']) ? $payment_meta['bpmj_edd_invoice_postcode'] : 'none';
        $city = isset($payment_meta['bpmj_edd_invoice_city']) ? $payment_meta['bpmj_edd_invoice_city'] : 'none';
        
        
        
        // Pobierama typ rozliczenia i tworzy odpowiednie nazwy gramatyczne
        global $edd_options;

        echo '<div><h4>' . __('Invoice data', 'bpmj-edd-invoice-data') . '</h4><ul>';
        if( $is_company ) {
            echo '<li><b>' . __('Type:', 'bpmj-edd-invoice-data') . '</b> ' . __('Company / Organization', 'bpmj-edd-invoice-data') . '</li>';
            echo '<li><b>' . __('Company name:', 'bpmj-edd-invoice-data') . '</b> ' . $company_name . '</li>';
            echo '<li><b>' . __('Tax ID:', 'bpmj-edd-invoice-data') . '</b> ' . $nip . '</li>';
        }
        else {
            echo '<li><b>' . __('Type:', 'bpmj-edd-invoice-data') . '</b> ' . __('Individual', 'bpmj-edd-invoice-data') . '</li>';
            echo '<li><b>' . __('Name:', 'bpmj-edd-invoice-data') . '</b> ' . $person_name . '</li>';
        }
        echo '<li><b>' . __('Street:', 'bpmj-edd-invoice-data') . '</b> ' . $street . '</li>';
        echo '<li><b>' . __('Postal Code:', 'bpmj-edd-invoice-data') . '</b> ' . $postcode . '</li>';
        echo '<li><b>' . __('City:', 'bpmj-edd-invoice-data') . '</b> ' . $city . '</li>';
        echo '</ul></div>';

    }
}
add_action('edd_payment_personal_details_list', 'bpmj_edd_invoice_data_show_invoice_data', 10, 2);

/*
 * Filtr, który dodaje skrypt ukrywający formularz z fakturą gdy wartość produktów wynosi 0zł
 * 
 */

function bpmj_edd_invoice_data_hide_invoice_after_total_dis() {
    
    ?>
        <script>
        
        var bpmj_edd_invoice_data_total_amount = jQuery('.edd_cart_total .edd_cart_amount').text();
        var bpmj_edd_invoice_data_action1 = jQuery('body');

        var bpmj_edd_invoice_data_to_hide = jQuery('.bpmj_edd_invoice_data_invoice_check, .bpmj_edd_invoice_data_invoice');

        bpmj_edd_invoice_data_action1.mousemove(function() {

            bpmj_edd_invoice_data_total_amount = jQuery('.edd_cart_total .edd_cart_amount').text();

            if(bpmj_edd_invoice_data_total_amount.indexOf('0.00') == 0 || bpmj_edd_invoice_data_total_amount.indexOf('0,00') == 0 ||
               bpmj_edd_invoice_data_total_amount.indexOf(' 0.00') != -1 || bpmj_edd_invoice_data_total_amount.indexOf(' 0,00') != -1){
                bpmj_edd_invoice_data_to_hide.hide();
            } else {
                 jQuery('.bpmj_edd_invoice_data_invoice_check').show();
            }

        });
        </script>
        
        <?php

    
}
add_action( 'edd_after_purchase_form', 'bpmj_edd_invoice_data_hide_invoice_after_total_dis' );

?>