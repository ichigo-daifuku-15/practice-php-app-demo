# なんかやってみる

## MVCパターン

1. **Model（モデル）**:  
データベースのデータやビジネスロジックを管理します。
データの保存、更新、削除、検証などの操作を行います。  
`./src/Model/`

1. **View（ビュー）**:  
ユーザーに表示される出力を担当します。
HTML、CSS、JavaScriptなどを使ってデータを視覚的に表現します。  
`./templates/`

1. **Controller（コントローラ）**:  
ユーザーからの入力を処理し、モデルとビューをつなぐ役割を果たします。
ユーザーのリクエストを受け取り、適切なモデルを呼び出してデータを取得し、ビューにデータを渡します。  
`./src/Controller`

## helloページを作る

まずはコントローラーの追加

```php:HelloController.php
<?php
namespace App\Controller;

use App\Controller\AppController;

class HelloController extends AppController
{
    public function index()
    {
        $message = 'こんにちは、動的な世界へようこそ！';
        $this->set(compact('message'));
    }
}
```

次にテンプレート
```php:templates/Hello/index.php
<h1><?= h($message) ?></h1>
```

最後にページへのルーティングを追加
```diff:config/routes.php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/pages/*', 'Pages::display');
+       $builder->connect('/hello', ['controller' => 'Hello', 'action' => 'index']); // 新しいルートの追加

        $builder->fallbacks();
    });
};

```

