
# MyFinance - Personal Finance Manager (Demo)

## ✅ 功能簡介
- 使用者登入/註冊
- 新增收入與支出
- 類別分類與搜尋
- 圖表顯示（靜態/動態）

## 🛠 安裝步驟（Raspberry Pi）

1. 安裝套件
```bash
sudo apt update
sudo apt install apache2 php mariadb-server php-mysql unzip
```

2. 匯入資料表與測試資料
```bash
sudo mysql -u root -p < init.sql
```

3. 將專案放到伺服器目錄
```bash
sudo cp -r MyFinance_With_PHP /var/www/html/myfinance
```

4. 訪問網站
- 在瀏覽器輸入 `http://<IP>/myfinance/pages/login.html`

## 🔐 測試帳號
- Email: `test@example.com`
- 密碼: `123456`

## 📌 注意事項
- `config.php` 中請修改為你實際的 root 密碼
- `save_transaction.php` 需要傳入 category 的 ID（請從資料庫中查）
