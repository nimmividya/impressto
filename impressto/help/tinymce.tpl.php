  
    
        <div class="referenceManualCollation depth-1">

            <h1>
                1.
                Introduction
            </h1>

            <p class="documentDescription">Introduction to TinyMCE.</p>
    
            <div>
                
                    <div><p><span class="ingress">TinyMCE is a platform 
independent web based Javascript HTML WYSIWYG editor. What this means is
 that it will let you create html content on your web site. TinyMCE 
supports a lot of Operation Systems and browsers. Some examples are: </span>Mozilla, Internet Explorer, Firefox, Opera, Safari and Chrome. TinyMCE has a large userbase and an active development community.</p>
<p>This user manual will show you all the basics of the TinyMCE editor. 
</p>
<p><span class="ingress"></span></p></div>
                
                
            </div>

            

        </div>        
    
    
        <div class="referenceManualCollation depth-1">

            <h1>
                2.
                Basics
            </h1>

            <p class="documentDescription">Basic options of TinyMCE.</p>
    
            <div>
                
                    <div><p>The default TinyMCE editor will look like this:</p>
<p><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/tiny_start.jpg" alt=""></p>
<p>On top you can see the toolbar, below the text area and at the bottom
 a resize bar. If you drag the lower right corner you can make the 
editor window bigger or smaller.</p>
<h2>Toolbar</h2>
<p>The following table describes the function and output of each button.</p>
<table class="listing"><thead><tr><th>icon</th>
<th>function</th>
<th>description</th>
<th>example</th>
</tr></thead><tbody><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/save.gif" alt=""></td>
<td>save</td>
<td>Saves changes <br></td>
<td>&nbsp;</td>
</tr><tr><td rowspan="11" valign="top"><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/style.jpg" alt="">&nbsp;<br></td>
<td valign="top">text style<br></td>
<td valign="top">Normal paragraph<br></td>
<td valign="top">text<br></td>
</tr><tr class="even"><td valign="top"><br></td>
<td valign="top">Heading<br></td>
<td valign="top">
<h2>text</h2>
</td>
</tr><tr><td valign="top"><br></td>
<td valign="top">Subheading<br></td>
<td valign="top">
<h3>text</h3>
</td>
</tr><tr class="even"><td valign="top"><br></td>
<td valign="top">Literal<br></td>
<td valign="top">
<pre>text</pre>
</td>
</tr><tr><td valign="top"><br></td>
<td valign="top">Discreet<br></td>
<td valign="top">
<p class="discreet">text</p>
</td>
</tr><tr class="even"><td valign="top"><br></td>
<td valign="top">Pull-quote<br></td>
<td valign="top">Pull-quote<br></td>
</tr><tr><td valign="top"><br></td>
<td valign="top">Call-out<br></td>
<td valign="top"><br></td>
</tr><tr class="even"><td valign="top"><br></td>
<td valign="top">Clear floats<br></td>
<td valign="top"><br></td>
</tr><tr><td valign="top"><br></td>
<td valign="top">Highlight<br></td>
<td valign="top"><br></td>
</tr><tr class="even"><td valign="top"><br></td>
<td valign="top">(remove style)<br></td>
<td valign="top"><br></td>
</tr><tr><td valign="top"><br></td>
<td valign="top">Page break (print only)<br></td>
<td valign="top"><br></td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/bold.gif" alt=""><br></td>
<td>bold<br></td>
<td>Bolds selected text<br></td>
<td><strong>test</strong></td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/italic.gif" alt=""><br></td>
<td>italic</td>
<td>Italicizes selected text<br></td>
<td><em>text</em></td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/copy_of_justifyleft.gif" alt=""></td>
<td>justify left<br></td>
<td>Aligns the selected text
to the left</td>
<td>text</td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/justifycenter.gif" alt=""><br></td>
<td>justify center<br></td>
<td>Aligns the selected text
to the center of the screen</td>
<td align="center">text<br></td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/justifyright.gif" alt=""></td>
<td>justify right<br></td>
<td>Aligns the selected text
to the right</td>
<td align="right">text<br></td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/justifyfull.gif" alt=""></td>
<td>justify full<br></td>
<td>Aligns the selected text&nbsp; to both left and right<br></td>
<td>text <br></td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/bullist.gif" alt=""></td>
<td>bulleted list<br></td>
<td>Creates a
bulleted list</td>
<td>
<ul><li>item 1</li><li>item 2</li><li>item 3<br></li></ul></td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/numlist.gif" alt=""></td>
<td>numbered list<br></td>
<td>Creates a
numbered list</td>
<td>
<ol><li>item 1</li><li>item 2</li><li>item 3<br></li></ol></td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/outdent.gif" alt=""></td>
<td>oudent</td>
<td>Moves an indented section
of text one tab to the left</td>
<td>&nbsp;</td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/indent.gif" alt=""></td>
<td>indent<br></td>
<td>Indents the selected text
by one tab</td>
<td>&nbsp;</td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/table.gif" alt=""></td>
<td>insert table<br></td>
<td>Inserts a table <br></td>
<td>&nbsp;</td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/rowproperties.gif" alt=""></td>
<td>row properties<br></td>
<td>Table row properties<br></td>
<td>&nbsp;</td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/celproperties.gif" alt=""></td>
<td>cell properties<br></td>
<td>Table cell properties<br></td>
<td>&nbsp;</td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/rowbefore.gif" alt=""></td>
<td>insert row before<br></td>
<td>Inserts a row before the current row<br></td>
<td>&nbsp;</td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/rowafter.gif" alt=""></td>
<td>insert row after<br></td>
<td>Inserts a row after the current row<br></td>
<td>&nbsp;</td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/delrow.gif" alt=""></td>
<td>delete row<br></td>
<td>Deletes the current row<br></td>
<td>&nbsp;</td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/colbefore.gif" alt=""></td>
<td>insert column before<br></td>
<td>Inserts a column before the current column<br></td>
<td>&nbsp;</td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/colafter.gif" alt=""></td>
<td>insert column after<br></td>
<td>Inserts a column after the current column<br></td>
<td>&nbsp;</td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/delcol.gif" alt=""></td>
<td>delete column<br></td>
<td>Deletes the current column<br></td>
<td>&nbsp;</td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/splitcel.gif" alt=""></td>
<td>split cells<br></td>
<td>Splits the current cell<br></td>
<td>&nbsp;</td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/mergecel.gif" alt=""></td>
<td>merge cells<br></td>
<td>Merge the current cell with other cells<br></td>
<td>&nbsp;</td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/link.gif" alt="">&nbsp;</td>
<td>insert link<br></td>
<td>Inserts or edits a link<br></td>
<td><a href="http://www.google.com/">text</a><br></td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/unlink.gif" alt=""></td>
<td>unlink<br></td>
<td>Removes the current link<br></td>
<td>text<br></td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/anchor.gif" alt=""></td>
<td>insert anchor<br></td>
<td>Inserts or edits an anchor <br></td>
<td>&nbsp;</td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/image.gif" alt=""></td>
<td>insert image<br></td>
<td>Inserts or edits an image<br></td>
<td>&nbsp;</td>
</tr><tr><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/code.gif" alt=""></td>
<td>html<br></td>
<td>Edit the HTML source code<br></td>
<td>&nbsp;</td>
</tr><tr class="even"><td><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/fullscreen.gif" alt="">&nbsp;</td>
<td>fullscreen<br></td>
<td>Toggles fullscreen mode<br></td>
<td>&nbsp;</td>
</tr></tbody></table><p>&nbsp;</p></div>
                
                
            </div>

            

        </div>        
    
    
        <div class="referenceManualCollation depth-1">

            <h1>
                3.
                Inserting Images
            </h1>

            <p class="documentDescription">A description of the options available for inserting images with TinyMCE.</p>
    
            <div>
                
                    <div><p>The TinyMCE editor allows you to insert image files stored in BitHeads Central into your document, using the <img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/image.gif" alt="Image"></p><p> button on the TinyMCE toolbar:</p>
