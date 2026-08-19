<?php

namespace App\Services\Mail;

use App\Services\Mail\TemplateFactory;
use App\Services\Mail\Config as MailConfig;
use Exception;

class Mail
{
    protected $config;

    public function __construct()
    {
        $this->config = new MailConfig;
    }

    public function send($to, $subject, $message)
    {
        $email = \Config\Services::email();

        $config['protocol']   = $this->config->MAIL_PROTO;
        $config['charset']    = $this->config->MAIL_CHARSET;
        $config['wordWrap']   = $this->config->WORD_WRAP;
        $config['SMTPHost']   = $this->config->MAIL_HOST;
        $config['SMTPUser']   = $this->config->MAIL_USER;
        $config['SMTPPass']   = $this->config->MAIL_SECRET;
        $config['SMTPPort']   = $this->config->MAIL_PORT;
        $config['mailType']   = $this->config->MAIL_TYPE;

        if (getenv('CI_ENVIRONMENT') != 'production'){
            $to = $this->config->DEBUGGING_MAIL;
        }
        if (empty($to)){
            throw new Exception('destination email is invalid');
        }

        if($this->config->MAIL_ISACTIVE) {
            $email->initialize($config);

            $email->setFrom($this->config->MAIL_USER, $this->config->MAIL_NAME);
            $email->setTo($to);

            $email->setSubject($subject);
            $email->setMessage($message);

            $email->send(false);
        }
    }

    public function sendMail($type, $to, $data)
    {
        try {
            $template = new TemplateFactory;
            if (method_exists($template, $type)){
                helper('config');
                helper('number');
                if (getenv('CI_ENVIRONMENT') != 'production'){
                    $to = $this->config->DEBUGGING_MAIL;
                }
                if (empty($to)){
                    throw new Exception('destination email is invalid');
                }
                $contact = (array)get_config_group('office');
                $data = array_merge($data, $contact);
                $result = $template->{$type}($data);
                try {
                    $this->send($to, $result['subject'], $result['message']);
                } catch (Exception $err){
                    return false;
                }
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
