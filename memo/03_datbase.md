# データベースを使えるようにしてみる

## MySQLをDockerで準備

```yaml:./docker-compose.yaml


```


```bash
% docker-compose up -d

[+] Running 12/12
 ✔ db 11 layers [⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿]      0B/0B      Pulled                                                                                     20.3s 
   ✔ 3c4da62cd991 Pull complete                                                                                                           5.4s 
   ✔ 6246d8c92d7f Pull complete                                                                                                           5.4s 
   ✔ 64e7eb422142 Pull complete                                                                                                           5.4s 
   ✔ f787785dc518 Pull complete                                                                                                           5.6s 
   ✔ 7585e10db184 Pull complete                                                                                                           5.6s 
   ✔ 8fa8f50b4ce6 Pull complete                                                                                                           5.6s 
   ✔ 16f26e70af83 Pull complete                                                                                                          11.0s 
   ✔ 7795c0f20a3d Pull complete                                                                                                          11.0s 
   ✔ 841fe6e72d4e Pull complete                                                                                                          15.3s 
   ✔ a902ff9733a9 Pull complete                                                                                                          15.4s 
   ✔ 8a6c3fcf3b9c Pull complete                                                                                                          15.4s 
[+] Running 3/3
 ✔ Network practice-php-app_default   Created                                                                                             0.0s 
 ✔ Volume "practice-php-app_db_data"  Created                                                                                             0.0s 
 ✔ Container my_cakephp_db            Started           
```

コンテナにアクセス
```bash
% docker exec -it my_cakephp_db mysql -u root -p           
Enter password: 
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 13
Server version: 8.0.37 MySQL Community Server - GPL

Copyright (c) 2000, 2024, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> 
```

DBを選択してテーブル作成
```bash
mysql> USE my_cakephp_app;
Database changed
mysql> CREATE TABLE articles (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     title VARCHAR(255) NOT NULL,
    ->     body TEXT,
    ->     created DATETIME,
    ->     modified DATETIME
    -> ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
Query OK, 0 rows affected (0.03 sec)
```


## articlesページ追加

モデルを追加
```php:src/Model/Table/ArticlesTable.php
<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ArticlesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }
}

```

Controller追加
```php:src/Controller/ArticlesController.php
<?php
namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController
{
    public function index()
    {
        $articles = $this->Articles->find('all');
        $this->set(compact('articles'));
    }
}
```

templateを追加

```php:templates/Articles/index.php
<h1>Articles</h1>
<table>
    <tr>
        <th>Title</th>
        <th>Body</th>
        <th>Created</th>
        <th>Modified</th>
    </tr>
    <?php foreach ($articles as $article): ?>
    <tr>
        <td><?= h($article->title) ?></td>
        <td><?= h($article->body) ?></td>
        <td><?= h($article->created) ?></td>
        <td><?= h($article->modified) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
```

ルーティングを追加
```diff:
```diff:config/routes.php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/pages/*', 'Pages::display');
        $builder->connect('/hello', ['controller' => 'Hello', 'action' => 'index']); // 新しいルートの追加
+       $builder->connect('/articles', ['controller' => 'Articles', 'action' => 'index']);

        $builder->fallbacks();
    });
};
```

DB接続のためapp_local.phpを編集
```bash
% diff -u ./config/app_local.example.php ./config/app_local.php
```

```diff
--- ./config/app_local.example.php      2023-10-01 03:53:56
+++ ./config/app_local.php      2024-05-15 22:52:59
@@ -25,7 +25,7 @@
      *   You should treat it as extremely sensitive data.
      */
     'Security' => [
-        'salt' => env('SECURITY_SALT', '__SALT__'),
+        'salt' => env('SECURITY_SALT', 'b1f3c16c863d8138b36559251b01f23a7571577e82ca01fafddcd472934c15be'),
     ],
 
     /*
@@ -36,7 +36,11 @@
      */
     'Datasources' => [
         'default' => [
-            'host' => 'localhost',
+            'className' => 'Cake\Database\Connection',
+            'driver' => 'Cake\Database\Driver\Mysql',
+            'persistent' => false,
+
+            'host' => '127.0.0.1å', // Dockerサービス名
             /*
              * CakePHP will use the default DB port based on the driver selected
              * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
@@ -44,10 +48,15 @@
              */
             //'port' => 'non_standard_port_number',
 
-            'username' => 'my_app',
-            'password' => 'secret',
+            'username' => 'my_user',      // docker-compose.ymlで設定したユーザー名
+            'password' => 'my_password',  // docker-compose.ymlで設定したパスワード
 
-            'database' => 'my_app',
+            'database' => 'my_cakephp_app', // docker-compose.ymlで設定したデータベース名
+            
+            'encoding' => 'utf8mb4',
+            'timezone' => 'UTC',
+            'cacheMetadata' => true,
+            
             /*
              * If not using the default 'public' schema with the PostgreSQL driver
              * set it here.
@@ -64,11 +73,18 @@
          * The test connection is used during the test suite.
          */
         'test' => [
+            'className' => 'Cake\Database\Connection',
+            'driver' => 'Cake\Database\Driver\Mysql',
+            'persistent' => false,
             'host' => 'localhost',
             //'port' => 'non_standard_port_number',
-            'username' => 'my_app',
-            'password' => 'secret',
+            'username' => 'my_user',
+            'password' => 'my_password',
             'database' => 'test_myapp',
+            'encoding' => 'utf8mb4',
+            'timezone' => 'UTC',
+            'cacheMetadata' => true,
+            'log' => false,
             //'schema' => 'myapp',
             'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite'),
         ],
```

<details><summary>config/app_local.php</summary>

```php:config/app_local.php
<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', 'b1f3c16c863d8138b36559251b01f23a7571577e82ca01fafddcd472934c15be'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,

            'host' => '127.0.0.1å', // Dockerサービス名
            /*
             * CakePHP will use the default DB port based on the driver selected
             * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
             * the following line and set the port accordingly
             */
            //'port' => 'non_standard_port_number',

            'username' => 'my_user',      // docker-compose.ymlで設定したユーザー名
            'password' => 'my_password',  // docker-compose.ymlで設定したパスワード

            'database' => 'my_cakephp_app', // docker-compose.ymlで設定したデータベース名
            
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            
            /*
             * If not using the default 'public' schema with the PostgreSQL driver
             * set it here.
             */
            //'schema' => 'myapp',

            /*
             * You can use a DSN string to set the entire configuration
             */
            'url' => env('DATABASE_URL', null),
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'my_user',
            'password' => 'my_password',
            'database' => 'test_myapp',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'log' => false,
            //'schema' => 'myapp',
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite'),
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
```
</details>