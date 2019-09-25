//Function found here: https://gist.github.com/ryanburnette/8803238
$.fn.setNow = function (onlyBlank) {
    var now = new Date($.now())
        , year
        , month
        , date
        , hours
        , minutes
        , seconds
        , formattedDateTime
    ;

    year = now.getFullYear();
    month = now.getMonth().toString().length === 1 ? '0' + (now.getMonth() + 1).toString() : now.getMonth() + 1;
    date = now.getDate().toString().length === 1 ? '0' + (now.getDate()).toString() : now.getDate();
    hours = now.getHours().toString().length === 1 ? '0' + now.getHours().toString() : now.getHours();
    minutes = now.getMinutes().toString().length === 1 ? '0' + now.getMinutes().toString() : now.getMinutes();

    formattedDateTime = year + '-' + month + '-' + date + 'T' + hours + ':' + minutes;

    if (onlyBlank === true && $(this).val()) {
        return this;
    }

    $(this).val(formattedDateTime);

    return this;
}

$(function () {
    // Handler for .ready() called.
    $('input[type="datetime-local"]').setNow();
});

function goBack() {
    window.history.back();
}

var now = new Date($.now())
    , year
    , month
    , date
    , hours
    , minutes
    , seconds
    , formattedDateTime
;

year = now.getFullYear();
month = now.getMonth().toString().length === 1 ? '0' + (now.getMonth() + 1).toString() : now.getMonth() + 1;
date = now.getDate().toString().length === 1 ? '0' + (now.getDate()).toString() : now.getDate();
hours = now.getHours().toString().length === 1 ? '0' + now.getHours().toString() : now.getHours();
minutes = now.getMinutes().toString().length === 1 ? '0' + now.getMinutes().toString() : now.getMinutes();

now.setDate(now.getDate() + 21);
formattedDateTime = year + '-' + month + '-' + date + 'T' + hours + ':' + minutes;
if (document.getElementById('date')) {
    document.getElementById("date").setAttribute("min", formattedDateTime);
}

function onSubmit(token) {
    document.getElementById("form").submit();
}

function menuIsCollapsed() {
    document.getElementById('logo').classList.toggle('logoCollapsed');
}

(function ($) {
    $(document).ready(function () {
        $(window).scroll(function () {
            if ($(window).width() < 1200) {
                if ($(this).scrollTop() < 100) {
                    $('#logoContainer').show();
                    $('#navBarToggler').removeClass('toTop');
                    $('#navBar').removeClass('removeNavbarBackground');
                    $('#navbarResponsive').removeClass('navBarResponsive');
                } else {
                    $('#logoContainer').hide();
                    $('#navBarToggler').addClass('toTop');
                    $('#navBar').addClass('removeNavbarBackground');
                    $('#navbarResponsive').addClass('navBarResponsive');
                }
            }
        });
    });
})(jQuery);

$('#workspace-date-picker').datepicker({
    format: "dd-mm-yyyy",
    maxViewMode: 1,
    startDate: "0d",
    endDate: now,
    todayBtn: true,
    clearBtn: true,
    language: "nl",
    daysOfWeekDisabled: "0,6",
    daysOfWeekHighlighted: "0,6",
    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true
});

$('#date-picker').datepicker({
    format: "dd-mm-yyyy",
    maxViewMode: 1,
    startDate: "0d",
    todayBtn: true,
    clearBtn: true,
    language: "nl",
    daysOfWeekDisabled: "0,6",
    daysOfWeekHighlighted: "0,6",
    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true
});

var input = $('#time').clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    'default': 'now'
});

var input = $('#time1').clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    'default': 'now'
});

$(document).ready(function () {
    var stickyTop = $('.sticky').offset().top;

    if ($(window).width() > 576) {
        $(window).scroll(function () {
            var windowTop = $(window).scrollTop();

            if (stickyTop < windowTop) {
                $('.sticky').css('position', 'fixed').addClass('signUp');
            } else {
                $('.sticky').css('position', 'relative').removeClass('signUp');
            }
        });
    }
});