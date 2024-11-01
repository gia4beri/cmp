    @vite("resources/js/app.js")
        <script src="/build/js/tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: '.textarea-toolbars',
                license_key: 'gpl',
                promotion: false,
                toolbar: true,
                menubar: false,
            });
        </script>
    </body>
</html>
