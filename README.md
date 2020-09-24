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
