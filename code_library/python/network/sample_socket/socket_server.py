# -*- coding: utf-8 -*-
##
# 一个简单的 client, servier 例子
##

import socket

# socket的实例化可以使用三个参数:
# 第一个参数是地址族(默认是 socket.AF_INET)
# 第二个参数是流 (默认是 socket.SOCK_STREAM, 或者数据报 socket.SOCK_DGRAM)
# 第三个参数是使用的协议 (默认是0, 使用默认即可).
s = socket.socket()

# 使用 scoket.gethostname 得到主机名
host = socket.gethostname()
port = 1234
# 一个地址就是一个格式为 (host, port) 的元祖，
# host 是主机名， port 是端口号
s.bind( (host, port) )

# 开始监听，参数数字是服务器未处理的连接长度(允许排队等待的连接数目，
# 这些连接在停止接收之前等待接收)
s.listen(5)

while True:
    # 接收客户端连接， 使用accept 方法来完成。
    # accept方法会阻塞(等待）直到客户端连接，客户端连接上后，
    # accpet方法会返回一个格式为(client, address) 的元祖， client是一个客户端套接字， address是地址。
    client, addr = s.accept()
    print 'Got connection from', addr
    # 套接字有两个方法： send和recv(用于接收).来传输数据。
    # 可以使用字符串参数调用send发送数据。 用一个所需(最大)字节数做参数调用recv来接收数据。 不确定的话，使用1024比较好
    client.send('Thank you for connecting')
    client.close()


