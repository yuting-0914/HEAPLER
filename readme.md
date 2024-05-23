# AIot在智慧醫療的應用

## 專案簡介
使用多種感測器，包括 GPS 感測器、MAX30102 心率血氧感測器和 DHT11 溫濕度感測器並通過 Raspberry Pi 獲取感測數據，再經由網頁及app將數據呈現。

## 目錄結構
```plaintext
AIoT在智慧醫療的應用/
├── README.md                               # 專案總體說明文件
├── 感測器/
│   ├── all
│   │   ├── sensors.py                      # 合併三個感測器之程式
│   │   └── readme.md                       # 感測器合併程式碼說明文件
│   ├── gps/
│   │   └── Python-NEO-6M-GPS-Raspberry-Pi-master/
│   │       ├── gps_sensor.py               # GPS 感測器主
│   │       ├── gpsdData.py                 # GPS 數據處理
│   │       ├── Neo6mGPS.py                 # GPS 操作
│   │       └── readme.md                   # GPS 感測器說明文件
│   ├── max30102/
│   │   └── max30102-tutorial-raspberrypi-master/
│   │       ├── hrcalc.py                   # 心率計算
│   │       ├── hrdump.py                   # 心率數據轉儲
│   │       ├── makegraph.py                # 生成圖表
│   │       ├── max30102.py                 # MAX30102 感測器操作
│   │       ├── testMAX30102.py             # 測試 MAX30102 感測器
│   │       └── README.md                   # MAX30102 感測器說明文件
│   ├── dht11/
│   │   ├── __init__.py                     # DHT11 初始化
│   │   ├── dht11.py                        # DHT11 感測器操作
│   │   ├── dht11.pyc                       # DHT11 感測器操作的編譯版本
│   │   └── dht11_example.py                # DHT11 感測器範例
│
├── 網頁/
│   ├── all                     
│   │   ├── db_connect.php                  # 資料庫連接
│   │   ├── style.css                       # 主樣式表
│   │   └── search.png              
│   ├── user                                # 一般使用者                
│   │   ├── home.html                       # 登入頁面
│   │   │   └── login.php                   # 經由資料庫識別帳號密碼，做登入確認
│   │   ├── current.php                     # 監聽firebase，印出即時數據
│   │   │   ├── healthStatus.js             # 獲取firebase判斷之狀況，以控制異常標紅及狀態框變色
│   │   │   └── advice.js                   # 判斷各項目狀態高低
│   │   │       └── get_advice.php          # 連接資料庫之衛教建議資料表，於狀態框印出溫馨提醒
│   │   ├── today.php                       # 將資料庫數據以折線圖方式呈現當日平均
│   │   ├── history.php                     # 將資料庫數據以折線圖方式呈現歷史平均
│   │   └── information.php                 # 資料庫內使用者資料
│   │       └── information_update.php      # 修改資料
│   └── medical                             # 醫療院方
│       ├── m-home.html                     # 登入頁面
│       │   └── m-login.php                 # 判斷是否為初登入
│       │       ├── change_pwd.php          # 初登入更改密碼
│       │       └── update_pwd.php          # 更新資料庫內密碼
│       └── search.php                      # 透過資料庫比對，查詢對應患者數據
│           ├── m-current.php               # 該患者即時數據
│           ├── m-today.php                 # 該患者當日平均數據
│           ├── m-history.php               # 該患者歷史數據
│           └── m-information.php           # 該患者基本資料

```

# 實驗步驟

## 1. 硬體連接
**以下皆為連接Raspberry Pi 4 之 gpio 腳位標示**
* DHT11：
    * vcc - 1/2
    * gnd - 6/9
    * data - 11
* MAX30102：
    * vin - 1/2 
    * sda - 3 
    * scl - 5 
    * gnd - 6/9
* Neo6mGPS：
    * vcc - 2
    * gnd - 6
    * txd - 10
    * rxd - 8


## 2. 軟體配置
``` 
pip3 install ***
```
* 以上述程式碼下載下列套件（將***換成套件名稱）
    * RPi.GPIO
    * dht11
    * Adafruit_DHT
    * pyrebase4
    * pyserial
    * pynmea2


* 網頁必須以下列兩種方式開啟才能顯示即時數據
    1. 以 localhost 開啟
    2. 在 vscode 的 extensions 中下載 live server。完完成後點右下方的 "Go Live" 即可。


## 3. 可能遇到的問題
### NEO6mGPS（請搭配感測器之readme看）
* NEO6mGPS模組通常在室內找不到訊號。若感測器一直不'blink'，代表感測器找不到訊號。可以先去室外完全沒有遮蔽物的地方測試感測器本身有無損壞。若無損壞可考慮買外接天線，使NEO6mGPS在室內也可以正常抓取訊號。
* 將感測器偵測到的經緯度訊號以 google map 形式顯示於網頁上之教學請參考：[DIY GPS Tracker using Raspberry pi & Neo 6M GPS Module with Javascript, firebase & Google Map API](https://www.youtube.com/watch?v=l4QnAPgiD5Q&t=1185s) 
