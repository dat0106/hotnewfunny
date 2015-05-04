<?php

if( isset( $options['file_name'] ) && ! empty( $options['file_name'] ) ){
    $file_name = 'data-file_name="' . $options['file_name'] . '"';
}else{
    $file_name = '';
}


if( isset( $options['panel_id'] ) && ! empty( $options['panel_id'] ) ){
    $panel_id = 'data-panel_id="' . $options['panel_id'] . '"';
}else{
    return '';
}


?>
<div>
    <input type="button" class="button" id="bf-download-export-btn" value="<?php _e( 'Download Backup', 'better-studio' ); ?>" <?php echo $file_name; ?> <?php echo $panel_id; ?>>
</div>