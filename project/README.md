這裡只標需要改動的

project/

├── android                     
│   ├── app              
│   │   └── src
│   │       └── main
│   │           └── AndroidManifest.xml    #因建設環境而需改動的檔
│   │       ├── build.gradle    #因建設環境而需改動的檔             
│   │       ├── google-services.json    #因建設環境而需新增的檔                   
│   └── build.gradle    #因建設環境而需改動的檔             
├── assets                                           
│   ├── images                   
│   │   ├── heartrate.png    #APP裡的圖片
│   │   ├── spo2.png    #APP裡的圖片
│   │   ├── temp.png    #APP裡的圖片
│   │   ├── your_image.png    #APP裡的圖片              
├── lib                        
│   ├── firebase_options.dart    #firebase建設完自動生成的檔               
│   ├── main.dart    #APP的程式碼
│   ├── notification_controller.dart    #通知設定檔      
└── pubspec.yaml    #配置文件
android 環境建設:
    因每一版SDK的環境建置不一定相同，因此不特別說明，以下是我參考的網站
    flutter_local_notifications: https://pub.dev/packages/flutter_local_notifications
    firebase相關:https://www.youtube.com/watch?v=YVB94s21jD8&t=167s&pp=ygUQZmx1dHRlciBmaXJlYmFzZQ%3D%3D
圖片增設:
    在pubspec.yaml中加入下列程式碼以後，圖片才能被放入APP中  
    assets:
    - assets/images/your_image.png
    - assets/images/heartrate.png
    - assets/images/spo2.png
    - assets/images/temp.png
SDK下載:
  在pubspec.yaml中加入下列程式碼以後，SDK會被下載
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
