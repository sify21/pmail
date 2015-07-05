<?php
/**
 * @RoutePrefix("/assessor")
 */

class AssessorController extends Base{
    /**
     * @Get("/getUnAssessed")
     */
    public function GetUnAssessedAction()
    {
        $uid = $this->request->get('uid');
        $unAssessedMails = ReplyMail::find([
            'conditions' => 'isAssessed=?1 AND assessor_id=?2',
            'bind' => [1 => 0, 2 => $uid],
            'column' => 'id, fromAddress, subject, receiveDate'
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
                $mailList[] = ['id' => "{$unAssessedMail->id}", 'fromAddress' => $unAssessedMail->fromAddress, 'subject' => $unAssessedMail->subject, 'receiveDate' => $unAssessedMail->receiveDate];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }

    /**
     * @Get("/getAssessed")
     */
    public function GetAssessedAction()
    {
        $uid = $this->request->get('uid');
        $assessedMails = ReplyMail::find([
            'conditions' => 'isAssessed=?1 AND assessor_id=?2',
            'bind' => [1 => 1, 2 => $uid],
            'column' => 'id, fromAddress, subject, receiveDate'
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
                $mailList[] = ['id' => "{$assessedMail->id}", 'fromAddress' => $assessedMail->fromAddress, 'subject' => $assessedMail->subject, 'receiveDate' => $assessedMail->receiveDate];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }
}