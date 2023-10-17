<?php
class ResetPw
{
    private $pdo;
    private $mailer;
    private $alert;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnect();
        $this->mailer = new Mailer();
        $this->alert = new Alert();
    }

    public function pwRequest($body)
    {
        $email = $body["email"];
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Something went wrong";
            exit;
        }

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
        $body = $_SERVER["TOKEN_ADD"] . "user/reset-pw?token=" . $token . "&expires=" . strtotime($expires);
        $subject = "Jelszó megváltoztatása!";
        !$user ? "" : $this->mailer->send($email, $body, $subject);


        $this->alert->set("A jelszó megváltoztatásához szükséges linket az e-mail címére küldtük!", "success", "/login");
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
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&pwVerifyProblem=1");
            exit;
        }

        $hashedPw = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE `users` SET `password` = :hashedPw WHERE `users`.`email` = :email;");

        $stmt->bindParam(':hashedPw', $hashedPw);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $stmt = $this->pdo->prepare("UPDATE `password_reset_tokens` SET `isUsed` = '1' WHERE `password_reset_tokens`.`token` = :token;");

        $stmt->bindParam(':token', $token);
        $stmt->execute();

        $this->alert->set("Jelszó megváltoztatása sikeres!", "success", "/login");

    }
}
