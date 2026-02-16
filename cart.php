<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

$wrapper_class = apply_filters(
	'blocksy:woocommerce:cart:wrapper-class',
	'ct-woocommerce-cart-form'
);

$image_size = blocksy_get_theme_mod('cart_page_image_size', 'woocommerce_thumbnail');
$image_ratio = blocksy_get_theme_mod('cart_page_image_ratio', '1/1');

?>

<style>
/* Retro Cart Styling - Refined */
:root {
    --cart-box-bg: rgba(255, 154, 0, 0.11);
    --cart-border-color: #000000;
    --cart-border-width: 2px;
    --cart-border-radius: 20px;
    --cart-shadow-offset: 0px; /* Figma shows internal elements have shadow, main box is flat/border only? No, main box has border. */
    --cart-btn-red: #ea0f09;
    --cart-btn-grey: #9E9E9E; /* Need to verify exact grey, matching screenshot */
    --cart-btn-orange: #ff7300;
    --cart-text-color: #000000;
    --cart-font-main: 'Genova', sans-serif;
    --cart-font-mono: 'Roboto Mono', monospace;
}

.woocommerce-cart .entry-content {
    background-color: transparent;
}

/* Page Title "Panier" */
.custom-cart-title-wrapper {
    position: relative;
    height: 100px; /* Adjust as needed */
    margin-bottom: 20px;
    font-family: var(--cart-font-main);
    font-size: 80px; /* Figma said 354px but that's likely the container or specific graphic scaling. 80px is reasonable for web. */
    line-height: 1;
    font-weight: 900;
}

.custom-cart-title {
    position: absolute;
    top: 0;
    left: 0;
    color: #000;
    z-index: 2;
    -webkit-text-stroke: 2px black; /* Simulate the thick border look */
}

.custom-cart-title-shadow {
    position: absolute;
    top: 5px;
    left: 5px;
    color: #efeadd; /* The light color from Figma text layer */
    z-index: 1;
    -webkit-text-stroke: 2px black;
}


/* Wrapper Layout */
.ct-woocommerce-cart-form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 50px;
    align-items: stretch; /* Ensure same height */
    justify-content: space-between;
}

/* Left Column: Cart Form */
.woocommerce-cart-form {
    flex: 2 1 400px; /* Reduced min-width to prevent early wrapping */
    width: auto !important;
    max-width: 100%;
    margin-right: 0;
    
    background: var(--cart-box-bg);
    border: var(--cart-border-width) solid var(--cart-border-color);
    border-radius: var(--cart-border-radius);
    padding: 20px;
    box-shadow: none; 
    display: flex;
    flex-direction: column;
}

/* Right Column: Cart Totals */
.cart-collaterals, 
.cart_totals {
    width: 100% !important;
    float: none !important;
    max-width: 100%;
    /* Ensure flex item behavior is set on the direct child if wrapper exists */
    flex: 1 1 300px; 
    min-width: 300px;
}

.cart_totals {
    background: var(--cart-box-bg) !important;
    border: var(--cart-border-width) solid var(--cart-border-color) !important;
    border-radius: var(--cart-border-radius) !important;
    padding: 30px !important; /* Increased padding */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%; 
}

/* Hide the default "Total panier" heading */
.cart_totals > h2 {
    display: none !important;
}

/* Shop Table in Totals */
.cart_totals table.shop_table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.cart_totals table.shop_table th,
.cart_totals table.shop_table td {
    padding: 15px 0;
    vertical-align: middle;
    border-top: 1px solid rgba(0,0,0,0.1); 
}

.cart_totals table.shop_table tr:first-child th,
.cart_totals table.shop_table tr:first-child td {
    border-top: none;
}

/* Subtotal Label */
.cart-subtotal th {
    font-weight: 500;
    font-size: 16px; 
    font-family: var(--cart-font-main);
}

