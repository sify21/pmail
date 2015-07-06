<?php
/**
 * @RoutePrefix('/handler')
 */

class HandlerController extends Base{
    /**
     * @Route("/getUnHandled", methods = {"GET", "OPTIONS"})
     */
    public function GetUnHandledAction()
    {
        $unHandledMails = ReceiveMail::find([
            'conditions' => 'isHandled=?1 AND handler_id=?2',
            'bind' => [1 => 0, 2 => $this->session->get('user_id')],
            'column' => 'id, fromAddress, subject, receiveDate'
        ]);
        if($unHandledMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($unHandledMails as $unHandledMail)
            {
                $mailList[] = ['id' => "{$unHandledMail->id}", 'fromAddress' => $unHandledMail->fromAddress, 'subject' => $unHandledMail->subject, 'receiveDate' => $unHandledMail->receiveDate];
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
        $handledMails = ReceiveMail::find([
            'conditions' => 'isHandled=?1 AND handler_id=?2',
            'bind' => [1 => 1, 2 => $this->session->get('user_id')],
            'column' => 'id, fromAddress, subject, receiveDate'
        ]);
        if($handledMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($handledMails as $handledMail)
            {
                $mailList[] = ['id' => $handledMail->id, 'fromAddress' => $handledMail->fromAddress, 'subject' => $handledMail->subject, 'receiveDate' => $handledMail->receiveDate];
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
        $assessors = Users::find([
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
    public function CreateReplyMailActions()
    {
        $info = $this->request->getJsonRawBody();
        if(!isset($info->subject)||!isset($info->body)||!isset($info->toWhom))
        {
            $this->response->setJsonContent(['message' => 'No Data!']);
            $this->response->send();
            return;
        }

    }
}