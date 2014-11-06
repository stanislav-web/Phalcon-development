/**
 * Locations. Ajax autocomplete locations: country > region > city
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @extends jQuery, (jQuery Mobile)
 * @since Browsers Support:
 *  - Internet Explorer 8+
 *  - Mozilla Firefox 3.6+
 *  - Opera 10.5+
 *  - Safari 4+
 *  - iPhone Safari
 *  - Android Web Browser
 *  
 *  @see 
 *  $('select.autocomplete').on('change', function(e) {
 *      e.preventDefault();
 *      
 *      var query   =   {}; 
 *      
 *      // formed request params
 *      
 *      query['request']               =   $(this).data('request');
 *      query[$(this).attr('name')]    =   $(this).val();
 *      
 *      // send request
 *      Locations.request('/locations/json', query, 'POST');
 *   });   
 */
var Locations =  {
    
    /**
     * @var data request params
     * @type array object
     */
    data     :   [],
    
    /**
     * @var messages an error messages container
     * @type Array
     */
    messages    :   [],
    
    /**
     * @var errorclass styling existing errors
     * @type string
     */
    errorclass  :   'ui-error',
    
    /**
     * request(uri, query, method) request method
     * @param string uri
     * @param object query
     * @param string method
     * @returns this.callback()
     */
    request :   function(uri, query, method)
    {
        try {
            if(typeof uri       == 'string') this.data['uri']       =   uri;
            if(typeof query     == 'object') this.data['query']     =   query;
            if(typeof method    == 'string') this.data['method']    =   method;
            
            var element = $('[data-response='+this.data['query']['request']+']');
            
            // send ajax request
            
            $.ajax({
                url         :   this.data['uri'],    
                data        :   this.data['query'],  
                method      :   this.data['method'],
                dataType    :   'json',   
                
                beforeSend: function(/*jqXHR, settings*/) {
                    // Handle the beforeSend event
                    $('.'+Locations.errorclass).remove();
                    if("loading" in $.mobile) $.mobile.loading('show');
                },
                
                success: function(data, textStatus) {
                    // Handle the success event
                    if(textStatus == 'success') return Locations.callback(element, data);
                    else Locations.messages.push('Error while success response');
                },
                
                error:  function(jqXHR, textStatus, errorThrown) {
                    // Handle the error event
                    Locations.messages.push(errorThrown);
                },
                
                complete: function(/*jqXHR, textStatus*/) {
                    // Handle the complete event
                    
                    if(element.length) if("selectmenu" in element) element.selectmenu('refresh');
                        else Locations.messages.push('Cannot update select list');
                        
                    // check if existing error and show it
                    if(Locations.messages.length > 0)
                    {   
                        var errlist    =   '',
                            max;
                    
                        for(i = 0, max = Locations.messages.length; i < max; i++) 
                        {
                            errlist += '<li>'+Locations.messages[i]+'</li>';
                        };
                        element.before('<ul class="'+Locations.errorclass+'">'+errlist+'</ul>');
                        errlist = '';
                    }
                    if("loading" in $.mobile) $.mobile.loading('hide');
                }, 
                statusCode: {
                    401: function() {
                        Locations.messages.push('Authorization required');
                    },      
                    403: function() {
                        Locations.messages.push('Access denied');
                    },                    
                    404: function() {
                        Locations.messages.push('Page not found');
                    }
                }
            });   // and ajax calls         
        }
        catch(error) {
            this.messages.push(error.message);
        }
    },
    
    /**
     * callback(element, data) complete data from response
     * @param jQuery object element
     * @param array data
     * @returns this object
     */
    callback    :   function(element, data) {
        try {
            if(!this.messages.length)
            {
                var list    =   '';
                data.forEach(function(entry) 
                {
                    var id = entry.id ? entry.id : entry.city_id; 
                    list += '<option value="'+id+'">'+entry.name+'</option>';
                });                
                element.empty().html(list);
            }
        }
        catch(error) {
            this.messages.push(error.message);
        }
        return this;
    },
}

