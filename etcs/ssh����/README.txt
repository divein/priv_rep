���Ҫ��Ҫ������public key �˺�

�� C:\Documents and Settings\Administrator\.ssh Ŀ¼�½�����config �ļ�

Ȼ�����������������

key-gen -t rsa -C "����" -f wxys_phpfog

Ȼ������conf�ļ�����������

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



Ȼ���޸�git url ����
git clone git@{����滻ΪHost����}:divein/priv_rep.git
