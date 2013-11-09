<?php /*
@Name: Website Estimator
@Type: PHP
@Author: Acart
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/12/05
*/
?>

<?php

$CI = &get_instance();  

$CI->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/default/custom_modules/website_estimator/js/website_estimator.js");
$CI->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/default/custom_modules/website_estimator/css/style.css");
		
$assetpath = ASSETURL . PROJECTNAME . "/default/custom_modules/website_estimator/";

		
?>
		

<div class="W_E estimator_wrapper">
		
<!-- -COPY AND PASTE ALL THE CODE BELOW INTO YOUR PROJECT -->



<!-- HIDE in JS until success. PayPal form will show here. -->
<div id="W_E_TopMessage"></div>

<!-- PAYPAL FORM ---REMOVE IF YOU ONLY WANT A CONTACT SUBMISSION -->
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payPalForm">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" id="paypalBusiness" value=""  />
<input type="hidden" name="item_name" id="itemName" value="" />
<input type="hidden" name="currency_code" id="currencyCode" value="" />
<input type="hidden" name="amount" id="payPalAmount" value="" />
<button class="W_E payment" type="submit" id="paymentPayPal"></button>
</form>



<!-- You will still need to create a submission form and payment gateway. Accordion 4 can be utilized for this. If you would like for me to create this please contact me. Finally, I suggest using jQuery serialize for submitting the form -->
<form action="" id="W_E-webEstimate" class="W_E">
		<div class="W_E-demo W_E">
				<div id="W_E-accordion"  class="W_E">
						<h3 class="W_E"> <a href="#"  class="W_E">Step 1: Let's Get Started</a> </h3>
						<div id="W_E-sectionOne"  class="W_E">
								<p  class="W_E">The code we create is W3C valid, table-less, semantic, accessible, and SEO friendly. We ensure that every project is compatible with all modern browsers.</p>
								<div class="W_E-dots W_E pages">
										<h6  class="W_E">How many pages is your site?
												<input type="text" id="W_E-pages" readonly="readonly" class="W_E" />
										</h6>
										<div  class="W_E">
												<div class="W_E-plusPages W_E" id="W_E-plusPages"></div>
												<div id="W_E-pagesSlider"  class="W_E"></div>
												<div class="W_E-minusPages W_E" id="W_E-minusPages"></div>
										</div>
								</div>
								<div class="W_E-clear W_E"></div>
								<div class="W_E-dots W_E days">
										<h6 class="W_E">When do you need your site? In Days:
												<input type="text" id="W_E-days" name="W_E-days" readonly="readonly" class="W_E" />
										</h6>
										<div class="W_E">
												<div class="W_E-plusDays W_E" id="W_E-plusDays"></div>
												<div id="W_E-daysSlider" class="W_E"></div>
												<div class="W_E-minusDays W_E" id="W_E-minusDays"></div>
										</div>
								</div>
								<div class="W_E-clear W_E"></div>
								<div class="W_E-dots W_E">
										<h6 class="W_E">Do you want a Content Management System (CMS)?</h6>
										<p class="W_E">CMS is a software system that provides website authoring, collaboration, and administration tools designed to allow users with little knowledge of web programming languages or markup languages to create and manage website content with relative ease. A robust WCMS provides the foundation for collaboration, offering users the ability to manage documents and output for multiple author editing and participation.</p>
										<input type="radio" id="W_E-cmsNone" name="cms" value="None" class="W_E W_E-width20"/>
										<label for="W_E-cmsNone" class="W_E-cms W_E"><img src="<?=$assetpath?>images/none.png" width="30" height="30" alt="None" class="W_E"/> None</label>
										<input type="radio" id="W_E-cms1" name="cms" value="ExpressionEngine" class="W_E W_E-width20"/>
										<label for="W_E-cms1" class="W_E-cms W_E"><img src="<?=$assetpath?>images/expression_engine.png" width="30" height="30" alt="Joomla" class="W_E"/> ExpressionEngine</label>
										<input type="radio" id="W_E-cms2" name="cms" value="WordPress" class="W_E W_E-width20"/>
										<label for="W_E-cms2" class="W_E-cms W_E"><img src="<?=$assetpath?>images/wordpress.png" width="30" height="30" alt="Wordpress" class="W_E"/> Wordpress</label>
										<input type="radio" id="W_E-cms3" name="cms" value="PageShaper" class="W_E W_E-width20"/>
										<label for="W_E-cms3" class="W_E-cms W_E"><img src="<?=$assetpath?>images/pageshaper.png" width="30" height="35" alt="PageShaper" class="W_E"/> PageShaper</label>
								</div>
						</div>
						<!-- END SECTION ONE -->
						
						<h3 class="W_E"> <a href="#" class="W_E">Step 2: Site Options</a> </h3>
						<div id="W_E-sectionTwo" class="W_E">
								<div class="W_E-dots W_E">
										<h6 class="W_E-first W_E">Are we creating your site design?
												<input id="W_E-designPrice" readonly="readonly" class="W_E"/>
										</h6>
										<p class="W_E">Some individuals already have designs made in Photoshop. If you do not have a site designed we will asign an art director to design a custom website template. You will receive two rounds of review/requests. <a href="#" target="_new" class="W_E">view our portfolio</a> </p>
										<div class="W_E">
												<input type="radio" id="W_E-designNo" name="design" checked="checked" class="W_E W_E-width20" value="No" disabled="disabled"/>
												<label for="W_E-designNo" class="W_E">No</label>
												<input type="radio" id="W_E-designYes" name="design" class="W_E W_E-width20" value="Yes"/>
												<label for="W_E-designYes" id="W_E-designAdded" class="W_E">Yes</label>
												<input id="W_E-designPrice2" readonly="readonly"  class="W_E-floatRight W_E-width60 W_E" />
										</div>
								</div>
								<!-- This is a hidden div to ask design specific questions -->
								<div id="W_E-designHidden" class="W_E">
										<div class="W_E-dots W_E">
												<h6 class="W_E">What is your sites primary colors?:</h6>
												<textarea id="W_E-colors" name="colors" rows="" cols="" class="W_E"></textarea>
												<br />
												<br />
												<h6 class="W_E">Please share with us some websites that you like:</h6>
												<textarea id="W_E-sitesDescription" name="sitesDescription" rows="" cols="" class="W_E"></textarea>
												<br />
												<br />
												<h6 class="W_E">Special instructions:</h6>
												<textarea id="W_E-specialDesignInstructions" name="specialDesignInstructions" rows="" cols="" class="W_E"></textarea>
										</div>
								</div>
								<div id="W_E-extrasSection" class="W_E-dots W_E">
										<h6 class="W_E">Extra Options</h6>
										<p class="W_E">These are some extra options that may be very important for your site.</p>
										<input type="checkbox" id="W_E-mobile" name="W_E-mobile" value="mobileSite" class="W_E W_E-width20"/>
										<label id="W_E-mobileSitetxt" class="W_E"></label>
										<input type="checkbox" id="W_E-extra1" name="W_E-extra1" value="extra1" class="W_E W_E-width20"/>
										<label id="W_E-extra1txt" class="W_E"></label>
										<input type="checkbox" id="W_E-extra2" name="W_E-extra2" value="extra2" class="W_E W_E-width20"/>
										<label id="W_E-extra2txt" class="W_E"></label>
										<input type="checkbox" id="W_E-extra3" name="W_E-extra3" value="extra3" class="W_E W_E-width20"/>
										<label id="W_E-extra3txt" class="W_E"></label>
										<input type="checkbox" id="W_E-extra4" name="W_E-extra4" value="extra4" class="W_E W_E-width20"/>
										<label id="W_E-extra4txt"></label>
										<input type="checkbox" id="W_E-extra5" name="W_E-extra5" value="extra5" class="W_E W_E-width20"/>
										<label id="W_E-extra5txt" class="W_E"></label>
										<input type="checkbox" id="W_E-extra6" name="W_E-extra6" value="extra6" class="W_E W_E-width20"/>
										<label id="W_E-extra6txt" class="W_E"></label>
										<input type="checkbox" id="W_E-extra7" name="W_E-extra7" value="extra7" class="W_E W_E-width20"/>
										<label id="W_E-extra7txt" class="W_E"></label>
										<input type="checkbox" id="W_E-extra8" name="W_E-extra8" value="extra8" class="W_E W_E-width20"/>
										<label id="W_E-extra8txt" class="W_E"></label>
										<input type="checkbox" id="W_E-extra9" name="W_E-extra9"  value="extra9" class="W_E W_E-width20"/>
										<label id="W_E-extra9txt" class="W_E"></label>
										<input type="checkbox" id="W_E-extra10" name="W_E-extra10" value="extra10" class="W_E W_E-width20"/>
										<label id="W_E-extra10txt" class="W_E"></label>
								</div>
						</div>
						
						<!-- END SECTION TWO -->
						
						<h3 class="W_E"> <a href="#" class="W_E">Step 3: Widgets</a> </h3>
						<div id="W_E-sectionThree" class="W_E">
								<div class="W_E-dots W_E"><!-- Creates a dotted line -->
										<h6 class="W_E-first W_E">Image Gallery
												<input id="W_E-imgGalleryPrice" readonly="readonly"  class="W_E"/>
										</h6>
										<p class="W_E">An image gallery is normally used to display images. <a href="#" target="_new" class="W_E">See an example</a> </p>
										<div class="W_E"><!-- Puts a background over the radio buttons and a text. You may need to adjsut the width of this div to keep everything on one line. -->
												
												<input type="radio" id="W_E-imgGalleryNo" name="imgGallery"  class="W_E W_E-width20" disabled="disabled"  checked="checked" value="No"/>
												<label for="W_E-imgGalleryNo" class="W_E">No</label>
												<input type="radio" id="W_E-imgGalleryYes" name="imgGallery" class="W_E W_E-width20"  value="Yes"/>
												<label for="W_E-imgGalleryYes" id="W_E-imgGalleryAdded" class="W_E">Yes</label>
												<input id="W_E-imgGalleryPrice2" readonly="readonly" class="W_E-floatRight W_E-width60 W_E"/>
										</div>
								</div>
								<div class="W_E-dots W_E"><!-- Creates a dotted line -->
										<h6 class="W_E">Slide-Show
												<input id="W_E-slideShowPrice" readonly="readonly" class="W_E" />
										</h6>
										<p class="W_E">Slideshow is an option for picture rotations or fades between images. These are currently very popular aross the web. <a href="#" target="_new" class="W_E">See an example</a> </p>
										<div class="W_E"><!-- Puts a background over the radio buttons and a text. You may need to adjsut the width of this div to keep everything on one line. -->
												
												<input type="radio" id="W_E-slideShowNo" name="slideShow" checked="checked"  class="W_E W_E-width20" disabled="disabled"  value="No"/>
												<label for="W_E-slideShowNo" class="W_E">No</label>
												<input type="radio" id="W_E-slideShowYes" name="slideShow" class="W_E W_E-width20"  value="Yes"/>
												<label for="W_E-slideShowYes" id="W_E-slideShowAdded" class="W_E">Yes</label>
												<input id="W_E-slideShowPrice2" readonly="readonly"  class="W_E-floatRight W_E-width60 W_E" />
										</div>
								</div>
								<div class="W_E-dots W_E"><!-- Creates a dotted line -->
										<h6 class="W_E">Lightbox Viewer
												<input id="W_E-lightBoxPrice" readonly="readonly" class="W_E"/>
										</h6>
										<p class="W_E">If you have a picture gallery and you'd like to view each picture in a pop-up window – then the lightbox add-on will be a perfect solution for you. If you choose this option, we will add JavaScript that makes the page fade out when the lightbox is opened, showing a particular picture. <a href="#" target="_new">See an example</a> </p>
										<div class="W_E"><!-- Puts a background over the radio buttons and a text. You may need to adjsut the width of this div to keep everything on one line. -->
												
												<input type="radio" id="W_E-lightBoxNo" name="lightBox" checked="checked"  class="W_E W_E-width20" disabled="disabled"  value="No"/>
												<label for="W_E-lightBoxNo" class="W_E">No</label>
												<input type="radio" id="W_E-lightBoxYes" name="lightBox" class="W_E W_E-width20"  value="Yes"/>
												<label for="W_E-lightBoxYes" id="W_E-lightBoxAdded" class="W_E">Yes</label>
												<input id="W_E-lightBoxPrice2" readonly="readonly" class="W_E-floatRight W_E-width60 W_E"  />
										</div>
								</div>
								<div class="W_E-dots W_E"><!-- Creates a dotted line -->
										<h6 class="W_E">ShareThis
												<input id="W_E-shareThisPrice" readonly="readonly" class="W_E"/>
										</h6>
										<p class="W_E">ShareThis control allows the user to share through social media. <a href="#" target="_new" class="W_E">See an example</a> </p>
										<div class="W_E"><!-- Puts a background over the radio buttons and a text. You may need to adjsut the width of this div to keep everything on one line. -->
												
												<input type="radio" id="W_E-shareThisNo" name="shareThis" checked="checked"  class="W_E W_E-width20" disabled="disabled"  value="No"/>
												<label for="W_E-shareThisNo" class="W_E">No</label>
												<input type="radio" id="W_E-shareThisYes" name="shareThis" class="W_E W_E-width20"  value="Yes"/>
												<label for="W_E-shareThisYes" id="W_E-shareThisAdded" class="W_E">Yes</label>
												<input id="W_E-shareThisPrice2" readonly="readonly" class="W_E-floatRight W_E-width60 W_E" />
												<br />
										</div>
								</div>
								<div class="W_E-dots W_E"><!-- Creates a dotted line -->
										<h6 class="W_E">Carousel
												<input id="W_E-carouselPrice" readonly="readonly" class="W_E"/>
										</h6>
										<p class="W_E">If you have a list of rotating items (for example: images or content blocks), we can add JavaScript that will allow scrolling through these items by clicking on the page links (1,2,3) or by clicking on the next/previous buttons. The list of items can rotate automatically as well. <a href="#" target="_new" class="W_E">See an example</a> </p>
										<div class="W_E"><!-- Puts a background over the radio buttons and a text. You may need to adjsut the width of this div to keep everything on one line. -->
												
												<input type="radio" id="W_E-carouselNo" name="carousel" checked="checked"  class="W_E W_E-width20" disabled="disabled"  value="No"/>
												<label for="W_E-carouselNo" class="W_E">No</label>
												<input type="radio" id="W_E-carouselYes" name="carousel" class="W_E W_E-width20"  value="Yes"/>
												<label for="W_E-carouselYes" id="W_E-carouselAdded" class="W_E">Yes</label>
												<input id="W_E-carouselPrice2" readonly="readonly" class="W_E-floatRight W_E-width60 W_E" />
												<br />
										</div>
								</div>
								<div class="W_E-dots W_E"><!-- Creates a dotted line -->
										<h6 class="W_E">Accordion
												<input id="W_E-accordionPrice" readonly="readonly" class="W_E"/>
										</h6>
										<p class="W_E">Accordion is a great JavaScript feature that allows the revealing of the sub-list of a particular list item with a smooth sliding effect. When one of the sub-lists is revealed – the rest of the items are closed at once. <a href="#" target="_new">See an example</a> </p>
										<div class="W_E"><!-- Puts a background over the radio buttons and a text. You may need to adjsut the width of this div to keep everything on one line. -->
												
												<input type="radio" id="W_E-accordionNo" name="accordion" checked="checked"  class="W_E W_E-width20" disabled="disabled"  value="No"/>
												<label for="W_E-accordion" class="W_E">No</label>
												<input type="radio" id="W_E-accordionYes" name="accordion" class="W_E W_E-width20"  value="Yes"/>
												<label for="W_E-accordionYes" id="W_E-accordionAdded" class="W_E">Yes</label>
												<input id="W_E-accordionPrice2" readonly="readonly" class="W_E-floatRight W_E-width60 W_E" />
												<br />
										</div>
								</div>
								<div class="W_E-dots W_E"><!-- Creates a dotted line -->
										<h6 class="W_E">Custom Forms
												<input id="W_E-customFormsPrice" readonly="readonly"  class="W_E"/>
										</h6>
										<p class="W_E">Choose this option if you'd like to customize the look of your check-boxes, radio buttons, or select drop down menus according to your designs. <a href="#" target="_new" class="W_E">See an example</a> </p>
										<div class="W_E"><!-- Puts a background over the radio buttons and a text. You may need to adjsut the width of this div to keep everything on one line. -->
												
												<input type="radio" id="W_E-customFormsNo" name="customForms" checked="checked"  class="W_E W_E-width20" disabled="disabled"  value="No"/>
												<label for="W_E-customFormsNo" class="W_E">No</label>
												<input type="radio" id="W_E-customFormsYes" name="customForms" class="W_E W_E-width20"  value="Yes"/>
												<label for="W_E-customFormsYes" id="W_E-customFormsAdded" class="W_E">Yes</label>
												<input id="W_E-customFormsPrice2" readonly="readonly" class="W_E-floatRight W_E-width60 W_E" />
												<br />
										</div>
								</div>
								<div class="W_E-dots W_E"><!-- Creates a dotted line -->
										<h6 class="W_E">Multi-Tier Fly Out Menu
												<input id="W_E-flyOutMenuPrice" readonly="readonly" class="W_E" />
										</h6>
										<p class="W_E">Indicate if a multi tier fly-out menu should be added. Please note that the price for this option includes standard CSS multi-level menu integration. If you'd like to add any special effects to the menu – please indicate this in the comments box when posting your project and we will send you a quote for implementing extra menu functionality. <a href="#" target="_new" class="W_E">See an example</a> </p>
										<div class="W_E">
												<input type="radio" id="W_E-flyOutMenuNo" name="flyOutMenu" checked="checked"  class="W_E W_E-width20" disabled="disabled"  value="No"/>
												<label for="W_E-flyOutMenuNo" class="W_E">No</label>
												<input type="radio" id="W_E-flyOutMenuYes" name="flyOutMenu" class="W_E W_E-width20"  value="Yes"/>
												<label for="W_E-flyOutMenuYes" id="W_E-flyOutMenuAdded" class="W_E">Yes</label>
												<input id="W_E-flyOutMenuPrice2" readonly="readonly" class="W_E-floatRight W_E-width60 W_E" />
												<br />
										</div>
								</div>
						</div>
						
						<!-- END SECTION THREE -->
						
						<h3 class="W_E"> <a href="#" class="W_E">Step 4: Submit Project</a> </h3>
						<div id="W_E-sectionFour" class="W_E">
								<div class="W_E_loader"><img src="images/loader.png"/></div>
								<div class="W_E_message"></div>
								
						<!-- YOUR PAYMENT SECTION GOES HERE. -->
								<div class="W_E-col1 W_E">
										<label for="W_E-firstName" class="W_E">First Name: <span class="W_E-red">*</span></label>
										<input name="firstName" id="W_E-firstName" type="text" class="W_E"/>
										<div class="W_E-clear W_E"></div>
										<label for="W_E-lastName" class="W_E">Last Name: <span class="W_E-red">*</span></label>
										<input name="lastName" id="W_E-lastName" type="text" class="W_E"/>
										<div class="W_E-clear W_E"></div>
										<label for="W_E-billingPhone" class="W_E">Phone #: <span class="W_E-red">*</span></label>
										<input name="billingPhone" id="W_E-billingPhone" type="text" class="W_E"/>
										<div class="W_E-clear W_E"></div>
										<label for="W_E-email" class="W_E">Email: <span class="W_E-red">*</span></label>
										<input name="email" id="W_E-email" type="text" class="W_E"/>
										<div class="W_E-clear W_E"></div>
										<label for="W_E-address" class="W_E">Address:</label>
										<input name="address" id="W_E-address" type="text" class="W_E"/>
								</div>
								<div class="W_E-col2 W_E">
										<label for="W_E-city" class="W_E">City:</label>
										<input name="city" id="W_E-city" type="text" class="W_E"/>
										<div class="W_E-clear W_E"></div>
										<label for="W_E-state" class="W_E">State:</label>
										<input name="state" id="W_E-state" type="text" class="W_E"/>
										<div class="W_E-clear W_E"></div>
										<label for="W_E-zip" class="W_E">Zip/Postal:</label>
										<input name="zip" id="W_E-zip" type="text" class="W_E"/>
										<div class="W_E-clear W_E"></div>
										<label for="W_E-country" class="W_E">Country:</label>
										<input name="country" id="W_E-country" type="text" class="W_E"/>
								</div>
								<div class="W_E-clear W_E"></div>
								<div id="W_E-buttons" class="W_E">
										<button class="W_E" id="W_E_submit" type="submit">Next</button>
										
										
										<div class="W_E-clear W_E"></div>
								</div>
						</div>
						<!-- END SECTION FOUR --> 
						
				</div>
				<!-- End Accordion --> 
				
		</div>
		<!--  End demo  -->
		
		<div class="ui-widget W_E-rounded_square W_E" id="W_E-floatingTotal">
				<h6 class="W_E">Order Summary: </h6>
				<div class="W_E-dots W_E">
						<label for="W_E-datepicker" class="W_E days">Date: </label>
						<input type="text" id="W_E-datepicker" name="W_E-datepicker"  disabled="disabled" class="W_E-width100 W_E days" />
						<div class="W_E-clear W_E"></div>
						<label for="W_E-pages" class="W_E pages">Pages: </label>
						<input type="text" id="W_E-pages2" name="W_E-pages2" readonly="readonly"  class="W_E-width60 W_E pages"/>
						<div class="W_E-clear W_E"></div>
						<label for="W_E-amount" class="W_E">Base Cost: <span class="W_E-blue currency"></span> </label>
						<input type="text"  id="W_E-amount" readonly="readonly" class="W_E-width60 W_E"/>
						<div class="W_E-clear W_E"></div>
						<label for="W_E-CMS_AMOUNT" class="W_E">CMS: <span class="W_E-blue currency"></span> </label>
						<input type="text"  id="W_E-CMS_AMOUNT" readonly="readonly" class="W_E-width60 W_E"/>
						<div class="W_E-clear W_E"></div>
						<label for="W_E-siteOptions" class="W_E">Site Options: <span class="W_E-blue currency"></span> </label>
						<input type="text"  id="W_E-siteOptions" readonly="readonly" class="W_E-width60 W_E"/>
						<div class="W_E-clear W_E"></div>
						<label for="W_E-widgets" class="W_E">Widgets: <span class="W_E-blue currency"></span> </label>
						<input type="text"  id="W_E-widgets" readonly="readonly" class="W_E-width60 W_E"/>
						<div class="W_E-clear W_E"></div>
				</div>
				<div class="W_E-dots W_E">
						<label for="W_E-total" class="W_E-total W_E">TOTAL: <span class="W_E-blue currency"></span></label>
						<input type="text"  readonly="readonly" class="W_E-width60 W_E-total W_E" id="W_E-total" name="total"/>
				</div>
				<p class="W_E-small W_E"> *Allow 24 hrs for processing </p>
		</div>
		<input type="hidden" id="W_E-sliderCalc" class="W_E"/>
		<input type="hidden" id="W_E-mobileSiteAmount" class="W_E"/>
		
		<!-- Work around to submit disabled radio buttons without  -->
		<input type="hidden" id="designHidden" name="designHidden" value="No"/>
		<input type="hidden" id="imgGalleryHidden" name="imgGalleryHidden" value="No"/>
		<input type="hidden" id="slideShowHidden" name="slideShowHidden" value="No"/>
		<input type="hidden" id="lightboxHidden" name="lightboxHidden" value="No"/>
		<input type="hidden" id="shareThisHidden" name="shareThisHidden" value="No"/>
		<input type="hidden" id="carouselHidden" name="carouselHidden" value="No"/>
		<input type="hidden" id="accordionHidden" name="accordionHidden" value="No"/>
		<input type="hidden" id="customFormsHidden" name="customFormsHidden" value="No"/>
		<input type="hidden" id="flyoutMenuHidden" name="flyoutMenuHidden" value="No"/>
		
</form>

</div>


<div style="clear:both"></div>


