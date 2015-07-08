<?php
/**
 * Created by PhpStorm.
 * User: sify
 * Date: 15-7-8
 * Time: 上午2:48
 */

class User_ReceiveMail extends Phalcon\Mvc\Model
{
    public $id;
    public $user_id;
    public $receiveMail_id;
    public function getSource()
    {
        return 'user_receiveMail';
    }
    /*public function initialize()
    {
        $this->belongsTo('user_id', 'User', 'id');
        $this->belongsTo('receiveMail_id', 'ReceiveMail', 'id');
    }*/
}