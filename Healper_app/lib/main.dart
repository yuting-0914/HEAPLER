import 'dart:io';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:firebase_database/firebase_database.dart';
import 'package:project/notification_controller.dart'; // 確保 notification_controller.dart 存在並正確引入
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'dart:async';
import 'package:google_maps_flutter_android/google_maps_flutter_android.dart';
import 'package:google_maps_flutter_platform_interface/google_maps_flutter_platform_interface.dart';
void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  // 初始化 Firebase
  Platform.isAndroid
      ? await Firebase.initializeApp(
      options: FirebaseOptions(
        apiKey: "AIzaSyDAdJsgmpxoRN4aqg5vwEyliA6Zi5PBH3w",
        appId: "1:1022974399912:web:c37050b0029174b655b99d",
        messagingSenderId: "1022974399912",
        projectId: "gps-traker-4de59",
        storageBucket: "gps-traker-4de59.appspot.com",
      ))
      : await Firebase.initializeApp();
  await LocalNotifications.init();// 初始化本地通知
  final GoogleMapsFlutterPlatform mapsImplementation =
      GoogleMapsFlutterPlatform.instance;
  if (mapsImplementation is GoogleMapsFlutterAndroid) {
    // 強制使用 Hybrid Composition 模式
    mapsImplementation.useAndroidViewSurface = true;
  }

  runApp(MyApp());
}

class MyApp extends StatefulWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  State<MyApp> createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'HEALPER',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: const HomeScreen(),
    );
  }
}

class HomeScreen extends StatelessWidget {
  const HomeScreen({Key? key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            height: MediaQuery.of(context).size.height * 0.15,
            alignment: Alignment.center,
            child: Text(
              'HEALPER',
              style: TextStyle(
                fontSize: 32,
                color: Colors.blue[700],
              ),
            ),
          ),
          const SizedBox(height: 30),
          Container(),
          const SizedBox(height: 30),
          const SizedBox(height: 10),
          ElevatedButton(
            onPressed: () {
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => const UserLogin()),
              );
            },
            child: const Text('用戶登入'),
          ),
        ],
      ),
    );
  }
}

