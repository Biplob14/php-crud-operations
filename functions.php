<?php
    // create image name from random stringing
    function randomString($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for($i = 0; $i < $n; $i++) {
            $index = mt_rand(0, strlen($characters) - 1); // mt_rand function works 10 times faster than rand
            $str .= $characters[$index];
        }
        return $str;
    }
?>