<?php

namespace Phostr\Templates;

class Template{

	public function main_header($title, $css_file, $js_file){
		echo '<html>
			<head>
<title>'..'</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
';
if(isset($css_file)){ echo "<link href='http://localhost:4000/assets/css/".$css_file."'";}
echo '</head>
	<body>
';
	}


	public function main_footer(){
		echo '<script src="http://localhost:4000/assets/js/app.js"></script>';
		echo '</body></html';
	}

	public function main_navbar($login=false){
		
	}


}

