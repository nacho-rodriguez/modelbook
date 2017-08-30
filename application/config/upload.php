<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['upload_path'] = './assets/uploads';
$config['allowed_types'] = 'gif|jpg|png';
$config['file_ext_tolower'] = 'TRUE';
$config['max_size'] = '1024';        //1MB=1024 KB
$config['remove_spaces'] = 'TRUE';
$config['encrypt_name'] = 'TRUE';
$config['overwrite'] = 'TRUE';
