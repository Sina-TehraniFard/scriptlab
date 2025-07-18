指定されたタスクについて、事前に必要なナレッジを読み込んでから実装を行う。
実装ガイドラインとベストプラクティスに従い、高品質なコードを実装してください。
Ultrathink.

## 必須参照ナレッジ

### 実装前に必ず読み込むファイル
以下のナレッジファイルを実装開始前に必ず読み込み、ガイドラインに従って実装してください：

1. **基本実装ガイドライン**
   - `./claude-knowledge/function/implementation/general-implementation-guidelines.md`

2. **Kotlin実装ガイドライン**  
   - `./claude-knowledge/function/implementation/kotlin-implementation-idiompriority.md`
   - Kotlinイディオム優先実装（Kotlin使用時必須）

3. **機能別実装ガイドライン（該当する場合）**
   - ConnectorGateway実装: `./claude-knowledge/function/implementation/gateway-upsertaccount-implementation.md`

4. **テスト実装ガイドライン**
   - `./claude-knowledge/function/testing/testing-junit-guidelines.md`
   - テストコード作成時（必須）

### タスク関連ナレッジの動的検索
タスクの内容に応じて、以下のディレクトリから関連ナレッジを検索・参照してください：

- `./claude-knowledge/integrations/` - SaaS連携関連
- `./claude-knowledge/resource/` - 技術仕様・API仕様
- `./claude-knowledge/development/` - 開発環境・ワークフロー

## 実行手順

### ステップ1: ナレッジ読み込みと理解
1. 上記必須参照ナレッジファイルを全て読み込み
2. タスクに関連するキーワードで追加ナレッジを検索
3. 実装要件とガイドラインを理解・整理
4. 技術スタック（Kotlin/Vue3/TypeScript等）を確認

### ステップ2: 実装計画の作成
1. タスクを具体的なサブタスクに分解
2. TodoWriteツールで実装計画を作成
3. 実装順序と依存関係を整理
4. 必要なファイル・クラス・メソッドを特定

### ステップ3: 既存コードの調査と理解
1. 関連する既存実装を調査（Grep/Globツール使用）
2. 既存のパターンとコーディングスタイルを確認
3. 類似機能の実装方法を参考に
4. 既存テストコードの構造を確認

### ステップ4: 実装の実行
以下の順序で実装を進めてください：

#### A. コア機能の実装
- **設計原則の遵守**
  - 単一責任原則
  - オープン・クローズ原則
  - 依存性逆転原則
- **コーディング規約の遵守**
  - 日本語メッセージ・コメント
  - Kotlinイディオムの活用
  - null安全性の確保
- **エラーハンドリング**
  - 適切な例外処理
  - ユーザー向け日本語メッセージ
  - ログ出力の実装

#### B. テストコードの実装
- **正常系テスト**
  - 基本的な動作確認
  - 期待値との一致確認
- **異常系テスト**
  - 入力値バリデーションテスト
  - エラーハンドリングテスト
  - 境界値テスト
- **テストデータ**
  - 実データに近いテストデータ
  - エッジケースを含むデータ

#### C. ドキュメント・コメントの追加
- **コメント**
  - クラス・メソッドの目的説明
  - 複雑なロジックの解説
  - 注意事項・制約の記載
- **型定義**
  - 適切な型アノテーション
  - Nullable/Non-null の明示

### ステップ5: 品質保証とコンパイルチェック

#### 必須実行項目（CLAUDE.mdに基づく）
実装完了後は以下を**必ず実行**してください：

1. **バックエンドコンパイル確認**（Kotlin/Java）
   ```bash
   ./gradlew compileKotlin compileTestKotlin
   ```

2. **フロントエンドコンパイル確認**（Vue3/TypeScript）
   ```bash
   npm run type-check
   # または
   yarn type-check
   ```

3. **ビルド確認**
   ```bash
   ./gradlew build --no-daemon
   # フロントエンドの場合
   npm run build
   ```

4. **テスト実行**
   ```bash
   ./gradlew test
   # または
   npm run test
   ```

#### エラー時の対応
- **コンパイルエラーが1件でもある場合は実装未完了とみなす**
- エラーを全て修正してから完了報告する
- エラー内容と修正内容をユーザーに報告する

### ステップ6: コードレビューの実施

#### セルフレビューチェック項目

##### A. 実装品質
- [ ] ガイドラインに従った実装になっているか
- [ ] Kotlinイディオムを適切に使用しているか
- [ ] null安全性が確保されているか
- [ ] 日本語メッセージ・コメントが適切か

##### B. セキュリティ
- [ ] 入力値検証が適切に実装されているか
- [ ] SQLインジェクション等の脆弱性がないか
- [ ] 機密情報の適切な取り扱い
- [ ] 認証・認可処理の確認

##### C. テスト品質
- [ ] 正常系・異常系テストが十分か
- [ ] テストカバレッジが適切か
- [ ] テストデータが現実的か
- [ ] テストコードの可読性が良いか

##### D. 保守性
- [ ] コードが理解しやすいか
- [ ] 責務が適切に分離されているか
- [ ] 将来の拡張を考慮した設計か
- [ ] ドキュメント・コメントが適切か

## 実装完了時の出力要件

実装完了時は以下の形式で報告してください：

```markdown
# 実装完了報告

## 基本情報
- **タスク**: [実装したタスクの概要]
- **技術スタック**: [使用した技術スタック]
- **実装ファイル**: [作成・更新したファイル一覧]

## 実装内容
### 主要機能
- [実装した主要機能の説明]

### 追加・変更ファイル
- `path/to/file.kt`: [ファイルの役割と主要な変更内容]
- `path/to/test.kt`: [テストファイルの内容]

## 品質保証結果
### コンパイル確認
- **バックエンド**: ✅ エラーなし / ❌ エラーあり
- **フロントエンド**: ✅ エラーなし / ❌ エラーあり
- **ビルド**: ✅ 成功 / ❌ 失敗

### テスト実行結果
- **実行コマンド**: [使用したテストコマンド]
- **結果**: ✅ 全テストPASS / ❌ 失敗あり
- **カバレッジ**: [テストカバレッジ情報]

### ガイドライン遵守確認
- **基本実装ガイドライン**: ✅ 遵守
- **Kotlinイディオム**: ✅ 遵守
- **日本語ルール**: ✅ 遵守
- **セキュリティ要件**: ✅ 遵守

## 特記事項
- [実装時の注意点や制約事項があれば記載]
- [今後の拡張の可能性や改善点があれば記載]
```

## 追加要件

### エラー発生時の対応
1. コンパイルエラーやテスト失敗が発生した場合は、必ず修正してから完了報告する
2. エラー内容と修正方法を詳細に報告する
3. 解決できない問題がある場合は、調査結果と推定原因を報告する

### ナレッジの追記
実装完了後、以下の場合はナレッジファイルに追記してください：
1. 新しい実装パターンや手法を発見した場合
2. ガイドラインにない特殊ケースを実装した場合
3. 実装時に有用な知見を得た場合

### コミット作成
実装完了後、ユーザーから明示的に指示された場合のみコミットを作成してください。