/* Subtotal Amount */
.cart-subtotal .amount {
    font-weight: 700;
    font-size: 16px;
    font-family: var(--cart-font-main);
}

/* Grand Total Row */
.order-total th {
    font-weight: 900 !important;
    font-size: 20px !important;
    font-family: var(--cart-font-main) !important;
    color: #000;
}

.order-total .amount {
    font-weight: 900 !important;
    font-size: 20px !important;
    font-family: var(--cart-font-main) !important;
    color: #000;
}

/* Checkout Button container */
.wc-proceed-to-checkout {
    padding: 0 !important;
    margin-top: 20px;
}


/* Table Headers */
table.shop_table thead th {
    font-family: var(--cart-font-main);
    font-weight: 900;
    font-size: 16px; /* Slightly smaller to save space */
    border-bottom: 1px solid var(--cart-border-color) !important;
    padding-bottom: 15px;
}

/* Product Rows */
table.shop_table tbody td {
    padding: 15px 0 !important;
    border-bottom: none !important;
}

.product-thumbnail img {
    border-radius: 10px;
    border: none;
    width: 80px; /* Smaller thumbnail */
    box-shadow: none;
}

.product-name a {
    font-family: var(--cart-font-main);
    font-size: 16px;
    font-weight: 500;
}

/* Prices */
.product-price {
    font-family: var(--cart-font-main);
    font-weight: 500;
    font-size: 16px;
    color: #000;
    vertical-align: middle; /* Ensure vertical alignment in cell */
}

/* Regular Price (or Sale Original Price wrapper) */
.product-price del {
    color: #9E9E9E !important;
    text-decoration: line-through !important;
    opacity: 1 !important;
    font-size: 14px !important;
    display: block !important; /* Force new line */
    margin-right: 0 !important;
    margin-bottom: 2px !important; /* Small gap */
    font-weight: 400 !important;
    line-height: 1.2 !important;
}

.product-price del .amount {
    color: #9E9E9E !important;
    text-decoration: line-through !important;
    font-weight: 400 !important;
}

/* Sale Price (or Regular Price if no sale) */
.product-price ins {
    color: #EA0F09 !important;
    text-decoration: none !important;
    opacity: 1;
    font-weight: 900 !important;
    font-size: 16px !important;
    display: block !important; /* Force new line */
    line-height: 1.2 !important;
}

.product-price ins .amount {
    color: #EA0F09 !important;
    font-weight: 900 !important;
}

.product-price .amount {
    display: inline-block; /* Ensure amount stays inline inside its wrapper if needed, but wrapper is block */
}

.product-subtotal .amount {
    font-family: var(--cart-font-main);
    font-weight: 900;
    font-size: 18px;
}

/* Quantity Column Alignment */
th.product-quantity,
td.product-quantity {
    text-align: center !important;
}

/* Quantity Input Customization - FIXED */
.quantity {
    display: inline-flex !important; /* Use inline-flex to obey text-align center of td */
    align-items: center !important;
    flex-wrap: nowrap !important; 
    gap: 5px !important;
    width: auto !important;
    margin: 0 auto; /* Center in flex context if needed, but text-align handles inline-flex */
    justify-content: center !important;
}

/* Hide default theme buttons (duplicates) */
.quantity button:not(.custom-qty-btn),
.quantity a.plus,
.quantity a.minus,
.quantity .qty-btn, 
.quantity .qty-handle,
.qty_button,
.ct-increase,
.ct-decrease {
    display: none !important;
}


.quantity input.qty {
    background: transparent !important;
    border: none !important;
    font-weight: 700 !important;
    width: 30px !important; /* Fixed narrow width */
    min-width: 30px !important;
    height: 30px !important;
    padding: 0 !important;
    text-align: center !important;
    -moz-appearance: textfield;
    font-size: 16px !important;
    margin: 0 !important;
}

