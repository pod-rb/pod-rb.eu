<?php
/**
 * Template: Footer.php
 *
 * @package WPFramework
 * @subpackage Template
 */
?>
		<!--END #content-->
		</div>
		<!--END .container-->
	</div> 	
		<!--BEGIN .footer-->
		<div class="footer">
			<!--p id="copyright">&copy; <?php the_time( 'Y' ); ?> <a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a>. <?php wpframework_credits(); ?></p-->
			<p id="copyright" style="text-align:center;margin-bottom:5px;">Уеб сайт на Пещерен Клуб Под Ръбъ (2011). Материалите се разпространяват под <a href="http://creativecommons.org/licenses/by-nc/2.5/bg/legalcode" target="_blank" rel="nofollow">Creative Commons Признание-Некомерсиално</a>.
                        </p>
			<!-- Theme Hook -->
		<?php wp_footer(); ?>
	</div>
</body>
</html>
