<?php
    $arr = array( 
        array('name' => 'makan', 'status' => true), 
        array('name' => 'mandi', 'status' => true), 
        array('name' => 'belajar', 'status' => false), 
        array('name' => 'tidur', 'status' => true)
    );

    foreach ($arr as $data) {
        echo ($data['status'] == false) ? 'To do list belum selesai semua' : '';
    }
?>