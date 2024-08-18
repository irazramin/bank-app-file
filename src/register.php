<?php

use App\Classes\User;
use App\Classes\Validator;
use App\Classes\Registration;

require_once __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/helpers/sanitize.php";
ob_start();

$errors = [];
$name = $email = $password = "";
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $validator = new Validator($_POST, 'registration');
    $errors = $validator->validateForm();

    if (empty($errors)) {
        $name = sanitize($_POST["name"]);
        $email = sanitize($_POST["email"]);
        $password = password_hash(sanitize($_POST["password"]), PASSWORD_DEFAULT);

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $register = new Registration($user);

        $register->register();
        header("location: login.php");
    }
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

    <title>Create A New Account</title>
</head>
<body class="h-full bg-slate-100">
<div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2
                class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">
            Create A New Account
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
                    method="POST" novalidate>
                <div>
                    <label
                            for="name"
                            class="block text-sm font-medium leading-6 text-gray-900"
                    >Name</label
                    >
                    <div class="mt-2">
                        <input
                                id="name"
                                name="name"
                                type="text"
                                required
                                value="<?=$name?>"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2"/>
                    </div>
                    <?php if (isset($errors['name'])): ?>
                        <div class="flex items-center mt-2">
                            <svg class="flex-shrink-0 inline w-3 h-3 me-1 text-red-600 font-medium text-xs" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <p class="text-red-600 font-medium text-xs"><?=$errors["name"]?></p>
                        </div>
                    <?php endif; ?>
                </div>

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
                                value="<?=$email?>"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2"/>
                    </div>
                    <?php if (isset($errors['email'])): ?>
                    <div class="flex items-center mt-2">
                        <svg class="flex-shrink-0 inline w-3 h-3 me-1 text-red-600 font-medium text-xs" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <p class="text-red-600 font-medium text-xs"><?=$errors["email"]?></p>
                    </div>
                    <?php endif; ?>
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
                                value="<?=$password?>"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2"/>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <div class="flex items-center mt-2">
                            <svg class="flex-shrink-0 inline w-3 h-3 me-1 text-red-600 font-medium text-xs" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <p class="text-red-600 font-medium text-xs"><?=$errors["password"]?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <div>
                    <button
                            type="submit"
                            class="flex w-full justify-center rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                        Register
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-10 text-sm text-center text-gray-500">
            Already a customer?
            <a
                    href="login.php"
                    class="font-semibold leading-6 text-emerald-600 hover:text-emerald-500"
            >Sign-in</a
            >
        </p>
    </div>
</div>
</body>
</html>
