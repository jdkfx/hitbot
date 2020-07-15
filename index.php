<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/config.php');

use Facebook\WebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Abraham\TwitterOAuth\TwitterOAuth;

class Crawling {
    public function access()
    {
        // ダウンロードしたchromedriverのパスを指定
        $driverPath = realpath("/usr/local/bin/chromedriver");
        putenv("webdriver.chrome.driver=" . $driverPath);

        // Chromeを起動するときのオプション指定用
        $options = new ChromeOptions();

        // ヘッドレスで起動するように指定
        $options->addArguments(['--headless']);

        $caps = DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);

        $driver = ChromeDriver::start($caps);

        $driver->get('https://hitpo.it-hiroshima.ac.jp/PfStudent/Login?target_url=%2fPfStudent%2fPortal');

        // テキストボックス入力
        $driver->findElement(WebDriverBy::id('MainContent_login_id'))->sendKeys(LOGIN_ID);

        $driver->findElement(WebDriverBy::id('MainContent_login_password'))->sendKeys(LOGIN_PASSWORD);

        // ボタン押下
        $driver->findElement(WebDriverBy::id('MainContent_LoginButton'))->click();
        
        $driver->get('https://hitpo.it-hiroshima.ac.jp/PfStudent/CSLecture');

        $twitter = new TwitterOAuth(APIKey, APISecretKey, AccessToken, AccessTokenSecret);

        $results = $driver->findElements(WebDriverBy::xpath("(//table[@id='MainContent_CancelLectureGView'])/tbody/tr[1 < position()]"));
        foreach ($results as $result) {
            $twitter->post(
                "statuses/update",
                array("status" => $result->getText())
            );
        }

        if($twitter->getLastHttpCode() == 200) {
            // ツイート成功
            print "tweeted\n";
        } else {
            // ツイート失敗
            print "tweet failed\n";
        }

        // ブラウザを閉じる
        $driver->close();
    }
}

$c = new Crawling();
$c->access();