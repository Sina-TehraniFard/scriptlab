タグ: #技術/Docker #機能/環境構築 #用途/セットアップ #重要度/高

関連ファイル:
- claude-knowledge/system-specific/wordpress-theme-guidelines.md
- README.md

# Docker環境構築ガイド

## 概要
scriptlab WordPressプロジェクトのDocker開発環境構築手順とトラブルシューティング。本番環境への移行準備も含む包括的なガイド。

## 詳細

### 1. 環境要件

#### 必須ソフトウェア
- **Docker Desktop**: 4.0以降
- **Node.js**: 18.x以降（ビルドツール用）
- **Git**: 2.30以降
- **エディタ**: VS Code推奨（拡張機能設定含む）

#### システム要件
- **メモリ**: 最低8GB（推奨16GB）
- **ディスク**: 最低10GB空き容量
- **OS**: Windows 10 Pro/macOS 10.15/Ubuntu 20.04以降

### 2. 初期セットアップ手順

#### Step 1: プロジェクトクローン
```bash
# リポジトリクローン
git clone <repository-url> scriptlab
cd scriptlab

# ディレクトリ構造確認
ls -la
```

#### Step 2: 環境変数設定
```bash
# .envファイル作成
cp .env.example .env

# セキュリティキー生成（推奨）
curl -s https://api.wordpress.org/secret-key/1.1/salt/ >> temp_keys.txt
# temp_keys.txtの内容を.envに手動でコピー
rm temp_keys.txt
```

#### Step 3: Docker環境起動
```bash
# バックグラウンドで起動
docker-compose up -d

# ログ確認（起動確認）
docker-compose logs -f wordpress

# ヘルスチェック確認
docker-compose ps
```

#### Step 4: WordPress初期設定
1. ブラウザで `http://localhost:8000` にアクセス
2. 言語選択（日本語推奨）
3. データベース接続設定（.envの値を使用）
4. サイト情報入力
5. 管理者アカウント作成

#### Step 5: テーマ有効化
```bash
# WordPressコンテナに接続
docker-compose exec wordpress bash

# テーマディレクトリ確認
ls -la /var/www/html/wp-content/themes/

# 管理画面でscriptlab-themeを有効化
# 外観 > テーマ > scriptlab-theme > 有効化
```

### 3. 開発環境設定

#### Node.js環境セットアップ
```bash
# テーマディレクトリに移動
cd theme/scriptlab-theme

# package.json作成（初回のみ）
cat > package.json << 'EOF'
{
  "name": "scriptlab-theme",
  "version": "1.0.0",
  "scripts": {
    "dev": "webpack --mode development --watch",
    "build": "webpack --mode production",
    "sass": "sass assets/scss:assets/css --watch",
    "lint:php": "php-cs-fixer fix --dry-run",
    "lint:scss": "stylelint assets/scss/**/*.scss",
    "test": "phpunit"
  },
  "devDependencies": {
    "webpack": "^5.88.0",
    "webpack-cli": "^5.1.0",
    "typescript": "^5.1.0",
    "ts-loader": "^9.4.0",
    "sass": "^1.63.0",
    "stylelint": "^15.10.0",
    "php-cs-fixer": "^3.21.0"
  }
}
EOF

# 依存関係インストール
npm install
```

#### Webpack設定
```bash
# webpack.config.js作成
cat > webpack.config.js << 'EOF'
const path = require('path');

module.exports = {
    entry: {
        main: './assets/ts/main.ts',
        admin: './assets/ts/admin.ts'
    },
    module: {
        rules: [
            {
                test: /\.ts$/,
                use: 'ts-loader',
                exclude: /node_modules/
            }
        ]
    },
    resolve: {
        extensions: ['.ts', '.js']
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'assets/js')
    }
};
EOF
```

### 4. Docker構成詳細

#### docker-compose.yml解説
```yaml
services:
  wordpress:
    image: wordpress:6.5.3-php8.2-apache
    # PHP 8.2 + Apache構成
    # セキュリティアップデート適用済み
    
    env_file: .env
    # 環境変数を.envから読み込み
    
    volumes:
      - ./theme/scriptlab-theme:/var/www/html/wp-content/themes/scriptlab-theme
      # テーマディレクトリをマウント（リアルタイム反映）
    
    healthcheck:
      test: ["CMD-SHELL", "curl -f http://localhost || exit 1"]
      # Apacheの動作確認
      
  db:
    image: mysql:8.0
    # MySQL 8.0（最新安定版）
    
    volumes:
      - db_data:/var/lib/mysql
      # データ永続化
```

