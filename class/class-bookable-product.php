<?php
/**
 * Returns an array of bookable products according to supplied criteria
 * 
 * @param  int    $pid      the $product->ID of the bookable object
 * @param  mixed  $when     a date in YYYY-MM-DD format or integer representing a day or month
 * @param  string $type     a value of 'day', 'month', or 'custom'
 * @param  string $bookable whether the bookable object is bookable or not ('yes' or 'no')
 * @return array            an array of bookable objects for the product
 */
function getBookables( $pid,  $bookable = 'yes' ) {
    $result = array();

    // is $when in the YYYY-MM-DD format?
    // if ( 'custom' == $type ) {
    //     // it's a custom date so convert $when to DateTime
    //     $when = DateTime::createFromFormat( 'Y-m-d', $when );
    // }

    $availability = get_post_meta( $pid, '_wc_booking_availability' );
    foreach ( $availability as $a ) {
        // if ( $a[ 'bookable' ] == $bookable ) {
        //     // is it in the YYYY-MM-DD format?
        //     if ( $when instanceof DateTime ) {
        //         // it's a custom date so use date compare
        //         $from = DateTime::createFromFormat( 'Y-m-d', $a[ 'from' ] );
        //         $to   = DateTime::createFromFormat( 'Y-m-d', $a[ 'to'   ] );
        //         if ( $when >= $from && $when <= $to ) {
        //             $result[] = $a;
        //         }
        //     } else {
        //         // it is an integer value (day or month)
        //         if ( $type == $a[ 'type' ] && ( $when >= $from && $when <= $to ) ) {
        //             $result[] = $a;
        //         }
        //     }
        // }
        print_r( $pid );
        die();
    }
    return $result;
}


// $bookables = getBookables( 1387, 'yes' );
