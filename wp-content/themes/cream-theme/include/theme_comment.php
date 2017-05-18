<?php
/**
 * File Name: theme_comment.php
 *
 * Theme Custom Comment Template
 *
 */
if (!function_exists('theme_comment')) {
    function theme_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="pingback">
                    <p><?php _e('Pingback:', 'framework'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'framework'), ' '); ?></p>
                </li>
                <?php
                break;
            default :
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment-body">

                        <div class="author-photo"><a class="avatar" href="<?php comment_author_url(); ?>"><?php echo get_avatar($comment, 85); ?></a></div>

                        <div class="comment-wrapper">
                            <div class="comment-meta">
                                <div class="comment-author vcard">
                                    <h5 class="fn"><?php echo get_comment_author_link(); ?></h5>
                                </div>
                                <div class="comment-metadata">
                                    <time datetime="<?php comment_time('c'); ?>"><?php printf(__('%1$s', 'framework'), get_comment_date()); ?></time>
                                </div>
                            </div>

                            <div class="comment-content">
                                <?php comment_text(); ?>
                            </div>

                            <div class="reply">
                                <!--<a class="comment-reply-link" href="#">Reply</a>-->
                                <?php comment_reply_link(array_merge(array('before' => ''), array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                            </div>
                        </div>

                    </article>
                    <!-- end of comment -->
                <?php
                break;
        endswitch;
    }
}

?>