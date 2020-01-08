<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use Goutte\Client;

$cli = getLoggedInClient();
$home = $cli->request(
    'GET',
    'https://hitpo.it-hiroshima.ac.jp/PfStudent/Portal'
);
echo $home->filter('.current_page_item')->first()->text();


function getLoggedInClient(){
    $topUrl = 'https://hitpo.it-hiroshima.ac.jp/PfStudent/Login?target_url=%2fPfStudent%2fCSLecture';
    $cli = new Client();
    $cli->setHeader('User-Agent', "Mozilla/5.0 (X11; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0");
    $top = $cli->request('GET', $topUrl);

    //$cookies = $cli->getCookieJar()->get('__AntiXsrfToken')->getValue();
    // print_r($cookies);
    // exit;

    // $sessions = $top->filter('div.aspNetHidden input')->each(function($inputform){
    //     // echo "NAME:" . $inputform->attr("name") . "\n";
    //     // echo "VALUE:" . $inputform->attr("value") . "\n";
    //     return array($inputform->attr("name") => $inputform->attr("value"));
    // });

    // $top = $cli->request('POST', $topUrl);

    $loginForm = $top->filter('form')->form();
    $loginForm['ctl00$MainContent$login_id']        = LOGIN_ID;
    $loginForm['ctl00$MainContent$login_password']  = LOGIN_PASSWORD;
    $cli->submit($loginForm);
    return $cli;
}
