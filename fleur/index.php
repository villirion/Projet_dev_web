<?php include('php/function.php'); ?>
<?php include('php/navbar.html'); ?>
<?php include('php/' . $_SESSION['status'] . '.html'); ?>
</div>
    <div class="content">
        <?php include('php/'.$_SESSION['content']); ?>
    </div>
<?php include('php/footer.html'); ?>
