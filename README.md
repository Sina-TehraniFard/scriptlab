# ScriptLab WordPress テーマ開発プロジェクト

このドキュメントはScriptLabプロジェクトのWordPressテーマ開発における起源、構造、開発経緯を追跡できるようにするためのガイドドキュメントです。

## プロジェクト概要

**プロジェクト名**: ScriptLab  
**テーマ名**: ScriptLab Theme  
**ベース**: _s (Underscores) スターターテーマ  
**作成者**: sina  
**開発開始**: 2025年7月  
**バージョン**: 1.0.0  

## プロジェクト起源

### 初期コミット履歴
```
c271eb8 CLAUDE.mdを更新
2a52859 ドキュメント整備  
df33610 Remove .env.example from tracking and update .gitignore
2389d8c Remove .env from tracking and update .gitignore
b6aee00 Initial commit: Docker environment and base WordPress theme
4facfc3 Initial commit
```

### 開発環境の構築
1. **Docker環境**: `docker-compose.yml`によるWordPress + MySQL環境
2. **開発用URL**: `http://localhost:8080`
3. **テーマパス**: `/home/sina/scriptlab/theme/scriptlab-theme/`

## ディレクトリ構造

```
/home/sina/scriptlab/
├── docker-compose.yml              # Docker環境設定
├── docker-compose.override.yml     # Docker環境カスタマイズ
├── CLAUDE.md                       # Claude Code作業ルール
├── theme/                          # テーマ開発メインディレクトリ
│   ├── README.md                   # このファイル（プロジェクトガイド）
│   ├── claude-knowledge/           # ナレッジベース
│   │   ├── development/            # 開発関連ナレッジ
│   │   │   └── wordpress-theme-starter-setup.md
│   │   └── system-specific/        # プロジェクト固有ナレッジ
│   │       ├── scriptlab-wordpress-setup.md
│   │       └── wordpress-theme-troubleshooting-docker.md
│   ├── scriptlab-theme/            # メインテーマ（本番用）
│   │   ├── style.css               # テーマ情報＋スタイル定義
│   │   ├── functions.php           # テーマ機能・設定
│   │   ├── index.php              # メインテンプレート
│   │   ├── header.php             # ヘッダーテンプレート
│   │   ├── footer.php             # フッターテンプレート
│   │   ├── sidebar.php            # サイドバーテンプレート
│   │   ├── inc/                   # 追加機能ディレクトリ
│   │   │   ├── custom-header.php   # カスタムヘッダー機能
│   │   │   ├── customizer.php      # カスタマイザー設定
│   │   │   ├── template-tags.php   # テンプレートタグ
│   │   │   └── template-functions.php # テンプレート関数
│   │   ├── js/                    # JavaScript
│   │   │   ├── customizer.js       # カスタマイザー用JS
│   │   │   └── navigation.js       # ナビゲーション用JS
│   │   └── template-parts/        # テンプレートパーツ
│   │       ├── content.php         # 記事コンテンツ部分
│   │       └── content-none.php    # コンテンツなし表示
│   └── scriptlab-theme-backup/     # バックアップ用テーマ
└── .claude/                        # Claude Code設定
```

## 技術仕様

### ベーステーマ: _s (Underscores)
- **提供元**: Automattic社
- **特徴**: 装飾を排除した構造のみのスターターテーマ
- **利点**: WordPressコーディング規約準拠、段階的な開発が可能

### 主要技術スタック
- **PHP**: 7.4+ (WordPress要件)
- **CSS**: CSS3 + Normalize.css
- **JavaScript**: ES5準拠（ブラウザ互換性重視）
- **WordPress**: 6.5対応
- **Docker**: WordPress + MySQL 8.0環境

## 開発経緯と問題解決

### 主要な開発段階
1. **初期環境構築** (Initial commit)
   - Docker環境のセットアップ
   - _sベーステーマの導入

