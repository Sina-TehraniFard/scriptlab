---
allowed-tools: Read(*), Write(*), Edit(*), MultiEdit(*), Bash(find:*), Bash(php -l:*), Bash(docker compose:*), Grep(*), Glob(*)
description: WordPressテーマ機能を実装（セキュア＆ベストプラクティス準拠）
argument-hint: 実装したい機能の説明（例：カスタム投稿タイプ、メニュー、ウィジェット等）
---

# WordPress テーマ開発実装

$ARGUMENTS

## 実装手順

<task>
1. まず theme/scriptlab-theme/ の既存構造を確認
2. functions.php と関連ファイルを読み込んで現状把握
3. 要求された機能を以下の規約で実装：

**必須セキュリティ対策**
- 出力: esc_html(), esc_attr(), esc_url(), wp_kses()
- 入力: sanitize_text_field(), absint(), wp_verify_nonce()
- SQL: $wpdb->prepare()
- 権限: current_user_can()

**WordPress規約**
- 国際化: __('text', 'scriptlab'), _e('text', 'scriptlab')
- プラガブル: if ( ! function_exists('func_name') )
- フック: add_action('init', 'func_name', 10)
- テキストドメイン: 'scriptlab'

4. 実装後、PHP構文チェック実行:
```bash
find theme/scriptlab-theme -name "*.php" -exec php -l {} \;
```

5. エラーが0件になるまで修正を繰り返す
</task>

## コード例（参考用）

<example>
カスタム投稿タイプ登録:
```php
function scriptlab_register_custom_post() {
    $args = array(
        'label' => __('カスタム投稿', 'scriptlab'),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
    );
    register_post_type('scriptlab_custom', $args);
}
add_action('init', 'scriptlab_register_custom_post');
```

フォーム処理:
```php
// 出力時
wp_nonce_field('scriptlab_action', 'scriptlab_nonce');

// 処理時
if (!wp_verify_nonce($_POST['scriptlab_nonce'], 'scriptlab_action')) {
    wp_die(__('不正なリクエスト', 'scriptlab'));
}
$safe = sanitize_text_field($_POST['field']);
```
</example>