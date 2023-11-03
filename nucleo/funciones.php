
<?php
    function generate_string( $strength = 16) {

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input=$permitted_chars;

        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
    
        return $random_string;
    }


    function voltear_fecha($fecha){
        $pieces = explode("-", $fecha);
        return $pieces[2].'/'.$pieces[1].'/'.$pieces[0];
    }
?>