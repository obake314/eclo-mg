# avant-p WordPress Git Deploy

このディレクトリは、Local で管理している WordPress のうち、Git デプロイ対象になる自作テーマだけを管理します。

Git のルートは `Local Sites` ディレクトリです。このサイトは `eclo-mg` リポジトリ内の `avant-p/` として管理されます。

## Git 管理するもの

- `app/public/wp-content/themes/avan-p/`
- デプロイ補助スクリプト
- この README

## Git 管理しないもの

- WordPress 本体
- `wp-config.php`
- Local の `conf/` と `logs/`
- `uploads/`
- All-in-One WP Migration の `.wpress` バックアップ
- 外部テーマ、外部プラグイン、翻訳ファイル、キャッシュ

## コミット例

```bash
cd "/Users/t_okazaki/Local Sites"
git status --short
git add avant-p/app/public/wp-content/themes/avan-p
git commit -m "Update avant-p theme"
git push
```

## 本番サーバーの準備

本番には通常の WordPress をインストールしておきます。

- 本番用の `wp-config.php` を作成する
- 必要なプラグインを本番側でインストール、有効化する
- メディアファイルは Git ではなく WordPress の `uploads/` で管理する
- 必要なら All-in-One WP Migration などで DB とメディアを初回移行する

現在ローカルにある主なプラグイン:

- All-in-One WP Migration
- All-in-One WP Migration Unlimited Extension
- Password Protected
- Snow Monkey Forms
- WP File Manager

`WP File Manager` は運用上のリスクになりやすいので、本番で必要な場合だけ有効化してください。

## Git 経由でテーマをデプロイする

本番サーバーに `eclo-mg` リポジトリを clone して、`avant-p/scripts/deploy-theme.sh` を実行します。

例:

```bash
cd /home/USER/repos/eclo-mg
git pull --ff-only origin main
cd avant-p
WP_ROOT=/home/USER/public_html ./scripts/deploy-theme.sh
```

`WP_ROOT` は本番 WordPress のルートディレクトリです。スクリプトは `avan-p` テーマだけを `wp-content/themes/avan-p/` に同期します。

必要なら本番サーバーの cron や webhook から上記の `git pull` とデプロイコマンドを呼び出せます。

## ローカル作業フロー

```bash
cd "/Users/t_okazaki/Local Sites"
git status --short
git add avant-p/app/public/wp-content/themes/avan-p
git commit -m "Update theme"
git push
```

その後、本番サーバーで:

```bash
cd /home/USER/repos/eclo-mg
git pull --ff-only origin main
cd avant-p
WP_ROOT=/home/USER/public_html ./scripts/deploy-theme.sh
```
