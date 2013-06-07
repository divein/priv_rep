如果要需要管理多个public key 账号

在 C:\Documents and Settings\Administrator\.ssh 目录下建立个config 文件

然后生成域别名的内容

key-gen -t rsa -C "测试" -f wxys_phpfog

然后建立个conf文件，内容如下

Host  wxy_phpfog
HostName git01.phpfog.com
User git
PreferredAuthentications publickey
IdentityFile ~/.ssh/wxy_phpfog

Host  divein_github
HostName github.com
User git
PreferredAuthentications publickey
IdentityFile ~/.ssh/divein_github



然后修改git url 如下
git clone git@{这块替换为Host内容}:divein/priv_rep.git
