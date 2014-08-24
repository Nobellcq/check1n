check1n
=======

实验室签到管理工具，服务端需要从中控5.0的控制端写入代码中对应的access.db读取数据并展示，并根据提供的python脚本输出统计结果。客户端可以实时查看签到结果，数据有服务器每5分钟推送一次。

# 简介 #
服务端（check1n_server）主要基于Yii框架开发，前提需要将该应用部署到一台与指纹机联网的服务器，并且该服务器能够运行中控5.0，从而连接中控指纹机并实时更新签到数据到服务器的数据库当中（这里的数据库是accessdb）.
服务端可以通过读取该db对数据进行展示（修改更新的接口也有提供，不过也算是非法操作了，哈哈）

check1n_push是采用了极光推送框架对客户端进行推送，这样我们的服务器在收到签到记录后会在该脚本运行时向客户端推送签到记录。推送的频率由推送脚本运行的频率决定。

客户端内嵌了服务端的网页，可以直接通过网页查看考勤。另外，客户端也嵌入了极光推送框架用于接收服务器推送。推送需要订阅，订阅规则可以通过check1n_push的代码看到。

# 鸣谢 #
极光推送[https://www.jpush.cn/](https://www.jpush.cn/ "jpush")
