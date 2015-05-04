<?php

/**
 * Generate Reviews Preview Codes
 * todo move it to new plugin
 */
class BetterStudio_Review_Generator {


    function __construct(){

        add_filter( 'better-framework/content/the_content', array( $this, 'bf_main_content' ) );

    }


    /**
     * Filter Callback: Main Content off page and posts
     *
     * @param $content
     * @return string
     */
    public function bf_main_content( $content ){

        if( $this->is_review_enabled() ){

            $atts = $this->prepare_atts( array() );

            if( $atts['position'] && $atts['position'] != 'none' ){

                if( $atts['position'] == 'top' ){

                    $content = $this->generate_block( $atts ) . $content;

                }elseif( $atts['position'] == 'bottom' ){

                    $content = $content . $this->generate_block( $atts );

                }
            }

        }

        return $content ;

    }


    /**
     * Used for preparing review atts
     *
     * @param $atts
     * @return array
     */
    public function prepare_atts( $atts = array() ){

        return array_merge(

            array(
                'type'              => Better_Mag::get_meta( 'bs_review_rating_type', false ),
                'heading'           => Better_Mag::get_meta( 'bs_review_heading', false ),
                'verdict'           => Better_Mag::get_meta( 'bs_review_verdict', false ),
                'summary'           => Better_Mag::get_meta( 'bs_review_verdict_summary', false ),
                'criteria'          => Better_Mag::get_meta( 'bs_review_criteria', false ),
                'position'          => Better_Mag::get_meta( 'bs_review_pos', false ),
                'extra_desc'        => Better_Mag::get_meta( 'bs_review_extra_desc', false ),
            ),

            $atts

        );

    }


    /**
     * Used for preparing review atts
     *
     * @param $atts
     * @return array
     */
    public function prepare_rate_atts( $atts = array() ){

        return array_merge(

            array(
                'type'              => Better_Mag::get_meta( 'bs_review_rating_type', false ),
                'criteria'          => Better_Mag::get_meta( 'bs_review_criteria', false ),
            ),

            $atts

        );

    }



    /**
     * Used for checking state of review
     * @return string
     */
    public function is_review_enabled(){

        return Better_Mag::get_meta( 'bs_review_enabled', false );

    }


    /**
     * Generates big block
     *
     * @param $atts
     * @return string
     */
    public function generate_block( $atts ){

        // Review is not enable
        if( ! $this->is_review_enabled() ){
            return '';
        }

        $atts = $this->prepare_atts( $atts );

        $overall_rate = $this->calculate_overall_rate( $atts );


        ob_start();

        ?>
    <section class="betterstudio-review type-<?php echo $atts['type']; ?>">
        <?php if( ! empty( $atts['heading'] ) ) Better_Mag::generator()->blocks()->get_page_title( $atts['heading'] ); ?>
        <div class="verdict clearfix">
            <div class="overall">
                    <span class="rate"><?php

                        if( $atts['type'] == 'points' ){
                            echo round( $overall_rate / 10 ,1 );
                        }
                        else{
                            echo $overall_rate;
                        }


                        if( $atts['type'] != 'points' ){
                            echo '<span class="percentage">%</span>';
                        }

                        ?></span>
                <?php

                echo $this->get_rating( $overall_rate, $atts['type'] );

                ?>
                <span class="verdict-title"><?php echo $atts['verdict']; ?></span>
            </div>
            <div class="the-content verdict-summary"><?php echo apply_filters( 'the_content', $atts['summary'] ); ?></div>
        </div>
        <ul class="criteria-list"><?php

            foreach( $atts['criteria'] as $criteria ){

                ?><li class="clearfix">
                <div class="criterion">
                    <span class="title"><?php echo !empty( $criteria['label'] ) ? $criteria['label'] : __( 'Criteria', 'better-studio' ); ?></span>
                    <?php if( $atts['type'] !='stars' ){ ?>
                        <span class="rate"><?php echo $atts['type'] !='points' ?  round( $criteria['rate'] * 10 ) . '%' : $criteria['rate']; ?></span>
                    <?php } ?>
                </div>
                <?php
                if( $atts['type'] != 'points' ){
                    echo $this->get_rating( $criteria['rate'] * 10, $atts['type'] );
                }else{
                    echo $this->get_rating( $criteria['rate'] * 10, $atts['type'] );
                }
                ?>
                </li>
            <?php
            }

            ?>
        </ul>
        <?php if( ! empty( $atts['extra_desc'] ) ){ ?>
        <div class="review-description"><?php echo wpautop( do_shortcode( $atts['extra_desc'] ) ); ?></div>
        <?php } ?>
    </section><?php

        return ob_get_clean();
    }


    /**
     * Calculates overall rate
     *
     * @param $atts
     * @return float
     */
    public function calculate_overall_rate( $atts = null ){

        if( is_null( $atts ) ){
            $atts = $this->prepare_atts( array() );
        }

        $total = 0;

        foreach( $atts['criteria'] as $criteria ){
            $total += floatval( $criteria['rate'] ) * 10;
        }

        if( $atts['type'] == 'points' ){
            return round( $total / count( $atts['criteria'] ), 1 );
        }else{
            return round( $total / count( $atts['criteria'] ) );
        }

    }


    /**
     * Used for retiring generated bars
     *
     * @param $rate
     * @param string $type
     * @param bool $show_rate
     * @return string
     */
    public function get_rating( $rate, $type = 'stars', $show_rate = false ){


        if( $show_rate ){
            if( $type == 'points' ){
                $show_rate = '<span class="rate-number">' . round( $rate / 10, 1 ) . '</span>';
            }else{
                $show_rate = '<span class="rate-number">' . $rate . '%</span>';
            }
        }else{
            $show_rate = '';
        }

        if( $type == 'points' || $type == 'percentage' ){
            $type = 'bar';
        }


        return '<div class="rating-' . $type . '"><span style="width: ' . $rate . '%;"></span>' . $show_rate . '</div>';

    }

}