<?php

function createAccount()
{
    if (!isset($_POST['signup']))
    {
        return new account(['username' => '', 'password' => '', 'password_repeat' => '']);
    }

    $account = new account($_POST);
    $result = $account->saveToDb();

    if ($result == account::STATUS_OK)
    {
        header("Location: success.php");
        exit;
    }

    return $account;
}