#### ポート設定とアクセス
- **WordPress**: `http://localhost:8000`
- **管理画面**: `http://localhost:8000/wp-admin`
- **MySQL**: 内部通信のみ（外部アクセス不可）

### 5. トラブルシューティング

#### よくある問題と解決法

##### 1. Docker起動エラー
```bash
# ポート競合確認
netstat -an | grep 8000

# コンテナ状態確認
docker-compose ps

# ログ詳細確認
docker-compose logs wordpress
docker-compose logs db
```

##### 2. データベース接続エラー
```bash
# DB初期化
docker-compose down -v
docker-compose up -d

# .env設定確認
cat .env | grep WORDPRESS_DB
```

##### 3. テーマファイル反映されない
```bash
# ボリュームマウント確認
docker-compose exec wordpress ls -la /var/www/html/wp-content/themes/

# パーミッション修正
docker-compose exec wordpress chown -R www-data:www-data /var/www/html/wp-content/themes/scriptlab-theme
```

##### 4. ビルドエラー
```bash
# Node.jsバージョン確認
node --version
npm --version

# node_modules再インストール
rm -rf node_modules package-lock.json
npm install
```

### 6. パフォーマンス最適化

#### Docker設定最適化
```bash
# Docker Desktop設定（推奨値）
# Memory: 4GB以上
# CPU: 2コア以上
# Disk image size: 64GB以上
```

#### ファイル監視最適化
```json
// package.json - webpack設定
{
  "scripts": {
    "dev": "webpack --mode development --watch --stats=minimal"
  }
}
```

### 7. 本番環境への移行準備

#### 環境差分管理
```bash
# 本番用Docker設定
cp docker-compose.yml docker-compose.prod.yml

# 本番用環境変数
cp .env .env.production
```

#### セキュリティ強化
```yaml
# docker-compose.prod.yml
services:
  wordpress:
    environment:
      WORDPRESS_DEBUG: false
      WORDPRESS_DEBUG_LOG: false
    # 開発用設定を無効化
```

## 実装例

### VS Code開発環境設定
```json
// .vscode/settings.json
{
    "php.suggest.basic": false,
    "php.validate.executablePath": "/usr/bin/php",
    "files.associations": {
        "*.php": "php"
    },
    "editor.formatOnSave": true,
    "typescript.preferences.includePackageJsonAutoImports": "auto"
}
```

### 開発用エイリアス設定
```bash
# ~/.bashrc または ~/.zshrc
alias dcup='docker-compose up -d'
alias dcdown='docker-compose down'
alias dclog='docker-compose logs -f'
alias wpbash='docker-compose exec wordpress bash'
alias dcreset='docker-compose down -v && docker-compose up -d'
```

## 関連事項

### 他ドキュメントとの関係
- **README.md**: プロジェクト全体概要とクイックスタート
- **wordpress-theme-guidelines.md**: テーマ開発の詳細ルール
- **claude-knowledge/function/**: 汎用的な開発・テストガイドライン

### 継続改善
- Docker imageの定期更新
- セキュリティパッチの適用
- パフォーマンス監視の導入
- バックアップ戦略の策定

{
  "@context": "https://schema.org",
  "@type": "TechArticle",
  "name": "Docker環境構築ガイド",
  "description": "scriptlab WordPressプロジェクトのDocker開発環境構築手順",
  "keywords": ["Docker", "WordPress", "環境構築", "トラブルシューティング", "開発環境"],
  "author": {
    "@type": "Organization",
    "name": "scriptlab"
  },
  "dateModified": "2025-07-14",
  "operatingSystem": ["Windows", "macOS", "Linux"],
  "applicationCategory": "DeveloperTool",
  "requirements": "Docker Desktop 4.0+, Node.js 18+, Git 2.30+"
}

検索キーワード: docker, wordpress, environment-setup, development, troubleshooting, mysql, apache, php8.2, containerization, local-development