/**
 * Инициализация Front End билиотек и функций
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /public/js/mobile/init.js
 * @since Browsers support *
 */

$(document).on('mobileinit', function() { /* Инициализирую preload jQuery Mobile */
	$.mobile.page.prototype.options.theme = "a"; // тема для загрузчика
  	$.mobile.loader.prototype.options.text = lang.loadingMessage; // текст ajax загрузчика
  	$.mobile.loader.prototype.options.textVisible = false; // показывать текст загрузчика
	$.mobile.pageLoadErrorMessage = lang.pageLoadErrorMessage; // сообщение об ошибке загрузке страницы
	$.mobile.defaultPageTransition = "slide"; // вариант загрузки страниц по умолчанию
	$.mobile.ajaxEnabled = false; // выключаю ajax навигацию по ссылкам
        $.mobile.selectmenu.prototype.options.nativeMenu = false; // нативное меню в select элементах
});

/**
 * Табы (решистрация, авторизация, восстановление
 */
$(document).delegate('.ui-navbar ul li > a', 'click', function () {
    $(this).closest('.ui-navbar').find('a.ui-tab').removeAttr('data-active-tab');
    $(this).attr('data-active-tab', 'true');
    $('#' + $(this).attr('data-href')).show().siblings('.inner-tabs').hide();
});


$('section').on('pageinit', function(event) {
    $('.ui-dialog button').on("click", function() {
        // действия при клике на диалоговое окно
        $("[data-role='dialog']").dialog("close");
    });
});

$(document).on('pagechange', function(event){
    // События
    $('nav ul li:eq(1) a.ui-tab').attr('data-active-tab', 'true');
    //$('#auth').show().siblings('.inner-tabs').hide();
});
