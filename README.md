Network Path Test
Imagine that there is a small network with a number of interconnected devices. Each connection has
a latency parameter which is expressed in milliseconds. Your task is to write a program that will
determine whether a signal can travel between two devices in a given amount of time or less.
Implementation Guidelines:
1. The program should be executable from command line and accept one parameter - csv file path.
2. CSV file structure:
Format: Device From, Device To, Latency (milliseconds)
Contents:
A,B,10
A,C,20
B,D,100
C,D,30
D,E,10
E,F,1000

To run the script, in windows CMD or powershell, php networkpath.php values.csv
When prompted to enter the values, do so as instructed, then press enter.

I was able to get it somewhat working, but errors do occur. I had to source some code, and see what could work.
