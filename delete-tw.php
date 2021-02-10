<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/config.php');

use Abraham\TwitterOAuth\TwitterOAuth;

class Deleting {
    public function delete()
    {
        $twitter = new TwitterOAuth(APIKey, APISecretKey, AccessToken, AccessTokenSecret);

        $count = 0;

        do {
            $tweets = $twitter->get("statuses/user_timeline", ["screen_name" => "hiroshimaitbot", "count" => 20]);
            foreach($tweets as $tweet){
                echo $count+1 . " : " . $tweet->text . "を削除します\n";
                $twitter->post('statuses/destroy/' . $tweet->id);
                $count++;
            }

        } while(count($tweets) > 0);

        echo "Finished!\n";
        echo $count . "件のツイートを削除しました\n";
    }
}

$c = new Deleting();
$c->delete();