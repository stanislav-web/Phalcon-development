/*
 * jQuery Mobile Framework : plugin to provide a date and time picker.
 * Copyright (c) JTSage
 * UKRAINIAN Language
 * CC 3.0 Attribution.  May be relicensed without permission/notifcation.
 * https://github.com/jtsage/jquery-mobile-datebox
 *
 * Translation by: J.T.Sage <jtsage@gmail.com>
 *
 */

jQuery.extend(jQuery.mobile.datebox.prototype.options.lang, {
  'ua': {
    setDateButtonLabel: "OK",
    setTimeButtonLabel: "OK",
    setDurationButtonLabel: "OK",
    calTodayButtonLabel: "Сьогодні",
    titleDateDialogLabel: "Оберіть дату",
    titleTimeDialogLabel: "Оберіть час",
    daysOfWeek: ["Неділя", "Понеділок", "Вівторок", "Середа", "Четвер", "П'ятниця", "Субота"],
    daysOfWeekShort: ["Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
    monthsOfYear: ["Січеня", "Лютого", "Марта", "Квітня", "Травня", "Червня", "Липня", "Серпня", "Вересня", "Жовтня", "Листопада", "Грудня"],
    monthsOfYearShort: ["Січ", "Лют", "Мар", "Кві", "Тра", "Чер", "Лип", "Сер", "Вер", "Жов", "Лис", "Гру"],
    durationLabel: ["Дні", "Години", "Хвилини", "Секунди"],
    durationDays: ["День", "Днів"],
    tooltip: "Відкрити календар",
    nextMonth: "Наст. місяць",
    prevMonth: "Попер. місяць",
    timeFormat: 12,
    headerFormat: '%-d %B,  %Y',
    dateFieldOrder: ['M', 'd', 'y'],
    timeFieldOrder: ['h', 'i', 'a'],
    slideFieldOrder: ['y', 'm', 'd'],
    dateFormat: "%-m/%-d/%Y",
    useArabicIndic: false,
    isRTL: false,
    calStartDay: 0,
    clearButton: "Стерти",
    durationOrder: ['d', 'h', 'i', 's'],
    meridiem: ["AM", "PM"],
    timeOutput: "%l:%M %p",
    durationFormat: "%Dd %DA, %Dl:%DM:%DS"
  }
});
jQuery.extend(jQuery.mobile.datebox.prototype.options, {
  useLang: 'ua'
});
