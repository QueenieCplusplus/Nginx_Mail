# Nginx_Mail
Mail Server

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
