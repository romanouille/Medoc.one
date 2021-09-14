			<footer class="center">
				Source des données : <a href="http://base-donnees-publique.medicaments.gouv.fr/" target="_blank" title="http://base-donnees-publique.medicaments.gouv.fr/">http://base-donnees-publique.medicaments.gouv.fr/</a><br>
				Nous ne sommes pas une entité médicale.
			</footer>
		</div>
		<script src="/js/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/jquery-ui.min.js"></script>
		<script src="/js/jquery.tocify.min.js"></script>
		<script src="/js/prettify.js"></script>
		<script>
		$(function() {
		  var toc = $("#toc").tocify({
		  selectors: "h1, h2"
		  }).data("toc-tocify");
		  prettyPrint();
		});
		</script>
	</body>
</html>