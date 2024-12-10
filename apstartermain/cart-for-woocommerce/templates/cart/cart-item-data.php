<?php
/**
 * @var $item_data []
 */
$first_item = true;
foreach ( $item_data as $data ) {
    $value = wp_kses_post( $data['display'] );

    // Check if it's the first item and remove the first word
    if ( $first_item ) {
        $value = implode(' ', array_slice(explode(' ', $value), 1));
        $first_item = false;
    }

    echo sprintf( 
        '<span class="fkcart-attr-wrap"><span class="fkcart-attr-key" data-attr-key="%1$s">%1$s:</span><span class="fkcart-attr-value">%2$s</span></span>', 
        wp_kses_post( $data['key'] ), 
        $value 
    ) . "\n";
}
