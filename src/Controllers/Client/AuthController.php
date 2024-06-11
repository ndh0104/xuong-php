<?php

namespace Duchuy\Php2\Controllers\Client;

use Exception;
use Duchuy\Php2\Commons\Controller;
use Duchuy\Php2\Commons\Helper;
use Duchuy\Php2\Models\User;
use Rakit\Validation\Validator;

class AuthController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function showFormLogin()
    {
        avoid_login();
        $this->renderViewClient('auth.login');
    }

    public function handleLogin()
    {
        avoid_login();
        try {
            $user = $this->user->findByEmail($_POST['email']);

            // Helper::debug($user);


            if (empty($user)) {
                throw new Exception('Không tồn tại email, vui lòng kiểm tra lại');
            }

            $flag = password_verify($_POST['password'], $user['password']);
            if ($flag) {
                $_SESSION['user'] = $user;

                unset($_SESSION['cart']);

                if ($user['type'] == 'admin') {
                    header('Location: ' . url('admin/'));
                    exit;
                }
                header('Location: ' . url(''));
                exit();
            }

            throw new \Exception('Mật khẩu không đúng, vui lòng thử lại');
        } catch (\Throwable $th) {
            $_SESSION['errors'] = $th->getMessage();
            redirect('login');
            exit();
        }
    }

    public function authRegister()
    {
        $this->renderViewClient('auth.register');
    }

    public function handleRegister()
    {
        if (!empty($_POST)) {

            $validator = new Validator();

            $validation = $validator->make($_POST, [
                'name' => 'required|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6',
                // 'confirm-password' => 'required|same:password',
            ]);

            $validation->validate();

            if ($validation->fails()) {
                $_SESSION['errors'] = $validation->errors()->firstOfAll();
                $_SESSION['data'] = $_POST;
                redirect('register');
                exit();
            }

            try {

                $activeToken = sha1(uniqid() . time());

                $data = [
                    'name' => $_POST['name'] ?? null,
                    'email' => $_POST['email'] ?? null,
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'active_token' => $activeToken,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                if ($data) {
                    $this->user->insert($data);

                    $linkActive = url('') . 'active-account/token/' . $activeToken;

                    $subject = $data['name'] . ' ' . 'Vui lòng kích hoạt tài khoản của bạn!';
                    $content = 'Chào ' . $data['name'] . PHP_EOL;
                    $content .= 'Vui lòng kích vào link dưới đây để kích hoạt tài khoản' . PHP_EOL;
                    $content .= $linkActive . PHP_EOL;
                    $content .= 'Trân trọng cảm ơn bạn!!!';

                    sendMail($data['email'], $subject, $content);

                    $_SESSION['status'] = true;
                    $_SESSION['msg'] = 'Đăng ký thành công, vui lòng kiểm tra email để kích hoạt tài khoản';
                    redirect('login');
                    exit();
                }
            } catch (\Throwable $th) {
                $_SESSION['status'] = false;
                $_SESSION['msg'] = $th->getMessage();
                redirect('register');
            }
        }
    }

    public function activeAccount($token)
    {

        $title = 'Kích hoạt tài khoản';

        $getToken = $this->user->activeToken($token);

        if (!empty($getToken)) {
            $userId = $getToken['id'];

            $data = [
                'status' => 1,
                'active_token' => null,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $activeToken = $this->user->update($userId, $data);

            if ($activeToken) {
                $_SESSION['status'] = true;
                $_SESSION['msg'] = 'Kích hoạt tài khoản thành công';
            }
        } else {
            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Liên kết không tồn tại hoặc đã hết hạn, vui lòng kiểm tra lại';
        }

        return $this->renderViewClient('auth.active', compact('title'));
    }

    public function showForgotPassword()
    {
        $title = 'Forgot Password';

        return $this->renderViewClient('auth.forgot-password', compact('title'));
    }

    public function handleForgotPassword()
    {
        if (!empty($_POST)) {

            $validator = new Validator();

            $validation = $validator->make($_POST, [
                'email' => 'required|email',
            ]);

            $validation->validate();

            if ($validation->fails()) {
                $_SESSION['errors'] = $validation->errors()->firstOfAll();
                redirect('forgot-password');
                exit();
            }

            try {

                $email = $_POST['email'] ?? null;

                $queryUser = $this->user->findByEmail($email);
                // Helper::dd($userID);

                if (!empty($queryUser)) {
                    $userId = $queryUser['id'];

                    $forgotToken = sha1(uniqid() . time());

                    $data = [
                        'forgot_token' => $forgotToken,
                    ];

                    $updateToken =   $this->user->update($userId, $data);

                    if ($updateToken) {

                        $linkReset = url('') . 'reset/'  . $forgotToken;

                        $subject = 'Yêu cầu khôi phục mật khẩu';
                        $content = 'Chào bạn' . '<br>';
                        $content .= 'Chúng tôi nhận được yêu cầu khôi phục mật khẩu từ bạn, vui lòng nhấp vào link sau để đổi lại mật khẩu' . '<br>';
                        $content .= $linkReset . '<br>';
                        $content .= 'Trân trọng cảm ơn !!!';

                        $sendEmail =  sendMail($email, $subject, $content);

                        if ($sendEmail) {
                            $_SESSION['status'] = true;
                            $_SESSION['msg'] = 'Gửi email thành công, Vui lòng kiểm tra email để đặt lại mật khẩu';
                            redirect('forgot-password');
                            exit();
                        } else {
                            throw new Exception('Gửi email thất bại');
                        }
                    } else {
                        throw new Exception('Lỗi hệ thống, vui lòng thử lại sau');
                    }
                } else {
                    throw new Exception('Email không tồn tại, vui lòng kiểm tra lại');
                }
            } catch (\Throwable $th) {
                $_SESSION['status'] = false;
                $_SESSION['msg'] = $th->getMessage();
                redirect('forgot-password');
                exit();
            }
        }
    }

    public function showFormResetPassword($token)
    {
        $title = 'Reset Password';

        $getToken = $this->user->getForgotToken($token);

        if (empty($getToken)) {
            echo '404';
            exit();
        }

        $userID = $getToken['id'];

        // Helper::dd($getToken);

        return $this->renderViewClient('auth.reset', compact('title', 'getToken'));
    }

    public function handleFormResetPassword($id)
    {
        try {
            $getToken = $this->user->getForgotToken($id);
            $userID = $getToken['id'];

            if (empty($getToken)) {
                echo '404';
                exit();
            }

            if (!empty($_POST)) {

                $validator = new Validator();

                $validation = $validator->make($_POST, [
                    'password' => 'required|min:6',
                    'confirm-password' => 'required|same:password',
                ]);

                $validation->validate();

                if ($validation->fails()) {
                    $_SESSION['errors'] = $validation->errors()->firstOfAll();
                    redirect('reset/' . $id);
                    exit();
                } else {
                    $data = [
                        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                        'forgot_token' => null,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];

                    $updatePassword = $this->user->update($userID, $data);
                    if ($updatePassword) {
                        echo '<script>alert("Thay đổi mật khẩu thành công")</script>';
                        redirect('login');
                        exit();
                    }
                }
            }
        } catch (\Throwable $th) {
            $_SESSION['status'] = false;
            $_SESSION['msg'] = $th->getMessage();
            redirect('reset/' . $id);
            exit();
        }
    }

    public function logout()
    {
        unset($_SESSION['cart-' . $_SESSION['user']['id']]);
        unset($_SESSION['user']);
        header('Location: ' . url(''));

        exit();
    }
}
