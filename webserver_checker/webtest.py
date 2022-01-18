#!/usr/bin/python
# coding: UTF-8
# ウェブサーバ 監視ツール
import http.client,datetime,os

#============設定項目==============
# Gメールのアカウント
gmail_sender = 'あなたのあかうんと@gmail.com'
# Gメールのパスワード
gmail_passwd = 'あなたのぱすわーど'
# エラーメール送信先
gmail_to = 'そうしんさき＠メールアドレス'
# メールの件名
mail_subject =  'サーバーエラーが発生しています'
#チェックするサーバ
servers = ("www.あなたのさいと１.com","www.あなたのさいと２.net")
# ログ保存先ディレクトリ(相対パス)
log_dir = "webtestlog"
#=================================

import smtplib
from email.mime.text import MIMEText

# メール送信
def sendmail(data):
    global gmail_sender,gmail_passwd,gmail_to,mail_subject
    TEXT = data
    # サインイン
    server = smtplib.SMTP('smtp.gmail.com', 587)
    server.ehlo()
    server.starttls()
    server.login(gmail_sender, gmail_passwd)

    message = MIMEText(data,"plain","UTF-8")
    message["Subject"] = mail_subject
    message["From"] = gmail_sender
    message["To"] = gmail_to

    try:
        server.sendmail(gmail_sender, [gmail_to], message.as_string())
        print ('email sent')
    except Exception as e:
        print (e)
        print ('error sending mail')

    server.quit()


result = ""
error_detected = False


#結果のフォーマット。ここをカスタマイズすれば、もっと詳しい情報を追記したりとかできる。
def format_result(address,response):
    return address +"  "+ str(response.status) + "   " + response.reason

#ルート・ディレクトリをチェックする
def checkroot(address):
    global result,error_detected
    conn = http.client.HTTPConnection( address )
    try:
        conn.request( "GET", "/" )
    except:
        result = result + address + " CANNOT GET\n"
        error_detected = True
        return
    response = conn.getresponse()
    if response.status != 200:
        error_detected = True
    result = result + format_result(address,response) + "\n"
    conn.close()

# ここですべてのサーバをチェックする
for each in servers:
    checkroot(each)


if not os.path.isdir(log_dir):
    os.mkdir(log_dir)

now = datetime.datetime.now()
# 時間情報を埋め込む
result = str(now) + "\n" + result
# レスポンスの記録
filename = log_dir+"\log_"+now.strftime("%y-%m-%d")+".txt";
f = open(filename, 'a') # 追記モード
f.write(result) # 結果
f.close()


#エラーがあればメール送信
if error_detected:
    sendmail(result);
