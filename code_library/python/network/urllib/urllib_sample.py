# -*- coding: utf-8 -*-
#
# 简单使用urllib
# urllib 和urllib2 ,能通过网络访问文件，通过一个函数调用，
# 可以吧任何url所指向的东西作为程序输入
#
# urllib2 相对urllib 提供了 HTTP验证(HTTP authentication) 和cookie支持
# 及自己协议的支持

import urllib, urllib2
import os.path, re
from urllib import urlopen

## 1. 使用urllib 打开远程文件

# 这里 webpage 为一个类文件对象
webpage = urlopen('http://www.python.org')
#urlopen 返回的类文件对象支持 close, read, readline和readlines方法。也支持迭代
# 打印出来
#for line in webpage:
#    print line
# 获取about 的连接内容
text = webpage.read()
m = re.search('<a href="([^"]+)" .*?>about</a>', text, re.IGNORECASE)
print m.group(1)

## 2. 获取远程文件。

# 如果希望urllib 为你下载文件并在本地文件存储一个文件得副本， 使用 urlretrieve
# urlretrieve 返回一个元祖(filename, headers) 而不是类文件对象。
# filename 是本地文件得名称(由urllib自动创建), headers 包含一些远程文件得信息。
# 如果需要为下载的副本指定文件名， 可以在urlretrieve函数第二个参数给出
print urllib.urlretrieve('http://www.python.org', 'C:\\tmp_python_webpage.html');
print os.path.exists(r'c:\tmp_python_webpage.html')

## 3. urllib 提供的一些功能(工具方法)

# quote : 返回一个所有特殊字符(这些特殊字符在URL中有特殊含义）都被URL友好的字符代替的字符串(比如%7E代替了~）。
# 如果在url中使用一个包含特殊祖父的字符串，这个函数很有用.
# http%3A//thisis.com%20100/a%7Ec.html
print urllib.quote('http://thisis.com 100/a~c.html');

# quote_plus: 和quote 功能相仿，但是使用 + 代替空格 , 并且quote 了 /(对/解码不安全)
# http%3A%2F%2Fthisis.com+100%2Fa%7Ec.html
print urllib.quote_plus('http://thisis.com 100/a~c.html');

# unquote : 和quote 相反
# http://thisis.com 100/a~c.html
print urllib.unquote('http%3A//thisis.com%20100/a%7Ec.html');

# unquote_plus: 和 quote_plus 相反
print urllib.unquote_plus('http%3A%2F%2Fthisis.com+100%2Fa%7Ec.html')

# urlencode(query[, doeq]) 把映射(比如字典）或者包含两个元素的元祖序列---(key, value)
# 这种形式--转换成URL格式编码的字符串， 这样的字符串可以在CGI查询中使用
print urllib.urlencode({'name':'wangxinyi', 'ping':'pong'})
print urllib.urlencode([('name','wangxinyi'), ('ping','pong')])