class UserLogin extends StatelessWidget {
  const UserLogin({Key? key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('User Login')),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              width: 200,
              height: 50,
              decoration: BoxDecoration(
                border: Border.all(color: Colors.black),
                borderRadius: BorderRadius.circular(10),
              ),
              child: TextField(
                decoration: InputDecoration(
                  border: InputBorder.none,
                  hintText: '身分證字號',
                  hintStyle: TextStyle(color: Colors.grey),
                  contentPadding: const EdgeInsets.symmetric(horizontal: 10),
                ),
              ),
            ),
            const SizedBox(height: 20),
            Container(
              width: 200,
              height: 50,
              decoration: BoxDecoration(
                border: Border.all(color: Colors.black),
                borderRadius: BorderRadius.circular(10),
              ),
              child: TextField(
                decoration: InputDecoration(
                  border: InputBorder.none,
                  hintText: '健保卡號',
                  hintStyle: TextStyle(color: Colors.grey),
                  contentPadding: const EdgeInsets.symmetric(horizontal: 10),
                ),
              ),
            ),
            const SizedBox(height: 20),
            SizedBox(
              width: 150,
              height: 40,
              child: ClipRRect(
                borderRadius: BorderRadius.circular(5),
                child: TextButton(
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const UserPage()),
                    );
                  },
                  style: TextButton.styleFrom(
                    backgroundColor: Colors.blue,
                  ),
                  child: const Text(
                    '登入',
                    style: TextStyle(color: Colors.white),
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class UserPage extends StatefulWidget {
  const UserPage({Key? key}) : super(key: key);

  @override
  _UserPageState createState() => _UserPageState();
}

class _UserPageState extends State<UserPage> {
  DatabaseReference databaseReference = FirebaseDatabase.instance.reference();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('測量數據'),
      ),
      body: Container(
        padding: const EdgeInsets.all(20.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            const Text(
              'HEALPER',
              style: TextStyle(
                fontSize: 24.0,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 20.0),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                Expanded(
                  child: ElevatedButton(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => UserPage()),
                      );
                    },
                    child: const Text('測量數據'),
                  ),
                ),
                Expanded(
                  child: ElevatedButton(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => SuggestPage()),
                      );
                    },
                    child: const Text('溫馨提醒'),
                  ),
                ),
                Expanded(
                  child: ElevatedButton(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => HistoryPage()),
                      );
                    },
                    child: const Text('歷史數據'),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 20.0),
            Expanded(
              child: StreamBuilder(
                stream: databaseReference.onValue,
                builder: (context, snapshot) {
                  if (snapshot.hasData && snapshot.data!.snapshot.value != null) {
                    var data = snapshot.data!.snapshot.value as Map<dynamic, dynamic>;
                    var condition = data['condition']?.toString() ?? '';
                    var heartRate = data['heart rate']?.toString() ?? '';
                    var spo2 = data['spo2']?.toString() ?? '';
                    var temp = data['temp']?.toString() ?? '';

                    Color conditionColor;
                    if (condition == '請留意您的身體狀況') {
                      conditionColor = Colors.red;
                      LocalNotifications.showSimpleNotification(
                        title: '注意',
                        body: '請留意您的身體狀況',
                        payload: '注意', // 可以选择发送的负载数据
                      );
                    } else if (condition == '狀態正常') {
                      conditionColor = Colors.green;
                    } else if (condition == '狀態良好') {
                      conditionColor = Colors.blue;
                    } else {
                      conditionColor = Colors.black; // 默認色
                    }

                    return GridView.count(
                      crossAxisCount: 2,
                      mainAxisSpacing: 10.0,
                      crossAxisSpacing: 10.0,
                      children: [
                        DataGridItem(
                          title: '心律',
                          value: heartRate,
                          unit: 'bpm',
                        ),
                        DataGridItem(
                          title: '溫度',
                          value: temp,
                          unit: '°C',
                        ),
                        DataGridItem(
                          title: '血氧',
                          value: spo2,
                          unit: '%SpO₂',
                        ),
                        DataGridItem(
                          title: '狀態',
                          value: condition,
                          unit: '',
                          color: conditionColor, // 增加 color 參數傳入 DataGridItem 中
                        ),
                      ],
                    );
                  } else {
                    return const Text('No data available');
                  }
                },
              ),
            ),
            const SizedBox(height: 20.0),
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 20.0, vertical: 10.0),
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(20.0),
                border: Border.all(color: Colors.black),
                color: Colors.blue,
              ),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text(
                    '目前定位',
                    style: TextStyle(fontSize: 18.0, color: Colors.white),
                  ),
                  ElevatedButton(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => MapPage()),
                      );
                    },
                    child: const Text('查看'),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class DataGridItem extends StatelessWidget {
  final String title;
  final String value;
  final String unit;
  final Color? color; // Add color parameter

  const DataGridItem({
    Key? key,
    required this.title,
    required this.value,
    required this.unit,
    this.color, // Use optional parameter
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    Color textColor = color ?? Colors.black; // Use color parameter or default color

    // Check if background color needs to be changed
    Color? backgroundColor;
    if (title == '狀態') {
      if (value == '狀態良好') {
        textColor = Colors.green; // Change text color to green for '狀態良好'
        backgroundColor = Colors.green[50]; // Change background color to light green
      } else if (value == '狀態正常') {
        textColor = Colors.blue; // Change text color to blue for '狀態正常'
        backgroundColor = Colors.blue[50]; // Change background color to light blue
      } else if (value == '請留意您的身體狀況') {
        textColor = Colors.red; // Change text color to red for '請留意您的身體狀況'
        backgroundColor = Colors.red[50]; // Change background color to light red
      }
    } else {
      // Additional condition checks for other titles
      if (title == '溫度') {
        double tempValue = double.tryParse(value) ?? 0.0;
        if (tempValue > 37.5 || tempValue < 35.5) {
          textColor = Colors.red;
          backgroundColor = Colors.red[50]; // Change background color to light red
        }
      } else if (title == '心律') {
        int heartRateValue = int.tryParse(value) ?? 0;
        if (heartRateValue > 120 || heartRateValue < 40) {
          textColor = Colors.red;
          backgroundColor = Colors.red[50]; // Change background color to light red
        }
      } else if (title == '血氧') {
        double spo2Value = double.tryParse(value) ?? 0.0;
        if (spo2Value < 95) {
          textColor = Colors.red;
          backgroundColor = Colors.red[50]; // Change background color to light red
        }
      }
    }

    return Card(
      color: backgroundColor, // Set background color
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(
            title,
            style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
          ),
          const SizedBox(height: 5),
          Text(
            '$value $unit',
            style: TextStyle(fontSize: 16, color: textColor),
          ),
        ],
      ),
    );
  }
}
class SuggestPage extends StatefulWidget {
  const SuggestPage({Key? key}) : super(key: key);

