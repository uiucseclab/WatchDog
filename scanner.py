from __future__ import division
from socket import *
import socket
from time import sleep
import multiprocessing as mp
import operator
import json
import urllib2
import sys
import os
import MySQLdb

db = MySQLdb.connect(host="127.0.0.1",user="watchdog",passwd="watchdogpass",db="watchdog")
cursor = db.cursor()


def check_online(ip):
    response = os.system("ping -c 1 "+ip+" > /dev/null")
    if response == 0:
        return True
    else:
        return False



def scan_port(ip,p,output):
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.settimeout(0.5)
    result = sock.connect_ex((ip, p))
    if result == 0:
        output.put(p)
    else:
        return



def scan_network(base,scan_id):
    for i in range(1,254):
        ip = base+str(i)
        print "Scanning "+ip
        if (check_online(ip)):
            print ip+" is online"
            output = mp.Queue()
            processes = []
            for p in range(0, 1024):
                process = mp.Process(target=scan_port,args=(ip,p,output))
                processes.append(process)
            for p in processes:
                p.start()
            for p in processes:
                p.join()
            open = []
            while not output.empty():
                open.append(output.get())
            print open


            #check if watching this ip
            cursor.execute("SELECT id FROM watching WHERE ip=%s",(ip))
            rows = cursor.fetchall()
            if (len(rows) > 0):
                print "We are watching this ip, getting total ports"
                cursor.execute("SELECT COUNT(ports.id) FROM ports INNER JOIN nodes ON ports.node_id=nodes.id WHERE nodes.id=(SELECT nodes.id as id FROM nodes WHERE ip=%s ORDER BY id DESC LIMIT 1)",(ip))
                rows = cursor.fetchall()
                total_ports = rows[0][0]
                print str(total_ports)+" total ports"

            #add node to database
            cursor.execute("INSERT INTO nodes (scan_id,ip) VALUES (%s,%s)",(scan_id,ip))
            node_id = cursor.lastrowid
            db.commit()

            #add ports to database
            for p in open:
                cursor.execute("INSERT INTO ports (node_id,port,state) VALUES (%s,%s,%s)",(node_id,p,0))
                db.commit()

            if (len(open) > total_ports):
                print "More ports than before ("+str(len(open))+"), alerting user"
                os.system("echo '"+ip+" has new open ports'")



# main

cursor.execute("SELECT * FROM networks")
rows = cursor.fetchall()

for network in rows:
    cursor.execute("INSERT INTO scans (network_id,date) VALUES (%s,NOW())",(network[0]))
    scan_id = cursor.lastrowid
    db.commit()
    scan_network(network[1],scan_id)


exit()

