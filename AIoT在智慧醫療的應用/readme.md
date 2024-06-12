# AIot在智慧醫療的應用

## 專案簡介
使用多種感測器，包括 GPS 感測器、MAX30102 心率血氧感測器和 DHT11 溫濕度感測器並通過 Raspberry Pi 獲取感測數據，再經由網頁及app將數據呈現。

## 目錄結構
```plaintext
AIoT在智慧醫療的應用/
├── README.md                               # 專案總體說明文件
|
├── sensors/
│   ├── all
│   │   └── sensors.py                      # 合併三個感測器之程式
│   ├── gps/
│   │   └── Python-NEO-6M-GPS-Raspberry-Pi-master/
│   │       ├── gps_sensor.py               # GPS 感測器主程式
│   │       ├── gpsdData.py                 # GPS 數據處理
│   │       ├── Neo6mGPS.py                 # GPS 感測器操作
│   │       └── readme.md                   # GPS 感測器說明文件
│   ├── hr_spo2/
│   │   └── max30102-tutorial-raspberrypi-master/
│   │       ├── hrcalc.py                   # 心率計算
│   │       ├── hrdump.py                   # 心率數據轉儲
│   │       ├── makegraph.py                # 生成圖表
│   │       ├── max30102.py                 # MAX30102 感測器操作
│   │       ├── testMAX30102.py             # 測試 MAX30102 感測器
│   │       └── README.md                   # MAX30102 感測器說明文件
│   ├── temperature/
│   │   ├── __init__.py                     # DHT11 初始化
│   │   ├── dht11.py                        # DHT11 感測器操作
│   │   ├── dht11.pyc                       # DHT11 感測器操作的編譯版本
│   │   └── dht11_example.py                # DHT11 感測器範例
|
├── ai_condition/
|   ├── AI_condition.ipynb                  # AI判斷模型
|   ├── dataset.xls                         # 資料集
│   └── README.md                           # AI判斷 說明文件
|
├── Healper_graph/
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
|
├── Healper_app/
│   ├── pubspec.yaml                        # Dart專案配置檔案
│   ├── android
│   │   ├── build.gradle                    #因建設環境而需改動的檔                     
│   │   ├── app              
│   │   │   └── src
│   │   │       └── main
│   │   │           └── AndroidManifest.xml #因建設環境而需改動的檔             
│   │   └── google-services.json            #因建設環境而需新增的檔                   
│         
│   ├── assets/
│   │   └── images/
│   │       ├── heartrate.png               # 顯示在app內的心率圖像
│   │       ├── spo2.png                    # 顯示在app內的血氧圖像
│   │       ├── temp.png                    # 顯示在app內的體溫圖像
│   │       └── your_image.png              # 顯示在app內的個人圖像
│   ├── lib/
│   │   ├── firebase_options.dart           # Firebase建設完成自動生成的檔
│   │   ├── main.dart                       # app的主程式
│   │   └── notification_controller.dart    # 通知設定檔

```

# 第三方來源註明
本專案使用了以下第三方資源：
* GPS 感測器程式碼： [Use NEO-6M Module with Raspberry Pi](https://sparklers-the-makers.github.io/blog/robotics/use-neo-6m-module-with-raspberry-pi/)，並遵循其使用條款。

* MAX30102 感測器程式碼：[max30102-tutorial-raspberrypi](https://github.com/vrano714/max30102-tutorial-raspberrypi)，並遵循其使用條款。

* AI_condition 程式碼：[Health-Monitoring-system-by-using-Machine-Learning](https://github.com/Ramyadeveloper59/Health-Monitoring-system-by-using-Machine-Learning)，並遵循其使用條款。
# 實驗步驟

## 1. 硬體連接
### 以下皆為連接Raspberry Pi 4 之 gpio 腳位標示
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

* android app 撰寫之環境架設及注意事項
    * 由於每一版的SDK環境架設不一定相同，因此不特別做說明。以下附上參考網站：
        * [flutter_local_notifications](https://pub.dev/packages/flutter_local_notifications)
        * [Setting up Firebase for Flutter (Connecting Android, iOS, and Web)](https://www.youtube.com/watch?v=YVB94s21jD8&t=167s)
    * 圖片增設  
    在 pubspec.yaml中加入下列程式碼以後，圖片才能被放入app中 
    ```
    assets/image/image_file_name
    ```
    * SDK下載  
    在 pubspec.yaml 中加入下列程式碼即可下載 SDK
    ```
        dependencies:
    flutter:
        sdk: flutter
    firebase_core: ^2.14.0
    firebase_database: ^10.5.0
    cloud_firestore: ^4.16.0
    flutter_local_notifications: ^17.0.0
    rxdart: ^0.27.7
    flutter_timezone: ^1.0.8
    google_maps_flutter: ^2.6.1
    oscilloscope: ^0.2.0+1
    flutter_charts: ^0.5.2
    fl_chart: ^0.67.0
    ```  

## 3. 可能遇到的問題
### NEO6mGPS（請搭配感測器之readme看）
* NEO6mGPS模組通常在室內找不到訊號。若感測器一直不'blink'，代表感測器找不到訊號。可以先去室外完全沒有遮蔽物的地方測試感測器本身有無損壞。若無損壞可考慮買外接天線，使NEO6mGPS在室內也可以正常抓取訊號。
* 將感測器偵測到的經緯度訊號以 google map 形式顯示於網頁上之教學請參考：[DIY GPS Tracker using Raspberry pi & Neo 6M GPS Module with Javascript, firebase & Google Map API](https://www.youtube.com/watch?v=l4QnAPgiD5Q&t=1185s) 