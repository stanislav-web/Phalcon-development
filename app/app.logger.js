
(function(angular) {

    "use strict";

    function getXmlHttp() {
        var xmlhttp;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                xmlhttp = false;
            }
        }
        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
            xmlhttp = new XMLHttpRequest();
        }
        xmlhttp.withCredentials = true;
        return xmlhttp;
    }

    angular.module('app.logger', [])

        /**
         * Service that gives us a nice Angular-esque wrapper around the * stackTrace.js pintStackTrace() method.
         */
        .factory( "traceService", function() {
                return({
                    print: printStackTrace
                });
            }
        )

        /**
         * Override Angular's built in exception handler, and tell it to
         * use our new exceptionLoggingService which is defined below
         */
        .provider( "$exceptionHandler",{
            $get: function(exceptionLoggingService) {
                return (CONFIG.LOGGER === true) ? (exceptionLoggingService) : function(exception, cause) {
                    exception.message += ' (caused by "' + cause + '")';
                    throw exception;
                };
            }
        })

        /**
         * Exception Logging Service, currently only used by the $exceptionHandler
         * it preserves the default behaviour ( logging to the console) but
         * also posts the error server side after generating a stacktrace
         */
        .factory( "exceptionLoggingService", ['$log','traceService', function($log, traceService) {
            function error(exception, cause) {

                // preserve the default behaviour which will log the error
                // to the console, and allow the application to continue running.
                $log.error.apply($log, arguments);

                // now try to log the error to the server side.
                try {

                    var errorMessage = exception.toString();
                    // use our traceService to generate a stack trace
                    var stackTrace = traceService.print({e: exception});

                    // use AJAX and NOT
                    // an angular service such as $http

                    var xmlhttp = getXmlHttp();
                    xmlhttp.open('POST', CONFIG.URL + CONFIG.REST.LOG, true);
                    xmlhttp.setRequestHeader('Content-Type', CONFIG.ACCEPT_ENCODING);
                    xmlhttp.setRequestHeader('Access-Control-Allow-Credentials', 'true');
                    xmlhttp.setRequestHeader('Access-Control-Allow-Headers', 'Accept, Authorization, X-Requested-With, Content-Type, Accept-Language, origin');
                    xmlhttp.setRequestHeader('Access-Control-Allow-Origin', '*');

                    xmlhttp.send(angular.toJson(
                            {
                                code:   1,
                                uri :   location.href,
                                message: stackTrace,
                                exception: errorMessage,
                            })
                    );
                    xmlhttp.onreadystatechange = function() { // waiting for response from server

                        if (xmlhttp.readyState == 4) {
                            if(xmlhttp.status == 201) {
                                console.log(xmlhttp.responseText);
                            }
                        }
                    };

                } catch (loggingError) {
                    $log.warn("Error server-side logging failed");
                    $log.log(loggingError);
                }
            }
            return(error);
        }])

})(angular);