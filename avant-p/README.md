# avant-p WordPress Git Deploy

このディレクトリは、Local で管理している WordPress のうち、Git デプロイ対象になる自作テーマだけを管理します。

Git のルートは `Local Sites` ディレクトリです。このサイトは `eclo-mg` リポジトリ内の `avant-p/` として管理されます。

## Git 管理するもの

- `app/public/wp-content/themes/avan-p/`
- デプロイ補助スクリプト
- この README

## FSE とトップページ

このテーマは FSE / ブロックテーマ構成です。

- `theme.json`
- `parts/header.html`
- `parts/footer.html`
- `templates/front-page.html`
- `templates/page-home.html`
- `templates/page.html`
- `templates/index.html`

トップページは固定ページ `home` の本文を表示します。WordPress 管理画面で以下を設定してください。

1. 固定ページ `home` を作成する
2. 表示設定で「ホームページの表示」を「固定ページ」にする
3. ホームページに `home` を選ぶ

テーマ有効化後、slug が `home` の固定ページがあり、まだホームページが未設定であれば自動で `home` をホームページに設定します。

`home` の本文が空の場合は、`patterns/home.php` の内容を一度だけ自動投入します。以後のTOPコンテンツは固定ページ `home` の本文として管理します。

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

## 自動デプロイ

`main` ブランチに `avant-p/app/public/wp-content/themes/avan-p/` の変更が push されると、GitHub Actions が本番サーバーへテーマだけを自動同期します。

GitHub の `obake314/eclo-mg` リポジトリで、以下の Secrets を設定してください。

```text
AVANT_P_SSH_HOST   本番サーバーのホスト名
AVANT_P_SSH_USER   SSH ユーザー名
AVANT_P_SSH_KEY    デプロイ用秘密鍵
AVANT_P_WP_ROOT    本番 WordPress のルートパス
AVANT_P_SSH_PORT   SSH ポート。省略時は 22
```

同期先:

```text
$AVANT_P_WP_ROOT/wp-content/themes/avan-p/
```

## 手動デプロイ

本番サーバー上で `eclo-mg` リポジトリを clone して、`avant-p/scripts/deploy-theme.sh` を実行する方法も使えます。

例:

```bash
cd /home/USER/repos/eclo-mg
git pull --ff-only origin main
cd avant-p
WP_ROOT=/home/USER/public_html ./scripts/deploy-theme.sh
```

`WP_ROOT` は本番 WordPress のルートディレクトリです。スクリプトは `avan-p` テーマだけを `wp-content/themes/avan-p/` に同期します。

通常は GitHub Actions の自動デプロイを使い、サーバー内で直接反映したい時だけこの手順を使います。

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