/* Quantity Buttons */
.qty_button.custom-qty-btn {
    width: 24px !important; /* Smaller button */
    height: 24px !important;
    min-width: 24px !important;
    border-radius: 50% !important;
    border: none !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    padding: 0 !important;
    line-height: 1 !important;
}

.qty_button.minus.custom-qty-btn {
    background-color: #9E9E9E !important; 
}

.qty_button.plus.custom-qty-btn {
    background-color: var(--cart-btn-red) !important;
}

/* ... svg ... */


.qty_button svg {
    width: 10px !important;
    height: 10px !important;
}

/* Coupon */
.coupon {
    display: flex;
    flex-wrap: wrap; 
    gap: 10px;
    border-top: none; 
    align-items: center;
    justify-content: flex-start;
}

.coupon input.input-text {
    background: rgba(255, 255, 255, 0.3) !important;
    border: 1px solid var(--cart-border-color) !important;
    border-radius: 5px !important;
    height: 40px !important; /* Slightly smaller height */
    padding: 0 10px !important;
    font-family: var(--cart-font-main) !important;
    max-width: 140px !important; /* Prevent taking too much space */
    font-size: 14px !important;
}

/* Unified Secondary Button Styles (Coupon & Update Cart) */
.coupon button.button,
button[name="update_cart"],
.woocommerce-cart-form button[name="update_cart"] {
    background: #FFFFFF !important;
    border: 1.6px solid var(--cart-border-color) !important;
    box-shadow: 4px 4px 0px var(--cart-border-color) !important;
    border-radius: 5px !important;
    height: 40px !important; /* Match input height */
    font-family: var(--cart-font-mono) !important;
    font-weight: 400 !important;
    font-size: 14px !important; /* Smaller text */
    text-transform: uppercase !important;
    color: #000 !important;
    padding: 0 15px !important;
    cursor: pointer !important;
    line-height: 1 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    white-space: nowrap !important;
    transition: all 0.2s !important;
    text-shadow: none !important;
}

.coupon button.button:hover,
button[name="update_cart"]:hover,
.woocommerce-cart-form button[name="update_cart"]:hover {
    box-shadow: 2px 2px 0px var(--cart-border-color) !important;
    transform: translate(2px, 2px) !important;
    background: #fff !important;
    color: #000 !important;
}

.coupon button.button:active,
button[name="update_cart"]:active,
.woocommerce-cart-form button[name="update_cart"]:active {
    box-shadow: 0px 0px 0px var(--cart-border-color) !important;
    transform: translate(4px, 4px) !important;
}

/* Update Cart Button Positioning */
button[name="update_cart"],
.woocommerce-cart-form button[name="update_cart"] {
    display: inline-block !important;
    margin-left: auto !important;
    float: right !important; /* Force right align if flex fails */
    opacity: 1 !important; /* Ensure visibility even if disabled */
}
button[name="update_cart"]:disabled,
.woocommerce-cart-form button[name="update_cart"]:disabled {
    opacity: 0.6 !important;
    cursor: not-allowed !important;
    box-shadow: 2px 2px 0px var(--cart-border-color) !important;
    transform: translate(2px, 2px) !important;
}

/* Totals Section */
.cart-subtotal, .order-total {
    display: flex;
    justify-content: space-between;
    font-family: var(--cart-font-main);
    font-size: 20px;
    padding: 10px 0;
}

.cart-subtotal th, .order-total th {
    font-weight: 400;
}
.cart-subtotal td, .order-total td {
    font-weight: 900;
    text-align: right;
}

.cart-subtotal {
    border-bottom: 1px solid var(--cart-border-color);
    margin-bottom: 10px;
}

/* Checkout Button */
.wc-proceed-to-checkout {
    padding: 0;
}

.wc-proceed-to-checkout a.checkout-button {
    background-color: var(--cart-btn-orange) !important;
    border: 1.6px solid var(--cart-border-color) !important; /**/
    border-radius: 5px !important;
    box-shadow: 4px 4px 0px var(--cart-border-color) !important;
    color: #000 !important;
    font-family: var(--cart-font-mono) !important;
    text-transform: uppercase !important;
    font-weight: 400 !important;
    font-size: 18px !important;
}

