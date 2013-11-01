var numberOfRows = 0;
var lastRowNumber = 0;

var numberOfButtons = 0;
var lastButtonNumber = 0;

$(function() {

    $.getJSON("config/configureForm.json", function(data) {
        var parsed = $.parseJSON(data.form);
        for (var index in parsed) {
            $('input').each(function() {
                if ($(this).attr('name') == index) {
                    $(this).val(parsed[index]);
                }
            });
        }

        var rows = parsed['row'];
        if (rows) {
            for (var i in rows) {
                cloneElement(lastRowNumber + 1, 'row', rows[i]);
            }
        } else {
            cloneElement(lastRowNumber + 1, 'row');
        }


        var buttons = parsed['button'];
        if (parsed['button']) {
            for (var j in buttons) {
                cloneElement(lastButtonNumber + 1, 'button', buttons[j]);
            }
        } else {
            cloneElement(lastButtonNumber + 1, 'button');
        }

    }).fail(function() {
        cloneElement(lastRowNumber + 1, 'row');
        cloneElement(lastButtonNumber + 1, 'button');
    });


    $('#addNewRow').click(function(e) {
        e.preventDefault();
        cloneElement(lastRowNumber + 1, 'row');
    });

    $('#addNewButton').click(function(e) {
        e.preventDefault();
        cloneElement(lastButtonNumber + 1, 'button');
    });

    $('form#supportForm').on('click', '.remove', function(e) {
        e.preventDefault();
        var $parent = $(this).parent().parent();
        if ($(this).hasClass('remove-row')) {
            if (numberOfRows > 1) {
                $parent.remove();
                numberOfRows--;
            }
        } else if ($(this).hasClass('remove-button')) {
            if (numberOfButtons > 1) {
                $parent.remove();
                numberOfButtons--;
            }
        }
    });


    $('form#supportForm').on('submit', function(e) {

        e.preventDefault();
        var sendArray = $(this).serializeArray();
        var parsed = null;

        $.post('save-form.php', sendArray, function(data) {
            parsed = $.parseJSON(data.form);
            var rows = parsed['row'];
            var buttons = parsed['button'];

            var $confirmedDiv = $('<div id="confirmed" class="display-none">');
            var $modalDiv = $('<div id="sp-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"></div><div class="modal-body"></div></div></div></div>');
            var $goBackButton = $('<button id="goBack" onclick="toggleBack()" class="btn btn-primary" type="button">Back to form config</button>');
            var $copyMe = $('<div id="copyMe"><button type="button" class="btn btn-info">Copy to clipboard</button><textarea id="copyText" class="form-control" rows="10" readonly></textarea></div>');
            var $copyMeAdvanced = $('<div id="copyMeAdvanced"><button type="button" class="btn btn-info">Copy to clipboard</button><textarea id="copyTextAdvanced" class="form-control" rows="10" readonly></textarea></div>');
            $confirmedDiv.append($goBackButton);
            $confirmedDiv.append($modalDiv);
            $confirmedDiv.append($copyMe);
            $confirmedDiv.append($copyMeAdvanced);
            $('div.well-new').append($confirmedDiv);

            var $header = $('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">' + parsed['form-action'] + '</h4>');
            var $form = $('<form role="form" action=' + parsed['url'] + ' id="sp-support-forms">');

            $('div.modal-header').append($header);
            $('div.modal-body').append($form);

            /*********** ROWS **********/
            for (var i in rows) {
                var row = rows[i];
                var $div = $('<div class="form-group"></div>');
                var $input = null;

                if (row['type'] == "textarea") {
                    $input = $(document.createElement('textarea'));
                } else {
                    $input = $(document.createElement('input'));
                }

                var $label = $(document.createElement('label'));


                $input.attr({
                    'name': row['name'],
                    'type': row['type'],
                    'placeholder': row['placeholder'],
                    'id': row['id'],
                    'class': row['class']
                });
                $input.addClass('form-control');

                if (row['required'] == "") {
                    $input.attr({
                        'required': ''
                    });
                }

                $label.attr({
                    'for': row['id']
                });
                $label.html(row['label']);

                $div.append($label);
                $div.append($input);

                $form.append($div);
            }

            /*********** BUTTONS **********/
            var colors = new Array();
            colors['red'] = 'btn-danger';
            colors['blue'] = 'btn-primary';
            colors['default'] = 'btn-default';

            var $div2 = $('<div class="btn-group btn-group-justified"></div>');

            for (var j in buttons) {
                var button = buttons[j];
                $input = $(document.createElement('a'));
                switch (button['type'])
                {
                    case "skype":
                        $input.attr('href', 'skype:' + parsed['skype']);
                        $input.html('Skype: ' + button['label']);
                        break;
                    case "mobile":
                        $input.attr('href', 'tel:' + parsed['phone']);
                        $input.html('Call to: ' + button['label']);
                        break;
                    default:
                        $input.attr('onclick', '$(function(){ $("#submitNewForm").trigger("click"); });');
                        $input.html(button['label']);

                }

                $input.attr({
                    'type': button['type'],
                    'class': colors[button['color']] + ' btn'
                });

                $div2.append($input);
                $form.append($div2);
            }

            $input = $(document.createElement('input'));
            $input.attr('type', 'submit');
            $input.attr('id', 'submitNewForm');
            $input.css('display', 'none');
            $div2.append($input);

            var supportButton = '$("body").append(\'<div id="support-button" style="position: fixed;right: 0px;bottom: 100px"><a data-toggle="modal" href="#sp-modal"  class="btn btn-primary btn-lg">Contact Us</a></div>\');';
            var form = $('<div>').append($('#sp-modal').clone().addClass('modal fade')).html();
            var modalForm = '$("body").append(\'' + form + '\');';
            var bootstrapSource = '<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">\n<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>';
            var copiableScript = bootstrapSource + '\n' + '<script>\n' + supportButton + modalForm + '\n</script>';
            $copyMe.find('textarea').val(copiableScript);
            var filename = "config/helpdesk-form.js";

            $.post('save-js.php', {message: supportButton + modalForm, filename: filename});

            var formSrc = '\n<script src="'+ 'http://'+ window.location.hostname + '/' + filename + '"></script>';
            var copiableScript2 = bootstrapSource + formSrc ;
            $copyMeAdvanced.find('textarea').val(copiableScript2);

        }, 'json');

        //TODO: obratit kopirovacie skripty....urobit copy to clipboard, show/hide pro advanced, hlaska ze to bolo skopirovane.
        //dalej je potreba namysliet ukladanie do db

        //        $('div.well-new').append('<div class="" id="sp-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Message us</h4></div><div class="modal-body"><form role="form" action="submit.php" id="sp-support-form"><input type="hidden" value="' + location.href + '" name="loc"><input type="hidden" name="nav" value="' + navigator.appName + '"><div class="form-group"><label for="sp-f-e">Email address</label><input type="email" class="form-control" id="sp-f-e" placeholder="Enter email" name="mail" required></div><div class="form-group"><label for="sp-f-m">Message</label><textarea id="sp-f-m" class="form-control" name="message" required></textarea></div><button type="submit" class="btn btn-lg btn-primary">Submit message</button> <a class="btn btn-lg btn-default" href="skype:' + skype + '?call">Call the Skype</a> <a href="tel:' + tel + '" class="btn btn-lg btn-default">Call ' + tel + '</a></form></div></div></div></div>');

        $('#supportForm').toggle('slow', function() {
            $('#confirmed').toggle('slow');
        });

    });

    $('input#reset').click(function(e) {
        $('body').find('.row-copy, .button-copy').each(function() {
            if (!$(this).hasClass('display-none')) {
                $(this).find('.remove').trigger('click');
            }
        });

        $('#setBack').removeClass('display-none');
    });

    $('button#setBack').click(function(e) {
        e.preventDefault();
        location.reload();
    });

})

function toggleBack() {
    $('#confirmed').toggle('slow', function() {
        $('#supportForm').toggle('slow');
        $('#confirmed').remove();
    });

}

function cloneElement(rowNumber, type, data) {
    var $clone = $('form#supportForm #' + type + '0').clone();
    $clone.removeClass('display-none');
    $clone.find('input, select').each(function() {
        var newName = type + '[' + rowNumber + ']' + '[' + $(this).attr('name') + ']';
        $(this).attr('name', newName);

        if (data) {
            var hdtype = $(this).attr('data-hd-type');
            $(this).val(data[hdtype]);

            if (hdtype == "required" && data[hdtype] == "") {
                $(this).prop('checked', true);
            }
        }
    });

    if (type == 'row') {
        numberOfRows++;
        lastRowNumber++;
        $clone.attr('id', type + (lastRowNumber));
        $clone.appendTo('form#supportForm #rows');
    }

    if (type == 'button') {
        numberOfButtons++;
        lastButtonNumber++;
        $clone.attr('id', type + (lastButtonNumber));
        $clone.appendTo('form#supportForm #buttons');
    }

}