<img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/toolbar_image.jpg" alt=""><p>&nbsp;</p>
<p>Clicking this button launches the Insert Image dialog:</p>
<img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/insert_image_dialog.jpg" alt=""><p>&nbsp;</p>
The three columns of the dialog display:
<ul><li>In the first column - a folder navigation list. </li><li>In the second column - an object navigation list, from which you can select your image file.</li><li>In the third column - image preview, and options for alignment, size and captions. <br></li></ul><p>
In the example above, an image of a rose was selected - rose.png (rather large one, at its original size of 600*450 pixels).</p>
<p>
According to the "Image alignment" option you choose, the image will be placed in
your page (and the following HTML code will be generated):</p>
<ul><li>lefthand (&lt;img class="image-left captioned" src="rose.png" alt="rose" /&gt;);</li><li>righthand (&lt;img class="image-right captioned" src="rose.png" alt="rose" /&gt;);</li><li>inline (&lt;img class="image-inline captioned" src="rose.png" alt="rose" /&gt;).</li></ul><p>
You may also choose the size of the image you need. This is especially
convenient when you deal with large images, as there is no need to
use Photoshop or other external image editing application to crop
or change the size of an image. The "Image size" dropdown list provides a choice
between many sizes and formats:</p>
<img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/image_size.jpg" alt=""><p>&nbsp;</p>
<ul><li>Large (&lt;img src="rose.png/image_large" alt="rose" /&gt;);</li><li>Preview&nbsp;(&lt;img src="rose.png/image_preview" alt="rose" /&gt;);</li><li>Mini&nbsp;(&lt;img src="rose.png/image_mini" alt="rose" /&gt;) - the minimum-size image is formed;</li><li>Thumb (&lt;img src="rose.png/image_thumb" alt="rose" /&gt;)
-&nbsp;a thumb(inch)-size icon is made out of your image (little bigger
than 2,5cm);&nbsp;</li><li>Tile (&lt;img src="rose.png/image_tile" alt="rose" /&gt;) - a tile is made out of your image;</li><li>Icon (&lt;img src="rose.png/image_icon" alt="rose" /&gt;) - an&nbsp;icon is made out of your image;</li><li>Listing (&lt;img&nbsp;src="rose.png/image_listing" alt="rose" /&gt;) - a listing icon is made out of your image; </li></ul><p>&nbsp;</p>


    </div>
                
            </div>

            

        </div>        
    
    
        <div class="referenceManualCollation depth-1">

            <h1>
                4.
                Inserting Links
            </h1>

            <p class="documentDescription">Inserting internal, external and anchor links.</p>
    
            <div>
                
                    <div><h2>Internal Links</h2>
