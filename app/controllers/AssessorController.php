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
            foreach($unAssessedMails as $mail)
            {
                $id = $mail->id;
                $mail_id = base64_decode( $mail->mail_id );
                $subject = base64_decode( $mail->subject );
                $reply_id = $mail->reply_id;
                $toWhom = $mail->toWhom;
                $replyDate = $mail->replyDate;
                $assessor_id = $mail->assessor_id;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'subject' => $subject, 'reply_id' => $reply_id,
                    'toWhom' => $toWhom, 'replyDate' => $replyDate, 'assessor_id' => $assessor_id];
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
            foreach($assessedMails as $mail)
            {
                $id = $mail->id;
                $mail_id = base64_decode( $mail->mail_id );
                $subject = base64_decode( $mail->subject );
                $reply_id = $mail->reply_id;
                $toWhom = $mail->toWhom;
                $replyDate = $mail->replyDate;
                $assessor_id = $mail->assessor_id;
                $mailList[] = ['id' => $id, 'mail_id' => $mail_id, 'subject' => $subject, 'reply_id' => $reply_id,
                    'toWhom' => $toWhom, 'replyDate' => $replyDate, 'assessor_id' => $assessor_id];
            }
            $this->response->setJsonContent(['count' => count($mailList), 'mailList' => $mailList]);
        }
        $this->response->send();
        return;
    }
}