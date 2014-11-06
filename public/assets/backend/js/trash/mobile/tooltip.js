/**
 * Всплывающие подсказки. Бонус! Поддержка мобильных устройств
 * @author Stanislav WEB | Lugansk <stanislav@uplab.ru>
 * @filesource /public/js/mobile/tooltip.js
 * @since Browsers support *
 */

$(document).ready(function() {
    var TOOLTIP  =   {
        object  :   $('[data-tooltip]'), // объекты, которые необходимо обходить
        init    :   false, // для функции инициализации
        remove  :   false, // для уничтожения подсказки
        target  :   false, // определенный объект
        tooltip :   false, // посказка по умолчанию
        title   :   false, // текст подсказки по умолчанию
        left    :   0, // позиционирование от левой стороны
        top     :   0, // позиционирование от верха

    }
    TOOLTIP.object.bind('mouseenter', function()
    {
        TOOLTIP.target  =   $(this);
        TOOLTIP.title   =   TOOLTIP.target.attr('title');
        TOOLTIP.tooltip =   $('<div class="ui-tooltip"></div>');

        if(!TOOLTIP.title || TOOLTIP.title == '') return false; // если пустой title у эл-та

        // создаю контейнер для tooltip подсказки
        TOOLTIP.target.removeAttr('title');
        TOOLTIP.tooltip .css('opacity', 0)
                        .html(TOOLTIP.title)
                        .appendTo('body');

        TOOLTIP.init = function() // инициализирую подсказку и настраиваю позиционирование
        {
            if($(window).width() < TOOLTIP.tooltip.outerWidth() * 1.5) TOOLTIP.tooltip.css('max-width', $(window).width()/2);
            else  TOOLTIP.tooltip.css('max-width', 340);
            TOOLTIP.left    =   TOOLTIP.target.offset().left + (TOOLTIP.target.outerWidth()/2) - ( TOOLTIP.tooltip.outerWidth() / 2 ),
            TOOLTIP.top     =   TOOLTIP.target.offset().top - TOOLTIP.tooltip.outerHeight() - 20;

            if(TOOLTIP.left < 0)
            {
                TOOLTIP.left = TOOLTIP.target.offset().left + TOOLTIP.target.outerWidth() / 2 - 20;
                TOOLTIP.tooltip.addClass('left');
            }
            else TOOLTIP.tooltip.removeClass('left');

            if(TOOLTIP.left + TOOLTIP.tooltip.outerWidth() > $(window).width())
            {
                TOOLTIP.left = TOOLTIP.target.offset().left - TOOLTIP.tooltip.outerWidth() + TOOLTIP.target.outerWidth() / 2 + 20;
                TOOLTIP.tooltip.addClass('right');
            }
            else TOOLTIP.tooltip.removeClass('right');

            if(TOOLTIP.top < 0)
            {
                TOOLTIP.top  = TOOLTIP.target.offset().top + TOOLTIP.target.outerHeight();
                TOOLTIP.tooltip.addClass('top');
            }
            else TOOLTIP.tooltip.removeClass('top');

            TOOLTIP.tooltip.css(
                        {
                            left    : TOOLTIP.left,
                            top     : TOOLTIP.top
                        }
                    )
                   .animate({ top: '+=10', opacity: 1 }, 50);
        }
        TOOLTIP.init(); // инициализурю
        $(window).resize(TOOLTIP.init); // подгоняю размер

        TOOLTIP.remove = function()
        {
            TOOLTIP.tooltip.animate({ top: '-=10', opacity: 0}, 50, function()
            {
                $(this).remove();
            });

            TOOLTIP.target.attr('title', TOOLTIP.title);
        };

        // уничтожаю
        TOOLTIP.target.bind('mouseleave', TOOLTIP.remove);
        TOOLTIP.tooltip.bind('click', TOOLTIP.remove);
    });
});

