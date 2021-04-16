<?php

namespace CodeCourse\Repositories;

use CodeCourse\Repositories\Database as Database;
use PDO;
use PDOException;

/**
 * User class
 */
class User
{
    private $conn;
    /**
     * Constructor
     */
    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
    /**
     * Prepare a query
     *
     * @param string $sql
     *
     * @return void
     */
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
    /**
     * Will fetch the last inserted Id
     *
     * @return void
     */
    public function lasdID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }
    /**
     * Will register a user
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $upass
     * @param string $code
     *
     * @return void
     */
    public function register($firstName, $lastName, $email, $upass, $code)
    {
        try {
            $password = md5($upass);
            $stmt = $this->conn->prepare('INSERT INTO tbl_users(firstName,lastName,userEmail,userPass,tokenCode) VALUES(:firstName,:lastName, :user_mail, :user_pass, :active_code)');
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':user_mail', $email);
            $stmt->bindParam(':user_pass', $password);
            $stmt->bindParam(':active_code', $code);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    /**
     * Login method
     *
     * @param string $email
     * @param string $upass
     *
     * @return void
     */
    public function login($email, $upass)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM tbl_users WHERE userEmail=:email_id');
            $stmt->execute(array(':email_id' => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() == 1) {
                if ($userRow['userStatus'] == 'Y') {
                    if ($userRow['userPass'] == md5($upass)) {
                        $_SESSION['userSession'] = $userRow['userID'];
                        return true;
                    } else {
                        header('Location: ../../../login/index.php?error');
                        exit;
                    }
                } else {
                    header('Location: ../../../login/index.php?inactive');
                    exit;
                }
            } else {
                header('Location: index.php?error');
                exit;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    /**
     * Will check if a user is logged in
     *
     * @return boolean
     */
    public function is_logged_in()
    {
        if (isset($_SESSION['userSession'])) {
            return true;
        }
    }
    /**
     * Will redirect a user
     *
     * @param string $url
     *
     * @return void
     */
    public function redirect($url)
    {
        header("Location: $url");
    }
    /**
     * Will log out a user
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }
    /**
     * Email verification
     *
     * @param string $email
     * @param string $message
     * @param string $subject
     *
     * @return void
     */
    public function send_mail($email, $message, $subject)
    {
        //require_once 'mailer/class.phpMailer.php';
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->AddAddress($email);
        // $mail->Username="your_gmail_id_here@gmail.com";
        // $mail->Password="your_gmail_password_here";
        // $mail->SetFrom('your_gmail_id_here@gmail.com','Coding Cage');
        // $mail->AddReplyTo("your_gmail_id_here@gmail.com","Coding Cage");
        $mail->Username = 'paul.bishwajit09@gmail.com';
        $mail->Password = 'B.66129.Paul';
        $mail->SetFrom('paul.bishwajit09@gmail.com', 'Aroma');
        $mail->AddReplyTo('paul.bishwajit09@gmail.com', 'Aroma');
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }
}
