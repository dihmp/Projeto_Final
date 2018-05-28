<?php
	function sanitize($dirty){
		return htmlentities($dirty, ENT_QUOTES, "UTF-8");
	}
	function login($id){
        $_SESSION['arterepo'] = $id;
        header('Location: /arterepo/index.php');
    }
    function display_errors($errors){
        $display = '<ul class="bg-danger">';
        foreach($errors as $error){
            $display .= '<li class="text-danger">'.$error.'</li>';
        }
        $display .= '</ul>';
        
        return $display;
    }
    function format_date($date){
        $dt = explode("-", $date);
        $date = $dt[2].'/'.$dt[1].'/'.$dt[0];
        
        return $date;
    }
?>