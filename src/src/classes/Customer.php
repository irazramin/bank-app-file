<?php

namespace App\classes;

use App\classes\Files;
use App\classes\User;

class Customer extends User
{
    private $userFiles;
    private $transactionFiles;

    public function __construct()
    {
//        parent::__construct("ir bayejid", "irazramin@gmail.com");
        $this->userFiles = new Files("../users.txt");
        $this->transactionFiles = new Files("../transactions.txt");
    }

    public function getAllCustomers(): array
    {
        $customers = [];
        $users = $this->userFiles->getFileData();
        $users = (array)json_decode($users, true);

        foreach ($users as $customer) {
            if ($customer["email"] !== $this->getEmail()) {
                $customers[] = $customer;
            }
        }
        return $customers;
    }

    public function getSingleCustomer($email): array {

        $customer = [];
        $users = $this->userFiles->getFileData();
        $users = (array)json_decode($users, true);

        foreach ($users as $user) {
            if($user["email"] == $email) {
                $customer = $user;
            }
        }

        return $customer;
    }

    public function addAmount($amount): void
    {
        $users = $this->userFiles->getFileData();
        $users = (array)json_decode($users, true);

        foreach ($users as $userIndex => $user) {
            if ($user["email"] == $this->getEmail()) {
                $users[$userIndex]["balance"] += $amount;
            }
        }
        $this->userFiles->saveData(json_encode($users));
    }

    public function showBalance()
    {
        $users = $this->userFiles->getFileData();
        $users = (array)json_decode($users, true);

        foreach ($users as $user) {
            if ($user["email"] == $this->getEmail()) {
                return $user["balance"];
            }
        }

        return 0;
    }

    public function withdrawAmount($amount): void
    {
        $users = $this->userFiles->getFileData();
        $users = (array)json_decode($users, true);

        foreach ($users as $userIndex => $user) {
            if ($user["email"] == $this->getEmail()) {
                $users[$userIndex]["balance"] -= $amount;
            }
        }
        $this->userFiles->saveData(json_encode($users));
    }

    public function transferAmount($amount, $email): void
    {
        $errors = [];
        $transactionInfo = [];
        $users = $this->userFiles->getFileData();
        $users = (array)json_decode($users, true);

        $existingTransactions = $this->transactionFiles->getFileData();
        $existingTransactions = json_decode($existingTransactions, true);

        if (!is_array($existingTransactions)) {
            $existingTransactions = [];
        }

        foreach ($users as $userIndex => $user) {
            if ($user["email"] === $email) {
                $users[$userIndex]["balance"] += $amount;
                $transactionInfo[] = [
                    'amount' => $amount,
                    'type' => 'send',
                    'date' => date("Y-m-d"),
                    'senderBy' => $this->getName(),
                    'receiverBy' => $user["name"],
                    'receiverEmail' => $user["email"],
                    'senderEmail' => $this->getEmail()
                ];
                $transactionInfo[] = [
                    'amount' => $amount,
                    'type' => 'receive',
                    'date' => date("Y-m-d"),
                    'senderBy' => $this->getName(),
                    'receiverBy' => $user["name"],
                    'receiverEmail' => $user["email"],
                    'senderEmail' => $this->getEmail()
                ];

            }
            if ($user["email"] == $this->getEmail()) {
                $users[$userIndex]["balance"] -= $amount;
            }
        }



        $allTransactions = array_merge($existingTransactions, $transactionInfo);


        $this->transactionFiles->saveData(json_encode($allTransactions));

        $this->userFiles->saveData(json_encode($users));
    }


    public function seeTransactions($email): array
    {
        $myTransactions = [];
        $transactions = $this->transactionFiles->getFileData();
        $transactions = (array)json_decode($transactions, true);
        foreach ($transactions as $transactionIndex => $transaction) {
            if ($transaction["senderEmail"] === $email) {
                $myTransactions[] = $transaction;
            } else if ($transaction["receiverEmail"] === $email) {
                $myTransactions[] = $transaction;
            }
        }

        return $myTransactions;
    }

    public function seeAllTransactions(): array
    {
        $transactions = $this->transactionFiles->getFileData();
        return (array)json_decode($transactions, true);
    }

}