Select a word or phrase, click the <em>Insert/edit link</em> icon, and the <em>Insert/edit link</em> panel will appear:
<img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/insert_internal_link.jpg" alt=""><p>&nbsp;</p>
<p>You use this panel by clicking on Home or Current folder to begin
navigating the BitHeads Central web site to find a folder, page, or image to which
you wish to make a link. In the example above, a page named
"Long-tailed Skippers" has been chosen for the link.&nbsp; After this panel
is closed, a link to the "Long-tailed Skippers" page will be set for
the word or phrase selected for the link.</p>
<h2>External Links</h2>
<p>Select a word or phrase, click the <em>Insert/edit link</em> icon, select <em>External</em> under <em>Libraries</em>, and the External link panel will appear:</p>
<p><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/insert_external_link.jpg" alt=""></p>
<p>Type the web address of the external web site in the box after 
http://. When you press return or leave the field a preview will appear 
to check the address. If you paste in the web address,
make sure you don't have duplicate http:// at the beginning of the
address. Then click <em>ok</em>. The external link will be set to the word or phrase you selected.</p>
<h2>Anchors</h2>
<p align="left">Anchors are like position markers within a document,
based on headings, subheadings, or another style set within the
document. As an example, for a page called "Eastern Tiger Swallowtail,"
with subheadings entitled "Description," "Habitat," "Behavior,"
"Conservation Status," and "Literature," an easy set of links to these
subheadings (to the positions within the document at those subheadings)
can be created using anchors.</p>
<p align="left">First, create the document with the subheadings set within it, and re-type the subheadings at the top of the document:</p>
<p align="left"><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/anchor_page.jpg" alt=""></p>
<p align="left">Now create the anchors for each subheading. To create 
each anchor move the cursor to the beginning of the subheading and press
 the <em>Insert/edit anchor</em> icon. Enter the name of the anchor in&nbsp; the <em>Anchor name</em> field. Then click <em>ok</em>.</p>
<p align="left"><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/insert_anchor.jpg" alt=""></p>
<p align="left">Then select each of the re-typed subheadings at the top and click the <em>Insert/edit link</em> icon to select by subheadings:</p>
<p align="left"><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/insert_anchor_select_text.jpg" alt=""></p>


<p align="left">When selecting <em>Anchors</em> under <em>Libraries</em>, a panel will appear for selecting which subheading to which the anchor link should connect:</p>


<p align="left"><img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/select_anchor.jpg" alt=""></p>




<p align="left">The <em>Link to anchor</em> tab will appear. The right side of the
panel shows the anchors that have been set within the document.
Here the <em>Description</em> anchor is chosen for the link (for the word Description, typed at the top of the document).</p>
<p align="left">You can be creative with this powerful feature, by
weaving such links-to-anchors within narrative text, by setting anchors
to other styles within the document, and coming up with clever mixes.
This functionality is especially important for large documents.</p></div>
                
                
            </div>

            

        </div>        
    
    
        

            <h1>
                5.
                Inserting Tables
            </h1>

<p class="documentDescription">Inserting, updating and deleting tables, columns, rows and cells.</p>
           
                    <p>Tables are handy for tabular data and lists. To add a table, put your cursor where you want it and click the <em>Inserts a new table</em> icon.&nbsp; You'll see the <em>Insert/Modify table</em>
</p><p> panel:</p>
<img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/insert_table.jpg" alt=""><p>&nbsp;</p>


<p>After the table has been created you can click in a cell to show table resizing handles:</p>
<img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/table_resize.jpg" alt=""><p>&nbsp;</p>
<p>In the table above, the cursor has been placed in the "Special 
Leader"
cell, which activates little square handles around the edges for
resizing the entire table. It also activates the other table controls in
 the toolbar which, lets you edit properties of a row or a cell, lets 
you add and remove rows or columns and lets you split and merge cells.</p>
<img class="image-inline" src="/<?php echo PROJECTNAME; ?>/help/images/tinymce/table_controls.jpg" alt="">


