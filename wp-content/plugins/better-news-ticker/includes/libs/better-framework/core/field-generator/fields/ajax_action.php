<div class="bf-ajax_action-field-container"><?php

    if( isset( $options['confirm'] ) ){
        $confirm = ' data-confirm="' . $options['confirm'] . '" ';
    }else{
        $confirm = '';
    }
?>
    <input type="button" class="bf-action-button button" value="<?php echo $options['button-name']; ?>" data-callback="<?php echo $options['callback']; ?>" <?php echo $confirm; ?>>
</div>
