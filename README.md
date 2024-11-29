# Laravel 11 Filament 旅館預訂

Filament 旅館預訂採用快速建立簡捷的 TALL（Tailwind CSS、Alpine.js、Laravel 和 Livewire）堆疊應用程式的工具組，立即確認旅館尚有房間，幫助旅館旅遊業提升轉換率，增加業績。

## 使用方式
- 打開 php.ini 檔案，啟用 PHP 擴充模組 intl 和 zip，並重啟服務器。
- 把整個專案複製一份到你的電腦裡，這裡指的「內容」不是只有檔案，而是指所有整個專案的歷史紀錄、分支、標籤等內容都會複製一份下來。
```sh
$ git clone
```
- 將 __.env.example__ 檔案重新命名成 __.env__，如果應用程式金鑰沒有被設定的話，你的使用者 sessions 和其他加密的資料都是不安全的！
- 當你的專案中已經有 composer.lock，可以直接執行指令以讓 Composer 安裝 composer.lock 中指定的套件及版本。
```sh
$ composer install
```
- 產生 Laravel 要使用的一組 32 字元長度的隨機字串 APP_KEY 並存在 .env 內。
```sh
$ php artisan key:generate
```
- 執行 __Artisan__ 指令的 __migrate__ 來執行所有未完成的遷移，並執行資料庫填充（如果要測試的話）。
```sh
$ php artisan migrate --seed
```
- 在瀏覽器中輸入已定義的路由 URL 來訪問，例如：http://127.0.0.1:8000。
- 你可以經由 `/hotel/login` 來進行旅館合作夥伴登入，預設的電子郵件和密碼分別為 __hotel@admin.com__ 和 __password__ 。
- 你可以經由 `/booking/login` 來進行客戶登入，預設的電子郵件和密碼分別為 __booking@admin.com__ 和 __password__ 。

----

## 畫面截圖
![](https://i.imgur.com/tl05K19.png)
> 合作夥伴刊登旅館，快速開始創造更多收入

![](https://i.imgur.com/L2ptBUl.png)
> 客戶選擇入住的開始和結束日期來預訂
