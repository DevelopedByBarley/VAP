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
        $stmt->bindParam(":adminId", $adminId);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":password", $pw);
        $stmt->bindParam(":createdAt", $createdAt);
        $stmt->execute();
    }

    public function loginAdmin($body)
    {
        session_start();
        $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $pw = filter_var($body["password"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt = $this->pdo->prepare("SELECT * FROM `admins` WHERE `name` = :name");
        $stmt->bindParam(":name", $name);
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

        header("Location: /admin/registrations");
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
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$user || count($user) === 0) {
            $this->alert->set("Hibás email vagy jelszó",  "Email or password is wrong", null, "danger", "/login");
        }

        $isVerified = password_verify($pw, $user["password"]);

        if (!$isVerified) {
            $this->alert->set("Hibás email vagy jelszó", "Email or password is wrong", null, "danger", "/login");
        }

        if ($user["isActivated"] !== 1) {
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


    public function activateRegister()
    {
        
        $code = $_GET["code"] ?? null;

        if (!$code) {
            header('Location: /');
        }

        try {
            // Ellenőrizze, hogy van-e olyan rekord, amelynek az isActivated értéke 0, és az activation_code megegyezik a kóddal
            $checkStmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `isActivated` = 0 AND `activation_code` = :activation_code");
            $checkStmt->bindParam(':activation_code', $code);
            $checkStmt->execute();

            $rowCount = $checkStmt->rowCount();

            if ($rowCount > 0) {
                // Van ilyen rekord, tehát folytathatja az aktiválást
                $updateStmt = $this->pdo->prepare("UPDATE `users` SET `isActivated` = '1', `activation_code` = NULL WHERE `isActivated` = 0 AND `activation_code` = :activation_code");
                $updateStmt->bindParam(':activation_code', $code);
                $updateStmt->execute();

                // Sikeres aktiválás üzenet beállítása
                $this->alert->set("Regisztráció sikeresen aktiválva!", "Registration is successfully activated!", null, "success", "/login");
            } else {
                // Nincs ilyen rekord, így hibát jelenthet
                $this->alert->set("Hiba a regisztráció aktiválása közben!", "Error while activating the registration!", null, "danger", "/");
            }
        } catch (PDOException $e) {
            // Hiba kezelése
            $this->alert->set("Hiba történt az aktiválás során: " . $e->getMessage(), "Error occurred during activation: " . $e->getMessage(), null, "danger", "/");
        }
    }
}
