<?php
/**
 * @RoutePrefix("/common")
 */

class CommonController extends Base{
    /**
     * @Put("/updateReceiveMail")
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
                if(isset($info->subject)) $email->suject = $info->subject;
                if(isset($info->body)) $email->body = $info->body;
                if(isset($info->fromAddress)) $email->fromAddress = $info->fromAddress;
                if(isset($info->receiveDate)) $email->receiveDate = $info->receiveDate;
                if(isset($info->isAnswered)) $email->isAnswered = $info->isAnswered;
                if(isset($info->isSeen)) $email->isSeen = $info->isSeen;
                if(isset($info->dispatcher_id)) $email->dispatcher_id = $info->dispatcher_id;
                if(isset($info->isDispatched)) $email->isDispatched = $info->isDispatched;
                if(isset($info->handler_id)) $email->handler_id = $info->handler_id;
                if(isset($info->isHandled)) $email->isHandled = $info->isHandled;
                if(isset($info->tags)) $email->tags = $info->tags;
                $email->save();
                $this->response->setJsonContent(['id' => $email->id, 'subject' => $email->subject, 'body' => $email->body, 'fromAddress' => $email->fromAddress, 'receiveDate' => $email->receiveDate,
                                                'isAnswered' => $email->isAnswered, 'isSeen' => $email->isSeen, 'dispatcher_id' => $email->dispatcher_id, 'isDispatched' => $email->isDispatched, 'handler_id' => $email->handler_id, 'isHandled' => $email->isHandled, 'tags' => $email->tags]);
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
     * @Put("/updateReplyMail")
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
                if(isset($info->subject)) $email->suject = $info->subject;
                if(isset($info->body)) $email->body = $info->body;
                if(isset($info->toWhom)) $email->toWhom = $info->toWhom;
                if(isset($info->replyDate)) $email->replyDate = $info->replyDate;
                if(isset($info->handler_id)) $email->handler_id = $info->handler_id;
                if(isset($info->isSend)) $email->isSend = $info->isSend;
                if(isset($info->assessor_id)) $email->assessor_id = $info->assessor_id;
                if(isset($info->isAssessed)) $email->isAssessed = $info->isAssessed;
                if(isset($info->assessor_advice)) $email->assessor_advice = $info->assessor_advice;
                $email->save();
                $this->response->setJsonContent(['message' => 'success']);
            }
            catch(Exception $e)
            {
                $this->response->setJsonContent(['message' => $e->getMessage()]);
            }
        }
        $this->response->send();
        return;
    }
}