.wc-proceed-to-checkout a.checkout-button:hover {
    background-color: var(--cart-btn-orange) !important;
    box-shadow: 2px 2px 0px var(--cart-border-color) !important;
    transform: translate(2px, 2px);
}

/* Quantity Buttons (SVG styles) */
.qty_button {
    width: 44px;
    height: 44px;
}
.qty_button.minus {
    background-color: #9E9E9E; /* Grey */
}
.qty_button.plus {
    background-color: var(--cart-btn-red); /* Red */
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .ct-woocommerce-cart-form {
        flex-direction: column;
    }
    .woocommerce-cart-form, .cart-collaterals {
        min-width: 100%;
    }
    .wc-proceed-to-checkout a.checkout-button {
        font-size: 11px !important;
    }

    /* Coupon 100% width on mobile */
    .coupon {
        width: 100% !important;
        flex-direction: column !important;
        align-items: stretch !important;
    }
    .coupon input.input-text {
        width: 100% !important;
        max-width: 100% !important;
        margin-bottom: 10px !important;
    }
    .coupon button { /* Ensure button takes full width too for uniformity */
        width: 100% !important; 
    }

    /* Totals Alignment (Subtotal/Total): Side-by-side */
    .cart_totals table.shop_table tr.cart-subtotal,
    .cart_totals table.shop_table tr.order-total {
        display: flex !important;
        justify-content: space-between !important;
        width: 100% !important;
        align-items: center !important;
    }

    .cart_totals table.shop_table tr.cart-subtotal th,
    .cart_totals table.shop_table tr.order-total th,
    .cart_totals table.shop_table tr.cart-subtotal td,
    .cart_totals table.shop_table tr.order-total td {
        display: block !important; 
        width: auto !important;
        padding: 5px 0 !important;
    }

    .cart_totals table.shop_table tr.cart-subtotal th,
    .cart_totals table.shop_table tr.order-total th {
        text-align: left !important;
    }
    
    .cart_totals table.shop_table tr.cart-subtotal td,
    .cart_totals table.shop_table tr.order-total td {
        text-align: right !important;
    }

    /* Hide pseudo-elements (duplicate labels) */
    .cart_totals table.shop_table tr.cart-subtotal td::before,
    .cart_totals table.shop_table tr.order-total td::before {
        content: none !important;
        display: none !important;
    }
}

/* Notification Styling */
.woocommerce-message,
.woocommerce-info,
.woocommerce-error {
    background-color: transparent !important;
    border: none !important;
    box-shadow: none !important;
    color: #000 !important;
    font-family: var(--cart-font-main) !important;
}
</style>

