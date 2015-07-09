<?php
/**
 * @RoutePrefix('/handler')
 */

class HandlerController extends Base{
    //下面的那么多getmailList，逻辑都是一样的，只是status不同，所以冗余代码很多；因为之前是把status拆成了好多字段来判断，相当于是给项目制造复杂度了；
    //因此数据库设计是一定要遵循最少字段原则，完成同样功能数据库字段越少代码逻辑肯定越清晰

    /**
     * @Route("/getReceiveList")
     */
    public function getReceiveList()
    {
        $uid = $this->request->get('uid');
        $status = $this->request->get('status');
        if($uid == null||$status == null)
        {
            $this->response->setJsonContent(['message' => 'No Data!']);
        }
        $receiveMails = ReceiveMail::find([
            'conditions' => 'status=?1 AND handler_id=?2',
            'bind' => [1 => $status, 2 => $uid],
            'column' => 'id, mail_id, subject, fromAddress, receiveDate, tags, status, deadline, dispatcher_id, handler_id'
        ]);
        if($receiveMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($receiveMails as $mail)
            {
                $id = $mail->id;
                $mail_id = base64_decode( $mail->mail_id );
                $fromAddress = $mail->fromAddress;
                $subject = base64_decode( $mail->subject );
                $receiveDate = $mail->receiveDate;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'fromAddress' => $fromAddress, 'subject' => $subject, 'receiveDate' => $receiveDate];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getUnHandled", methods = {"GET", "OPTIONS"})
     */
    public function GetUnHandledAction()
    {
        $uid = $this->request->get('uid');
        if($uid == null)
        {
            $this->response->setJsonContent(['message' => 'No Data!']);
        }
        $receiveMails = ReceiveMail::find([
            'conditions' => '(status=1 OR status=3) AND handler_id=?1',
            'bind' => [1 => $uid],
            'column' => 'id, mail_id, subject, fromAddress, receiveDate, tags, status, deadline, dispatcher_id, handler_id'
        ]);
        if($receiveMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($receiveMails as $mail)
            {
                $id = $mail->id;
                $mail_id = base64_decode( $mail->mail_id );
                $subject = base64_decode( $mail->subject );
                $fromAddress = $mail->fromAddress;
                $receiveDate = $mail->receiveDate;
                $tags = base64_decode( $mail->tags);
                $status = $mail->status;
                $deadline = $mail->deadline;
                $dispatcher_id = $mail->dispatcher_id;
                $handler_id = $mail->handler_id;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'subject' => $subject, 'fromAddress' => $fromAddress, 'receiveDate' => $receiveDate,
                'tags' => $tags, 'status' => $status, 'deadline' => $deadline, 'dispatcher_id' => $dispatcher_id, 'handler_id' => $handler_id];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getHandled", methods = {"GET", "OPTIONS"})
     */
    public function GetHandledAction()
    {
        $uid = $this->request->get('uid');
        //$uid = $this->session->get('user_id');
        $handledMails = ReceiveMail::find([
            'conditions' => 'status=?1 AND handler_id=?2',
            'bind' => [1 => 2, 2 => $uid],
            'column' => 'id, mail_id, fromAddress, subject, receiveDate'
        ]);
        if($handledMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($handledMails as $mail)
            {
                $id = $mail->id;
                $mail_id = base64_decode( $mail->mail_id );
                $fromAddress = $mail->fromAddress;
                $subject = base64_decode( $mail->subject );
                $receiveDate = $mail->receiveDate;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'fromAddress' => $fromAddress, 'subject' => $subject, 'receiveDate' => $receiveDate];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getAssessing", methods = {"GET", "OPTIONS"})
     */
    public function GetAssessingAction()//审核中
    {
        $uid = $this->request->get('uid');
        //$uid = $this->session->get('user_id');
        $assessingMails = ReplyMail::find([
            'conditions' => 'status=?1 AND handler_id=?2',
            'bind' => [1 => 1, 2 => $uid],
            'column' => 'id, mail_id, subject, reply_id, toWhom, replyDate, assessor_advice, status, assessor_id, handler_id'
        ]);
        if($assessingMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($assessingMails as $mail)
            {
                $id = $mail->id;
                $mail_id = base64_decode( $mail->mail_id );
                $subject = base64_decode( $mail->subject );
                $reply_id = $mail->reply_id;
                $toWhom = $mail->toWhom;
                $replyDate = $mail->replyDate;
                $assessor_advice = base64_decode( $mail->assessor_advice );
                $status = $mail->status;
                $assessor_id = $mail->assessor_id;
                $handler_id = $mail->handler_id;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'subject' => $subject, 'reply_id' => $reply_id,'toWhom' => $toWhom, 'replyDate' => $replyDate,
                    'assessor_advice' => $assessor_advice, 'status' => $status, 'assessor_id' => $assessor_id, 'handler_id' => $handler_id];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getAssessed", methods = {"GET", "OPTIONS"})
     */
    public function GetAssessedAction()//审核已通过
    {
        $uid = $this->request->get('uid');
        //$uid = $this->session->get('user_id');
        $assessedMails = ReplyMail::find([
            'conditions' => 'status=?1 AND handler_id=?2',
            'bind' => [1 => 3, 2 => $uid],
            'column' => 'id, mail_id, subject, reply_id, toWhom, replyDate, assessor_advice, status, assessor_id, handler_id'
        ]);
        if($assessedMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($assessedMails as $mail)
            {
                $id = $mail->id;
                $mail_id = base64_decode( $mail->mail_id );
                $subject = base64_decode( $mail->subject );
                $reply_id = $mail->reply_id;
                $toWhom = $mail->toWhom;
                $replyDate = $mail->replyDate;
                $assessor_advice = base64_decode( $mail->assessor_advice );
                $status = $mail->status;
                $assessor_id = $mail->assessor_id;
                $handler_id = $mail->handler_id;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'subject' => $subject, 'reply_id' => $reply_id,'toWhom' => $toWhom, 'replyDate' => $replyDate,
                    'assessor_advice' => $assessor_advice, 'status' => $status, 'assessor_id' => $assessor_id, 'handler_id' => $handler_id];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getUnAssessed", methods = {"GET", "OPTIONS"})
     */
    public function GetUnAssessedAction()//审核退回
    {
        $uid = $this->request->get('uid');
        //$uid = $this->session->get('user_id');
        $unAssessedMails = ReplyMail::find([
            'conditions' => 'status=?1 AND handler_id=?2',
            'bind' => [1 => 2, 2 => $uid],
            'column' => 'id, mail_id, subject, reply_id, toWhom, replyDate, assessor_advice, status, assessor_id, handler_id'
        ]);
        if($unAssessedMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($unAssessedMails as $mail)
            {
                $id = $mail->id;
                $mail_id = base64_decode( $mail->mail_id );
                $subject = base64_decode( $mail->subject );
                $reply_id = $mail->reply_id;
                $toWhom = $mail->toWhom;
                $replyDate = $mail->replyDate;
                $assessor_advice = base64_decode( $mail->assessor_advice );
                $status = $mail->status;
                $assessor_id = $mail->assessor_id;
                $handler_id = $mail->handler_id;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'subject' => $subject, 'reply_id' => $reply_id,'toWhom' => $toWhom, 'replyDate' => $replyDate,
                    'assessor_advice' => $assessor_advice, 'status' => $status, 'assessor_id' => $assessor_id, 'handler_id' => $handler_id];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getSent", methods = {"GET", "OPTIONS"})
     */
    public function GetSentAction()//已发送
    {
        $uid = $this->request->get('uid');
        //$uid = $this->session->get('user_id');
        $handledMails = ReplyMail::find([
            'conditions' => 'status=?1 AND handler_id=?2',
            'bind' => [1 => 0, 2 => $uid],
            'column' => 'id, mail_id, subject, reply_id, toWhom, replyDate, assessor_advice, status, assessor_id, handler_id'
        ]);
        if($handledMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($handledMails as $mail)
            {
                $id = $mail->id;
                $mail_id = base64_decode( $mail->mail_id );
                $subject = base64_decode( $mail->subject );
                $reply_id = $mail->reply_id;
                $toWhom = $mail->toWhom;
                $replyDate = $mail->replyDate;
                $assessor_advice = base64_decode( $mail->assessor_advice );
                $status = $mail->status;
                $assessor_id = $mail->assessor_id;
                $handler_id = $mail->handler_id;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'subject' => $subject, 'reply_id' => $reply_id,'toWhom' => $toWhom, 'replyDate' => $replyDate,
                    'assessor_advice' => $assessor_advice, 'status' => $status, 'assessor_id' => $assessor_id, 'handler_id' => $handler_id];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getAssessorList", methods = {"GET", "OPTIONS"})
     */
    public function GetAssessorListAction()
    {
        $assessors = User::find([
            'conditions' => 'role=?1',
            'bind' => [1 => 'assessor']
        ]);
        $return = array();
        foreach($assessors as $assessor)
        {
            $return[] = ['id' => $assessor->id, 'name' => $assessor->name, 'role' => $assessor->role, 'created_at' => $assessor->created_at];
        }
        $this->response->setJsonContent(['count' => count($return), 'assessorList' => $return]);
        $this->response->send();
        return;
    }

    /**
     * @Route("/createReplyMail", methods = {"POST", "OPTIONS"})
     */
    public function CreateReplyMailAction()
    {
        try
        {
            $info = $this->request->getJsonRawBody();
            if(!isset($info->subject)||!isset($info->body)||!isset($info->toWhom)||!isset($info->handler_id))
            {
                $this->response->setJsonContent(['message' => 'No Data!']);
                $this->response->send();
                return;
            }
            $subject = $info->subject;
            $body = $info->body;
            $toWhom = $info->toWhom;
            $handler_id = $info->handler_id;
            $replyMail = new ReplyMail();
            $original_mail = null;
            if(isset($info->reply_id))//一封回复邮件,在body后面加上原邮件内容,同时主题前加 回复：
            {
                $subject = "回复：".$subject;
                $original_mail = ReceiveMail::findFirst([
                    'conditions' => 'id = ?1',
                    'bind' => [1 => $info->reply_id]
                ]);
                if($original_mail == null)
                {
                    $this->response->setJsonContent(['message' => '原邮件不存在！']);
                    $this->response->send();
                    return;
                }
                $replyMail->reply_id = $info->reply_id;
            }
            $o_id = $original_mail->id;
            $o_mail_id = base64_decode( $original_mail->mail_id );
            $o_subject = base64_decode($original_mail->subject);
            $o_body = base64_decode($original_mail->body);
            $o_fromAddress = $original_mail->fromAddress;
            $o_receiveDate = $original_mail->receiveDate;
            $o_tags = base64_decode($original_mail->tags);
            $o_status = $original_mail->status;
            $o_deadline = $original_mail->deadline;
            $o_dispatcher_id = $original_mail->dispatcher_id;
            $o_handler_id = $original_mail->handler_id;
            if(!isset($info->mail_id))
            {
                $uuid = Utils::create_uuid();
                $replyMail->mail_id = base64_encode( $uuid );
            }
            else
            {
                $replyMail->mail_id = base64_encode( $info->mail_id );
            }
            $replyMail->subject = base64_encode( $subject );
            $replyMail->body = base64_encode( $body );
            $replyMail->toWhom = $toWhom;
            $replyMail->handler_id = $handler_id;
            if(isset($info->assessor_id))//需要提交审核
            {
                $replyMail->status = 1;
                $replyMail->assessor_id = $info->assessor_id;
                $replyMail->save();
            }
            else//不需要提交审核,直接发送
            {
                $replyMail->status = 0;
                $replyMail->save();
                Utils::sendMail($replyMail->id);
            }
            $this->response->setJsonContent(['current_main' => ['id' => $replyMail->id, 'mail_id' => $replyMail->mail_id, 'subject' => base64_decode($replyMail->subject),
                'body' => base64_decode($replyMail->body), 'reply_id' => $replyMail->reply_id, 'toWhom' => $replyMail->toWhom, 'reply_date' => $replyMail->replyDate,
                'status' => $replyMail->status, 'handler_id' => $replyMail->handler_id, 'assessor_id' => $replyMail->assessor_id],
                'original_mail' => ['id' => $o_id, 'mail_id' => $o_mail_id, 'subject' => $o_subject, 'body' => $o_body, 'fromAddress' => $o_fromAddress, 'receiveDate' => $o_receiveDate,
                    'tags' => $o_tags, 'status' => $o_status, 'deadline' => $o_deadline, 'dispatcher_id' => $o_dispatcher_id, 'handler_id' => $o_handler_id]]);
        }
        catch(Exception $e)
        {
            $this->response->setJsonContent(['message' => $e->getMessage()]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getTemplates", methods = {"GET", "OPTIONS"})
     */
    public function GetTemplatesAction()
    {
        $uid = $this->request->get('uid');
        $templates = Template::find([
            'conditions' => 'handler_id=?1 OR handler_id IS NULL',
            'bind' => [1 => $uid]
        ]);
        $templateList = array();
        if($templates->getFirst() == null)
        {
            $this->response->setJsonContent(['message' => 'No Templates Found!']);
            $this->response->send();
            return;
        }
        foreach ($templates as $template)
        {
            $template_id = $template->id;
            $name = base64_decode( $template->name );
            $subject = base64_decode( $template->subject );
            $body = base64_decode( $template->body );
            $templateList[] = ['template_id' => $template_id, 'name' => $name, 'subject' => $subject, 'body' => $body];
        }
        $this->response->setJsonContent( $templateList );
        $this->response->send();
        return;
    }

    /**
     * @Route("/createTemplate", methods = {"POST", "OPTIONS"})
     */
    public function CreateTemplateAction()
    {
        $info = $this->request->getJsonRawBody();
        if(!isset($info->handler_id)||!isset($info->name)||!isset($info->subject)||!isset($info->body))
        {
            $this->response->setJsonContent(['message' => 'No Data!']);
            $this->response->send();
            return;
        }
        $template = new Template();
        $template->handler_id = $info->handler_id;
        $template->name = base64_encode($info->name);
        $template->subject = base64_encode($info->subject);
        $template->body = base64_encode($info->body);
        $template->save();
        $this->response->setJsonContent(['template_id' => $template->id, 'handler_id' => $info->handler_id, 'name' => $info->name, 'subject' => $info->subject, 'body' => $info->body]);
        $this->response->send();
        return;
    }

    /**
     * @Route("/uploadFile", methods = {"POST", "OPTIONS"})
     */
    public function UploadFileAction()
    {
        if ($this->request->hasFiles() == true)
        {
            foreach ($this->request->getUploadedFiles() as $file)
            {
                $dir = realpath('../..').'/phpinfo/';
                $file_name = Utils::create_uuid().'_'.$file->getName();
                $file->moveTo($dir.$file_name);
            }
        }
        $this->response->setJsonContent(['file_name'=> $file->getName(), 'file_path' => 'http://phpinfo.sify21.com/'.$file_name]);
        $this->response->send();
        return;
    }
}