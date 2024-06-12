
# -*-coding:utf-8-*-

import max30102
import time
import smbus

bus = smbus.SMBus(1)
time.sleep(1)

m = max30102.MAX30102()

red, ir = m.read_sequential(1000)

with open("red.log", "w") as f:
    for r in red:
        f.write("{0}\n".format(r))
with open("ir.log", "w") as f:
    for r in ir:
        f.write("{0}\n".format(r))

m.shutdown()
