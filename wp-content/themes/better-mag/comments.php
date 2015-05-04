<?php if( post_password_required() ): ?>
    <p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.', 'better-studio' ); ?></p>
    <?php return; endif;?>

<div id="comments">

    <?php if( have_comments() ): ?>
        <?php

        $num_comments = get_comments_number();

        if( $num_comments == 0 ){
            $comments_text = __( 'No Comments', 'better-studio' );
        } elseif ( $num_comments > 1 ) {
            $comments_text = str_replace('%', number_format_i18n( $num_comments ), __( '% Comments', 'better-studio' ) );
        } else {
            $comments_text = __( '1 Comment', 'better-studio' );
        }

        Better_Mag::generator()->blocks()->get_block_title( $comments_text ); ?>

        <ol class="comments-list">
            <?php

            wp_list_comments( array( 'callback' => 'better_mag_comment' ) );

            ?>
        </ol>

        <?php if( get_comment_pages_count() > 1 && get_option('page_comments') ): // are there comments to navigate through ?>
            <nav class="comment-nav">
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'better-studio' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'better-studio' ) ); ?></div>
            </nav>
        <?php endif; // check for comment navigation ?>

    <?php elseif( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments') ): ?>
        <p class="nocomments"><?php _e( 'Comments are closed.', 'better-studio' ); ?></p>
    <?php endif;

    comment_form(array(
        'title_reply'           =>  Better_Mag::generator()->blocks()->get_block_title( __( 'Leave A Reply', 'better-studio'), false, false  ),
        'title_reply_to'        =>  Better_Mag::generator()->blocks()->get_block_title( __( 'Reply To %s', 'better-studio'), false, false  ),
        'comment_notes_before'  => '',
        'comment_notes_after'   => '',

        'logged_in_as'          => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'better-studio'),
                admin_url('profile.php'), $user_identity, wp_logout_url( get_permalink() ) ) . '</p>',

        'comment_field'         =>  '<p><textarea name="comment" id="comment" cols="45" rows="10" aria-required="true" placeholder="'. esc_attr__( 'Your Comment', 'better-studio' ) .'"></textarea></p>',
        'id_submit'             => 'comment-submit',
        'label_submit'          =>  __( 'Post Comment', 'better-studio' ),
        'cancel_reply_link'     =>  __( 'Cancel Reply', 'better-studio' ),
        'fields'                => array(
            'author'    =>  '<p><input name="author" id="author" type="text" value="" size="45" aria-required="true" placeholder="'. esc_attr__( 'Your Name', 'better-studio' ) .'" /></p>',
            'email'     =>  '<p><input name="email" id="email" type="text" value="" size="45" aria-required="true" placeholder="'. esc_attr__( 'Your Email', 'better-studio' ) .'" /></p>',
            'url'       =>  '<p><input name="url" id="url" type="text" value="" size="45" placeholder="'. esc_attr__( 'Your Website', 'better-studio' ) .'" /></p>'
        ),

    )); ?>
</div><!-- #comments -->
