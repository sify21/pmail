<?php
/**
 * php注解差错不方便，而且注解没有定义参数个数什么的，错了也很难查出来
 * 使用@与普通注释区分的
 * 用路由写在写的时候就可以确定有没有写错
 * 如果要定义某个action是否可以通过get、post、delete、put访问，需要把每个路由都写一遍，不能写
 * /：index/:action/:params 这个默认路由，因为其他不匹配这个肯定会匹配的了，就没有区分上面4个的效果了
 * @RoutePrefix("/test")
 */
    class TestController
        extends Base
    {
        /**
         * @Route("/email", methods = {"GET", "OPTIONS"})
         */
        public function EmailAction()
        {
            require __DIR__.'/../vendor/autoload.php';

            //收邮件
            //sina
            //$mailbox = new PhpImap\Mailbox('{imap.sina.com:993/imap/ssl}INBOX', 'softpioneers@sina.com', 'softbuaa');

            //163
            //163第一连接会提示，到邮箱中点安全提醒邮件以开启支持
            /*$mailbox = new PhpImap\Mailbox('{imap.163.com:993/imap/ssl}INBOX', 'softpioneers@163.com', 'npcxcizgalswoafa','/home/sify/文档/localhost');

            $mailsIds = $mailbox->searchMailBox('UNSEEN');
            foreach($mailsIds as $id)
            {
                $mail = $mailbox->getMail($id);
                $mailbox->markMailAsRead($id);
//                preg_match_all('/^cid:(.*?\\$163\\.com$)/', $mail->textHtml, $matches);
//                print_r($matches);
//                $combine = array_combine($matches[1], $matches[0]);
                $attachments = $mail->getAttachments();
                $body = $mail->textHtml;
                foreach ($attachments as $attach)
                {
                    $cid ='cid:'.$attach->id;
                    $fileName = basename($attach->filePath);
                    $a[] = ['cid' => $cid, 'filePath' => $fileName];
                    $body = str_replace($cid,'http://localhost/'.$fileName, $body);
                }
            }*/


            //发邮件
            $mail = new PHPMailer();

//            $mail->SMTPDebug = 2;                               // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'softpioneers@163.com';                 // SMTP username
            $mail->Password = 'npcxcizgalswoafa';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 994;                                    // TCP port to connect to


            $mail->CharSet = 'utf-8';
            $mail->From = 'softpioneers@163.com';
            $mail->FromName = 'Dak-App 科技有限公司';
//            $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $mail->addAddress('softpioneers@163.com');               // Name is optional
//            $mail->addReplyTo('info@example.com', 'Information');
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');

//            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = '孙星宇';
            $mail->Body    = '<h1>HeHe<h1/> <br/><b>XiXi</b>';
//            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
        }

        /**
         * @Route("/code")
         */
        public function CodeAction()
        {
            //array
//            $a = ['a', 'b', 'c', 'd'];好了
//            $b = array();
//            foreach($a as $t)
//            {
//                $b[] = $t;
//            }
//            //print_r($b);
//            echo $a[ array_rand($a) ];

            //date
//            echo date('YmdHis');//实际时间
//            echo round(microtime(true) * 1000);//1970 1月1号至今的毫秒数

            //email body
//            $this->view->enable();
//            $mail_id = $this->request->get('id');
//            $mail = ReceiveMail::findFirst([
//                'conditions' => 'id=?1',
//                'bind' => [1 =>$mail_id]
//            ]);
//            $body = base64_decode($mail->body);
//            $this->response->setContentType('text/html','utf-8');
//            $this->response->setContent($body);
//            $this->response->send();
//            return;
//            $filePath = __DIR__.'/../config/email.json';
//            $jsonString = file_get_contents($filePath);
//            $jsonObj = json_decode($jsonString);
//            $jsonObj->email_address = "hehe";
//            echo json_encode($jsonObj);
        }
    }