# Atte
勤怠管理システム<br>
会員登録者の業務時間及び休憩時間を管理
![Atte_top_image](https://github.com/ShuTamura/Atte-app/assets/134911812/e17e9b6b-2b01-4cd6-b80d-67a666be80a4)

## 作成した目的
- 社員の人事評価
- アプリ利用者100人達成

## アプリケーションURL
URL：http://13.230.90.214/

ログイン認証あり
初回利用時にユーザー名、メールアドレス、及びパスワードにより会員登録。

## 機能一覧
### 認証機能
- 会員登録
- ログイン
- ログアウト
- メール認証
### 打刻ページ
- 勤務開始時間
- 勤務終了時間
- 休憩時間
### 勤怠情報取得ページ
- 名前検索機能付き日付別勤怠表
- ユーザー一覧ページからユーザーごとの勤怠表ページへ遷移

## 実行環境
- Laravel Framework 8.83.27
- PHP 7.4.9-fpm
- nginx 1.21.1
- mysql 8.0.26

## テーブル設計
Usersテーブル
|カラム名| 型 |PRIMARY KEY|UNIQUE KEY|NOT NULL|FOREIGN KEY|
| :---- | :---- | :---- | :---- | :---- | :---- |
| id    | unsigned bigint | 〇 |  | 〇 |  |
| name    | varchar(255) |  | 〇 | 〇 |  |
| email    | varchar(255) |  |  | 〇 |  |
| password    | varchar(255) |  |  | 〇 |  |
| create_at    | timestamp |  |  |  |  |
| update_at    | timestamp |  |  |  |  |

WorkHoursテーブル
|カラム名| 型 |PRIMARY KEY|UNIQUE KEY|NOT NULL|FOREIGN KEY|
| :---- | :---- | :---- | :---- | :---- | :---- |
| id | unsigned bigint | 〇 |  | 〇 |  |
| users_id | unsigned bigint | 〇 |  | 〇 |  |
| clock_in | datetime |  |  |  |  |
| clock_out | datetime |  |  |  |  |
| total_break | datetime |  |  |  |  |

BreakTimesテーブル
|カラム名| 型 |PRIMARY KEY|UNIQUE KEY|NOT NULL|FOREIGN KEY|
| :---- | :---- | :---- | :---- | :---- | :---- |
| id | unsigned bigint | 〇 |  | 〇 |  |
| users_id | unsigned bigint | 〇 |  | 〇 |  |
| break_start | datetime |  |  |  |  |
| break_end | datetime |  |  |  |  |

## ER図
![beginner drawio](https://github.com/ShuTamura/Atte-app/assets/134911812/117833d1-7be7-4275-950d-5bcca036abad)

# 環境構築
```
$ cd "laravelプロジェクトを入れる任意のディレクトリ"
$ git clone https://github.com/ShuTamura/Atte-app.git
$ sudo chmod -R 777 *
$ docker-compose up -d --build
```
laravelのパッケージインストール
```
$ docker-compose exec php bash //phpコンテナにログイン
$ composer install
```
.envファイルの編集
```
## mysqlと接続
DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
+ DB_HOST=mysql
DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=root
- DB_PASSWORD=
+ DB_DATABASE="データベース名"          //
+ DB_USERNAME="データベースユーザー名"   //docker-compose.ymlのmysqlをもとに編集
+ DB_PASSWORD="データベースパスワード"   //
```
開発環境ではメール認証を確認するためにmailhogを設定。
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=home@example.com 
```
```
## phpコンテナ内
$ php artisan key:generate //アプリケーションキー生成
$ php artisan migrate
```
