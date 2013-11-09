{*
@Name: SlickPhone
@Filename: slickphone
@Projectnum: 4660
@Author: peterdrinnan
@Status: complete
@Date: 2012-02
*}

<div class="logo">
    <a href="index.html"><img src="/assets/public/default/images/logo.png" alt="Everything you need to know"></a>
</div>
<div class="header">

{widgetzone name='top'}

	<div class="wrap top-bar">
    	<button class="menu-show"><img src="/assets/public/default/images/plus.png" alt="plus"></button>
    	<button class="menu-hide"><img src="/assets/public/default/images/minus.png" alt="minus"></button>
        <div class="search">
        	<form>
            	<input type="text">
                <input type="submit" value="">
            </form>
        </div>
        <div class="clear-both"></div>
        <nav class="menu">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Clients</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
    </div>
</div>
<div class="content">
	<div class="wrap">
        <div class="post">
        	<h2><a href="#">Complete Markup Reference</a></h2>
            <h1>Heading 1</h1>
            <h2>Heading 2</h2>
            <h3>Heading 3</h3>
            <h4>Heading 4</h4>
            <h5>Heading 5</h5>
            <h6>Heading 6</h6>
            <h2>Paragraph</h2>
            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
            <h2>Bold, Italic, Code, Link</h2>
            <p><b>bold</b> <br> <i>italic</i> <br> <code>code</code> <br> <a href="#">link</a></p>
            <h2>Image</h2>
            <figure><img src="http://lorempixel.com/320/160" alt=""></figure>
            <h2>Ordered List</h2>
            <ol>
                <li>Lorem</li>
                <li>Aliquam</li>
                <li>Morbi</li>
                <li>Praesent</li>
                <li>Pellentesque</li>
            </ol>                        
            <h2>Unordered List</h2>
            <ul>
                <li>Pellentesque</li>
                <li>Morbi</li>
                <li>Lorem</li>
                <li>Aliquam</li>
                <li>Praesent</li>
            </ul>                        
            <h2>Blockquote</h2>
            <blockquote><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p></blockquote>
            <h2>Code</h2>
            <pre><code>
            #header h1 a { 
            display: block; 
            width: 300px; 
            height: 80px; 
            }
            </code></pre>
            <dl>
                <dt>Definition list</dt>
                <dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna 
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea 
                commodo consequat.</dd>
                <dt>Lorem ipsum dolor sit amet</dt>
                <dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna 
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea 
                commodo consequat.</dd>
            </dl>
         </div>
    </div>
</div>
<div class="footer">
	<div class="wrap bot-bar">

{if isset($ps_ismobile) && $ps_ismobile == true && isset($ps_domobile) && $ps_domobile == true }

	<a href="javascript:ps_base.setmobile(false);">Standard Version</a> 

{/if}
    </div>
</div>
<script type="text/javascript">
	$('.menu').hide();
	$('.menu-show').show();
	$('.menu-hide').hide();
	$('.menu-show').click(function(){
		$('.menu-show').toggle();
		$('.menu-hide').toggle();
		$('.menu').slideDown();
	});
	$('.menu-hide').click(function(){
		$('.menu-hide').toggle();
		$('.menu-show').toggle();
		$('.menu').slideUp();
	});
</script>



