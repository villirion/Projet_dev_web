<?php include('php/setCatalogue.php'); ?>
<?php include('php/function.php'); ?>
<?php include('php/navbar.html'); ?>
<?php include('php/' . $_SESSION['status'] . '.php'); ?>
</div>
    <div class="content">
        <?php include('php/menu.html'); ?>
        <?php include('php/'.$_SESSION['content'].'.html'); ?>
    </div>
<?php include('php/footer.html'); ?>
