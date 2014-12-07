<?php

/**
 * Contain different helper classes
 * used for different purpose
 * 
 */

/**
 * @TwitterAuth for setting Twitter Credentials
 */
class TwitterAuth {

    private static $twitterCredentials;

    public static function getTwitterCredentials() {
        /* Setting up parameters for Authentication */
        self::$twitterCredentials = array(
            'oauth_access_token' => OAUTH_ACCESS_TOKEN,
            'oauth_access_token_secret' => OAUTH_ACCESS_TOKEN_SECRET,
            'consumer_key' => CONSUMER_KEY,
            'consumer_secret' => CONSUMER_SECRET
        );
        return self::$twitterCredentials;
    }

}
