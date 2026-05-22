# eclo-mg

複数の WordPress サイトを Git 経由で管理するためのリポジトリです。

各サイトはルート直下にサイト名ディレクトリを作り、その中で Local の WordPress 構成を保ちます。

```text
eclo-mg/
  avant-p/
    app/public/wp-content/themes/avan-p/
    scripts/deploy-theme.sh
    README.md
```

## 管理方針

- Git に入れるのは自作テーマや自作プラグインなどのプロジェクトコードだけ
- WordPress 本体、`wp-config.php`、`uploads/`、バックアップ、外部プラグインは Git に入れない
- データベースとメディアの初回移行は All-in-One WP Migration などで別管理する
- 本番反映は各サイト配下の `scripts/deploy-theme.sh` でテーマだけ同期する

## サイト追加手順

```bash
mkdir new-site
```

既存サイトを追加する場合は、`new-site/app/public/wp-content/themes/<theme-name>/` に自作テーマを置き、`new-site/.gitignore` で WordPress 本体や生成物を除外します。

## 現在のサイト

- `avant-p/`
