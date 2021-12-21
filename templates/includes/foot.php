
		<?
            load_stylesheets(1);
			load_javascript();
            custom_body_close();
            page_body_close();
        ?>

        <? if ($settings['sticky_header']) : ?>
            <script>
                if (typeof sticky_nav !== 'undefined' && typeof sticky_nav === 'function') {
                    $(document).ready(function () {
                        sticky_nav('.header');
                    });
                }
            </script>
        <? endif; ?>

	</body>

</html>