<?php
// WebAPI init file. 
/* WebAPI initialisation file

Copyright 2014 - 2019 Gaël Stébenne (alias Wh1t3c0d3r)

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
kernel_override_url('/API', 'API.php', 1);
kernel_protected_var("registeredFunctions", array());
kernel_protected_var_addScript('registeredFunctions', 'API.php');

function WebAPI_register($function, $endpointName = null){
    $endpointName = $endpointName === null ? $function : $endpointName;
    $registeredFunctions = kernel_protected_var("registeredFunctions");
    if (isset ($registeredFunctions[$function])) {
        kernel_log("Function $function is already registered. Cannot register the same function twice.", 4);
        return false;
    } else {
        $registeredFunctions[$endpointName] = $function;
        kernel_protected_var("registeredFunctions", $registeredFunctions);
        kernel_log("Function $function registered. Exposed as $endpointName");
    }
}
?>