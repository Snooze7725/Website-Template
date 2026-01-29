<?php
namespace Core\Controllers;

class AuthenticationController {
    /**
     * Just checks if a username is available.
     *
     * @param \mysqli $mysqli The mysqli connection obj.
     * @param string $username The entered username.
     * @param string $type The entered type of data the data is being looked through.
     * @return \mysqli_result The result of the query.
     */
    private function checkDataAvailab(\mysqli $mysqli, string $username, string $type): \mysqli_result {
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE ? = ? LIMIT ?");
        $stmt->bind_param("ss", $type, $username);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Just checks if a username is available.
     *
     * @param \mysqli $mysqli The mysqli connection obj.
     * @param string $username The entered username.
     * @param string $email The entered email.
     * @param string $password The entered password.
     * @return bool The result of the query.
     */
    private function insertNewUser(\mysqli $mysqli, string $username, string $email, string $password): bool {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        return $stmt->execute();
    }

    /**
     * Just checks if a username is available.
     *
     * @param \mysqli $mysqli The mysqli connection obj.
     * @param array $post The post data.
     * @param array &$session The session data.
     * @param string $page The page chosen for the controller.
     * @return voids
     * 
     */
    function signupUser(\mysqli $mysqli, array $post, array &$session, string $page): void {
        if (isset($session['user'])) {
            header("Location: /");
            exit();
        }

        $result = $this->checkDataAvailab($mysqli, $post["username"], "username");
        if ($result->num_rows > 0) {
            header("Location: /error?error=username_taken");
            exit();
        }

        $result = $this->checkDataAvailab($mysqli, $post["email"], "email");
        if ($result->num_rows > 0) {
            header("Location: /error?error=email_taken");
            exit();
        }

        $this->insertNewUser($mysqli, $post["username"], $post["email"], $post["password"]);

        $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $post["username"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $session['userId'] = $result->fetch_assoc()['id'];
        $session['user'] = $post["username"];
        $session['email'] = $post["email"];

        require_once __DIR__ . "/../views/pages/" . $page;
    }
}