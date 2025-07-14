# scriptlab

WordPressカスタムテーマ開発プロジェクト

## 📋 プロジェクト概要

scriptlabは、モダンな開発環境とベストプラクティスに基づいたWordPressカスタムテーマです。Docker環境での開発、セキュアなコーディング標準、効率的なビルドプロセスを特徴とします。

### 🎯 主な特徴
- **モダンな開発環境**: Docker + WordPress 6.5.3 + PHP 8.2
- **セキュアなコーディング**: nonce検証、権限チェック、入力サニタイズを標準化
- **パフォーマンス最適化**: 条件分岐読み込み、キャッシュ活用、画像最適化
- **効率的なワークフロー**: SCSS/TypeScript、ビルドツール、テスト環境統合

## 🚀 クイックスタート

### 必要条件
- Docker Desktop
- Node.js 18+ (ビルドツール用)
- Git

### 環境構築

1. **リポジトリクローン**
```bash
git clone <repository-url> scriptlab
cd scriptlab
```

2. **環境変数設定**
```bash
# .envファイルを作成（サンプルを参考）
cp .env.example .env
# 必要に応じて設定値を編集
```

3. **Docker環境起動**
```bash
docker-compose up -d
```

4. **WordPress初期設定**
- ブラウザで `http://localhost:8000` にアクセス
- WordPress管理画面で初期設定を完了
- 外観 > テーマから「scriptlab-theme」を有効化

5. **開発環境セットアップ**
```bash
# テーマディレクトリに移動
cd theme/scriptlab-theme

# 依存関係インストール
npm install

# 開発サーバー起動（SCSS/JSビルド監視）
npm run dev
```

## 🛠️ 開発ガイド

### ディレクトリ構造
```
theme/scriptlab-theme/
├── assets/           # 静的アセット（CSS/JS/画像）
├── template-parts/   # テンプレート断片
├── inc/              # PHP関数・設定ファイル
├── languages/        # 翻訳ファイル
├── tests/            # PHPUnitテスト
└── 各種テンプレートファイル
```

### 主要コマンド
```bash
# 開発モード（ファイル監視）
npm run dev

# 本番ビルド
npm run build

# PHPコード品質チェック
npm run lint:php

# SCSS品質チェック
npm run lint:scss

# テスト実行
npm run test
```

### コーディング規約
- **PHP**: PSR-12準拠、接頭辞`sl_`必須、セキュリティ関数の使用
- **CSS**: BEM命名規則、SCSS構造分離
- **JavaScript**: TypeScript使用、data属性でのDOM選択

詳細は [`claude-knowledge/system-specific/wordpress-theme-guidelines.md`](claude-knowledge/system-specific/wordpress-theme-guidelines.md) を参照

## 🔧 開発環境詳細

### Docker構成
- **WordPress**: 6.5.3-php8.2-apache
- **MySQL**: 8.0
- **ポート**: 8000 (デフォルト、.envで変更可能)
- **ボリューム**: テーマファイルのリアルタイム反映

### ビルドツール
- **Webpack**: JavaScript/TypeScriptバンドル
- **Sass**: SCSS → CSS変換
- **PostCSS**: CSS後処理（autoprefixer等）

### 品質管理
- **PHP-CS-Fixer**: PHP コードフォーマット
- **Stylelint**: SCSS品質チェック
- **PHPUnit**: ユニットテスト

## 📚 ドキュメント

### 開発ガイドライン
- [テーマ開発ガイドライン](claude-knowledge/system-specific/wordpress-theme-guidelines.md)
- [コーディング規約](claude-knowledge/function/implementation/)
- [テスト戦略](claude-knowledge/function/testing/)

### 参考リソース
- [WordPress Developer Handbook](https://developer.wordpress.org/)
- [PHP-FIG PSR Standards](https://www.php-fig.org/psr/)
- [BEM Methodology](https://getbem.com/)

## 🤝 コントリビューション

1. 機能ブランチを作成: `git checkout -b feature/amazing-feature`
2. 変更をコミット: `git commit -m 'Add amazing feature'`
3. ブランチをプッシュ: `git push origin feature/amazing-feature`
4. プルリクエストを作成

### コミット前チェックリスト
- [ ] コーディング規約に準拠
- [ ] テストが通る
- [ ] ドキュメントを更新（必要に応じて）

## 📞 サポート

- **イシュー報告**: GitHubのIssuesタブ
- **質問**: Discussionsタブ
- **ドキュメント**: `claude-knowledge/` ディレクトリ

## 📝 ライセンス

MIT License - 詳細は [LICENSE](LICENSE) ファイルを参照

---

**🔗 関連リンク**
- [WordPress公式サイト](https://wordpress.org/)
- [Docker公式ドキュメント](https://docs.docker.com/)
- [Node.js公式サイト](https://nodejs.org/)
