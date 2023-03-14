
		<?
            load_stylesheets(1);
			load_javascript();
            custom_body_close();
            page_body_close();
        ?>

        <? if ($settings['sticky_header']) : ?>
            <script>
                let sticky = new Sticky('.header');
            </script>
        <? endif; ?>

	</body>

</html>