  @override
  _SuggestPageState createState() => _SuggestPageState();
}

class _SuggestPageState extends State<SuggestPage> {
  DatabaseReference databaseReference = FirebaseDatabase.instance.reference();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('溫馨提醒'),
      ),
      body: Container(
        padding: const EdgeInsets.fromLTRB(20.0, 10.0, 20.0, 40.0), // Adjusted top padding to 10.0
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            const Text(
              'HEALPER',
              style: TextStyle(
                fontSize: 24.0,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 20.0),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                Expanded(
                  child: ElevatedButton(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => UserPage()),
                      );
                    },
                    child: const Text('測量數據'),
                  ),
                ),
                Expanded(
                  child: ElevatedButton(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => SuggestPage()),
                      );
                    },
                    child: const Text('溫馨提醒'),
                  ),
                ),
                Expanded(
                  child: ElevatedButton(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => HistoryPage()),
                      );
                    },
                    child: const Text('歷史數據'),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 20.0),
            Expanded(
              child: StreamBuilder(
                stream: databaseReference.onValue,
                builder: (context, snapshot) {
                  if (snapshot.hasData && snapshot.data!.snapshot.value != null) {
                    var data = snapshot.data!.snapshot.value as Map<dynamic, dynamic>;
                    var heartRate = double.parse(data['heart rate']?.toString() ?? '0');
                    var spo2 = double.parse(data['spo2']?.toString() ?? '0');
                    var temp = double.parse(data['temp']?.toString() ?? '0');

                    String suggestionSpo2 = '';
                    String suggestionHeartRate = '';
                    String suggestionTemp = '';

                    if (temp > 37.5) {
                      suggestionTemp = '目前體溫偏高，記得多喝水，保持通風。如果發燒超過39℃，感到呼吸困難或意識不清，請盡快就醫。';
                    } else if (temp < 35.5) {
                      suggestionTemp = '目前體溫偏低，若穿著溼冷衣服請先脫掉，注意動作不要過大。也請盡快移動到溫暖的地方，期間要多補充水分喔！';
                    } else {
                      suggestionTemp = '繼續保持';
                    }

                    if (heartRate > 120) {
                      suggestionHeartRate = '心跳有點快！如果情緒過度激動，或攝入太多咖啡因，可能造成心悸情形。找個陰涼的地方坐下深呼吸休息吧！';
                    } else if (heartRate < 40) {
                      suggestionHeartRate = '心率有點低喔，記得多補充水分！並觀察意識與呼吸型態，如果有暈眩情況應避免過大的姿勢變動。';
                    } else {
                      suggestionHeartRate = '繼續保持';
                    }

                    if (spo2 < 95) {
                      suggestionSpo2 = '血氧偏低，請注意自己的意識與呼吸狀態！檢查是否有呼吸道阻塞情形，可以攝取氧氣與抬高床頭45~60度來減緩情況。';
                    } else {
                      suggestionSpo2 = '繼續保持';
                    }

                    return SingleChildScrollView(
                      child: Column(
                        children: [
                          Container(
                            margin: const EdgeInsets.symmetric(vertical: 10.0),
                            padding: const EdgeInsets.all(15.0),
                            width: 350.0,
                            height: 150.0,
                            decoration: BoxDecoration(
                              color: Colors.grey[50], // Lighter background color
                              borderRadius: BorderRadius.circular(20.0), // Rounded corners
                              border: Border.all(color: Colors.grey[600]!), // Darker border color
                            ),
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Text(
                                  '溫度',
                                  style: TextStyle(
                                    fontSize: 18,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                SizedBox(height: 10),
                                Text(
                                  suggestionTemp.isNotEmpty ? suggestionTemp : 'No suggestion',
                                  style: TextStyle(fontSize: 16),
                                ),
                              ],
                            ),
                          ),
                          SizedBox(height: 10.0),
                          Container(
                            margin: const EdgeInsets.symmetric(vertical: 10.0),
                            padding: const EdgeInsets.all(15.0),
                            width: 350.0,
                            height: 150.0,
                            decoration: BoxDecoration(
                              color: Colors.grey[50], // Lighter background color
                              borderRadius: BorderRadius.circular(20.0), // Rounded corners
                              border: Border.all(color: Colors.grey[600]!), // Darker border color
                            ),
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Text(
                                  '心律',
                                  style: TextStyle(
                                    fontSize: 18,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                SizedBox(height: 10),
                                Text(
                                  suggestionHeartRate.isNotEmpty ? suggestionHeartRate : 'No suggestion',
                                  style: TextStyle(fontSize: 16),
                                ),
                              ],
                            ),
                          ),
                          SizedBox(height: 10.0),
                          Container(
                            margin: const EdgeInsets.symmetric(vertical: 10.0),
                            padding: const EdgeInsets.all(15.0),
                            width: 350.0,
                            height: 150.0,
                            decoration: BoxDecoration(
                              color: Colors.grey[50], // Lighter background color
                              borderRadius: BorderRadius.circular(20.0), // Rounded corners
                              border: Border.all(color: Colors.grey[600]!), // Darker border color
                            ),
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Text(
                                  '血氧',
                                  style: TextStyle(
                                    fontSize: 18,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                SizedBox(height: 10),
                                Text(
                                  suggestionSpo2.isNotEmpty ? suggestionSpo2 : 'No suggestion',
                                  style: TextStyle(fontSize: 16),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    );
                  } else {
                    return const Text('No data available');
                  }
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class MapPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('目前定位'),
      ),
      body: Center(
        child: Image.asset('assets/images/your_image.png'), // 替换为你的图片路径
      ),
    );
  }
}
class HistoryPage extends StatefulWidget {
  const HistoryPage({Key? key}) : super(key: key);

  @override
  _HistoryPageState createState() => _HistoryPageState();
}

class _HistoryPageState extends State<HistoryPage> {
  DatabaseReference databaseReference = FirebaseDatabase.instance.reference();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('歷史數據'),
      ),
      body: SingleChildScrollView(
        child: Container(
          padding: const EdgeInsets.all(20.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              const Text(
                'HEALPER',
                style: TextStyle(
                  fontSize: 24.0,
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(height: 20.0),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: [
                  Expanded(
                    child: ElevatedButton(
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(builder: (context) => UserPage()),
                        );
                      },
                      child: const Text('測量數據'),
                    ),
                  ),
                  Expanded(
                    child: ElevatedButton(
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(builder: (context) => SuggestPage()),
                        );
                      },
                      child: const Text('溫馨提醒'),
                    ),
                  ),
                  Expanded(
                    child: ElevatedButton(
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(builder: (context) => HistoryPage()),
                        );
                      },
                      child: const Text('歷史數據'),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 20.0), // Add space between buttons and images
              Row(
                children: [
                  Expanded(
                    child: InteractiveViewer(
                      boundaryMargin: const EdgeInsets.all(20.0), // Margin around the image
                      minScale: 0.5, // Minimum scale allowed
                      maxScale: 2.0, // Maximum scale allowed
                      child: Image.asset(
                        'assets/images/heartrate.png',
                        fit: BoxFit.fitWidth, // Adjust image width to fit the screen
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 20.0), // Add space between images
              Row(
                children: [
                  Expanded(
                    child: InteractiveViewer(
                      boundaryMargin: const EdgeInsets.all(20.0), // Margin around the image
                      minScale: 0.5, // Minimum scale allowed
                      maxScale: 2.0, // Maximum scale allowed
                      child: Image.asset(
                        'assets/images/spo2.png',
                        fit: BoxFit.fitWidth, // Adjust image width to fit the screen
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 20.0), // Add space between images
              Row(
                children: [
                  Expanded(
                    child: InteractiveViewer(
                      boundaryMargin: const EdgeInsets.all(20.0), // Margin around the image
                      minScale: 0.5, // Minimum scale allowed
                      maxScale: 2.0, // Maximum scale allowed
                      child: Image.asset(
                        'assets/images/temp.png',
                        fit: BoxFit.fitWidth, // Adjust image width to fit the screen
                      ),
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}