
<!-- BEGIN IMAGESLIDERHELP -->


Image slider help.

<!-- END IMAGESLIDERHELP -->


<!-- BEGIN IMAGEGALLERYHELP -->


Image gallery help.

<!-- END IMAGEGALLERYHELP -->


<!-- BEGIN TOPBANNERSHELP -->


help!

<!-- END TOPBANNERSHELP -->

<!-- BEGIN BLOGHELP -->

<h3>Creating and Editing Posts</h3>
<p>
<img src="/<?php echo PROJECTNAME; ?>/help/modules/admin_blog/screen3.png" alt="Creating New Posts" />
<br />
When creating or editing posts, you simply add a title, name of the author, pulish date, and a short description. If you want the post to link to a full artice, you can use the full artice field, but that is optional. 
</p>


<h3>Archiving Posts</h3>
<p>
To archive a blog post, you simply have to mark it as archived. You can do this within the blog items list (fig. 1), or within the edit form of the post (figure 2). 
<p>


<p>
<strong>Figure 1</strong><br />
<img src="/<?php echo PROJECTNAME; ?>/help/modules/admin_blog/screen2.png" alt="Archiving Posts" />
</p>

<br />
<br />

<p>
<strong>Figure 2</strong><br />
<img src="/<?php echo PROJECTNAME; ?>/help/modules/admin_blog/screen1.png" alt="Archiving Posts" />
</p>


<h3>Global Blog Settings</h3>
<p>
The Setting form lets you setup your blog post pages and the pagination limits. 

<h4>Listings Limit</h4>
<p>Limits how many posts appear on a page at once.</p>

<h4>[LANGUAGE] Blog Page Wrapper</h4>
<p>Select the page that will be used to show your current blog posts.</p>

<h4>[LANGUAGE] Archived Blog Page Wrapper</h4>
<p>Select the page that will be used to show your archived blog posts.</p>

</p>


<h3>Widgets</h3>
<p>
These are generally setup by site administrators once when the site is being built. They are containers for blog posts that are placed within site templates and wrapper pages. 
</p>


<!-- END BLOGHELP -->



<!-- BEGIN TUBEPRESSHELP -->


help!

<!-- END TUBEPRESSHELP -->

<!-- BEGIN CONTENTLISTHELP -->


help!

<!-- END CONTENTLISTHELP -->



<!-- BEGIN XTRACONTENTHELP -->

<p>These custom variables can help you build rich content pages without having to build custom widgets or templates for each page.</p>

<p>Once you have created these variables, they will appear as edit fields within the page manager editor. These fields can also be renamed without losing data.</p>

<p>To use these variables in your templates, use these code samples:</p>

<h5>Smarty</h5>


<pre>

{if &#36;xtra_mobile_content_head_1 != '' &amp;&amp; &#36;xtra_mobile_content_1 != ''}<br />
	&lt;div data-role=&quot;collapsible&quot; data-theme=&quot;c&quot; data-content-theme=&quot;d&quot;&gt;<br />
	&lt;h3&gt;{&#36;xtra_mobile_content_head_1}&lt;/h3&gt;<br />
	&lt;p&gt;{&#36;xtra_mobile_content_1}&lt;/p&gt;<br />
	&lt;/div&gt;<br />
{/if}<br />
</pre>

<h5>PHP</h5>


<pre>

&lt;?php if(&#36;xtra_mobile_content_head_1 != '' &amp;&amp; &#36;xtra_mobile_content_1 != ''): ?&gt;<br />
	&lt;div data-role=&quot;collapsible&quot; data-theme=&quot;c&quot; data-content-theme=&quot;d&quot;&gt;<br />
	&lt;h3&gt;&lt;?=&#36;xtra_mobile_content_head_1?&gt;&lt;/h3&gt;<br />
	&lt;p&gt;&lt;?=&#36;xtra_mobile_content_1?&gt;&lt;/p&gt;<br />
	&lt;/div&gt;<br />
&lt;?php endif; ?&gt;<br />
			
</pre>




<!-- END XTRACONTENTHELP -->




