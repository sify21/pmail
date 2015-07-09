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
        $this->dispatcher->forward([
            'action' => 'getReceiveList',
            'params' => ['uid' => $this->request->get('uid'), 'status' => 1]
        ]);
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
            $subject = "回复：".$info->subject;
            $body = $info->body;
            $toWhom = $info->toWhom;
            $handler_id = $info->handler_id;
            $replyMail = new ReplyMail();
            if(isset($info->reply_id))//一封回复邮件,在body后面加上原邮件内容
            {
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
                $original_mail_body = base64_decode($original_mail->body);
                $original_mail_address = $original_mail->fromAddress;
                $body = $body."<br/><br/><hr/><span style='color:grey'>{$original_mail_address}</span>在原邮件中写到：".$original_mail_body;
                $replyMail->reply_id = $info->reply_id;
            }
            $uuid = Utils::create_uuid();
            $replyMail->mail_id = base64_encode( $uuid );
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
            $this->response->setJsonContent(['id' => $replyMail->id, 'mail_id' => $replyMail->mail_id, 'subject' => base64_decode($replyMail->subject),
                'body' => base64_decode($replyMail->body), 'reply_id' => $replyMail->reply_id, 'toWhom' => $replyMail->toWhom, 'reply_date' => $replyMail->replyDate,
                'status' => $replyMail->status, 'handler_id' => $replyMail->handler_id, 'assessor_id' => $replyMail->assessor_id]);
        }
        catch(Exception $e)
        {
            $this->response->setJsonContent(['message' => $e->getMessage()]);
        }
        $this->response->send();
        return;
    }
}