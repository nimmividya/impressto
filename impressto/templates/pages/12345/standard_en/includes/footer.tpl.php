
{if isset($ps_ismobile) && $ps_ismobile == true && isset($ps_domobile) && $ps_domobile == false }

	<a href="javascript:ps_base.setmobile(true);">Mobile Version</a>

{/if}


</div><!-- [END] #wrapper -->



<!-- Piwik -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://central.bitheads.ca/piwik/" : "http://central.bitheads.ca/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://central.bitheads.ca/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->


</body>
</html>