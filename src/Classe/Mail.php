<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{

    private $api_key;

    private $api_key_secret;

    public function __construct() {
        $this->api_key = $_ENV['MAILJET_KEY'];
        $this->api_key_secret = $_ENV['MAILJET_KEY_SECRET'];
    }

    public function send($to_email, $to_name, $subject, $content)
    {
            $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);

                
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "contact@stc-immobilier.fr",
                        'Name' => "STC"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name,
                        ]
                    ],
                    'TemplateID' => 3534050,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                    'content' => $content,
                
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]); 
        $response->success();
        
        
    }

}