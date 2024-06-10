這裡只標需要改動的

project/
├── android                     
│   ├── app              
│   │   └── src
│   │       └── main
│   │           └── AndroidManifest.xml
│   │       ├── build.gradle 
│   │       ├── google-services.json                   
│   └── build.gradle             
├── assets                                           
│   ├── images                   
│   │   ├── heartrate.png
│   │   ├── spo2.png
│   │   ├── temp.png
│   │   ├── your_image.png              
├── lib                        
│   ├── firebase_options.dart                
│   ├── main.dart
│   ├── notification_controller.dart      
└── pubspec.yaml
android 環境建設:
    因每一版SDK的環境建置不一定相同，因此不特別說明
    flutter_local_notifications: https://pub.dev/packages/flutter_local_notifications
    firebase相關:https://www.youtube.com/watch?v=YVB94s21jD8&t=167s&pp=ygUQZmx1dHRlciBmaXJlYmFzZQ%3D%3D
圖片增設:
    在pubspec.yaml中加入  
    assets:
    - assets/images/your_image.png
    - assets/images/heartrate.png
    - assets/images/spo2.png
    - assets/images/temp.png
SDK下載:
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
