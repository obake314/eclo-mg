# eclo-mg

`Local Sites` ディレクトリの中で、eclo-mg 管理対象の WordPress サイトだけを Git 管理します。

このリポジトリは `Local Sites` 全体を作業ツリーにしますが、すべての Local サイトを管理するわけではありません。管理対象にするサイトだけを `.gitignore` で明示的に許可します。

## 管理方針

- Git に入れるのは自作テーマや自作プラグインなどのプロジェクトコードだけ
- WordPress 本体、`wp-config.php`、`uploads/`、バックアップ、外部プラグインは Git に入れない
- データベースとメディアの初回移行は All-in-One WP Migration などで別管理する
- 本番反映は GitHub Actions でサイトごとにテーマだけ同期する

## 現在の管理対象

- `avant-p/`
- `spacenoid/`

## ディレクトリ構成

```text
Local Sites/
  avant-p/
    app/public/wp-content/themes/avan-p/
    README.md
  spacenoid/
    app/public/wp-content/themes/spacenoid/
  admin/        # eclo-mg 管理対象外
  capital/      # eclo-mg 管理対象外
  ...
```

## サイト追加手順

1. `Local Sites` 直下に対象サイトを用意する
2. ルート `.gitignore` でそのサイトディレクトリを unignore する
3. WordPress 本体、`wp-config.php`、`uploads/`、バックアップを ignore する
4. 自作テーマや自作プラグインだけを unignore する

## Git 操作

```bash
cd "/Users/t_okazaki/Local Sites"
git status --short
git add README.md .gitignore .github/workflows avant-p/app/public/wp-content/themes/avan-p
git commit -m "Update avant-p theme"
git push
```

## avant-p の自動デプロイ

`main` ブランチに `avant-p/app/public/wp-content/themes/avan-p/` の変更が push されると、GitHub Actions が本番サーバーへテーマだけを自動同期します。

GitHub の `obake314/eclo-mg` リポジトリで、以下の Secrets を設定してください。

```text
AVANT_P_SSH_HOST   本番サーバーのホスト名
AVANT_P_SSH_USER   SSH ユーザー名
AVANT_P_SSH_KEY    デプロイ用秘密鍵
AVANT_P_WP_ROOT    本番 WordPress のルートパス
AVANT_P_SSH_PORT   SSH ポート。省略時は 22
```

例:

```text
AVANT_P_WP_ROOT=/home/USER/public_html
```

同期先は以下になります。

```text
$AVANT_P_WP_ROOT/wp-content/themes/avan-p/
```

デプロイ用 SSH ユーザーには、このテーマディレクトリへ書き込める権限が必要です。

## avant-p のDBデプロイ

運用開始前の初期投入に限り、ローカルDBを本番DBへ上書き import できます。通常運用開始後は、本番の投稿・問い合わせ・ユーザー情報を消す可能性があるため使わないでください。

DBデプロイは GitHub Actions の自動実行には入れず、ローカルPCから手動で実行します。SQL内のURL置換は `wp search-replace --export` で行うため、シリアライズデータも壊れにくい形で書き出します。

```bash
cd "/Users/t_okazaki/Local Sites/avant-p"

AVANT_P_SSH_HOST="example.xserver.jp" \
AVANT_P_SSH_USER="server-user" \
AVANT_P_SSH_PORT="10022" \
AVANT_P_SSH_KEY_FILE="$HOME/.ssh/avant-p-deploy" \
AVANT_P_WP_ROOT="/home/USER/public_html" \
AVANT_P_PROD_URL="https://example.com" \
CONFIRM_DB_DEPLOY="deploy-avant-p-db" \
./scripts/deploy-db.sh
```

`AVANT_P_SSH_KEY_FILE` の代わりに、秘密鍵本文を `AVANT_P_SSH_KEY` に入れても実行できます。

本番側では import 前に以下へDBバックアップを作成します。

```text
$AVANT_P_WP_ROOT/wp-content/db-backups/pre-db-deploy-YYYYMMDDHHMMSS.sql
```

## spacenoid の自動デプロイ

`main` ブランチに `spacenoid/app/public/wp-content/themes/spacenoid/` の変更が push されると、GitHub Actions が Lolipop サーバーへテーマだけを自動同期します。

GitHub の `obake314/eclo-mg` リポジトリで、以下の Secrets を設定してください。

```text
SPACENOID_SSH_HOST   Lolipop の SSH ホスト名
SPACENOID_SSH_USER   SSH アカウント
SPACENOID_SSH_KEY    デプロイ用秘密鍵
SPACENOID_WP_ROOT    本番 WordPress のルートパス
SPACENOID_SSH_PORT   SSH ポート。省略時は 2222
```

例:

```text
SPACENOID_WP_ROOT=/home/users/0/lolipop.jp-ACCOUNT/web
```

同期先は以下になります。

```text
$SPACENOID_WP_ROOT/wp-content/themes/spacenoid/
```

Lolipop 側で SSH を有効化し、`SPACENOID_SSH_KEY` に対応する公開鍵がサーバー側で許可されている必要があります。デプロイ用 SSH ユーザーには、このテーマディレクトリへ書き込める権限が必要です。
