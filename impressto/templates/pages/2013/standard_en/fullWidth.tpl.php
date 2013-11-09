{*
@Name: Full Width
@Type: Smarty
@Filename: fullWidth.tpl.php
@Lang: 
@Description: 
@Author: peterdrinnan
@Docket: 4660
@Version: 
@Status: complete
@Date: 2012-02
@fulltemplatepath: //pshaper/templates/pages/1001/standard_en/fullWidth.tpl.php
*}


<section id="page" class="container-wrap">				<div id = "page-container" class = "container">					<header id = "page-header">						<h1>{$CO_seoTitle}</h1>					</header><!--- #page-header -->															{widgetzone name='top'}															<div id = "page-content" class="{$CO_Url}"><!-- the class declared in page-content is used to assign custom styles to each page -->																{$CO_Body}					
					
					{$xtra_field_1}
																	</div><!--- #page-content -->									</div><!--- #page-container -->			</section><!--- #page -->