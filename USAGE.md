## Module's description
This module provides an easy way to add an API to your web application. It works by allowing a function to be called directly as an HTTP request.<br/>
**IMPORTANT**: Your function must be well protected against attacks, since this module **do not** verify the information sent within a request.

## Registering an endpoint
The easiest and quickest way to register a function as an endpoint, is to call `webapi_register()` with your function's name as a parameter, just like this: `webapi_register('myfunction')`. This will create an endpoint that will be listening at `/API/myFunction`.<br/>
You can also provides a name to expose your function as. Please see the last section of this document for the function's definition

## Using an API endpoint
Calling an endpoint is as easy as sending a GET or POST request to the created endpoint. To use an endpoint, you simply need to send a request to `/API/yourFunctionName`. *GET* requests are handled by the module and will be parsed before being sent to the function. *POST* requests are handled directly by the called function.

### Via GET
This is the easiest method, but restricts you to the function's declared parameters.<br/>
Arguments that needs to be sent to the function only needs to be provided as part of the *GET* request in the same order as you would call the function within PHP.

For example, let's say we have a function defined by `function myFunction($myFirstValue, $mySecondValue)`. This one accepts two parameters: `$myFirstValue` and `$mySecondValue`. From PHP, you could call that function with `myFunction('First value', 'Second value')`.<br/>
From the API, you can use a *GET* request to call it the same way. A request that would send the same values would look like `/API/myFunction/First value/Second value`.<br/>

This works because the API handler will first parse the *GET* request before sending it to the function. The forward-slash (`/`) is the parameter seperator. You can use as many parameters as your function and web server allows (maximum request lenght).

**NOTE**: Data sent this way can only be text. If you wanted to send something else than text, you need to encode it so that it becomes text (like BASE64).

### Via POST
This method requires handling to be done by your function, since the module won't parse data sent via *POST*.<br/>
To call a function via *POST*, you only need to send a *POST* request to `/API/yourFunctionName`.<br/>
Just like any *POST* requests, sent data will be available directly in `$_POST`.

**NOTE**: Unlike with a *GET* request, you can send any data your script and PHP can handle. Also, you are not restricted by the request lenght, but by the *POST* maximum size defined in both PHP and the web server (this is usually higher than *GET*).<br/>
Also, even if it is a *POST* request, you can still provide data to your function the same way as if it was a *GET* request. Please see the previous section on how to do it.


## The output
If a function return data after the execution, it will be encoded as *JSON* and returned directly to the requester.
<br/><br/>

## Function's usage
**Syntax**: `WebAPI_register(string $function, [string $endpointName])`


Register a function as an API endpoint. By default, the endpoint will have the same name as the function's, but a set to a different one via `$endpointName`.

<br/>

**Parameters**

*$function*
<br/>
   The function to register. **Provide only the name, without the parentheses**

<br/>

**Optional** *$endpointName*
<br/>
   The name to expose the function as
   
**Return values**

Return `TRUE` if the function has been registered and the endpoint is created. `FALSE` if the endpoint already exist (not if the function is already registered).<br/>

**NOTE**: `TRUE` will be returned even the function **doesn't exist**. If a non-existent function is registered, a fatal PHP error will occur at the moment a request is received for it.

<br/>

**Examples**:

*Register **myFunction** as an endpoint*
<br/>
`WebAPI_register('myFunction')`


*Register *myFunction* as an endpoint and expose it as **helloWorld***
<br/>
`WebAPI_register('myFunction', 'helloWorld')`