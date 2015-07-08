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
        $uid = $this->request->get('uid');
        //$uid = $this->session->get('user_id');
        $unHandledMails = ReceiveMail::find([
            'conditions' => 'status=?1 AND handler_id=?2',
            'bind' => [1 => 1, 2 => $uid],
            'column' => 'id, mail_id, fromAddress, subject, receiveDate'
        ]);
        if($unHandledMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'uid' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($unHandledMails as $mail)
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
     * @Route("/getAssessed", methods = {"GET", "OPTIONS"})
     */
    public function GetAssessedAction()
    {

    }

    /**
     * @Route("/getUnAssessed", methods = {"GET", "OPTIONS"})
     */
    public function GetUnAssessedAction()
    {

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