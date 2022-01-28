<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
 
    private $api_key = 'a07edd335755445f5e07bec06eaa2e59';
    private $api_key_secret = '787bb648c1a906eb1011b598ed193702';

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
                    'TemplateID' => 3383440,
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