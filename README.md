# Nginx_Mail
Mail Server

# 前導

郵件服務，又稱為『電子郵件』，是網路上應用範圍很顧的軟體。郵件服務屬於『非同步』通訊，成本低、操作簡單。並且能在郵件中傳遞超連結、html文字、影像、視訊、音訊等 MIME-TYPE 多元網路媒體型態的內文。

此服務有五種軟體套件可以實現其實例，並能支援 ssl 的安全傳輸設定：

* Mailbox, 使用者代理

  如 mail.google.com、mail.yahoo.com
  使用者看到的 GUI 畫面都是使用者代理用戶端。

* Mail Server

* SMTP

* POP3

* IMAP

# Mail Server Instance

      mail{

          server_name mail.pattysapplab.name;

          # http認證的位址
          auth_http mail.postfix.tw:80/auth.php; 
          imap_capabilities IMAP4rev1 ...;

          pop3_auth ...;
          pop3_capabilities ...;

          smtp_auth ...;
          smtp_capabilties ...;

          xclient off;


      }

      # 針對三台虛擬機的郵件協定設定

      server{

          listen 143;
          protocol imap;


      }

      server{

          listen 110;
          protocol pop3;
          proxy_pass_error_message on;

      }


      server{

          listen 25;
          protocol smtp;

      }

# Auth

            ?php

             if(isset($_SERVER["HTTP_AUTH_USER"]) || !isset($_SERVER["HTTP_AUTH_PASS"])){

                fail();

             } 

             # 設定後端伺服器的 port

             $name = $_SERVER["HTTP_AUTH_USER"];
             $pass = $_SERVER["HTTP_AUTH_PASS"];
             $protocol = $_SERVER["HTTP_AUTH_PROTOCOL"];
             $backend_port = 88;

             if($protocol = "imap"){
                $backend_port = 143;
             }

             if($protocol = "smtp"){
                $backend_port = 25;
             }

             if($username = "kate@mail.pattyappier.name"){
                $server_ip = "192.168.1.8";
             } else {
                 faile();
             }

             function fail(){

                header("");
                exit;

             }

            ?>
