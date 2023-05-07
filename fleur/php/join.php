<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <link rel="stylesheet" href="../css/navbar.css"> -->
    <link rel="stylesheet" href="../css/styleJoin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
</head>

<body>
    <div class="navbar">
        <div class="navbar-left">
            <a href="index.html">Accueil</a>
            <a>À propos</a>
            <a>Contact</a>
        </div>
        <div class="navbar-right">
            <a class="sign-in">Sign in</a>
            <a class="join-now" href="sign-in.html" >Join now</a>
        </div>
    </div>

    <div class="reste">
        <section class="intro">
            <h1 class="title">Faire du sport</h1>
            <p>Get up to 50% off on all our products and services. Hurry up, the offer ends in 24 hours.</p>

        </section>

        <!-- sign-up section -->
        <section class="sign-up">
            <p class="sign-up-para">Aller la</p>
            <!-- the form itself -->
            <form class="sign-up-form">
                <div class="form-input">
                    <input type="text" name="first-name" id="first-name" placeholder="First Name" required>
                    <span>!</span>
                    <p class="warning">First name cannot be empty</p>
                </div>

                <div class="form-input">
                    <input type="text" name="last-name" id="last-name" placeholder="Last Name" required>
                    <span>!</span>
                    <p class="warning">Last name cannot be empty</p>
                </div>

                <div class="form-input">
                    <input type="email" name="email" id="email" placeholder="Email Address" required>
                    <span>!</span>
                    <p class="warning">Looks like this is not an email</p>
                </div>

                <div class="form-input">
                    <input type="Password" name="Password" id="Password" placeholder="Password" required>
                    <span>!</span>
                    <p class="warning">Password cannot be empty</p>
                </div>

                <input class="submit-btn" type="submit" value="Claim your offer">
                <p class="form-term">By clicking the button, you are agreeing to our <span>Terms and Services</span>
                </p>
            </form>
        </section>
    </div>
</body>

</html>