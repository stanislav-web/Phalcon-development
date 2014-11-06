/*
 * jQuery Mobile Framework : plugin to provide a date and time picker.
 * Copyright (c) JTSage
 * RUSSIAN Language
 * CC 3.0 Attribution.  May be relicensed without permission/notifcation.
 * https://github.com/jtsage/jquery-mobile-datebox
 *
 * Translation by: J.T.Sage <jtsage@gmail.com>
 *
 */

jQuery.extend(jQuery.mobile.datebox.prototype.options.lang, {
  'ru': {
    setDateButtonLabel: "OK",
    setTimeButtonLabel: "OK",
    setDurationButtonLabel: "OK",
    calTodayButtonLabel: "На сегодня",
    titleDateDialogLabel: "Выберите дату",
    titleTimeDialogLabel: "Выберите время",
    daysOfWeek: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
    daysOfWeekShort: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
    monthsOfYear: ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"],
    monthsOfYearShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
    durationLabel: ["Дни", "Часы", "МАинуты", "Секунды"],
    durationDays: ["День", "Дней"],
    tooltip: "Открыть календарь",
    nextMonth: "След. месяц",
    prevMonth: "Предыдущий месяцц",
    timeFormat: 12,
    headerFormat: '%-d %B,  %Y',
    dateFieldOrder: ['M', 'd', 'y'],
    timeFieldOrder: ['h', 'i', 'a'],
    slideFieldOrder: ['y', 'm', 'd'],
    dateFormat: "%-m/%-d/%Y",
    useArabicIndic: false,
    isRTL: false,
    calStartDay: 0,
    clearButton: "Очистить",
    durationOrder: ['d', 'h', 'i', 's'],
    meridiem: ["AM", "PM"],
    timeOutput: "%l:%M %p",
    durationFormat: "%Dd %DA, %Dl:%DM:%DS"
  }
});
jQuery.extend(jQuery.mobile.datebox.prototype.options, {
  useLang: 'ru'
});
