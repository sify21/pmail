<?php
/**
 * @RoutePrefix("/assessor")
 */

class AssessorController extends Base{
    /**
     * @Route("/getUnAssessed", methods = {"GET", "OPTIONS"})
     */
    public function GetUnAssessedAction()
    {
        $uid = $this->request->get('uid');
        //$uid = $this->session->get('user_id');
        $unAssessedMails = ReplyMail::find([
            'conditions' => 'status=?1 AND assessor_id=?2',
            'bind' => [1 => 1, 2 => $uid],
            'column' => 'id, mail_id, fromAddress, subject, receiveDate'
        ]);
        if($unAssessedMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'user_id' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($unAssessedMails as $unAssessedMail)
            {
                $id = $unAssessedMail->id;
                $mail_id = base64_decode( $unAssessedMail->mail_id );
                $fromAddress = $unAssessedMail->fromAddress;
                $subject = base64_decode( $unAssessedMail->subject );
                $receiveDate = $unAssessedMail->receiveDate;
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
        $uid = $this->request->get('uid');
        //$uid = $this->session->get('user_id');
        $assessedMails = ReplyMail::find([
            'conditions' => 'status=?1 AND assessor_id=?2',
            'bind' => [1 => 0, 2 => $uid],
            'column' => 'id, mail_id, fromAddress, subject, receiveDate'
        ]);
        if($assessedMails->getFirst() == null)
        {
            $this->response->setJsonContent(['count' => 0, 'user_id' => $this->session->get('user_id')]);
        }
        else
        {
            $mailList = array();
            foreach($assessedMails as $assessedMail)
            {
                $id = $assessedMail->id;
                $mail_id = base64_decode( $assessedMail->mail_id );
                $fromAddress = $assessedMail->fromAddress;
                $subject = base64_decode( $assessedMail->subject );
                $receiveDate = $assessedMail->receiveDate;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'fromAddress' => $fromAddress, 'subject' => $subject, 'receiveDate' => $receiveDate];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }
}