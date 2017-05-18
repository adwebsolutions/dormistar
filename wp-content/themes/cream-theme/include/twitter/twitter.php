<?php
/**
 * Twitter Class
 *
 */

class Twitter{

    /** Twitter Authentication Keys */
    private $consumer_key;
    private $consumer_secret;
    private $access_token;
    private $access_token_secret;

    /** Class Constructor */
    function __construct($consumer_key, $consumer_secret, $access_token, $access_token_secret) {
        $this->consumer_key = $consumer_key;
        $this->consumer_secret = $consumer_secret;
        $this->access_token = $access_token;
        $this->access_token_secret = $access_token_secret;
    }

    /** Get Tweets */
    public function get_tweets( $screen_name, $count = 1, $include_rts = 0, $exclude_replies = 1, $transient_key = 'inspiry_tweets', $expiry = 3600 ){

        /** Get tweets from transient. False if it has expired */
        $tweets = get_transient( $transient_key );

        if ( $tweets === false ) {

            /** Require the twitter auth class */
            if ( !class_exists('TwitterOAuth') )
                require_once get_template_directory().'/include/twitter/twitteroauth/twitteroauth.php';

            /** Get Twitter connection */
            $twitter_connection = new TwitterOAuth(
                $this->consumer_key,
                $this->consumer_secret,
                $this->access_token,
                $this->access_token_secret
            );

            /** Get tweets */
            $tweets = $twitter_connection->get(
                'statuses/user_timeline',
                array(
                    'screen_name' => $screen_name,
                    'count' => $count,
                    'include_rts' => $include_rts,
                    'exclude_replies' => $exclude_replies
                )
            );

            /** Bail if failed */
            if ( !$tweets || isset( $tweets->errors ) ){
                return false;
            }else{
                /** Set tweets */
                set_transient( $transient_key, $tweets, $expiry );
            }
        }

        /** Return tweets */
        return $tweets;

    }

    /** Format tweet */
    public function format_tweet( $text ) {
        $text = preg_replace( "#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $text );
        $text = preg_replace( "#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $text );
        $text = preg_replace( "/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $text );
        $text = preg_replace( "/#(\w+)/", "<a href=\"http://twitter.com/search?q=%23\\1&src=hash\" target=\"_blank\">#\\1</a>", $text );
        return $text;
    }
}