<div class="<?php echo $wrapper_class ?>">

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="product-name" colspan="2"><?php esc_html_e( 'Product', 'blocksy' ); ?></th>
				<th scope="col" class="product-price"><?php esc_html_e( 'Price', 'blocksy' ); ?></th>
				<th scope="col" class="product-quantity"><?php esc_html_e( 'Quantity', 'blocksy' ); ?></th>
				<th scope="col" class="product-subtotal"><?php esc_html_e( 'Subtotal', 'blocksy' ); ?></th>
				<th class="product-remove">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				/**
				 * Filter the product name.
				 *
				 * @since 2.1.0
				 * @param string $product_name Name of the product in the cart.
				 * @param array $cart_item The product in the cart.
				 * @param string $cart_item_key Key for the product in the cart.
				 */
				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-thumbnail">
							<?php
								echo apply_filters(
									'woocommerce_cart_item_thumbnail',
									blocksy_media([
										'no_image_type' => 'woo',
										'attachment_id' => $_product->get_image_id(),
										'post_id' => $_product->get_id(),
										'size' => $image_size,
										'ratio' => $image_ratio,
										'tag_name' => 'a',
										'html_atts' => [
											'href' => esc_url( $_product->get_permalink() )
										],
									]),
									$cart_item,
									$cart_item_key
								);
							?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'blocksy' ); ?>">
							<?php
								if ( ! $product_permalink ) {
									echo wp_kses_post( $product_name . '&nbsp;' );
								} else {
									/**
									 * This filter is documented above.
									 *
									 * @since 2.1.0
									 */
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', blocksy_safe_sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
								}

								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

								// Meta data.
								echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

								// Backorder notification.
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'blocksy' ) . '</p>', $product_id ) );
								}
							?>

							<div class="product-mobile-actions ct-hidden-lg product-remove">
								<?php
									if ( $_product->is_sold_individually() ) {
										$product_quantity = blocksy_safe_sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1">', $cart_item_key );
									} else {
										$product_quantity = woocommerce_quantity_input(
											array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $_product->get_max_purchase_quantity(),
												'min_value'    => '0',
												'product_name' => $product_name
											),
											$_product,
											false
										);
									}

									echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
								?>

								<span class="ct-product-multiply-symbol">×</span>

								<?php
									if (class_exists('WCS_ATT_Display_Cart')) {
										remove_filter(
											'woocommerce_cart_item_price',
											array(
												'WCS_ATT_Display_Cart',
												'show_cart_item_subscription_options'
											),
											1000,
											3
										);
									}

									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.

									if (class_exists('WCS_ATT_Display_Cart')) {
										add_filter(
											'woocommerce_cart_item_price',
											array(
												'WCS_ATT_Display_Cart',
												'show_cart_item_subscription_options'
											),
											1000,
											3
										);
									}
								?>

								<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										blocksy_safe_sprintf(
											'<a role="button" href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">
												<svg class="ct-icon" width="10px" height="10px" viewBox="0 0 24 24" aria-hidden="true"><path d="M9.6,0l0,1.2H1.2v2.4h21.6V1.2h-8.4l0-1.2H9.6z M2.8,6l1.8,15.9C4.8,23.1,5.9,24,7.1,24h9.9c1.2,0,2.2-0.9,2.4-2.1L21.2,6H2.8z"></path></svg>
											</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											/* translators: %s is the product name */
											esc_attr( blocksy_safe_sprintf( __( 'Remove %s from cart', 'blocksy' ), wp_strip_all_tags($product_name) ) ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										),
										$cart_item_key
									);
								?>
							</div>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'blocksy' ); ?>">
							<?php
								// Custom Price Display to ensure Regular Price is shown
								if ( $_product->is_on_sale() ) {
									echo '<del aria-hidden="true" style="color: #9E9E9E; opacity: 1; text-decoration: line-through;">' . wc_price( wc_get_price_to_display( $_product, array( 'price' => $_product->get_regular_price() ) ) ) . '</del>';
									echo ' <ins style="color: #EA0F09; text-decoration: none; font-weight: 900;">' . wc_price( wc_get_price_to_display( $_product, array( 'price' => $_product->get_sale_price() ) ) ) . '</ins>';
								} else {
									echo '<span class="amount" style="color: #000; font-weight: 500;">' . wc_price( wc_get_price_to_display( $_product ) ) . '</span>';
								}
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'blocksy' ); ?>">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = blocksy_safe_sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1">', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'blocksy' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-remove" data-title="<?php esc_attr_e( 'Remove product', 'blocksy' ); ?>">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									blocksy_safe_sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">
											<svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3 18C2.45 18 1.97917 17.8042 1.5875 17.4125C1.19583 17.0208 1 16.55 1 16V3H0V1H5V0H11V1H16V3H15V16C15 16.55 14.8042 17.0208 14.4125 17.4125C14.0208 17.8042 13.55 18 13 18H3ZM13 3H3V16H13V3ZM5 14H7V5H5V14ZM9 14H11V5H9V14Z" fill="black"/>
