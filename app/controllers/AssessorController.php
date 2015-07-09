<?php
/**
 * @RoutePrefix("/assessor")
 */

class AssessorController extends Base{
    /**
     * @Route("/getMailList", methods = {"GET", "OPTIONS"})
     */
    public function GetMailListAction()//获取邮件列表，0=已发送，1=待审核，2=退回审核，3=审核通过
    {
        $uid = $this->request->get('uid');
        //$uid = $this->session->get('user_id');
        $status = $this->request->get('status');
        $unAssessedMails = ReplyMail::find([
            'conditions' => 'status=?1 AND assessor_id=?2',
            'bind' => [1 => $status, 2 => $uid],
            'column' => 'id, mail_id, subject, reply_id, toWhom, replyDate, assessor_advice, status, assessor_id, handler_id'
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
     * @Route("/send", methods = {"PUT", "OPTIONS"})
     */
    public function SendAction()
    {
        $info = $this->request->getJsonRawBody();
        if(!isset($info->id))
        {
            $this->response->setJsonContent(['message' => 'No Email Id Set!']);
        }
        else
        {
            $message = Utils::sendMail($info->id);
            $this->response->setJsonContent(['message' => $message]);
        }
        $this->response->send();
        return;
    }
}