<?php
/**
 * Created by PhpStorm.
 * User: sify
 * Date: 15-7-3
 * Time: 下午2:36
 */

class Users extends Phalcon\Mvc\Model
{
    public $id;
    public $name;
    public $password;
    public $role;
    public $created_at;
    public function initialize()
    {
        $this->hasMany('id', 'ReceiveMail', 'dispatcher_id');
        $this->hasMany('id', 'ReplyMail', 'assessor_id');
        $this->hasMany('id', 'ReplyMail', 'handler_id');
    }

    public function getSource()
    {
        return "users";
    }
}