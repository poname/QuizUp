<?php

namespace QUIZUP\Libraries;

use Phalcon\Mvc\User\Component;
use QUIZUP\Libraries\Exceptions\AuthException;
use QUIZUP\Models\User;
use QUIZUP\Models\UserRememberTokens;
use QUIZUP\Models\UserSuccessLogin;
use QUIZUP\Models\UserFailedLogin;

/**
 * QUIZUP\Libraries\Auth
 * Manages Authentication/Identity Management in QUIZUP
 */
class Auth extends Component
{

    /**
     * Checks the user credentials
     *
     * @param array $credentials
     * @return boolean
     * @throws AuthException
     */
    public function check($credentials)
    {

        // Check if the user exist
        $user = User::findFirstByEmail($credentials['email']);
        if ($user == false) {
            $this->registerUserThrottling(0);
            throw new AuthException('WRONG_EMAIL_PASSWORD_COMBINATION');
        }

        // Check the password
        if (!$this->security->checkHash($credentials['password'], $user->getPassword())) {
            $this->registerUserThrottling($user->getId());
            throw new AuthException('WRONG_EMAIL_PASSWORD_COMBINATION');
        }
        // Check if the user was flagged
        $this->checkUserFlags($user);

        // Register the successful login
        $this->saveSuccessLogin($user);

        // Check if the remember me was selected
        if (isset($credentials['remember'])) {
            $this->createRememberEnviroment($user);
        }

        $this->session->set('auth-identity', array(
            'id' => $user->getId(),
            'name' => $user->getName()
        ));
    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     * @param User $user
     * @throws AuthException
     */
    public function saveSuccessLogin($user)
    {
        $successLogin = new UserSuccessLogin();
        $successLogin->setUserId($user->getId());
        $successLogin->setIp($this->request->getClientAddress());
        $successLogin->setUserAgent($this->request->getUserAgent());
        if (!$successLogin->save()) {
            $messages = $successLogin->getMessages();
            throw new AuthException($messages[0]);
        }
    }

    /**
     * Implements login throttling
     * Reduces the efectiveness of brute force attacks
     *
     * @param int $userId
     */
    public function registerUserThrottling($userId)
    {
        $failedLogin = new UserFailedLogin();
        $failedLogin->setUserId($userId);
        $failedLogin->setIpAddress($this->request->getClientAddress());
        $failedLogin->setAttempted(time());
        $failedLogin->save();

        $attempts = UserFailedLogin::count(array(
            'ip_address = ?0 AND attempted >= ?1',
            'bind' => array(
                $this->request->getClientAddress(),
                time() - 3600 * 6
            )
        ));

        switch ($attempts) {
            case 1:
            case 2:
                // no delay
                break;
            case 3:
            case 4:
                sleep(2);
                break;
            default:
                sleep(4);
                break;
        }
    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     * @param User $user
     */
    public function createRememberEnviroment(User $user)
    {
        $userAgent = $this->request->getUserAgent();
        $token = md5($user->getEmail() . $user->getPassword() . $userAgent);

        $remember = new UserRememberTokens();
        $remember->setUserId($user->getId());
        $remember->setToken($token);
        $remember->setUserAgent($userAgent);
        $remember->setCreatedAt(time());

        if ($remember->save() != false) {
            $expire = time() + 86400 * 8;
            $this->cookies->set('RMU', $user->getId(), $expire);
            $this->cookies->set('RMT', $token, $expire);
        }else{
            var_dump($remember->getMessages());die();
        }
    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        return $this->cookies->has('RMU');
    }

    /**
     * Logs on using the information in the coookies
     *
     * @return Phalcon\Http\Response
     */
    public function loginWithRememberMe()
    {
        $userId = $this->cookies->get('RMU')->getValue();
        $cookieToken = $this->cookies->get('RMT')->getValue();

        $user = User::findFirstById($userId);
        if ($user) {

            $userAgent = $this->request->getUserAgent();
            $token = md5($user->getEmail() . $user->getPassword() . $userAgent);

            if ($cookieToken == $token) {

                $remember = UserRememberTokens::findFirst(array(
                    'usersId = ?0 AND token = ?1',
                    'bind' => array(
                        $user->getId(),
                        $token
                    )
                ));
                if ($remember) {

                    // Check if the cookie has not expired
                    if ((time() - (86400 * 8)) < $remember->getCreatedAt()) {

                        // Check if the user was flagged
                        $this->checkUserFlags($user);

                        // Register identity
                        $this->session->set('auth-identity', array(
                            'id' => $user->getId(),
                            'name' => $user->getName()
                        ));

                        // Register the successful login
                        $this->saveSuccessLogin($user);

//                        return $this->response->redirect('users');
                        return true;
                    }
                }
            }
        }

        $this->cookies->get('RMU')->delete();
        $this->cookies->get('RMT')->delete();

//        return $this->response->redirect('session/login');
        return false;
    }

    /**
     * Checks if the user is banned/inactive/suspended
     *
     * @param User $user
     * @throws AuthException
     */
    public function checkUserFlags(User $user)
    {
        if ($user->getActive() != 'Y') {
            throw new AuthException('THIS_USER_IS_INACTIVE');
        }

        if ($user->getBanned() != 'N') {
            throw new AuthException('THIS_USER_IS_BANNED');
        }

        if ($user->getSuspended() != 'N') {
            throw new AuthException('THIS_USER_IS_SUSPENDED');
        }
    }

    /**
     * Returns the current identity
     *
     * @return array
     */
    public function getIdentity()
    {
        return $this->session->get('auth-identity');
    }

    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getName()
    {
        $identity = $this->session->get('auth-identity');
        return $identity['name'];
    }

    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
        if ($this->cookies->has('RMU')) {
            $this->cookies->get('RMU')->delete();
        }
        if ($this->cookies->has('RMT')) {
            $this->cookies->get('RMT')->delete();
        }

        $this->session->remove('auth-identity');
    }

    /**
     * Auths txhe user by his/her id
     *
     * @param int $id
     * @throws AuthException
     */
    public function authUserById($id)
    {
        $user = User::findFirstById($id);
        if ($user == false) {
            throw new AuthException('THIS_USER_DOES_NOT_EXIST');
        }

        $this->checkUserFlags($user);

        $this->session->set('auth-identity', array(
            'id' => $user->getId(),
            'name' => $user->getName()
        ));
    }

    /**
     * Get the entity related to user in the active identity
     * @return User
     * @throws AuthException
     */
    public function getUser()
    {
        $identity = $this->session->get('auth-identity');
        if (isset($identity['id'])) {

            $user = User::findFirstById($identity['id']);
            if ($user == false) {
                throw new AuthException('THIS_USER_DOES_NOT_EXIST');
            }

            return $user;
        }

        return false;
    }
}