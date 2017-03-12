        </div>
        <footer class="footer">
            <div class="container text-center">
                <span class="text-muted">&copy; <?php echo date('Y'); ?> - SV DEU</span>
            </div>
        </footer>
        <!-- Bootstrap core JavaScript
            ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/app.js?ver=<?php echo md5_file('js/app.js'); ?>"></script>
<?php
if(isset($_SESSION['successFlash'])) {
echo <<<JavaScript
    <script type="text/javascript">
    APP.main.flashMessage('success', '{$_SESSION['successFlash']}');
    </script>
JavaScript;
    unset($_SESSION['successFlash']);
}

if(isset($_SESSION['errorFlash'])) {
echo <<<JavaScript
    <script type="text/javascript">
    APP.main.flashMessage('error', '{$_SESSION['errorFlash']}');
    </script>
JavaScript;
    unset($_SESSION['errorFlash']);
}

if($_SERVER['SCRIPT_NAME'] == '/add.php') {
echo <<<JavaScript
    <script src="//cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
    <script type="text/javascript">
    APP.main.initializeEditor();
    </script>
JavaScript;
}
?>

    </body>
</html>