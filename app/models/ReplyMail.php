<?php
/**
 * Created by PhpStorm.
 * User: sify
 * Date: 15-7-3
 * Time: 下午6:50
 */

class ReplyMail extends Phalcon\Mvc\Model
{
    public $id;
    public $mail_id;
    public $subject;
    public $body;
    public $reply_id;//回复的原邮件的id
    public $toWhom;
    public $replyDate;
    public $assessor_advice;
    public $status;
    public $handler_id;
    public $assessor_id;
    public function initialize()
    {
        $this->belongsTo('handler_id','User','id');
        $this->belongsTo('assessor_id','User','id');
    }

    public function getSource()
    {
        return "replyMail";
    }
}