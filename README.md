# eclo-mg

`Local Sites` ディレクトリの中で、eclo-mg 管理対象の WordPress サイトだけを Git 管理します。

このリポジトリは `Local Sites` 全体を作業ツリーにしますが、すべての Local サイトを管理するわけではありません。管理対象にするサイトだけを `.gitignore` で明示的に許可します。

## 管理方針

- Git に入れるのは自作テーマや自作プラグインなどのプロジェクトコードだけ
- WordPress 本体、`wp-config.php`、`uploads/`、バックアップ、外部プラグインは Git に入れない
- データベースとメディアの初回移行は All-in-One WP Migration などで別管理する
- 本番反映は各サイト配下の `scripts/deploy-theme.sh` でテーマだけ同期する

## 現在の管理対象

- `avant-p/`

## ディレクトリ構成

```text
Local Sites/
  avant-p/
    app/public/wp-content/themes/avan-p/
    scripts/deploy-theme.sh
    README.md
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
git add README.md .gitignore avant-p/app/public/wp-content/themes/avan-p
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
