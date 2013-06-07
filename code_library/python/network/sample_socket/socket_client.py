# -*- coding: utf-8 -*-
#
# 一个简单的socket客户机
#

import socket
# 建立一个socket 实例
s = socket.socket()

# 获得当前主机地址, 这里的host 是服务器地址
host = socket.gethostname()
# 服务器的端口号
port = 1234

# 连接服务器， 地址用一个 (host, port) 元祖表示
s.connect( (host, port))
print s.recv(1024)

