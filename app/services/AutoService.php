<?php

namespace services;
use Random\RandomException;
use utils\TemplateFacade;
use repository\UserRepository;

require_once __UTILS__ . '\TemplateFacade.php';

class AutoService
{
    private TemplateFacade $templateFacade;
    private UserRepository $userRepository;
    public function __construct(TemplateFacade $templateFacade, UserRepository $userRepository
                                )
    {
        $this->templateFacade = $templateFacade;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Exception
     */
    public function handleAutoPage(): string
    {
        return $this->templateFacade->render(__TEMPLATES__ .'\auto.html', []);
    }

    /**
     * @throws RandomException
     */
    public function searchUser(): void
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            exit;
        }

        $email = $data['email'];
        $password = $data['password'];
        $remember = $data['rememberMe'];

        $dataUser = $this->userRepository->read(['email' => $email]);

        if (!$dataUser || ($password !== $dataUser[0]['passwordHash'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
            exit;
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start([
                'cookie_secure' => true,
                'cookie_httponly' => true,
                'cookie_samesite' => 'Strict'
            ]);
            session_regenerate_id(true);
        }

        $_SESSION['username'] = $dataUser[0]['userName'];
        $_SESSION['email'] = $dataUser[0]['email'];
        $_SESSION['id'] = $dataUser[0]['idUser'];

        if (!empty($remember)) {
            $token = bin2hex(random_bytes(32));
            $this->userRepository->updateToken($dataUser[0]['idUser'], $token);

            // Устанавливаем куку на 30 дней
            setcookie('remember_token', $token, [
                'expires' => time() + 86400 * 30,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
        }

        echo json_encode(['success' => true, 'redirect' => '/']);
        exit();
    }

    /*
    public function checkAuth(): bool
    {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start([
                'cookie_lifetime' => 86400 * 30, // 30 дней
                'cookie_secure' => true,
                'cookie_httponly' => true,
                'cookie_samesite' => 'Strict',
                'read_and_close' => false
            ]);
            session_regenerate_id(true);
        } else{
            if(!empty($_SESSION['token'])){
                return true;
            }
        }


        if (!empty($_SESSION['email'])) {
            return true;
        }

        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            $user = $this->userRepository->getByToken($token);

            if ($user) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start([
                        'cookie_secure' => true,
                        'cookie_httponly' => true,
                        'cookie_samesite' => 'Strict'
                    ]);
                    session_regenerate_id(true);
                }

                $_SESSION = [
                    'username' => $user['userName'],
                    'email' => $user['email'],
                    'id' => $user['idUser']
                ];


                $newToken = bin2hex(random_bytes(32));
                $this->userRepository->updateToken($user['idUser'], $newToken);

                setcookie('remember_token', $newToken, [
                    'expires' => time() + 86400 * 30,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);

                return true;
            }

        }

        return false;
    }
        */


    public function checkAuth(): bool
    {
        if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION['id'])) {
            return true;
        }
        

        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            $user = $this->userRepository->getByToken($token);

            if ($user) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start([
                        'cookie_secure' => true,
                        'cookie_httponly' => true,
                        'cookie_samesite' => 'Strict'
                    ]);
                    session_regenerate_id(true);
                }

                $_SESSION = [
                    'username' => $user->userName,
                    'email' => $user->email,
                    'id' => $user->idUser
                ];

                $newToken = bin2hex(random_bytes(32));
                $this->userRepository->updateToken($user->idUser, $newToken);

                setcookie('remember_token', $newToken, [
                    'expires' => time() + 86400 * 30,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);

                return true;
            }
        }

        return false;
    }


    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');

        echo json_encode(['redirect' => '/authorization']);
        exit();
    }
}