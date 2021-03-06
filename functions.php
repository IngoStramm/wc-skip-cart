<?php

/*
 * Change button text on Product Archives
 */
add_filter('woocommerce_loop_add_to_cart_link', 'misha_add_to_cart_text_1');

function misha_add_to_cart_text_1($add_to_cart_html)
{
    return str_replace('Add to cart', get_wc_skip_cart_buy_text_btn(), $add_to_cart_html);
}

/*
 * Change button text on product pages
 */
add_filter('woocommerce_product_single_add_to_cart_text', 'wc_skip_cart_add_to_cart_text_2');

function wc_skip_cart_add_to_cart_text_2($product)
{
    return get_wc_skip_cart_buy_text_btn();
}

/*
 * Change button text on Product Archives
 */
add_filter('woocommerce_product_add_to_cart_text', 'wc_skip_cart_add_to_cart_text_1', 10, 2);

function wc_skip_cart_add_to_cart_text_1($text, $product)
{
    return $product->is_purchasable() && $product->is_in_stock() ? get_wc_skip_cart_buy_text_btn() : get_wc_skip_cart_read_more_text_btn();
}

/*
 * Redirect to Checkout Page
 */
add_filter('woocommerce_add_to_cart_redirect', 'wc_skip_cart_skip_cart_redirect_checkout');

function wc_skip_cart_skip_cart_redirect_checkout($url)
{
    return wc_get_checkout_url();
}

/*
 * Fix for “Sold Individually” Products
 */
add_action('woocommerce_add_to_cart_validation', 'wc_skip_cart_woocommerce_add_to_cart_validation', 11, 2);

function wc_skip_cart_woocommerce_add_to_cart_validation($passed, $product_id)
{
    $product = wc_get_product($product_id);
    if (
        $product->get_sold_individually()                                              // if individual product
        && WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id($product_id)) // if in the cart
        && $product->is_purchasable()                                                      // if conditions
        && $product->is_in_stock()
    ) {
        wp_safe_redirect(wc_get_checkout_url());
        exit();
    }
    return $passed;
}

/*
 * Remove “The product has been added to your cart” message
 */
add_filter('wc_add_to_cart_message_html', 'wc_skip_cart_remove_add_to_cart_message');

function wc_skip_cart_remove_add_to_cart_message($message)
{
    return '';
}
