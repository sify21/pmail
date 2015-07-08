<?php
/**
 * @RoutePrefix("/common")
 */

class CommonController extends Base{
    /**
     * @Route("/updateReceiveMail", methods = {"PUT", "OPTIONS"})
     */
    public function UpdateReceiveMailAction()
    {
        $info = $this->request->getJsonRawBody();
        if(!isset($info->id))
        {
            $this->response->setJsonContent(['message' => '未指定id']);
            $this->response->send();
            return;
        }
        $id = $info->id;
        $email = ReceiveMail::findFirst([
            'conditions' => 'id=?1',
            'bind' => [1 => $id]
        ]);
        if($email == null)
        {
            $this->response->setJsonContent(['message' => '邮件不存在']);
        }
        else
        {
            try
            {
                if(isset($info->subject)) $email->suject = base64_encode( $info->subject );
                if(isset($info->body)) $email->body = base64_encode( $info->body );
                if(isset($info->fromAddress)) $email->fromAddress = $info->fromAddress;
                if(isset($info->receiveDate)) $email->receiveDate = $info->receiveDate;
                if(isset($info->tags)) $email->tags = $info->tags;
                if(isset($info->status)) $email->status = $info->status;
                if(isset($info->dispatcher_id)) $email->dispatcher_id = $info->dispatcher_id;
                if(isset($info->handler_id)) $email->handler_id = $info->handler_id;
                $email->save();
                $this->response->setJsonContent(['id' => $email->id, 'subject' => $email->subject, 'body' => $email->body,
                    'fromAddress' => $email->fromAddress, 'receiveDate' => $email->receiveDate, 'tags' => $email->tags,
                    'status' => $email->status, 'dispatcher_id' => $email->dispatcher_id, 'handler_id' => $email->handler_id] );
            }
            catch(Exception $e)
            {
                $this->response->setJsonContent(['message' => $e->getMessage()]);
            }
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/updateReplyMail", methods = {"PUT", "OPTIONS"})
     */
    public function UpdateReplyMailAction()
    {
        $info = $this->request->getJsonRawBody();
        if(!isset($info->id))
        {
            $this->response->setJsonContent(['message' => '未指定id']);
            $this->response->send();
            return;
        }
        $id = $info->id;
        $email = ReplyMail::findFirst([
            'conditions' => 'id=?1',
            'bind' => [1 => $id]
        ]);
        if($email == null)
        {
            $this->response->setJsonContent(['message' => '邮件不存在']);
        }
        else
        {
            try
            {
                if(isset($info->subject)) $email->suject = base64_encode( $info->subject );
                if(isset($info->body)) $email->body = base64_encode( $info->body );
                if(isset($info->reply_id)) $email->reply_id = $info->reply_id;
                if(isset($info->toWhom)) $email->toWhom = $info->toWhom;
                if(isset($info->replyDate)) $email->replyDate = $info->replyDate;
                if(isset($info->assessor_advice)) $email->assessor_advice = base64_encode( $info->assessor_advice );
                if(isset($info->status)) $email->status = $info->status;
                if(isset($info->handler_id)) $email->handler_id = $info->handler_id;
                if(isset($info->assessor_id)) $email->assessor_id = $info->assessor_id;
                $email->save();
                $this->response->setJsonContent(['id' => $email->id, 'subject' => $email->subject, 'body' => $email->body, 'reply_id' => $email->reply_id,
                    'toWhom' => $email->toWhom, 'replyDate' => $email->replyDate, 'assessor_advice' => $email->assessor_advice, 'tags' => $email->tags,
                    'status' => $email->status, 'dispatcher_id' => $email->dispatcher_id, 'handler_id' => $email->handler_id] );
            }
            catch(Exception $e)
            {
                $this->response->setJsonContent(['message' => $e->getMessage()]);
            }
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getReceiveEmail", methods = {"GET", "OPTIONS"})
     */
    public function GetReceiveEmailAction()
    {
        $id = $this->request->get('id');
        $email = ReceiveMail::findFirst([
            'conditions' => 'id=?1',
            'bind' => [1 => $id]
        ]);
        if($email == null)
        {
            $this->response->setJsonContent(['message' => '邮件不存在']);
        }
        else
        {
            $id = $email->id;
            $mail_id = base64_decode( $email->mail_id );
            $subject = base64_decode( $email->subject );
            $body = base64_decode( $email->body );
            $fromAddress = $email->fromAddress;
            $receiveDate = $email->receiveDate;
            $tags = $email->tags;
            $status = $email->status;
            $dispatcher_id = $email->dispatcher_id;
            $handler_id = $email->handler_id;
            $this->response->setJsonContent(['id' => $id, 'mail_id' => $mail_id, 'subject' => $subject, 'body' => $body, 'fromAddress' => $fromAddress,
                'receiveDate' => $receiveDate, 'tags' => $tags, 'status' => $status, 'dispatcher_id' => $dispatcher_id, 'handler_id' => $handler_id]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Route("/getReplyEmail", methods = {"GET", "OPTIONS"})
     */
    public function GetReplyEmailAction()
    {
        $id = $this->request->get('id');
        $email = ReplyMail::findFirst([
            'conditions' => 'id=?1',
            'bind' => [1 => $id]
        ]);
        if($email == null)
        {
            $this->response->setJsonContent(['message' => '邮件不存在']);
        }
        else
        {
            $id = $email->id;
            $mail_id = base64_decode( $email->mail_id );
            $subject = base64_decode( $email->subject );
            $body = base64_decode( $email->body );
            $reply_id = $email->reply_id;
            $toWhom = $email->toWhom;
            $replyDate = $email->replyDate;
            $assessor_advice = $email->assessor_advice;
            $status = $email->status;
            $handler_id = $email->handler_id;
            $assessor_id = $email->assessor_id;
            $this->response->setJsonContent(['id' => $id, 'mail_id' => $mail_id, 'subject' => $subject, 'body' => $body, 'reply_id' => $reply_id,'toWhom' => $toWhom,
                'replyDate' => $replyDate, 'assessor_advice' => $assessor_advice, 'status' => $status, 'handler_id' => $handler_id, 'assessor_id' => $assessor_id]);
        }
        $this->response->send();
        return;
    }
}