</svg>
										</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										/* translators: %s is the product name */
										esc_attr( blocksy_safe_sprintf( __( 'Remove %s from cart', 'blocksy' ), $product_name ) ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'blocksy' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'blocksy' ); ?>" /> <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'blocksy' ); ?>"><?php esc_html_e( 'Apply coupon', 'blocksy' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'blocksy' ); ?>"><?php esc_html_e( 'Update cart', 'blocksy' ); ?></button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    function initQuantityButtons() {
        var quantityInputs = document.querySelectorAll('.quantity input.qty');
        
        quantityInputs.forEach(function(input) {
            // Check if buttons already exist (theme might add them or we added them)
            if (!input.parentNode.querySelector('.plus')) {
                var minusBtn = document.createElement('button');
                minusBtn.type = 'button';
                minusBtn.className = 'qty_button minus custom-qty-btn';
                minusBtn.innerHTML = '<svg width="10" height="2" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="12" height="2" rx="1" fill="white"/></svg>'; // Simple line or SVG
                
                var plusBtn = document.createElement('button');
                plusBtn.type = 'button';
                plusBtn.className = 'qty_button plus custom-qty-btn';
                plusBtn.innerHTML = '<svg width="10" height="10" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="5" width="12" height="2" rx="1" fill="white"/><rect x="5" width="2" height="12" rx="1" fill="white"/></svg>'; // Plus SVG

                input.parentNode.insertBefore(minusBtn, input);
                input.parentNode.appendChild(plusBtn);
                
                // Event Listeners
                minusBtn.addEventListener('click', function() {
                    var value = parseFloat(input.value);
                    var min = parseFloat(input.getAttribute('min')) || 0;
                    var step = parseFloat(input.getAttribute('step')) || 1;
                    if (value > min) {
                        input.value = value - step;
                        input.dispatchEvent(new Event('change', { 'bubbles': true }));
                        triggerCartUpdate();
                    }
                });
                
                plusBtn.addEventListener('click', function() {
                    var value = parseFloat(input.value);
                    var max = parseFloat(input.getAttribute('max')) || 9999;
                    var step = parseFloat(input.getAttribute('step')) || 1;
                    if (value < max) {
                        input.value = value + step;
                        input.dispatchEvent(new Event('change', { 'bubbles': true }));
                        triggerCartUpdate();
                    }
                });
            }
        });
    }

    // Initialize on load
    initQuantityButtons();

    // Re-initialize on WooCommerce AJAX updates
    if (typeof jQuery !== 'undefined') {
        jQuery(document.body).on('updated_cart_totals updated_wc_div', function() {
            initQuantityButtons();
        });
    }
    
    // Function to trigger update cart
    function triggerCartUpdate() {
        var updateBtn = document.querySelector('button[name="update_cart"]');
        if (updateBtn) {
            updateBtn.removeAttribute('disabled');
            updateBtn.click();
        }
    }
});
</script>

<style>
/* Additional Styles for JS Buttons */
.qty_button {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.1s;
}

.qty_button.minus {
    background-color: var(--cart-btn-grey);
}

.qty_button.plus {
    background-color: var(--cart-btn-red);
}

.qty_button:active {
    transform: scale(0.9);
}

.qty_button svg {
    fill: white; /* Ensure icon is white */
}
</style>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<?php
	/**
	 * Cart collaterals hook.
	 *
	 * @hooked woocommerce_cross_sell_display
	 * @hooked woocommerce_cart_totals - 10
	 */
	do_action( 'woocommerce_cart_collaterals' );
?>

</div>

<?php

	do_action('blocksy:woocommerce:cart:before-cross-sells');

	if (apply_filters('blocksy:woocommerce:cart:has-cross-sells', true)) {
		woocommerce_cross_sell_display(null, 4);
	}

	do_action('woocommerce_after_cart');
?>

