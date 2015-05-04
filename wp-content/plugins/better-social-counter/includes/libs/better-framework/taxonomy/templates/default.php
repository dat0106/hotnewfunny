<?php 
$classes = $this->get_classes( $options );
$iri     = isset( $options['repeater_item'] ) && $options['repeater_item'] == true; // Is this section for a repeater item

$section_classes  = $classes['section'];

$heading_classes  = $classes['heading'];
$controls_classes = $classes['controls'];
$explain_classes = $classes['explain'];

if( $iri ) {

    $section_classes  .= ' ' . $classes['repeater-section'];
    $heading_classes  .= ' ' . $classes['repeater-heading'];
    $controls_classes .= ' ' . $classes['repeater-controls'];
    $explain_classes  .= ' ' . $classes['repeater-explain'];

} else {

    $section_classes  .= ' ' . $classes['nonrepeater-section'];
    $heading_classes  .= ' ' . $classes['nonrepeater-heading'];
    $controls_classes .= ' ' . $classes['nonrepeater-controls'];
    $explain_classes  .= ' ' . $classes['nonrepeater-explain'];

}

$section_classes  .= ' ' . $classes['section-class-by-filed-type'];
$heading_classes  .= ' ' . $classes['heading-class-by-filed-type'];
$controls_classes .= ' ' . $classes['controls-class-by-filed-type'];
$explain_classes  .= ' ' . $classes['explain-class-by-filed-type'];

if( isset($options['id']) )
    $option_id = $options['id'];
else
    $option_id = '';
?>
<tr class="form-field <?php echo $section_classes; ?>"  data-id="<?php echo $option_id; ?>">
    <th scope="row" class="<?php echo $heading_classes; ?>">
        <label for="<?php echo $option_id; ?>"><?php echo $options['name']; ?></label>
    </th>

    <td><?php echo $input; ?>
        <?php if ( !empty( $options['desc'] ) ) { ?>
            <div class="description <?php echo $explain_classes; ?> bf-clearfix"><?php echo $options['desc']; ?></div>
        <?php } ?>
    </td>
</tr>
