<?php
require __DIR__.'/../vendor/autoload.php';
/**
 * @RoutePrefix("/dispatcher")
 */
class DispatcherController extends Base{
    /**
     * @Get("/getUnDispatched")
     */
    public function GetUnDispatchedAction()
    {
        $uid = $this->request->get('uid');
        $unDispatchedMails = ReceiveMail::find([
            'conditions' => 'isDispatched=?1 AND dispatcher_id=?2',
            'bind' => [1 => 0, 2 => $uid],
            'column' => 'id, fromAddress, subject, receiveDate'
        ]);
        if($unDispatchedMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($unDispatchedMails as $unDispatchedMail)
            {
                $mailList[] = ['id' => "{$unDispatchedMail->id}", 'fromAddress' => $unDispatchedMail->fromAddress, 'subject' => $unDispatchedMail->subject, 'receiveDate' => $unDispatchedMail->receiveDate];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Get("/getDispatched")
     */
    public function GetDispatchedAction()
    {
        $uid = $this->request->get('uid');
        $dispatchedMails = ReceiveMail::find([
            'conditions' => 'isDispatched=?1 AND dispatcher_id=?2',
            'bind' => [1 => 1, 2 => $uid],
            'column' => 'id, fromAddress, subject, receiveDate'
        ]);
        if($dispatchedMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($dispatchedMails as $dispatchedMail)
            {
                $mailList[] = ['id' => $dispatchedMail->id, 'fromAddress' => $dispatchedMail->fromAddress, 'subject' => $dispatchedMail->subject, 'receiveDate' => $dispatchedMail->receiveDate];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Get("/getUnSeenMails")
     */
    public function GetUnSeenAction()
    {
        $uid = $this->request->get('uid');
        $unSeenMails = ReceiveMail::find([
            'conditions' => 'isSeen=?1 AND dispatcher_id=?2',
            'bind' => [1 => 0, 2 => $uid],
            'column' => 'id, fromAddress, subject'
        ]);
        $mailList = array();
        foreach($unSeenMails as $unSeenMail)
        {
            $mailList[] = ['id' => $unSeenMail->id, 'fromAddress' => $unSeenMail->fromAddress, 'subject' => $unSeenMail->subject];
        }
        $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        $this->response->send();
        return;
    }

    /**
     * @Get("/getHandlerList")
     */
    public function GetHandlerListAction()
    {
        $handlers = Users::find([
            'conditions' => 'role=?1',
            'bind' => [1 => 'handler']
        ]);
        if($handlers->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0]);
        }
        else
        {
            $handlers_array = array();
            foreach($handlers as $handler)
            {
                $handlers_array[] = ['handler_id' => $handler->id, 'handler_name' => $handler->name];
            }
            $this->response->setJsonContent($handlers_array);
        }
        $this->response->send();
        return;
    }

    /**
     * @Get("/getEmail")
     */
    public function GetEmailAction()
    {
        $id = $this->request->get('id');
        $receiveMail = ReceiveMail::findFirst([
            'conditions' => 'id=?1',
            'bind' => [1 => $id]
        ]);
        if($receiveMail == null)
        {
            $this->response->setJsonContent(['message' => '邮件不存在']);
        }
        else
        {
            $this->response->setJsonContent(['id' => $receiveMail->id, 'subject' => $receiveMail->subject, 'body' => $receiveMail->body, 'fromAddress' => $receiveMail->fromAddress, 'receiveDate' => $receiveMail->receiveDate, 'isAnswered' => $receiveMail->isAnswered, 'isSeen' => $receiveMail->isSeen, 'isDispatched' => $receiveMail->isDispatched, 'handler_id' => $receiveMail->handler_id, 'isHandled' => $receiveMail->isHandled, 'tags' => $receiveMail->tags]);
        }
        $this->response->send();
        return;
    }
}