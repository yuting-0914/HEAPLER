```bash
網頁/
├── all                     
│   ├── db_connect.php              # 資料庫連接
│   ├── style.css                   # 主樣式表
│   └── search.png              
├── user                            # 一般使用者                
│   ├── home.html                   # 登入頁面
│   │   └── login.php               # 經由資料庫識別帳號密碼，做登入確認
│   ├── current.php                 # 監聽firebase，印出即時數據
│   │   ├── healthStatus.js         # 獲取firebase判斷之狀況，以控制異常標紅及狀態框變色
│   │   └── advice.js               # 判斷各項目狀態高低
│   │       └── get_advice.php      # 連接資料庫之衛教建議資料表，於狀態框印出溫馨提醒
│   ├── today.php                   # 將資料庫數據以折線圖方式呈現當日平均
│   ├── history.php                 # 將資料庫數據以折線圖方式呈現歷史平均
│   └── information.php             # 資料庫內使用者資料
│       └── information_update.php  # 修改資料
└── medical                         # 醫療院方
    ├── m-home.html                 # 登入頁面
    │   └── m-login.php             # 判斷是否為初登入
    │       ├── change_pwd.php      # 初登入更改密碼
    │       └── update_pwd.php      # 更新資料庫內密碼
    └── search.php                  # 透過資料庫比對，查詢對應患者數據
        ├── m-current.php           # 該患者即時數據
        ├── m-today.php             # 該患者當日平均數據
        ├── m-history.php           # 該患者歷史數據
        └── m-information.php       # 該患者基本資料
 

