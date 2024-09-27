<?php
/**
 * Store all methods hooks filter related to checkout
 */
// Remove the payment section from the default position in the checkout

function custom_remove_payment_section()
{

    remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);

}

// add_action('woocommerce_before_checkout_form', 'custom_remove_payment_section');

// change create account text

function my_text_strings($translated_text, $text, $domain)
{

    if ('woocommerce' !== $domain) {

        return $translated_text;

    }

    switch ($translated_text) {

        case 'Create an account?':

            $translated_text = __('Create an account to track your orders', 'woocommerce');

            break;

    }

    return $translated_text;

}

add_filter('gettext', 'my_text_strings', 20, 3);

// Add fields on create account / change label

add_filter('woocommerce_checkout_fields', 'customize_checkout_account_fields');

function customize_checkout_account_fields($fields)
{

    if (isset($fields['account']['account_username'])) {

        $fields['account']['account_username']['label'] = __('Name', 'woocommerce');

    }

    if (isset($fields['account']['account_password'])) {

        $fields['account']['account_password']['label'] = __('Password', 'woocommerce');

    }

    $fields['account']['account_email'] = array(

        'type' => 'email',

        'label' => __('Email', 'woocommerce'),

        'placeholder' => __('Enter your email address', 'woocommerce'),

        'required' => true,

        'class' => array('form-row-wide'),

        'clear' => true,

    );

    // Reorder fields

    $fields['account'] = array(

        'account_email' => $fields['account']['account_email'],

        'account_username' => $fields['account']['account_username'],

        'account_password' => $fields['account']['account_password'],

    );

    return $fields;

}
