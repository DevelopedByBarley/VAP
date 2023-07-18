<?php
class AuthService
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
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














    public function registerUser($body)
    {

        $userId = uniqid();
        $name = filter_var($body["name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($body["email"] ?? '', FILTER_SANITIZE_EMAIL);
        $pw = password_hash(filter_var($body["password"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS), PASSWORD_DEFAULT);
        $address = filter_var($body["address"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $mobile = filter_var($body["mobile"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $profession = filter_var($body["profession"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $school_name = filter_var($body["school_name"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $programs = filter_var(PROGRAMS[$body["programs"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $english = filter_var($body["english"] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $germany = filter_var($body["germany"] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $italy = filter_var($body["italy"] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $serbian = filter_var($body["serbian"] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $otherLanguages = filter_var($body["other_languages"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $participation = filter_var($body["participation"] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $task = filter_var(TASK_AREAS[$body["tasks"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $informedBy = filter_var(INFORMED_BY[$body["informed_by"]]["Hu"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $permission = filter_var((isset($body["permission"]) && $body["permission"] === 'on') ? 1 : 0, FILTER_SANITIZE_NUMBER_INT);
        $createdAt = time();



        $isUserExist = self::checkIsUserExist($email);

        if ($isUserExist) {
            echo "User exist";
        }


        // INSERT parancs előkészítése
        $stmt = $this->pdo->prepare("INSERT INTO users VALUES 
        (NULL, 
        :userId, 
        :name, 
        :email, 
        :password, 
        :address, 
        :mobile, 
        :profession, 
        :schoolName, 
        :programs, 
        :english, 
        :germany, 
        :italy, 
        :serbian, 
        :otherLanguages, 
        :participation, 
        :tasks, 
        :informedBy, 
        :permission, 
        :createdAt)");

        // Paraméterek kötése
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $pw);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':profession', $profession);
        $stmt->bindParam(':schoolName', $school_name);
        $stmt->bindParam(':programs', $programs);
        $stmt->bindParam(':english', $english);
        $stmt->bindParam(':germany', $germany);
        $stmt->bindParam(':italy', $italy);
        $stmt->bindParam(':serbian', $serbian);
        $stmt->bindParam(':otherLanguages', $otherLanguages);
        $stmt->bindParam(':participation', $participation);
        $stmt->bindParam(':tasks', $task);
        $stmt->bindParam(':informedBy', $informedBy);
        $stmt->bindParam(':permission', $permission);
        $stmt->bindParam(':createdAt', $createdAt);

        // INSERT parancs végrehajtása
        $stmt->execute();

        if ($this->pdo->lastInsertId()) {
            header("Location: /");
        }
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
            $_SESSION["alert"] = [
                "bg" => "red",
                "message" => "Hibás email vagy jelszó!"
            ];
        
            
            header("Location: /login");
            return;
        }

        $isVerified = password_verify($pw, $user["password"]);

        if (!$isVerified) {
            $_SESSION["alert"] = [
                "bg" => "red",
                "message" => "Hibás email vagy jelszó!"
            ];
            header("Location: /login");
            return;
        }

        $_SESSION["userId"] = $user["userId"];

        header("Location: /user/dashboard");
    }

    public function logoutUser()
    {
        session_start();
        session_destroy();

        $cookieParams = session_get_cookie_params();
        setcookie(session_name(), "", 0, $cookieParams["path"], $cookieParams["domain"], $cookieParams["secure"], isset($cookieParams["httponly"]));


        header("Location: /");
    }




    private  function checkIsUserExist($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `email` = :email");

        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && !empty($user)) {
            return true;
        }

        return false;
    }
}
