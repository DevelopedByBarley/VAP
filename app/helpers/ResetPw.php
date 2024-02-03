<?php
require_once 'app/helpers/Alert.php';
require_once 'app/helpers/Validate.php';

class ResetPw
{
    private $pdo;
    private $mailer;
    private $alert;
    private $validator;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnect();
        $this->mailer = new Mailer();
        $this->alert = new Alert();
        $this->validator = new Validator();
    }
    
    public function pwRequest($body)
    {
        session_start();
        
        $url = $_SERVER["REFERER"];
        $email = $body["email"];

        
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $token = uniqid();
        $current_time = time();
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes', $current_time));


        $stmt = $this->pdo->prepare("INSERT INTO 
        `password_reset_tokens` 
        (`tokenId`, 
        `email`, 
        `token`, 
        `expires`, 
        `isUsed`, 
        `createdAt`)
        VALUES 
        (NULL, 
        :email, 
        :token, 
        :expires, 
        '0',
        current_timestamp());");



        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires', $expires);

        $stmt->execute();



        $body = "$url/user/reset-pw?token=" . $token . "&expires=" . strtotime($expires);
        $subject = "Jelszó megváltoztatása!";
        !$user ? "" : $this->mailer->send($email, $body, $subject);

        if (isset($_SESSION["forgotPwFormErrors"])) unset($_SESSION["forgotPwFormErrors"]);
        $this->alert->set('A jelszó változtatásához szükséges levelet az e-mail címére küldtük', 'The letter to change the password has been sent to your e-mail address', null, "success", "/login");
    }


   


    public function checkTokenData($token)
    {


        $stmt = $this->pdo->prepare("SELECT * FROM `password_reset_tokens` WHERE token = :token AND isUsed = 0");

        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $token = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$token) {
            return false;
        }

        $currentDate = time();
        $expires = strtotime($token["expires"]);

        if ($currentDate > $expires) {

            return false;
        }

        return $token["email"];
    }

    public function newPw($body)
    {
        $password = $body["password"];
        $password_repeat = $body["password-repeat"];
        $email = $body["email"];
        $token = $body["token"];



        if ($password !== $password_repeat) {
            $this->alert->set('A jelszavak nem egyeznek', "The passwords are not the same", null, "danger", $_SERVER['HTTP_REFERER']);
        }

        $hashedPw = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE `users` SET `password` = :hashedPw WHERE `users`.`email` = :email;");

        $stmt->bindParam(':hashedPw', $hashedPw);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $stmt = $this->pdo->prepare("UPDATE `password_reset_tokens` SET `isUsed` = '1' WHERE `password_reset_tokens`.`token` = :token;");

        $stmt->bindParam(':token', $token);
        $stmt->execute();


        $this->alert->set('Új jelszó sikeresen beállítva!', 'New password successfully set!', null, "success", "/login");
    }
}
