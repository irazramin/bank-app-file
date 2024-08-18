<?php
session_start();

use App\classes\Login;
use App\Classes\User;
use App\classes\Validator;

require_once __DIR__ . "/vendor/autoload.php";
require __DIR__ . '/helpers/sanitize.php';
ob_start();
$errors = [];
$email = $password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validator = new Validator($_POST, 'login');
    $errors = $validator->validateForm();

    if (!count($errors)) {
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password']);
        $login = new Login($email, $password);

        $user = $login->login();

        if (count((array) $user) > 0) {
            unset($errors["auth_error"]);

            $_SESSION['user'] = [
                'email' =>  $user->email,
                'name' =>  $user->name,
                'balance' =>  $user->balance,
                'role' => $user->role,
            ];

            if($user->role == 'admin') {
                header("Location: /admin/customers.php");
            }
            else {
                header("Location: /customer/dashboard.php");
            }
            exit;
        } else {
            $errors["auth_error"] = 'Invalid email or password';
//            header("Location: /login.php");
        }

    }
    ob_end_flush();
}
?>


<!DOCTYPE html>
<html
        class="h-full bg-white"
        lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>

    <link
            rel="preconnect"
            href="https://fonts.googleapis.com"/>
    <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin/>
    <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
            rel="stylesheet"/>

    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
            'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
            'Helvetica Neue', sans-serif;
        }
    </style>

    <title>Sign-In To Your Account</title>
</head>
<body class="h-full bg-slate-100">
<div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2
                class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">
            Sign In To Your Account
        </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
        <?php if (isset($errors["auth_error"])): ?>
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50"
                 role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium"> <?= $errors["auth_error"]; ?> </span>
                </div>
            </div>
        <?php endif; ?>
        <div class="px-6 py-12 bg-white shadow sm:rounded-lg sm:px-12">
            <form
                    class="space-y-6"
                    action="#"
                    method="POST">
                <div>
                    <label
                            for="email"
                            class="block text-sm font-medium leading-6 text-gray-900"
                    >Email address</label
                    >
                    <div class="mt-2">
                        <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 p-2 sm:text-sm sm:leading-6"/>
                    </div>
                </div>

                <div>
                    <label
                            for="password"
                            class="block text-sm font-medium leading-6 text-gray-900"
                    >Password</label
                    >
                    <div class="mt-2">
                        <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6"/>
                    </div>
                </div>

                <div>
                    <button
                            type="submit"
                            class="flex w-full justify-center rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                        Sign in
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-10 text-sm text-center text-gray-500">
            Don't have an account?
            <a
                    href="register.php"
                    class="font-semibold leading-6 text-emerald-600 hover:text-emerald-500"
            >Register</a
            >
        </p>
    </div>
</div>
</body>
</html>
