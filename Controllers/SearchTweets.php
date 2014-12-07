<?php

/**
 * SearchTweets
 * 
 * Getting Tweets from Twitter API
 */

class SearchTweets {
   
    /**
     * 
     * @param Array $requestParams contains all the request parameters
     */
    
    public function get($requestParams) {
        /* Setting Default values */
        $hashTag = empty($requestParams['hash_tag']) ? 'custserv' : $requestParams['hash_tag'];
        $count = empty($requestParams['result']) ? 20 : $requestParams['result'];
        $retweet = empty($requestParams['retweet']) ? 0 : $requestParams['retweet'];
        /* Preparing Request format */
        $url = "https://api.twitter.com/1.1/search/tweets.json";
        $requestMethod = "GET";
        $getfield = "?q=#$hashTag&count=$count";
        /* Checking Credentials */
        $twitter = new TwitterAPIExchange(TwitterAuth::getTwitterCredentials());
        /* Getting Response from Twitter */
        $tweets = json_decode($twitter->setGetfield($getfield)
                        ->buildOauth($url, $requestMethod)
                        ->performRequest(), $assoc = TRUE);

        if ($tweets['errors'][0]['message'] != '')
            ErrorAndMessages::generalError($tweets['errors'][0]['message'], 400);

        /* Filtering Tweets based on retweet Count */
        $i = 0;
        foreach ($tweets['statuses'] as  $value) {
            if ($value['retweet_count'] >= $retweet) {
                $Tweets[$i]['retweet_count'] = $value['retweet_count'];
                $Tweets[$i]['text'] = $value['text'];
                $i++;
            }
        }
        //Displaying Tweets
        ErrorAndMessages::generalMessage($Tweets, 200, "Tweets");
    }
    
    /**
     * 
     * @param Array $requestParams contains all the request parameters
     */
    
    public function post($requestParams) {
        //post Method
    }
    
    /**
     * 
     * @param Array $requestParams contains all the request parameters
     */
    
    public function put($requestParams) {
        //put method
    }
    
    /**
     * 
     * @param Array $requestParams contains all the request parameters
     */
    
    public function delete($requestParams) {
        //delete method
    }

}