#-*- coding: UTF-8 -*-
#from numpy import *
import operator
from os import listdir
import copy
import sys
import re
import time
import datetime

saveerr = sys.stderr
ferrsock = open('error.log', 'w')
sys.stderr = ferrsock


saveout = sys.stdout
fsock = open(sys.argv[2], 'w')
sys.stdout = fsock

print '<meta content="text/plain;charset=utf-8" http-equiv="content-type"></meta>'

filename = sys.argv[1]
ourTeam = ['35','36','37','43','44','45' ,'46','47','53','55','82','100','1004','1005','1006','1013','1014','1015','1016','1017']
ourName = ['张  凡','霍丙乾','黄丽娜','石  翔','王昶心','王  超','沈佳伟','李俊涛','王  乐','文瑞','张乐玫','丁  磊','范雅茹','张伟康','李正玉','刘文彦','易  鸣','杨朝齐','孙忆晨','时伟森']
ourName2 = ['ZhangFan', 'HuoBingqian','HuangLina','ShiXiang','WangChangxin','WangChao','ShenJiawei','LiJuntao','WangLe','ZhangLemei','DingLei','FanYaru','ZhangWeiKang','LiZhengyu','LiuWenyan','YiMing','YangZhaoqi','SunYichen','ShiWeisen']

#get time
#month = []
#date = []
#startTime = time.strptime(sys.argv[3],'%Y/%m/%d %X')
#for i in range(4):
#    week = datetime.datetime()
#date("w",startTime)
month = [sys.argv[3],sys.argv[4],sys.argv[5],sys.argv[6],sys.argv[7]]
date = [sys.argv[8],sys.argv[9],sys.argv[10],sys.argv[11],sys.argv[12]]
#date =['01','02','03','04','05']

#get time end.

x = 3*len(date)
data = []
result = [ [['0' for i in range(4)] for i in range(len(date))] for i in range(len(ourTeam))]
def initialize():
#-----make data-----
    fr = open(filename)
    for line in fr.readlines():
        listFromLine = re.split(r'[\s\-\:]', line)
        if listFromLine[0] in ourTeam: 
           data.append(listFromLine[0:7])
    temp = []
    for j in range(len(data)-1):
        for k in range(len(data)-1-j):
            if int(data[k][0])>int(data[k+1][0]):
               temp = data[k+1]
               data[k+1] = data[k]
               data[k] = temp
    for j in range(len(data)-1):
        for k in range(len(data)-1-j):
            if int(data[k][0]) == int(data[k+1][0]) and (float(data[k][1])*10000+float(data[k][2])*100+float(data[k][3])+float(data[k][4])*0.01+float(data[k][5])*0.0001+float(data[k][6])*0.000001) > (float(data[k+1][1])*10000+float(data[k+1][2])*100+float(data[k+1][3])+float(data[k+1][4])*0.01+float(data[k+1][5])*0.0001+float(data[k+1][6])*0.000001):
             #if int(data[k][0]) == int(data[k+1][0]) and int(data[k][1])*10000+int(data[k][2])*100+int(data[k][3]) > int(data[k+1][1])*10000+int(data[k+1][2])*100+int(data[k+1][3]):
               temp = data[k+1]
               data[k+1] = data[k]
               data[k] = temp
    for g in range(len(data)):
        for f in range(len(ourTeam)):
            if data[g][0] == ourTeam[f]:
               data[g].insert(1,ourName[f])
#-----make result-----
    for j in date:
      for i in ourTeam:
          oneone(i,j)