2. **基本構造の整備** (Base WordPress theme)
   - 必須テンプレートファイルの作成
   - 基本的なWordPress機能の実装

3. **ナレッジベースの構築** (ドキュメント整備)
   - 開発ガイドラインの策定
   - トラブルシューティング情報の蓄積

### 解決した主要問題

#### 1. 画面真っ白問題
- **原因**: 不完全なテンプレートファイル
- **解決**: _s標準構造に準拠した完全なファイル作成

#### 2. CSS読み込み問題  
- **原因**: functions.phpでのアセット登録不備
- **解決**: 適切なwp_enqueue_style()実装とファイル存在チェック

#### 3. Docker環境での反映問題
- **原因**: コンテナキャッシュとボリュームマウント
- **解決**: 適切なコンテナ再起動手順の確立

## 現在の開発状況

### 実装済み機能
- ✅ 基本的なWordPressテーマ構造
- ✅ レスポンシブデザイン対応
- ✅ カスタムロゴ機能
- ✅ ナビゲーションメニュー
- ✅ ウィジェットエリア
- ✅ カスタムヘッダー機能
- ✅ HTML5サポート
- ✅ 国際化対応(i18n)
- ✅ アクセシビリティ考慮

### テーマ特徴
- **Text Domain**: `scriptlab`
- **対応機能**: カスタム背景、カスタムロゴ、カスタムメニュー、アイキャッチ画像、スレッド化コメント、翻訳対応
- **デザイン**: ミニマル、モダン、レスポンシブ
- **カラーパレット**: デフォルト背景色 #ffffff

## 開発ワークフロー

### 1. 環境起動
```bash
cd /home/sina/scriptlab
docker compose up -d
```

### 2. テーマ編集
```bash
cd theme/scriptlab-theme/
# ファイル編集作業
```

### 3. 変更確認
- ブラウザで `http://localhost:8080` にアクセス
- 必要に応じて `docker compose restart wordpress`

### 4. 品質チェック
```bash
# PHP構文チェック
find . -name "*.php" -exec php -l {} \;

# ログ確認  
docker compose logs -f wordpress
```

### 5. バックアップ
```bash
# テーマバックアップ
cp -r scriptlab-theme scriptlab-theme-backup

# Git管理
git add .
git commit -m "機能更新: 説明"
```

## トラブルシューティング

問題が発生した場合の参照先：

1. **一般的な問題**: `claude-knowledge/development/wordpress-theme-starter-setup.md`
2. **Docker環境問題**: `claude-knowledge/system-specific/wordpress-theme-troubleshooting-docker.md`  
3. **プロジェクト固有設定**: `claude-knowledge/system-specific/scriptlab-wordpress-setup.md`
4. **Claude Code作業ルール**: `/home/sina/scriptlab/CLAUDE.md`

## ナレッジベース活用方法

### 汎用ナレッジ (`claude-knowledge/`)
- WordPressテーマ開発の一般的なベストプラクティス
- 他のプロジェクトでも再利用可能な情報

### システム固有ナレッジ (`claude-knowledge/system-specific/`)
- ScriptLabプロジェクト固有の設定と構成
- Docker環境の詳細設定
- プロジェクト特有のトラブルシューティング

## 今後の拡張予定

### 検討中の機能
- カスタム投稿タイプ対応
- 追加のテンプレートファイル（single.php、page.php等）
- カスタムフィールド機能
- パフォーマンス最適化
- SEO対応強化

### 保守・運用方針
- WordPressコーディング規約の厳守
- 定期的なセキュリティ更新
- バックアップの自動化
- テストの充実化

---

このドキュメントは開発の進展に合わせて更新されます。テーマ開発で問題や疑問が生じた場合は、まずこのドキュメントと関連するナレッジベースを参照してください。

**最終更新**: 2025年7月25日  
**作成者**: Claude Code  
**プロジェクト**: ScriptLab WordPress Theme Development