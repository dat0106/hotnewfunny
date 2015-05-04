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

?>
<div class="bf-section-container bf-admin-panel bf-clearfix" data-id="<?php echo $options['id']; ?>">
    <div class="<?php echo $section_classes; ?> bf-clearfix" data-id="<?php echo $options['id']; ?>">

        <div class="<?php echo $heading_classes; ?> bf-clearfix">
            <h3><label><?php echo $options['name']; ?></label></h3>
        </div>

        <div class="<?php echo $controls_classes; ?> bf-clearfix">
            <?php echo $input; ?>


            <?php if ( isset( $options['desc'] ) && !empty( $options['desc'] ) ) { ?>
            <div class="typography-desc">
                <?php echo $options['desc']; ?>
            </div>
            <?php } ?>
        </div>

        <?php if ( isset( $options['preview'] ) && $options['preview'] ) { ?>
            <div class="<?php echo $explain_classes; ?> bf-clearfix">
                <?php if( ! isset( $options['preview_tab'] ) ){
                        $options['preview_tab'] = 'title';
                    }
                    ?>
                    <a class="load-preview-texts" href="javascript: void(0);">Load Preview</a>
                    <div class="typography-preview">
                        <ul class="preview-tab bf-clearfix">
                            <li class="tab <?php echo $options['preview_tab'] == 'title' ? 'current' : ''; ?>" data-tab="title"><a href="javascript: void(0);">Heading</a></li>
                            <li class="tab <?php echo $options['preview_tab'] == 'paragraph' ? 'current' : ''; ?>" data-tab="paragraph"><a href="javascript: void(0);">Paragraph</a></li>
                            <li class="tab <?php echo $options['preview_tab'] == 'divided' ? 'current' : ''; ?>" data-tab="divided"><a href="javascript: void(0);">Divided</a></li>
                        </ul>

                        <p class="preview-text <?php echo $options['preview_tab'] == 'title' ? 'current' : ''; ?> title">
                            <?php if( isset( $options['preview_text'] ) && ! empty( $options['preview_text'] ) ){
                                echo $options['preview_text'];
                            }else{
                                _e( 'This Is a Test Title Text!', 'better-studio' );
                            } ?>
                        </p>
                        <p class="preview-text paragraph <?php echo $options['preview_tab'] == 'paragraph' ? 'current' : ''; ?>">
                            <?php if( isset( $options['preview_text'] ) && ! empty( $options['preview_text'] ) ){
                                echo $options['preview_text'];
                            }else{
                                _e( 'Grumpy wizards make toxic brew for the evil Queen and Jack. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. ', 'better-studio' );
                            } ?>
                        </p>

                        <p class="preview-text divided <?php echo $options['preview_tab'] == 'divided' ? 'current' : ''; ?>">
                            <?php if( isset( $options['preview_text'] ) && ! empty( $options['preview_text'] ) ){
                                echo $options['preview_text'];
                            }else{
                                _e( "a b c d e f g h i j k l m n o p q r s t u v w x y z<br>
                                A B C D E F G H I J K L M N O P Q R S T U V W X Y Z<br>
                                0123456789 (!@#$%&.,?:;)", 'better-studio' );
                            } ?>
                        </p>

                    </div>
            </div>
        <?php } ?>
    </div>
</div>