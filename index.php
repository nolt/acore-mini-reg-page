<?php

require_once "config/config.php";
require_once "lib/mysql.php";
require_once "lib/account.php";
require_once "module/create_account.php";

$account = createAccount();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>mini RegistrationPage | Sign Up</title>
        <style>
            body {
                background: #0c0d0d url('img/background.png') no-repeat top center;
                width: 100%;
            }

            header {
                width: 100%;
                height: 605px;
                position: absolute;
                margin: 0 auto;
                background: url('img/') no-repeat top center;
                top: 0;
                z-index: -1;
            }

            fieldset {
                width: 70%;
                padding: 50px;
                box-shadow: 0 0 9px white;
                margin: 90px auto;
                background-color: rgba(230, 230, 230, 0.9);
            }

            fieldset input[type="text"],
            fieldset input[type="email"],
            fieldset input[type="password"] {
                display:block;
                margin-bottom: 15px;
                line-height: 18px;
                height: 30px;
                width: 80%;
            }

            fieldset input[type="submit"] {
                width: 80%;
                height: 36px;
                cursor: pointer;
            }

            .logo {
                margin: 10px auto;
                display: block;
            }

            pre {
                display: inline;
                background-color: white;
                padding: 0px 9px;
	    }

            .infoo {
		text-align: center;
		font-family: Tahoma,Geneva, sans-serif;
		font-size: 20px;
		   }

            .form {
                float: left;
		width: 45%;
		font-family: Tahoma,Geneva, sans-serif;
            }

            .information {
                float:right;
                width: 52%;
		font-family: Tahoma,Geneva, sans-serif;
            }

            li {
                margin-bottom: 20px;
            }

            .errors li {
                margin-bottom: 8px;
                color: red;
            }

            footer {
                color: white;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header> </header>
        <img class="logo" src="img/logo.png" />
        <fieldset>
            <div class="errors">
                <ul>
                    <?php
                    foreach ($account->getErrors() as $error)
                    {
                        echo "<li>$error</li>";
                    }
                    ?>
                </ul>
            </div>

        <div class="infoo">
        Welcome on <span style="color: #3590d7; font-size: 22px;"><strong>Private Realm</strong></span>.
        <br>
        Project is only for learning purpouse.
        <br><br><br>
        </div>

            <div class="form">
                <form method="post">
                    <label for="username">Username (a-z/0-9)</label>
                    <input type="text" name="username" id="username" required pattern="[a-zA-Z][a-zA-Z0-9\s]*" value="<?=$account->getUsername()?>" />

                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required value="<?=$account->getPasswords()[0]?>" />

                    <label for="password_repeat">Password verification</label>
                    <input type="password" name="password_repeat" id="password_repeat" required value="<?=$account->getPasswords()[1]?>" />

                    <input type="submit" name="signup" value="Sign Up" />
                </form>
            </div>
            <div class="information">
                <ul>
                    <li>This is a Private Realm!</li>
                    <li>This realm is for private purpouse only!</li>
                    <br>
                    <li>The realmlist is <pre>set realmlist ***</pre></li>
                </ul>
            </div>
        </fieldset>

        <footer>
            &copy; 2020 Private Realm
        </footer>
    </body>
</html>
