<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cross_script_experiment extends PSAdmin_Controller {


	public function __construct(){
		
		parent::__construct();

				
	}
	

	public function index(){

		echo "<div style=\"padding:10px; background:#DDDDDD;\"><h1>This annoying shit is coming from another domain via remote javascript</h1>";
		
		echo " <p>SEE: <a href=\"http://anyorigin.com/\">http://anyorigin.com</a><br />";
		
		echo "<table>
    <tr>
        <td>Foo</td>
        <td>
            <div class=\"bouncyHouse\">
                <div class=\"bouncer1\">
                    <img src=\"http://cazasaikaley.acartdev.com/assets/sparks/visualcaptcha/images/christmas/santa_claus.png\" />
                </div>
                <div class=\"bouncer2\">
                    <img src=\"http://cazasaikaley.acartdev.com/assets/sparks/visualcaptcha/images/christmas/snowman.png\" />
                </div>
				
            </div>
        </td>
    </tr>
</table>

		</div>";
		


		
	}
	
}