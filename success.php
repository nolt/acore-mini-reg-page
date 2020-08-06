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
                text-align:center;
                background-color: rgba(230, 230, 230, 0.9);
		font-family: Tahoma,Geneva, sans-serif;
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

            .form {
                float: left;
                width: 45%;
            }

            .information {
                float:right;
                width: 52%;
            }

            li {
                margin-bottom: 20px;
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
            <h1 style="color: green;">Account successfully created!</h1>
            <h3>Change now your realmlist.wtf to connect.</h3>
            Navigate to your World of Warcraft directory<br>
            Open realmlist.wtf with your editor<br>
            Change the content of the file to <pre>set realmlist ***</pre><br><br>
            <a href="./">Back to our website</a>
        </fieldset>

        <footer>
            &copy; 2020 Private Realm
        </footer>
    </body>
</html>
