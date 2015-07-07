<?php
/**
 * Created by PhpStorm.
 * User: sify
 * Date: 15-7-3
 * Time: 下午6:28
 * models 只支持最简单的与数据库表名的对应，所以最好用getSource方法指定对应的表名
 * 多写几句话总比少些几句话好点
 */

class ReceiveMail extends Phalcon\Mvc\Model
{
    public $id;
    public $mail_id;
    public $subject;
    public $body;
    public $fromAddress;
    public $receiveDate;
    public $tags;
    public $status;
    public $dispatcher_id;
    public $handler_id;
    public function initialize()
    {
        $this->belongsTo('dispatcher_id','User','id');
        $this->hasMany('mail_id', 'Attachment', 'mail_id');
    }

    public function getSource()
    {
        return "receiveMail";
    }
}