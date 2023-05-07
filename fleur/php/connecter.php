<!-- <div class="right">
    <div class="login-container">
        <?php 
            echo "Bonjour, " . $_SESSION['username']; 
            if ($_SESSION['admin']) {
                echo '<form action="" method="post"> <input type="submit" name="admin" value="admin"/> </form>';
            }
        ?>
        <br>

        <form action="" method="post">
            <input type="submit" name="panier" value="Panier"/>
        </form>
        <?php 
            if ($_SESSION["articles"] > 0) {
                echo $_SESSION["articles"];
            }
        ?>
        <br>
        <form action="" method="post">
            <input type="submit" name="logOf" value="Déconnexion"/>
        </form>
    </div>
</div> -->