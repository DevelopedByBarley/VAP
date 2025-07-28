<?php
require_once 'app/helpers/Alert.php';

class AuthService
{
    private $pdo;
    private $alert;


    public function __construct()
    {
        $db = new Database();
        $this->alert = new Alert();
        $this->pdo = $db->getConnect();
    }


    public function registerAdmin($body)
    {
        $adminId = uniqid();
        $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $pw = password_hash(filter_var($body["password"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS), PASSWORD_DEFAULT);
        $createdAt = time();

        $stmt = $this->pdo->prepare("INSERT INTO `admins` (`id`, `adminId`, `name`, `password`, `createdAt`) VALUES (NULL, :adminId, :name, :password, :createdAt)");
        $stmt->bindParam(":adminId", $adminId, PDO::PARAM_STR);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":password", $pw, PDO::PARAM_STR);
        $stmt->bindParam(":createdAt", $createdAt, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function loginAdmin($body)
    {
        session_start();
        $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $pw = filter_var($body["password"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt = $this->pdo->prepare("SELECT * FROM `admins` WHERE `name` = :name");
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$admin || count($admin) === 0) {
            header("Location: /admin");
        }

        $isVerified = password_verify($pw, $admin["password"]);


        if (!$isVerified) {
            header("Location: /admin");
            exit;
        }

        $_SESSION["adminId"] = $admin["adminId"];

        header("Location: /admin/dashboard");
    }

    public function logoutAdmin()
    {
        session_start();
        session_destroy();

        $cookieParams = session_get_cookie_params();
        setcookie(session_name(), "", 0, $cookieParams["path"], $cookieParams["domain"], $cookieParams["secure"], isset($cookieParams["httponly"]));


        header("Location: /admin");
    }

    public function loginUser($body)
    {
        session_start();
        $email = filter_var($body["email"] ?? '', FILTER_SANITIZE_EMAIL);
        $pw = filter_var($body["password"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$user || count($user) === 0) {
            $this->alert->set("Hibás email vagy jelszó",  "Email or password is wrong", null, "danger", "/login");
        }

        $isVerified = password_verify($pw, $user["password"]);

        if (!$isVerified) {
            $this->alert->set("Hibás email vagy jelszó", "Email or password is wrong", null, "danger", "/login");
        }

        if ((int)$user["isActivated"] !== 1) {
            $this->alert->set("Hibás email vagy jelszó", "Email or password is wrong", null, "danger", "/login");
        }

        $_SESSION["userId"] = $user["id"];

        header("Location: /user/dashboard");
    }

    public function logoutUser()
    {
        session_start();
        session_destroy();

        $cookieParams = session_get_cookie_params();
        setcookie(session_name(), "", 0, $cookieParams["path"], $cookieParams["domain"], $cookieParams["secure"], isset($cookieParams["httponly"]));

        $referer = $_SERVER['HTTP_REFERER'];


        header("Location: " . $referer);
    }
}
