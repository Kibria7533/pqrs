/**
 * Start enToBn JS Code
 * **/
function en2bn(input) {
    var numbers = {
        0: '০',
        1: '১',
        2: '২',
        3: '৩',
        4: '৪',
        5: '৫',
        6: '৬',
        7: '৭',
        8: '৮',
        9: '৯'
    };

    var output = [];
    for (var i = 0; i < input.length; i++) {
        if (numbers.hasOwnProperty(input[i])) {
            output.push(numbers[input[i]]);
        } else {
            output.push(input[i]);
        }
    }
    return output.join('').toString();
}

function bn2en(input) {
    var numbers = {
        '০': 0,
        '১': 1,
        '২': 2,
        '৩': 3,
        '৪': 4,
        '৫': 5,
        '৬': 6,
        '৭': 7,
        '৮': 8,
        '৯': 9
    };

    var output = [];
    for (var i = 0; i < input.length; i++) {
        if (numbers.hasOwnProperty(input[i])) {
            output.push(numbers[input[i]]);
        } else {
            output.push(input[i]);
        }
    }
    return output.join('').toString();
}

function toBnText(element, event, onlyNumber = false) {

    if (onlyNumber) {
        let numeric_input = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

        if ($.inArray(event.key, numeric_input) == "-1") {
            return false;
        }
    }

    let current = $(element).val().split('');

    let new_input = en2bn(event.key);

    if (element.selectionStart < element.selectionEnd) {
        current.splice(element.selectionStart, (element.selectionEnd - element.selectionStart), new_input);
    } else {
        current.splice(element.selectionStart, 0, new_input);

    }
    let oldEnd = Number(element.selectionStart) + 1;

    $(element).val(current.join(""));

    setMyMapCaretPosition(element, oldEnd);
}

function toEnText(element, event, onlyNumber = false) {

    if (onlyNumber) {
        let numeric_input = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

        if ($.inArray(event.key, numeric_input) == "-1") {
            return false;
        }
    }

    let current = $(element).val().split('');

    let new_input = bn2en(event.key);

    if (element.selectionStart < element.selectionEnd) {
        current.splice(element.selectionStart, (element.selectionEnd - element.selectionStart), new_input);
    } else {
        current.splice(element.selectionStart, 0, new_input);

    }
    let oldEnd = Number(element.selectionStart) + 1;

    $(element).val(current.join(""));

    setMyMapCaretPosition(element, oldEnd);
}

function setMyMapCaretPosition(ctrl, pos) {
    // Modern browsers
    if (ctrl.setSelectionRange) {
        ctrl.focus();
        ctrl.setSelectionRange(pos, pos);

        // IE8 and below
    } else if (ctrl.createTextRange) {
        let range = ctrl.createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
    }
}
