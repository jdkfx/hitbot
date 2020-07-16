# jdkfx/hitbot
🏫広島工業大学の休講ボット

# 環境について

## CentOS7
CentOS Linux release 7.8.2003 (Core)

# PHPやライブラリについて

- php  
PHP 7.3.17 (cli)

- abraham/twitteroauth  
1.1.0  
[公式サイト](https://twitteroauth.com/)

- facebook/webdriver  
1.7.1  
[公式wiki](https://github.com/php-webdriver/php-webdriver/wiki)

# Getting Started
[Twitter Developer](https://developer.twitter.com/ja) でアプリを作成して、キーを取得。  
  
CentOS7にChromeをインストール（デフォルトでは入っていないので自分でインストールする必要がある）  

リポジトリファイルを設定  
```
$ vi /etc/yum.repos.d/google.chrome.repo
```
以下の内容を記入して保存
```
[google-chrome]
name=google-chrome
baseurl=http://dl.google.com/linux/chrome/rpm/stable/$basearch
enabled=1
gpgcheck=1
gpgkey=https://dl-ssl.google.com/linux/linux_signing_key.pub
```
情報を反映
```
$ yum update
```
インストール
```
$ sudo yum install google-chrome-stable
```

GitHubからプロジェクトをクローン  
```
$ git clone git@github.com:jdkfx/hitbot.git
```
  
プロジェクトに移動
```
$ cd hitbot/
```
  
sample.config.php を参考に config.php ファイルを作成して適宜環境変数を設定する。  
```
$ cp sample.config.php config.php
```

composer の利用
```
$ composer install
$ composer update
```

php の実行
```
$ php index.php
```