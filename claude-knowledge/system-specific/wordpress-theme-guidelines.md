タグ: #技術/WordPress #機能/テーマ開発 #用途/ガイドライン #重要度/高

関連ファイル:
- claude-knowledge/function/implementation/coding-standards.md
- claude-knowledge/function/testing/testing.md

# WordPressテーマ開発における基礎ストラクチャとルール

## 概要
このドキュメントはscriptlab WordPressプロジェクトにおけるテーマ開発の標準構造、コーディングルール、セキュリティ要件を定義する。モダンな開発環境とベストプラクティスに基づいた実践的なガイドライン。

## 詳細

### 1. ディレクトリ構造（厳守）

```
.
├── assets/                      # 静的アセット管理（CSS/JS/画像）
│   ├── css/                    # 最終的に出力されるCSS（ビルド後）
│   ├── js/                     # 最終的に出力されるJS（ビルド後）
│   ├── scss/                   # SCSS元ファイル
│   │   ├── _variables.scss     # 変数定義
│   │   ├── _mixins.scss        # ミックスイン
│   │   ├── _layout.scss        # レイアウト基本設計
│   │   └── main.scss           # メインエントリポイント
│   ├── ts/                     # TypeScript元ファイル（任意）
│   └── images/                 # 画像素材
├── template-parts/             # テンプレート断片群（get_template_part）
│   ├── header/                 # ヘッダー関連
│   ├── footer/                 # フッター関連
│   ├── content/                # 投稿や固定ページの本文テンプレート
│   ├── components/             # カスタムUIコンポーネント（例：カード、タグ等）
│   └── blocks/                 # Gutenbergブロック用テンプレート
├── inc/                        # 各種関数・設定ファイル
│   ├── setup.php               # テーマ初期化処理（サポート宣言等）
│   ├── enqueue.php             # CSS/JSの読み込み
│   ├── custom-post-types.php   # CPTの定義
│   ├── custom-taxonomies.php   # タクソノミーの定義
│   ├── shortcodes.php          # ショートコード定義
│   ├── filters.php             # フィルターフック群
│   ├── admin.php               # 管理画面カスタマイズ
│   ├── security.php            # セキュリティ関連設定
│   └── config.php              # 設定値・定数管理
├── languages/                  # 翻訳ファイル（.pot/.po/.mo）
├── tests/                      # PHPUnit テストファイル
├── functions.php               # inc/* を require_once するだけに留める
├── style.css                   # テーマメタ情報（@theme header）
├── screenshot.png              # テーマサムネイル（880x660推奨）
├── index.php                   # 最低限のフォールバックテンプレート
├── page.php                    # 固定ページ用テンプレート
├── single.php                  # 投稿詳細ページテンプレート
├── archive.php                 # アーカイブ一覧
├── search.php                  # 検索結果テンプレート
├── 404.php                     # 404エラー用テンプレート
├── package.json                # npm依存関係・ビルドスクリプト
├── webpack.config.js           # ビルド設定
└── .env                        # 環境変数（.gitignoreで除外）
```

### 2. コーディングルール（PHP）

#### 基本原則
- `functions.php` にはロジックを書かず、すべて `inc/` に分離する
- 定数は `define()` せず `inc/config.php` で一元管理する
- 全関数名にはテーマ接頭辞（`sl_`）をつける（グローバル汚染回避）
- `add_action` や `add_filter` は関数定義の直後に記述する

#### セキュリティ強化（必須）
```php
// 1. nonce検証の例
function sl_process_form() {
    if (!wp_verify_nonce($_POST['_wpnonce'], 'sl_form_action')) {
        wp_die('Security check failed');
    }
    
    // 2. 権限チェック
    if (!current_user_can('edit_posts')) {
        wp_die('Permission denied');
    }
    
    // 3. 入力サニタイズ
    $data = sanitize_text_field($_POST['user_input']);
    $email = sanitize_email($_POST['email']);
}

// 4. 出力エスケープ
echo esc_html($user_data);
echo esc_attr($attribute_value);
echo wp_kses_post($content_with_html);
```

#### パフォーマンス最適化
```php
// 条件分岐読み込み（inc/enqueue.php）
function sl_conditional_enqueue() {
    // 特定ページでのみ読み込み
    if (is_page('contact')) {
        wp_enqueue_script('contact-form', get_template_directory_uri() . '/assets/js/contact.js');
    }
    
    // キャッシュ活用
    $cached_data = wp_cache_get('sl_custom_data', 'sl_cache_group');
    if (false === $cached_data) {
        $cached_data = expensive_database_query();
        wp_cache_set('sl_custom_data', $cached_data, 'sl_cache_group', 3600);
    }
}
```

### 3. コーディングルール（HTML + テンプレート）

#### テンプレート設計
- テンプレートの断片化：`get_template_part()` を必ず使う
- 条件分岐テンプレートは極力 `template-parts/` にまとめる
- ループ処理は `have_posts()`, `the_post()` の形式を厳守する

