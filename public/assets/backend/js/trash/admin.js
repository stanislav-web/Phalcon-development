/**
 * Инициализация Front End билиотек и функций для административной части
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /public/js/admin.js
 * @since Browsers support *
 */

/*
 * @type object ADMIN elements
 */ 
$(document).on('pageinit', function(e)
{ 
    var ADMIN_FUNC  =   {
                        clock:  function () { // часы
                            var currTime = new Date();
                            var currMinutes = (currTime.getMinutes() < 10 ? "0" : "" ) + currTime.getMinutes();
                            var currSeconds = (currTime.getSeconds() < 10 ? "0" : "" ) + currTime.getSeconds();
                            var currTimeString = currTime.getHours() + ":" + currMinutes + ":" + currSeconds;
                            return currTimeString;
                        },
    };
    var ADMIN_DOM   =   {
                        clockContiner       :   $('a#clock'),
                        clockImgContainer   :   '<img src="/assets/backend/images/admin/clock.png" /> ',
                        checkall            :   $('input[name=all]'),
                        checkbox            :   $('input[name="select[]"]'),
    };
    
    /**
     * Часы
     * @returns {undefined}
     */
    setInterval(function() {
        ADMIN_DOM.clockContiner.html(ADMIN_DOM.clockImgContainer+''+ADMIN_FUNC.clock());
    }, 1000);
    
    /**
     * Отмечаю все checkbox
     */
    ADMIN_DOM.checkall.change(function() {
        if(ADMIN_DOM.checkbox.is(':checked')) ADMIN_DOM.checkbox.attr("checked",false).checkboxradio("refresh");
        else ADMIN_DOM.checkbox.attr("checked",true).checkboxradio("refresh");
    });    
});

                  
     
