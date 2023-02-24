<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
Hook Points
The following is a list of available hook points.

pre_system => Called very early during system execution. Only the benchmark and hooks class have been loaded at this point. No routing or other processes have happened.

pre_controller => Called immediately prior to any of your controllers being called. All base classes, routing, and security checks have been done.

post_controller_constructor => Called immediately after your controller is instantiated, but prior to any method calls happening.

post_controller => Called immediately after your controller is fully executed.

display_override => Overrides the _display() method, used to send the finalized page to the web browser at the end of system execution. This permits you to use your own display methodology. Note that you will need to reference the CI superobject with $this->CI =& get_instance() and then the finalized data will be available by calling $this->CI->output->get_output().

cache_override => Enables you to call your own method instead of the _display_cache() method in the Output Library. This permits you to use your own cache display mechanism.

post_system => Called after the final rendered page is sent to the browser, at the end of system execution after the finalized data is sent to the browser.


Multiple Call to the Same Hook

$hook['pre_controller'][] = array(
        'class'    => 'MyClass',
        'function' => 'MyMethod',
        'filename' => 'Myclass.php',
        'filepath' => 'hooks',
        'params'   => array('beer', 'wine', 'snacks')
);

$hook['pre_controller'][] = array(
        'class'    => 'MyOtherClass',
        'function' => 'MyOtherMethod',
        'filename' => 'Myotherclass.php',
        'filepath' => 'hooks',
        'params'   => array('red', 'yellow', 'blue')
);

*/


$hook['pre_controller'] = array(
    "class" => "onload",
    "function" => "checklogin",
    "filename" => "onload.php",
    "filepath" => "hooks"
);
