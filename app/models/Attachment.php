<?php
/**
 * Created by PhpStorm.
 * User: sify
 * Date: 15-7-8
 * Time: 上午2:45
 */

class Attachment extends Phalcon\Mvc\Model
{
    public $id;
    public $mail_id;
    public $attachment_id;
    public $attachment_name;
    public $file_name;
    public function getSource()
    {
        return 'attachment';
    }
    /*public function initialize()
    {
        $this->belongsTo('mail_id', 'ReceiveMail', 'mail_id');
    }*/
}