def oneone(idnum,date2):
    mat = []
    lastHour = 0
    lastMinute = 0
    for i in range(len(data)):
        if (data[i][0] == idnum and data[i][4] == date2) and (int(data[i][5]*60+data[i][6])-int(lastHour*60+lastMinute) > 15):
        #and int(data[i][5])<20:
           mat.append(data[i])
           lastHour = data[i][5]
           lastMinute = data[i][6]
    if len(mat) == 4:
        y = [];
        for i in range(len(mat)):
            y.append(int(mat[i][5])*60+int(mat[i][6]))
        time = y[1] - y[0] + y[len(y)-1] - y[2]
        if time < 360:
               for j in range(4):
                    result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][j] = '5'
        else:
                for j in range(4):
                    result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][j] = '4'
    elif len(mat) > 3:
        if int(mat[1][5]) > 12:
            result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][0] = '3'
            result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
            result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = '3'
            result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = '3'
        else:
            y=[] 
            for i in range(len(mat)):
                y.append(int(mat[i][5])*60+int(mat[0][6]))
            for j in range(len(y)-2):
                if j > 0 and y[j+1] < 750:
                    y.remove(y[j])
                    break
            if y[len(y)-1] > 1110:
                y[len(y)-1] = 1110
            time = y[1] - y[0] + y[len(y)-1] - y[2]
            if time < 360:
               for j in range(4):
                    result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][j] = '5'
            else:
                for j in range(4):
                    result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][j] = '4'
    if len(mat) == 3:
       if int(mat[0][5]) < 10:
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][0] = '3'
          if int(mat[1][5])*60+int(mat[1][6]) > 12*60+30:
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = '3'
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = '3'
          else:
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = '3'
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = '3'
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = ":".join([mat[2][5],mat[2][6],mat[2][7]])
       else:
            result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][0] = '3'
            result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
            result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = '3'
            result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = '3'            
    if len(mat) == 2:
       if int(mat[0][5]) < 10:
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][0] = '2'
          if int(mat[1][5])*60+int(mat[1][6]) > 12*60+30:
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = '2'
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = ":".join([mat[1][5],mat[1][6],mat[1][7]])
          else:
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = '2'
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = ":".join([mat[1][5],mat[1][6],mat[1][7]])
       elif int(mat[0][5])*60+int(mat[0][6]) > 12*60+30:
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][0] = '2'
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = '2'
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = ":".join([mat[1][5],mat[1][6],mat[1][7]])
       else:
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][0] = '2'
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = '2'
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
             result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = ":".join([mat[1][5],mat[1][6],mat[1][7]])
    if len(mat) == 1:
       if int(mat[0][5])*60+int(mat[0][6]) > 12*60+30:
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][0] = '1'
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
       else:
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][0] = '1'
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][1] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][2] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
          result[ourTeam.index(mat[0][0])][date.index(mat[0][4])][3] = ":".join([mat[0][5],mat[0][6],mat[0][7]])
    #for k in range(4):
    #    result[ourTeam.index('1004')][1][k] = '10'
    #    result[ourTeam.index('1004')][2][k] = '10'
    #    result[ourTeam.index('1006')][1][k] = '10'
    #    result[ourTeam.index('1006')][2][k] = '10'
    #    result[ourTeam.index('1013')][1][k] = '10'
    #    result[ourTeam.index('1013')][2][k] = '10'
    ##    result[ourTeam.index('1017')][2][k] = '10'
     #   result[ourTeam.index('1016')][2][k] = '10'
    #    result[ourTeam.index('1015')][4][k] = '10'
    #    result[ourTeam.index('1015')][2][k] = '10'
    #    result[ourTeam.index('1005')][2][k] = '10'
    #for k in range(2):
    #    result[ourTeam.index('1017')][0][k+2] = '10'
    #    result[ourTeam.index('1017')][1][k+2] = '10'
    #    result[ourTeam.index('1016')][3][k+2] = '10'
    #    result[ourTeam.index('1016')][1][k] = '10'
    #    result[ourTeam.index('1015')][0][k+2] = '10'
    #    result[ourTeam.index('1015')][1][k+2] = '10'
    #    result[ourTeam.index('1005')][1][k] = '10'
    #    result[ourTeam.index('1014')][3][k+2] = '10'
    #    result[ourTeam.index('1014')][0][k+2] = '10'
    #    result[ourTeam.index('1014')][1][k+2] = '10'
    #    result[ourTeam.index('1014')][2][k+2] = '10'
        
def checkoneone(idnum3,date3):
    mat = result[ourTeam.index(idnum3)][date.index(date3)]
    #for i in range(len(mat)):
         #print mat[i]
    if mat[0] == '4' or mat[0] == '5':
        if mat[2] == '10':
            print "%s %s %s月%s日 全勤,下午有课" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3)
        else:
            print "%s %s %s月%s日 全勤" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3)
        
        
    if mat[0] == '3':
        if mat[1] != '3':
            print "%s %s %s月%s日 上午少一次，上午打卡时间: %s" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,mat[1])
        if mat[1] == '3':
            if mat[3] == '10':
                print "%s %s %s月%s日 上午全勤, 下午有课" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3)
            elif mat[3] != '3':
                print "%s %s %s月%s日 下午少一次，下午打卡时间: %s" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,mat[3])
    if mat[0] == '2':
        if mat[1] != '2':
            if mat[3] != '2':
                print "%s %s %s月%s日 上午少一次，上午打卡时间: %s; 下午少一次，下午打卡时间: %s" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,mat[1],mat[3])
            elif mat[3] == '10':
                print "%s %s %s月%s日 上午少一次，上午打卡时间: %s; 下午有课" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,mat[1])
        if mat[1] =='2':
            if mat[3] != '2':
                print "%s %s %s月%s日 少打卡两次，打卡时间: %s %s" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,mat[2],mat[3])
            elif mat[3] == '10':
                print "%s %s %s月%s日 全勤，下午有课" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3)
    if mat[0] == '1':
        if mat[2] == '10':
            print "%s %s %s月%s日 上午少一次，上午打卡时间: %s; 下午有课" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,mat[1])
        else:
            print "%s %s %s月%s日 仅打卡一次,打卡时间: %s" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,mat[1])
    if mat[0] == '0':
        if mat[2] == '10':
            print "%s %s %s月%s日 上午未打卡，下午有课" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3)
        else:
            print "%s %s %s月%s日 未打卡" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3)
    if mat[0] =='10':
        if mat[2] == '10':
            print "%s %s %s月%s日 全天课" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3)
        if mat[3] == '3':
            print "%s %s %s月%s日 全勤，上午有课" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3)
        
    print result[ourTeam.index(idnum3)][date.index(date3)]
    for i in range(len(data)):
        if data[i][0] == idnum3 and data[i][4] == date3:
           print "%s %s  %s-%s-%s %s:%s:%s" % (data[i][0],data[i][1],data[i][2],data[i][3],data[i][4],data[i][5],data[i][6],data[i][7])
    print '<br>'
     #print '%s %s %s' % (idnum,date,len(mat))
    #for i in range(len(mat)):
      #  print '%s %s' % (mat[i][1],mat[i][2])
       # 


