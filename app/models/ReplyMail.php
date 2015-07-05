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
    public $subject;
    public $body;
    public $toWhom;
    public $replyDate;
    public $handler_id;
    public $isSend;
    public $assessor_id;//此字段为空表示在处理人手中，不为空表示在审核人手中，处理人每次递交审核都要选一次审核人
    public $isAssessed;
    public $assessor_advice;
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