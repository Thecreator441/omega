$(document).ready(function () {
    // Initialise the MDBootstrap API
    $.material.init();

    //Initialize Select2 Elements
    $('.select2').select2();

    // Resolve conflict in jQuery UI tooltip with Bootstrap tooltip
    $.widget.bridge('uibutton', $.ui.button);

    // Used to set alerts automatic dismissal
    $(() => {
        setTimeout(function () {
            $(".alert").alert('close');
        }, 5000);
    });

    //iCheck for checkbox and radio inputs
    //Square red color scheme for iCheck
    // $('input[type="checkbox"].square-red, input[type="radio"].square-red').iCheck({
    //     checkboxClass: 'icheckbox_square-red',
    //     radioClass: 'iradio_square-red'
    // });
    //Square green color scheme for iCheck
    // $('input[type="checkbox"].square-green, input[type="radio"].square-green').iCheck({
    //     checkboxClass: 'icheckbox_square-green',
    //     radioClass: 'iradio_square-green'
    // });
    //Square blue color scheme for iCheck
    // $('input[type="checkbox"].square-blue, input[type="radio"].square-blue').iCheck({
    //     checkboxClass: 'icheckbox_square-blue',
    //     radioClass: 'iradio_square-blue'
    // });
    //Square yellow color scheme for iCheck
    // $('input[type="checkbox"].square-yellow, input[type="radio"].square-yellow').iCheck({
    //     checkboxClass: 'icheckbox_square-yellow',
    //     radioClass: 'iradio_square-yellow'
    // });

    // Datatable initialisation
    $('#bootstrap-data-table, #bootstrap-data-tables').DataTable({
        scrollX: true,
        scrollY: '75vh',
        scrollCollapse: true,
        paging: false,
        responsive: true,
        ordering: false
    });

    // Datatable initialisation
    $('#simul-data-table, #simul-data-table2').DataTable({
        scrollX: true,
        scrollY: '75vh',
        scrollCollapse: true,
        searching: false,
        paging: false,
        paginate: false,
        responsive: true,
        ordering: false,
    });

    $('form').attr('autocomplete', 'off');
});

$(document).on('input', 'input[type="text"]', function () {
    $(this).val($(this).val().toUpperCase());
});

$('#home, .home').click(function () {
    location.assign('/omega');
});

// Change Address ?
$('#change_addr, #interval, #by_sex').click(function () {
    if ($(this).is(":checked")) {
        $('#changeAddr').css('display', 'block');
    } else {
        $('#changeAddr').css('display', 'none');
    }
});

/**
 *
 * @param text
 * @param type
 * @returns {*}
 */
function trimOver(text, type) {
    if (type === null) {
        return text.replace(/ /g, '');
    }
    return text.replace(/,/g, ' ');
}

/**
 *
 * @param number
 * @returns {*}
 */
function money(number) {
    let amount = accounting.formatNumber(number);
    return trimOver(amount, ',');
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
function pad(text, size, type = 'left') {
    let length;
    length = text.toString().length;

    if (type === 'left') {
        let output = '';
        for (let i = 0; i < (size - length); i++) {
            output += '0';
        }
        return output + "" + text;
    } else {
        let output = text;
        for (let i = 0; i < (size - length); i++) {
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
    return Date.parse(userDate).toString('dd/MM/yyyy');
}

/**
 *
 * @param days
 * @returns {string}
 */
function formDate(days) {
    let date = new Date();
    date = date.addDays(parseInt(days));
    return Date.parse(date).toString('yyyy-MM-dd');
}

$.fn.verifNumber = function () {
    return this.bind("input paste", function () {
        setTimeout($.proxy(function () {
            this.val(this.val().replace(/[^0-9]/g, ''));
        }, $(this)), 0);
    });
};

$.fn.verifTax = function () {
    return this.bind("input paste", function () {
        setTimeout($.proxy(function () {
            this.val(parseFloat(this.val().replace(/[^0-9]/g, '')));
        }, $(this)), 0);
    });
};
