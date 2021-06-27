<?php 
    require_once(__DIR__ . '/vendor/autoload.php');
    use \Mailjet\Resources;
    define('API_PUBLIC_KEY', '96f1428f9b5bb441f493ae6772ab85ed');
    define('API_PRIVATE_KEY', '6349a5bd5b348b293427106509a471dd');
    $mj = new \Mailjet\Client(API_PUBLIC_KEY, API_PRIVATE_KEY,true,['version' => 'v3.1']);


    if(!empty($_POST['surname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['message'])){
        $surname = htmlspecialchars($_POST['surname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "frigeurv10@gmail.com",
                'Name' => "Mailjet"
                ],
                'To' => [
                [
                    'Email' => "frigeurv10@gmail.com",
                    'Name' => "Mailjet"
                ]
                ],
                'Subject' => "Information Request from \"$surname $firstname\"",
                'TextPart' => "User email:$email, Message: $message", 
                //'HTMLPart' => "TEXT EMAIL",
                'CustomID' => "AppGettingStartedTest"
            ]
            ]
        ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success();
            echo "Email envoyé avec succès !";
        }
        else{
            echo "Email non valide";
        }

    }

?>

<!--
/*

If error wih sending email
open vendor\guzzlehttp\guzzle\src\Handler\CurlFactory.php
and change this

$conf[CURLOPT_SSL_VERIFYHOST] = 2;
$conf[CURLOPT_SSL_VERIFYPEER] = true;

to this

$conf[CURLOPT_SSL_VERIFYHOST] = 0;
$conf[CURLOPT_SSL_VERIFYPEER] = FALSE;

source : "https://stackoverflow.com/questions/35638497/curl-error-60-ssl-certificate-prblm-unable-to-get-local-issuer-certificate"

-->