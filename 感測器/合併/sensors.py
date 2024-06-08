import RPi.GPIO as GPIO
import dht11
import time
import datetime
import max30102
import hrcalc
import pyrebase
import serial
import string
import pynmea2

# Initialize GPIO
GPIO.setwarnings(True)
GPIO.setmode(GPIO.BOARD)

m = max30102.MAX30102()

# Initialize DHT11 sensor
instance = dht11.DHT11(pin=11)

# Firebase configuration
firebaseConfig = {
    "apiKey": "YOUR_API_KEY",
    "authDomain": "YOUR_AUTH_DOMAIN",
    "databaseURL": "YOUR_DATABASE_URL",
    "projectId": "YOUR_PROJECT_ID",
    "storageBucket": "YOUR_STORAGE_BUCKET",
    "messagingSenderId": "YOUR_MESSAGING_SENDER_ID",
    "appId": "YOUR_APP_ID"
}

firebase = pyrebase.initialize_app(firebaseConfig)
db = firebase.database()

port = "/dev/ttyAMA0"
ser = serial.Serial(port, baudrate=9600, timeout=0.5)

def read_gps_data():
    while True:
        newdata = ser.readline()
        if newdata.startswith(b"$GPRMC"):
            newmsg = pynmea2.parse(newdata.decode('utf-8'))
            lat = newmsg.latitude
            lng = newmsg.longitude
            current_time = time.strftime('%Y-%m-%d %H:%M:%S')
            time.sleep(5)  # Adjust this delay as needed

def insert_to_firebase():
    try:
        while True:
            # Read data from DHT11 sensor
            result = instance.read()
            if result.is_valid():
                current_time = time.strftime('%Y-%m-%d %H:%M:%S')
                result.temperature = result.temperature + 2
                print(current_time, "Temperature: %-3.1f C" % result.temperature)
                if result.temperature > 33:
                    fb_data3 = {"temp": result.temperature}
                    db.update(fb_data3)
                    #print("temp data sent")

            # Read data from MAX30102 sensor
            red, ir = m.read_sequential()
            hr, hrb, sp, spb = hrcalc.calc_hr_and_spo2(ir, red)
            current_time = time.strftime('%Y-%m-%d %H:%M:%S')

            # Insert data into Firebase
            if hrb and hr != -999:
                hr2 = int(hr)
                print(current_time, " Heart Rate:", hr2)
                if hr2 < 200:
                    fb_data = {"heart rate": hr2}
                    db.update(fb_data)

            if spb and sp != -999:
                sp2 = int(sp)
                print(current_time, "       SPO2:", sp2)
                if sp2 > 80:
                    fb_data2 = {"spo2": sp2}
                    db.update(fb_data2)

            time.sleep(5)

    except KeyboardInterrupt:
        quit()

if __name__ == '__main__':
    try:
        # Start a new thread for reading GPS data continuously
        import threading
        gps_thread = threading.Thread(target=read_gps_data)
        gps_thread.start()

        # Start inserting other sensor data to Firebase
        insert_to_firebase()
        
    except KeyboardInterrupt:
        quit()

