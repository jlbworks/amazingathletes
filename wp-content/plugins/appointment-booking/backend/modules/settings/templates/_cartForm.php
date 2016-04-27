<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<form method="post" action="<?php echo esc_url( add_query_arg( 'tab', 'cart' ) ) ?>"  class="ab-settings-form">
    <div class="form-group">
        <label for="ab_settings_step_cart_enabled"><?php _e( 'Cart', 'bookly' ) ?></label>
        <p class="help-block"><?php _e( 'If cart is enabled then your clients will be able to book several appointments at once. Please note that WooCommerce integration must be disabled.', 'bookly' ) ?></p>
        <?php \Bookly\Lib\Utils\Common::optionToggle( 'ab_settings_step_cart_enabled' ) ?>
    </div>
    <div class="form-group">
        <label for="ab_cart_show_columns"><?php _e( 'Columns', 'bookly' ) ?></label><br/>
        <div class="ab-flags" id="ab_cart_show_columns">
        <?php foreach ( (array) get_option( 'ab_cart_show_columns' ) as $column => $attr ) :
            printf( '<div class="checkbox"><input type="hidden" name="ab_cart_show_columns[%s][show]" value="0"><label><input type="checkbox" name="ab_cart_show_columns[%s][show]" value="1" %s>%s</label></div>',
                $column, $column, checked( $attr['show'], true, false ), $cart_columns[ $column ] );
        endforeach ?>
        </div>
    </div>
    <?php \Bookly\Lib\Utils\Common::submitButton() ?>
    <?php \Bookly\Lib\Utils\Common::resetButton() ?>
</form>