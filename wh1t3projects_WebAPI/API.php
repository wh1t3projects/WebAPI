<?php
// WebAPI API. 
/* WebAPI intepreter. This is the file that receive the external request and parse it

Copyright 2014 - 2015 Gaël Stébenne (alias Wh1t3c0d3r)

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/
preg_match("/(?<={$TEMP['regex_app_location']}API\/).*?(?:(?=\/)|$)/", $INFO['web_location'], $function);
if (($function = isset($function[0]) ? $function[0] : null) === null ) { 
    kernel_log('Called the API without any function!', 3);
    echo 'Invalid';
    return false;
}
$arguments = explode('/', substr($INFO['web_location'], strlen($CONFIG['app_location'] . "API/$function/")));
if (isset(kernel_protected_var('registeredFunctions')[$function])) {
    $function = kernel_protected_var('registeredFunctions')[$function];
    $call = "$function(";
    foreach ($arguments as $arg) {
        $arg = urldecode($arg);
        $call .= "'$arg',";
    }
    $call = substr($call, 0, -1) . ');';
    kernel_log("Calling $function");
    unset ($function);
    $result = eval("return $call");
    if ($result === null) {
        kernel_log('Call result is null', 4);
    }
    echo json_encode ($result);
} else {
    echo 'Invalid';
    kernel_log("Invalid or non-registered function called: $function",4);
}

?>