```php
// 正しいループの例
if (have_posts()) :
    while (have_posts()) : the_post();
        get_template_part('template-parts/content/content', get_post_type());
    endwhile;
    the_posts_navigation();
else :
    get_template_part('template-parts/content/content', 'none');
endif;
```

### 4. CSS設計

#### 命名規則（BEM採用）
```scss
// Block__Element--Modifier
.card {
    &__header {
        padding: 1rem;
        
        &--featured {
            background-color: var(--primary-color);
        }
    }
    
    &__content {
        padding: 1.5rem;
    }
}
```

#### SCSS構造分離
```scss
// main.scss
@import 'variables';
@import 'mixins';
@import 'reset';
@import 'layout';
@import 'components';
@import 'utilities';
```

### 5. JavaScript設計

#### モダン開発環境
```javascript
// assets/ts/main.ts
document.addEventListener('DOMContentLoaded', () => {
    // DOM選択子はdata属性で指定
    const toggleButton = document.querySelector('[data-toggle="menu"]');
    const menu = document.querySelector('[data-menu="main"]');
    
    if (toggleButton && menu) {
        toggleButton.addEventListener('click', () => {
            menu.classList.toggle('is-open');
        });
    }
});
```

#### ビルド設定（webpack.config.js）
```javascript
const path = require('path');

module.exports = {
    entry: {
        main: './assets/ts/main.ts',
        admin: './assets/ts/admin.ts'
    },
    output: {
        path: path.resolve(__dirname, 'assets/js'),
        filename: '[name].js'
    },
    module: {
        rules: [
            {
                test: /\.ts$/,
                use: 'ts-loader',
                exclude: /node_modules/
            }
        ]
    }
};
```

### 6. WordPress機能設計

#### テーマ初期化（inc/setup.php）
```php
function sl_theme_setup() {
    // テーマサポート宣言
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list'));
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    // ナビゲーションメニュー登録
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'scriptlab'),
        'footer' => __('Footer Menu', 'scriptlab')
    ));
    
    // 画像サイズ登録
    add_image_size('sl-featured', 800, 450, true);
}
add_action('after_setup_theme', 'sl_theme_setup');
```

### 7. 開発効率化設定

#### package.json
```json
{
    "scripts": {
        "dev": "webpack --mode development --watch",
        "build": "webpack --mode production",
        "sass": "sass assets/scss:assets/css --watch",
        "lint:php": "php-cs-fixer fix --dry-run",
        "lint:scss": "stylelint assets/scss/**/*.scss",
        "test": "phpunit"
    },
    "devDependencies": {
        "webpack": "^5.0.0",
        "typescript": "^4.0.0",
        "sass": "^1.0.0",
        "stylelint": "^14.0.0"
    }
}
```

#### .gitignore
```
node_modules/
vendor/
.env
assets/css/*.css
assets/js/*.js
*.log
```

## 実装例

### カスタム投稿タイプの定義（inc/custom-post-types.php）
```php
function sl_register_portfolio_post_type() {
    $args = array(
        'public' => true,
        'label' => __('Portfolio', 'scriptlab'),
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'portfolio'),
        'show_in_rest' => true // Gutenberg対応
    );
    
    register_post_type('portfolio', $args);
}
add_action('init', 'sl_register_portfolio_post_type');
```

### セキュリティ設定（inc/security.php）
```php
// ファイルエディタ無効化
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

// XMLRPCを無効化
add_filter('xmlrpc_enabled', '__return_false');

// WordPressバージョン情報を非表示
remove_action('wp_head', 'wp_generator');

// ログイン試行回数制限
function sl_limit_login_attempts() {
    // 実装例（プラグイン使用推奨）
}
```

## 関連事項

### 他ナレッジとの関係
- **function/implementation/**: 汎用的なコーディング規約との整合性
- **function/testing/**: PHPUnitを使用したWordPressテストの実装
- **development/**: Docker環境でのWordPress開発環境構築

### 継続改善
- WordPress最新版への対応
- セキュリティ要件の定期見直し
- パフォーマンス最適化の改善
- 開発効率化ツールの導入検討

{
  "@context": "https://schema.org",
  "@type": "TechArticle",
  "name": "WordPressテーマ開発ガイドライン",
  "description": "scriptlab WordPressプロジェクトのテーマ開発標準",
  "keywords": ["WordPress", "テーマ開発", "PHP", "セキュリティ", "パフォーマンス"],
  "author": {
    "@type": "Organization",
    "name": "scriptlab"
  },
  "dateModified": "2025-07-14",
  "programmingLanguage": ["PHP", "JavaScript", "SCSS"],
  "operatingSystem": "Any",
  "applicationCategory": "DeveloperTool"
}

検索キーワード: wordpress, theme-development, php, security, performance, scss, javascript, gutenberg, custom-post-types, hooks, filters