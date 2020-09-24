# Nginx_Mail
Mail Server

# 前導

郵件服務，又稱為『電子郵件』，是網路上應用範圍很顧的軟體。郵件服務屬於『非同步』通訊，成本低、操作簡單。並且能在郵件中傳遞超連結、html文字、影像、視訊、音訊等 MIME-TYPE 多元網路媒體型態的內文。

此服務有 4 種軟體套件可以實現其實例，並能支援 ssl 的安全傳輸設定：

* Mailbox, 使用者代理

  如 mail.google.com、mail.yahoo.com
  使用者看到的 GUI 畫面都是使用者代理用戶端。

* IMAP(Sync)

  使用者下載郵件後，伺服器中的郵件不會被刪除，倘若使用者對郵件進行操作，則會同步狀態至伺服器上，所以伺服器和用戶端本機的郵件狀態保持一制性。

* POP3(Offline)

   使用者下載郵件後，伺服器中的郵件會被刪除，另外此協定為郵件服務的第一個離線 offline 協定。
   
* SMTP(Mail Server)

   使用者需要帳號密碼方才能登入，且此協定能幫助避免受到垃圾郵件侵擾。

# Mail Server Instance

      mail{

          server_name mail.pattysapplab.name; #(C)

          # http認證的位址
          auth_http mail.postfix.tw:80/auth.php; #(F)
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
          protocol imap; #(D)


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
             $backend_port = 88;#(B)

             if($protocol = "imap"){
                $backend_port = 143;
             }

             if($protocol = "smtp"){
                $backend_port = 25;
             }

             if($username = "kate@mail.pattyappier.name"){
                $server_ip = "192.168.1.8"; #(A)
             } else {
                 faile();
             }

             function fail(){

                header("");
                exit;

             }

            ?>

# 郵件服務的基本指令

(A) 郵件伺服器的 ip 位址

    作用於 OSI L3

(B) 郵件伺服器的服務通訊號

    作用於 OSI L4


(C) 虛擬主機的域名
    
    由虛擬伺服器區塊組成。
    
(D) 服務協定

    包含 POP3、SMTP、IMAP。
    該指令僅能於虛擬伺服器主機區塊中設定。
    
(E) so_keepalive

    設定後端代理伺服器啟用 TCP keepalive 模式處理郵件伺服器轉發的用戶端連結。
    該指令僅能於虛擬伺服器主機區塊中設定。

(F) auth_http [URL]

    設定代理伺服器提供郵件服務時用於 http 認證的伺服器位址。
    如上範例為 uth_http mail.postfix.tw:80/auth.php;
    該指令僅能於虛擬伺服器主機區塊中設定。
    
(G) auth_http_header X-Auth-Key "secret-string";  
          auth_http_timeout [time];

    如 (F) 認證伺服器發出請求時，代理伺服器在請求的標頭增加指定的標頭域，轉發予使用者端。
    而逾時的設定預設為 60 m (<75s)，是指代理伺服器向 http 認證伺服器發出認證請求後，等待認證伺服器回應的時間。 

(H) proxy_buffer 4k|8k

    該指令用於設定後端代理伺服器群組之情況，設定伺服器代理快取大小，即平台記憶體分頁大小。
    該指令僅能於虛擬伺服器主機區塊中設定。

(I) proxy_pass_error_message on

    該指令用於設定後端代理伺服器群組情況，用於設定是否將後端伺服器上郵件服務認證過程中產生的錯誤訊息亦轉發予使用者端。
    其中，POP3 協定下，此指令應該關閉為 off，否則即便 http 伺服器認證成功，代理伺服器的 POP3 服務認為是認證錯誤。
