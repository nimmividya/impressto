<script type="text/javascript">
	function BrowseServer(){
		// You can use the "CKFinder" class to render CKFinder in a page:
		var finder = new CKFinder();
		finder.basePath = '../../';	// The path for the installation of CKFinder (default = "/ckfinder/").
		finder.selectActionFunction = SetFileField;
		finder.popup();
	}

	function BrowseServer2(){
		// You can use the "CKFinder" class to render CKFinder in a page:
		var finder = new CKFinder();
		finder.basePath = '../../';	// The path for the installation of CKFinder (default = "/ckfinder/").
		finder.selectActionFunction = SetFileField2;
		finder.popup();
	}

	// This is a sample function which is called when a file is selected in CKFinder.
	function SetFileField( fileUrl ){
		document.getElementById( 'xFilePath' ).value = fileUrl;
	}

	// This is a sample function which is called when a file is selected in CKFinder.

	function SetFileField2( fileUrl2 ){
		document.getElementById( 'xFilePath2' ).value = fileUrl2;
	}
	
	function DeleteRecord(news_id) {
		if (confirm("You are about to delete this news item. This action cannot be undone. Continue?")) {
			document.location.href="/admin_news/delete/"+news_id+"";
		}
	}
</script>

<div class="subNav clearfix">
	<ul>
		<li><a class="btn btn-default" href="/admin_news">Show All</a></li>
		<li><a class="btn btn-default" href="/admin_news/edit"><i class="icon-white icon-star"></i> Add News Item</a></li>
	</ul>
</div>