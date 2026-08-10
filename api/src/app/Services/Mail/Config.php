<?php

namespace App\Services\Mail;

use CodeIgniter\Config\BaseConfig;

class Config extends BaseConfig
{
    public $MAIL_NAME   = 'Star Community';
    public $MAIL_ISACTIVE = true;

    public $MAIL_USER   = 'starcom.official88@gmail.com';
    public $MAIL_SECRET = 'xxwguqycylbrilqx';

    public $MAIL_HOST    = 'smtp.gmail.com';
    public $MAIL_PROTO   = 'smtp';
    public $MAIL_CHARSET = 'utf-8';
    public $MAIL_PORT    = 587;
    public $MAIL_SECURE = true;

    public $MAIL_TYPE   = 'html';
    public $WORD_WRAP   = true;
    
    public $DEBUGGING_MAIL = 'sakuratadevapp@gmail.com';
}
