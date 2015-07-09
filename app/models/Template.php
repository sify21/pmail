<?php
/**
 * Created by PhpStorm.
 * User: sify
 * Date: 15-7-9
 * Time: 下午4:26
 */

class Template extends Phalcon\Mvc\Model
{
    public $id;
    public $name;
    public $handler_id;
    public $subject;
    public $body;
    public function getSource()
    {
        return 'template';
    }
    /*public function initialize()
    {
        $this->belongsTo('mail_id', 'ReceiveMail', 'mail_id');
    }*/
}