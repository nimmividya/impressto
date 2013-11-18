<?php
/*
@Name: Font Resizer Tool
@Type: PHP
@Filename: font_resizer.php
@Description: Adds a simple font resizer toolbar
@Projectnum: 1001
@Author: Nimmitha Vidyathilaka
@Status: development
@Date: 2012-06-29
*/
?>


<script>

$(document).ready(function(){
  // Reset Font Size
  var originalFontSize = $('html').css('font-size');
    $(".resetFont").click(function(){
    $('html').css('font-size', originalFontSize);
  });
  // Increase Font Size
  $(".increaseFont").click(function(){
    var currentFontSize = $('html').css('font-size');
    var currentFontSizeNum = parseFloat(currentFontSize, 10);
    var newFontSize = currentFontSizeNum*1.2;
    $('html').css('font-size', newFontSize);
    return false;
  });
  // Decrease Font Size
  $(".decreaseFont").click(function(){
    var currentFontSize = $('html').css('font-size');
    var currentFontSizeNum = parseFloat(currentFontSize, 10);
    var newFontSize = currentFontSizeNum*0.8;
    $('html').css('font-size', newFontSize);
    return false;
  });
});

</script>


<div id="changeFont">
<a href="#" class="increaseFont">Increase</a>
<a href="#" class="decreaseFont">Decrease</a>
<a href="#" class="resetFont">Reset</a>
</div>