def checkoneone2(idnum3,date3):
    mat = result[ourTeam.index(idnum3)][date.index(date3)]
    x = []
    for i in range(len(data)):
        if data[i][0] == idnum3 and data[i][4] == date3:
            x.append(":".join([data[i][5],data[i][6],data[i][7]]))
    if mat[0] == '4':
        if mat[2] == '10':
            print "%s %s %s月%s日 全勤,下午有课  %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        else:
            print "%s %s %s月%s日 全勤 %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
    if mat[0] == '5':
        if mat[2] == '10':
            print "%s %s %s月%s日 全勤,下午有课  %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        else:
            print "%s %s %s月%s日 全勤 , 时间不够 ， %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        
        
    if mat[0] == '3':
        if mat[1] != '3':
            print "%s %s %s月%s日 上午少一次，%r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        if mat[1] == '3':
            if mat[3] == '10':
                print "%s %s %s月%s日 上午全勤, 下午有课,%r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
            elif mat[3] != '3':
                print "%s %s %s月%s日 下午少一次，%r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
    if mat[0] == '2':
        if mat[1] != '2':
            if mat[3] != '2':
                print "%s %s %s月%s日 少打卡两次，%r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
            elif mat[3] == '10':
                print "%s %s %s月%s日 上午少一次，下午有课, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        if mat[1] =='2':
            if mat[3] == '10':
                print "%s %s %s月%s日 全勤，下午有课, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
            elif mat[3] != '2':
                print "%s %s %s月%s日 少打卡两次，%r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
            
    if mat[0] == '1':
        if mat[2] == '10':
            print "%s %s %s月%s日 上午少一次，下午有课, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        else:
            print "%s %s %s月%s日 仅打卡一次, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
    if mat[0] == '0':
        if mat[2] == '10':
            print "%s %s %s月%s日 上午未打卡，下午有课, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        else:
            print "%s %s %s月%s日 未打卡, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
    if mat[0] =='10':
        if mat[3] == '4':
            print "%s %s %s月%s日 全勤，上午有课, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        elif mat[2] == '10':
            print "%s %s %s月%s日 全天课, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        elif mat[2] == '3' and mat[3] != '3':
            print "%s %s %s月%s日  上午有课，上午少一次, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        elif mat[3] == '3':
            print "%s %s %s月%s日 全勤，上午有课, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        elif mat[3] == '5':
            print "%s %s %s月%s日 全勤，上午有课, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        elif mat[2] == '2':
            print "%s %s %s月%s日 全勤，上午有课, %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        elif mat[3] == '0':
            print "%s %s %s月%s日 上午有课, 下午未登记， %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
        else:
            print "%s %s %s月%s日 上午有课, 下午未登记， %r" % (idnum3,ourName[ourTeam.index(idnum3)],month[date.index(date3)],date3,x)
    #print result[ourTeam.index(idnum3)][date.index(date3)]    

initialize()
for i in ourTeam:
    for j in date:
        if j is not '01':
            checkoneone2(i,j)
            print '<br>'
    print '<br>'
#for j in date:
   # checkoneone2('35',j)
    
#print result[ourTeam.index('1016')][date.index('10')]    




#oneone('1016','16')
#checkoneone2('1013','22')
#for f in range(len(data)):
#    if data[f][0] != data[f-1][0]:
#       print '\n\n'
#    if data[f][4] != data[f-1][4]:
#       print '\n'
#    print "%s %s %s-%s-%s %s:%s:%s" % (data[f][0],data[f][1],data[f][2],data[f][3],data[f][4],data[f][5],data[f][6],data[f][7])

#prfloat data
#while inpu != 'q':
      #inpu = begin()
#for i in range(len(result)):
   # print result[i]
#oneperson('37')


sys.stdout = saveout
sys.stderr = saveerr