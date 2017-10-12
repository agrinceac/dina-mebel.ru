	<div class="footer">
		<div class="max_width">
			<div class="foot_in">
				<table width="100%" class="footer_table">
					<tr>
						<?=$this->getController('Article')->getArticle('schedule_footer')->text?>
						<td>
							<div class="foot_menu">
								<?foreach ($this->getController('Article')->getTopMenuItems() as $item):?>
								<p><a href="<?=$item->getPath()?>"><?=$item->name?></a></p>
								<?endforeach?>
							</div>
						</td>
						<td>
							<p><a href="/"><img src="/images/bg/logo2.png" alt="" /></a></p>
							<p><br /></p>
							<p class="desc">Широкий выбор классической мебели</p>
						</td>
					</tr>
				</table>
				<?if($_REQUEST['controller'] != 'shopcart'):?>
				<div class="shopcartBar">
					<?$this->getController('Shopcart')->ajaxGetShopcartBar()?>
				</div>
				<?endif?>

				<!-- Yandex.Metrika counter -->
				<script type="text/javascript">
				(function (d, w, c) {
					(w[c] = w[c] || []).push(function() {
						try {
							w.yaCounter22453480 = new Ya.Metrika({id:22453480,
									webvisor:true,
									clickmap:true,
									trackLinks:true,
									accurateTrackBounce:true});
						} catch(e) { }
					});

					var n = d.getElementsByTagName("script")[0],
						s = d.createElement("script"),
						f = function () { n.parentNode.insertBefore(s, n); };
					s.type = "text/javascript";
					s.async = true;
					s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

					if (w.opera == "[object Opera]") {
						d.addEventListener("DOMContentLoaded", f, false);
					} else { f(); }
				})(document, window, "yandex_metrika_callbacks");
				</script>
				<noscript><div><img src="//mc.yandex.ru/watch/22453480" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
				<!-- /Yandex.Metrika counter -->


				<div style="display: none;">
					<!--LiveInternet counter--><script type="text/javascript"><!--
					document.write("<a href='//www.liveinternet.ru/click' "+
					"target=_blank><img src='//counter.yadro.ru/hit?t44.11;r"+
					escape(document.referrer)+((typeof(screen)=="undefined")?"":
					";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
					screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
					";"+Math.random()+
					"' alt='' title='LiveInternet' "+
					"border='0' width='31' height='31'><\/a>")
					//--></script><!--/LiveInternet-->
				</div>

				<!-- reenter.ru -->
				<script type="text/javascript" src="//cdn.reenter.ru/782/m.js"></script>
				<!-- reenter.ru -->

			</div>
		</div>
	</div><!--footer-->
</body>
</html>