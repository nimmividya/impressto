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
	
	function DeleteRecord(blog_id) {
		if (confirm("You are about to delete this blog item. This action cannot be undone. Continue?")) {
			document.location.href="/admin_blog/delete/"+blog_id+"";
		}
	}
</script>

<div class="subNav clearfix">
	<ul>
		<li><a class="btn btn-default" href="/admin_blog">Show All</a></li>
		<li><a class="btn btn-default" href="/admin_blog/edit"><i class="icon-white icon-star"></i> Add Blog Item</a></li>
	</ul>
</div>