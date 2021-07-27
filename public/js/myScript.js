// $(document).ajaxSend(function () {
//     $('body').preloader();
// });
// $(document).ajaxComplete(function () {
//     $('body').preloader('remove');
// });

(function () {
    "use strict";

    window.addEventListener("load", function () {
        var forms = document.getElementsByClassName("needs-validation");

        var validator = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener("submit", function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    event.preventDefault();
                    event.stopPropagation();
                    submitForm();
                }
            }, false);
        });
    }, false);
})();

$(document).ready(function () {
    // Initialise the MDBootstrap API
    $.material.init();

    //Initialize Select2 Elements
    $('select').select2();

    // Resolve conflict in jQuery UI tooltip with Bootstrap tooltip
    $.widget.bridge('uibutton', $.ui.button);

    // Used to set alerts automatic dismissal
    $(() => {
        setTimeout(function () {
            $(".alert").alert('close');
        }, 5000);
    });

    $('form').attr('autocomplete', 'off');
    // $('form').sisyphus();

    $("#phone1, #phone2, #phonecode, #isocode, #code, #inst_com, #col_com, #plat_com, #part_com, #plancode, #per_rate, #cnpsnumb, #tax_rate, #login_attempt, #block_duration, #inactive_duration").prop("type", "number");
    $(".bene_reg, .limit").prop('type', 'number');
    $("input[type='number']").prop("min", "0");
    $("#per_rate, #tax_rate").prop("step", "0.01");

    $("input[type='number']").prop("oninput", "validity.valid ? this.save = value : value = this.save;");
    $("#per_rate").prop("oninput", "this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\\..*)\\./g, '$1');");

    $(".limit, .bene_reg, #per_rate, #tax_rate, #inst_com, #col_com, #plat_com, #part_com").prop("max", "100");

    $("input[type='date']").prop("data-date", "");
    $("input[type='date']").prop("data-date-format", "dd/mm/yyyy");
});

$(document).on("input", "input[type='text'], #name", function () {
    $(this).val($(this).val().toUpperCase());
});

$(document).on("input", "#dev_model", function () {
    $(this).val($(this).val().toLowerCase());
});

$('#home, .home').on('click', function () {
    $('#homePage').trigger('submit');
});

$('td button').on('click', function () {
    location.href = "#page-top";
});

function mySwal(title, text, no, yes, formUrl, icon = 'info') {
    swal({
        icon: icon,
        title: title,
        text: text,
        closeOnClickOutside: false,
        allowOutsideClick: false,
        closeOnEsc: false,
        buttons: {
            cancel: {
                text: " " + no,
                value: false,
                visible: true,
                closeModal: true,
                className: "btn bg-red fa fa-close"
            },
            confirm: {
                text: " " + yes,
                value: true,
                visible: true,
                closeModal: true,
                className: "btn bg-green fa fa-check"
            },
        },
    }).then(function (isConfirm) {
        if (isConfirm) {
            $(formUrl).submit();
        }
    });
}

function myOSwal(title, text, icon = 'info') {
    swal({
        icon: icon,
        title: title,
        text: text,
        closeOnClickOutside: false,
        allowOutsideClick: false,
        closeOnEsc: false,
        buttons: {
            confirm: {
                text: "OK",
                value: true,
                visible: true,
                closeModal: true,
                className: "btn bg-blue"
            },
        },
    });
}

function setDisabled(choice) {        
    $('.fillform :input').prop('disabled', choice);
    $('.fillform :input[type="checkbox"]').prop('disabled', choice);
    $('.fillform :input[type="radio"]').prop('disabled', choice);
    $('.fillform :input[type="button"]').prop('disabled', choice);
    $('.select2').prop('disabled', choice).select2();
}

/**
 *
 * @param text
 * @param type
 * @returns {*}
 */
function trimOver(text = null, type = null) {
    if (text !== null) {
        if (type === null) {
            return text.replace(/ /g, '');
        }
        return text.replace(/,/g, ' ');
    }
    return 0;
}

/**
 *
 * @param number
 * @returns {*}
 */
function money(number, type = ',') {
    var amount = accounting.formatNumber(number);

    return trimOver(amount, type);
}

/**
 *
 * @param number
 * @param lang
 * @returns {string}
 */
function toWord(number, lang) {
    if (lang === 'fr')
        return writtenNumber(number, {lang: 'fr'}).toUpperCase();
    else
        return writtenNumber(number).toUpperCase();
}

/**
 *
 * @param text
 * @param size
 * @param type
 * @returns {string|*}
 */
function pad(text, size = 2, type = 'left') {
    var length = text.toString().length;
    var output = '';

    if (type === 'left') {
        for (var i = 0; i < (size - length); i++) {
            output += '0';
        }
        return output + '' + text;
    } else {
        output = text;
        for (var i = 0; i < (size - length); i++) {
            output += '0';
        }
        return output;
    }
}

/**
 *
 * @param userDate
 * @returns {string}
 */
function userDate(userDate) {
    var date = new Date(userDate);
    return Date.parse(date).toString('dd/MM/yyyy');
}

/**
 *
 * @param sysDate
 * @returns {string}
 */
function sysDate(sysDate) {
    var date = new Date(sysDate);
    return Date.parse(date).toString('yyyy-MM-dd');
}

/**
 *
 * @param days
 * @returns {string}
 */
function formDate(days) {
    var date = new Date();
    date = date.addDays(parseInt(days));
    return Date.parse(date).toString('yyyy-MM-dd');
}

function installment_date(grace) {
    var date = new Date();
    
    if (grace === 'D') {
        date = date.addDays(1);
    } else if (grace === 'W') {
        date = date.addDays(7);
    } else if (grace === 'B') {
        date = date.addDays(15);
    } else if (grace === 'M') {
        date = date.addMonths(1);
    } else if (grace === 'T') {
        date = date.addMonths(3);
    } else if (grace === 'S') {
        date = date.addMonths(6);
    } else {
        date = date.addYears(i);
    }

    return Date.parse(date).toString('yyyy-MM-dd');
}

/**
 * Used to get Data
 * @param url
 * @returns {Promise<any>}
 */
async function getData(url) {
    const response = await fetch('/' + url);
    return response.json();
}

$.fn.verifNumber = function () {
    return this.bind("input paste keyup", function () {
        setTimeout($.proxy(function () {
            this.val(this.val().replace(/[^0-9]/g, ''));
        }, $(this)), 0);
    });
};

$.fn.number = function () {
    return this.bind("input paste keyup", function () {
        if (isNaN(this.val())) {
            return false;
        }
    });
};

$.fn.verifTax = function () {
    return this.bind("input paste", function () {
        setTimeout($.proxy(function () {
            this.val(parseFloat(this.val().replace(/[^0-9]/g, '')));
        }, $(this)), 0);
    });
};

/**
 * Sends a request to the specified url from a form. This will change the window location.
 * @param {string} path the path to send the post request to
 * @param {object} params the parameters to add to the url
 * @param {string} [method=post] the method to use on the form
 */
function post(path, params, method = 'post') {
    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    const form = document.createElement('form');
    form.method = method;
    form.action = path;

    for (const key in params) {
        if (params.hasOwnProperty(key)) {
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = key;
            hiddenField.value = params[key];

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}
