# ScriptLab WordPress Theme

![WordPress](https://img.shields.io/badge/WordPress-6.5%2B-blue)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-v4-06B6D4)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED)
![License](https://img.shields.io/badge/License-GPL%20v2-green)

WordPressテーマ開発プロジェクト。_s (Underscores)をベースに、Tailwind CSSを統合したモダンなテーマ開発環境。

## 🚀 クイックスタート

### 前提条件

- Docker & Docker Compose
- Node.js 18+ & npm
- Git

### 環境構築手順

```bash
# 1. リポジトリのクローン
git clone [repository-url]
cd scriptlab

# 2. 環境変数の設定（必要に応じて）
cp .env.example .env
# .envファイルを編集して設定

# 3. Docker環境の起動
docker compose up -d

# 4. 依存パッケージのインストール
npm install

# 5. Tailwind CSSのビルド
npm run build

# 6. ブラウザでアクセス
# http://localhost:8000
```

### 初回セットアップ

WordPressの初回セットアップ画面が表示されたら：

1. 言語を選択
2. サイト情報を入力
3. 管理者アカウントを作成
4. 管理画面 → 外観 → テーマ から「ScriptLab Theme」を有効化

## 📁 プロジェクト構造

```
scriptlab/
├── 📄 docker-compose.yml        # Docker環境設定
├── 📄 docker-compose.override.yml # 開発環境のポート設定(8000)
├── 📄 package.json              # Node.js依存関係
├── 📄 tailwind.config.js        # Tailwind CSS設定
├── 📄 postcss.config.js         # PostCSS設定
├── 📄 CLAUDE.md                 # Claude Code用ガイドライン
├── 📁 .claude/
│   └── 📁 commands/
│       └── 📄 imp.md            # WordPress実装コマンド
└── 📁 theme/
    └── 📁 scriptlab-theme/      # メインテーマ
        ├── 📄 style.css         # Tailwindビルド済みCSS
        ├── 📄 functions.php     # テーマ機能
        ├── 📄 index.php         # メインテンプレート
        ├── 📄 header.php        # ヘッダー
        ├── 📄 footer.php        # フッター
        ├── 📁 src/
        │   └── 📄 input.css     # Tailwindソース
        ├── 📁 inc/              # 機能分離
        ├── 📁 js/               # JavaScript
        └── 📁 template-parts/   # テンプレートパーツ
```

## 🛠️ 開発コマンド

### Docker操作

```bash
# 環境起動
docker compose up -d

# 環境停止
docker compose down

# コンテナ再起動（変更反映）
docker compose restart wordpress

# ログ確認
docker compose logs -f wordpress

# WordPressコンテナに入る
docker exec -it $(docker ps -q -f name=wordpress) bash
```

### Tailwind CSS

```bash
# 開発モード（ファイル監視）
npm run dev

# 本番ビルド（圧縮）
npm run build
```

### コード品質

```bash
# PHP構文チェック
docker exec $(docker ps -q -f name=wordpress) \
  find /var/www/html/wp-content/themes/scriptlab-theme \
  -name "*.php" -exec php -l {} \;

# Claude Codeでの実装（Tailwind必須）
# .claude/commands/imp.md 使用
/imp [実装したい機能の説明]
```

## 🎨 Tailwind CSS 統合

このテーマは**Tailwind CSS v4**を使用しており、以下のルールが適用されます：

### スタイリングルール

- ✅ **Tailwindユーティリティクラスのみ使用**
- ❌ カスタムCSS禁止
- ❌ インラインstyle属性禁止（移行期を除く）
- ✅ WordPress必須クラスは`src/input.css`で定義

### WordPress必須クラス対応

```css
/* src/input.css内で定義済み */
.screen-reader-text    /* アクセシビリティ */
.alignleft/right/center /* コンテンツ配置 */
.wp-caption            /* メディアキャプション */
.sticky                /* 固定投稿 */
```

## 💻 技術スタック

### コア技術

- **WordPress**: 6.5.3
- **PHP**: 7.4+（8.2推奨）
- **MySQL**: 8.0
- **Apache**: 2.4

### フロントエンド

- **Tailwind CSS**: v4.1.12
- **PostCSS**: Autoprefixer対応
- **JavaScript**: ES6+（バニラJS）

### 開発環境

- **Docker Compose**: コンテナ化環境
- **Node.js**: ビルドツール
- **npm**: パッケージ管理

## 🔒 セキュリティ対策

WordPressのベストプラクティスに従った実装：

```php
// 出力エスケープ
esc_html(), esc_attr(), esc_url(), wp_kses()

// 入力検証
sanitize_text_field(), absint()

// CSRF対策
wp_verify_nonce()

// SQL対策
$wpdb->prepare()

// 権限確認
current_user_can()
```

## 📝 開発ガイドライン

### WordPress規約

- **国際化**: `__()`, `_e()` 使用（テキストドメイン: `scriptlab`）
- **プラガブル関数**: `if ( ! function_exists() )` でラップ
- **フック**: 適切な優先度設定
- **テンプレート階層**: WordPress標準に準拠

### コーディング規約

1. WordPress Coding Standards準拠
2. PHPDocコメント必須
3. エスケープ処理徹底
4. Tailwindクラスのみ使用

## 🚧 トラブルシューティング

### Tailwind CSSが反映されない

```bash
# 1. ビルドを再実行
npm run build

# 2. ブラウザキャッシュをクリア
# 3. Dockerコンテナを再起動
docker compose restart wordpress
```

### PHPエラーが発生

```bash
# エラーログ確認
docker compose logs wordpress

# Debug有効化（wp-config.php）
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### 変更が反映されない

```bash
# 1. コンテナ再起動
docker compose restart wordpress

# 2. ボリュームの確認
docker compose down
docker compose up -d
```

## 📚 関連ドキュメント

- [CLAUDE.md](./CLAUDE.md) - Claude Code用開発ガイド
- [STYLE_GUIDE.md](./STYLE_GUIDE.md) - スタイルガイドライン
- [WordPress Codex](https://codex.wordpress.org/) - WordPress公式ドキュメント
- [Tailwind CSS Docs](https://tailwindcss.com/docs) - Tailwind公式ドキュメント

## 🤝 コントリビューション

1. Featureブランチを作成 (`git checkout -b feature/AmazingFeature`)
2. 変更をコミット (`git commit -m 'Add some AmazingFeature'`)
3. ブランチをプッシュ (`git push origin feature/AmazingFeature`)
4. Pull Requestを作成

## 📄 ライセンス

GNU General Public License v2 or later - [LICENSE](./LICENSE)

## 👥 作成者

- **sina** - 初期開発
- **Claude Code** - 開発支援・ドキュメント作成

---

**最終更新**: 2025年8月16日  
**バージョン**: 0.1.0
**ステータス**: 🟢 Active Development