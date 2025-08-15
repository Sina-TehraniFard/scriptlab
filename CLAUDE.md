# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## プロジェクト概要

**ScriptLab WordPress Theme Development**
- WordPressテーマ開発環境（Docker構成）
- ベーステーマ: _s (Underscores) スターターテーマ
- テーマパス: `theme/scriptlab-theme/`
- 開発URL: `http://localhost:8000` (docker-compose.override.ymlで設定)

## 開発コマンド

### 環境管理
```bash
# Docker環境起動
docker compose up -d

# Docker環境停止
docker compose down

# コンテナ再起動（変更反映用）
docker compose restart wordpress

# ログ確認
docker compose logs -f wordpress
```

### PHPチェック・検証
```bash
# PHP構文チェック（テーマディレクトリ内）
find theme/scriptlab-theme -name "*.php" -exec php -l {} \;

# WordPress Coding Standards（PHPCS導入時）
vendor/bin/phpcs --standard=WordPress theme/scriptlab-theme

# WP-CLIテーマチェック（WP-CLI導入時）
wp theme check scriptlab
```

## アーキテクチャ構造

### テーマ構造（_sベース）
```
theme/scriptlab-theme/
├── style.css              # テーマ情報とスタイル定義
├── functions.php          # テーマ機能・フック登録
├── index.php             # メインテンプレート
├── header.php            # ヘッダーテンプレート
├── footer.php            # フッターテンプレート  
├── sidebar.php           # サイドバーテンプレート
├── inc/                  # 機能分離ディレクトリ
│   ├── custom-header.php     # カスタムヘッダー機能
│   ├── customizer.php        # カスタマイザー設定
│   ├── template-tags.php     # テンプレートタグ関数
│   └── template-functions.php # テンプレート補助関数
├── js/                   # JavaScript
│   ├── customizer.js         # カスタマイザー用JS
│   └── navigation.js         # ナビゲーション用JS
└── template-parts/       # 再利用可能なテンプレートパーツ
    ├── content.php           # 投稿コンテンツ表示
    └── content-none.php      # コンテンツなし時表示
```

### Docker構成
- **WordPress**: 6.5.3-php8.2-apache
- **MySQL**: 8.0
- **ボリュームマウント**: テーマディレクトリをコンテナ内にマウント
- **環境変数**: `.env`ファイルで管理

## 重要な開発ルール

### WordPress開発規約
- **エスケープ必須**: 出力時は`esc_html()`, `esc_attr()`, `esc_url()`使用
- **国際化対応**: テキストは`__()`, `_e()`等でラップ
- **nonce検証**: フォーム送信時は必須
- **プラガブル関数**: `if ( ! function_exists() )`でラップ

### テーマ開発時の確認事項
1. PHPエラーがないか構文チェック実行
2. functions.phpの既存コードとの競合確認
3. テンプレート階層に従った適切なファイル配置
4. カスタム投稿タイプ・タクソノミーの責任分界考慮

## 作業ルール

### ユーザーからの質問への対応（Q&A）
- 直接回答すること。追加のガイドライン参照は不要です。
- ナレッジのフルパスをもらった場合は該当ディレクトリを確認して回答する

### 実装タスク実行時
- PHP実装後は必ず構文チェック実行: `find theme/scriptlab-theme -name "*.php" -exec php -l {} \;`
- エラーが1件でもある場合は修正してから完了報告
- functions.php編集時は既存コードとの競合を確認

### Git操作ルール
- ユーザーの明示的な指示なしにgit操作を実行しない
- commit作成を依頼された場合のみgitコマンドを実行
