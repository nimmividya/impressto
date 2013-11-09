<?php

// sample tags
//  [widget type='bg_pos_slider/bg_widget' bgcolor='#AA22FF' title=wawaewa]
//  direct from PHP cde Widget::run('top_banners, array()'name'=>'widget_1')
// within smarty {widget type='top_banners' name='widget1'}


class top_banners extends Widget
{
    function run() {
		
		$CI =& get_instance();  
		
		$args = func_get_args();
		
		$data['page_id'] = $CI->page_id;
		
		
		$this->render('top_banners_widget',$data);
		
		
		return;
			

		 
    }
}  

?>
