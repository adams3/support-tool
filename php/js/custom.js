var numberOfRows = 0;
var lastRowNumber = 0;

var numberOfButtons = 0;
var lastButtonNumber = 0;

var bootstrapJs = "//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js";
var bootstrapCss = "//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css";
var filename = "helpdesk-form.js";
var address = "";
var userId = 0; //hash
var formId = 0; //hash
var originalFormId = 0;

$(function() {

    var split = location.search.replace('?', '').split('=')
    $.getJSON("get-form.php", {"formId" : split[1]}, function(data) {

        originalFormId = split[1];
        userId = data.userId;
        formId = data.formId;
        address = "config/" + userId + "/" + formId + "/" + filename;

        var parsed = data.form;
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
        sendArray.push({name : "formId", value : originalFormId});
        var parsed = null;

        $.post('save-form.php', sendArray, function(data) {
            parsed = data.form;
            var rows = parsed['row'];

            var buttons = parsed['button'];

            var $confirmedDiv = $('<div id="confirmed" class="display-none">');
            var $modalDiv = $('<div id="sp-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"></div><div class="modal-body"></div></div></div></div>');
            var $goBackButton = $('<button id="goBack" onclick="toggleBack()" class="btn btn-primary" type="button">Back to form config</button>');
            var $copyMe = $('<div id="copyMe" class="tab-pane fade in active"><button id="copyButton" type="button" class="btn btn-info" data-clipboard-target="copyText">Copy to clipboard</button><textarea id="copyText" class="form-control" rows="3" readonly></textarea></div>');
            var $copyMeAdvanced = $('<div id="copyMeAdvanced" class="tab-pane fade in"><button id="copyButtonAdvanced" type="button" class="btn btn-info" data-clipboard-target="copyTextAdvanced">Copy to clipboard</button><textarea id="copyTextAdvanced" class="form-control" rows="10" readonly></textarea></div>');
            var $tabs = $('<ul id="myTab" class="nav nav-tabs"><li class="active"><a href="#copyMe" data-toggle="tab">Basic copiable script</a></li><li><a href="#copyMeAdvanced" data-toggle="tab">Advanced copiable script</a></li></ul></li></ul>')
            var $tabContent = $('<div id="myTabContent" class="tab-content">');
            $tabContent.append($copyMe);
            $tabContent.append($copyMeAdvanced);
            $confirmedDiv.append($goBackButton);
            $confirmedDiv.append($modalDiv);
            $confirmedDiv.append($tabs);
            $confirmedDiv.append($tabContent);

            $('div.well-new').append($confirmedDiv);

            var $header = $('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">' + parsed['form-action'] + '</h4>');
            var $form = $('<form role="form" action=' + parsed['url'] + ' id="sp-support-forms">');

            $('div.modal-header').append($header);
            $('div.modal-body').append($form);
            $form.append('<input id="domain" name="domain" type="hidden" />');
            $form.append('<div id="alertMessage" class="alert" style="display:none;"></div>');

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
            var ajaxSubmit = "$('form#sp-support-forms').on('submit', function(e) { e.preventDefault();var parsed=null; $.post($(this).attr('action'), $(this).serializeArray(), function(data) { parsed = $.parseJSON(data.form); $('#alertMessage').addClass(data['class']); $('#alertMessage').show(); $('#alertMessage').html(data['alertMessage']);},'json'); });";
            var modalForm = '$("body").append(\'' + form + '\');' + '$("#domain").val(window.location.hostname);' + ajaxSubmit;
            var bootstrapSource = '<link href="' + bootstrapCss + '" rel="stylesheet">\n<script src="' + bootstrapJs + '"></script>';
            var copiableScript = bootstrapSource + '\n' + '<script>\n' + supportButton + modalForm + '\n</script>';
            var formSrc = '\n<script src="' + 'http://' + window.location.hostname + '/' + address + '"></script>';
            var copiableScript2 = bootstrapSource + formSrc;

            $.post('save-js.php', {message: supportButton + modalForm, filename: filename, userId : userId ,formId : formId});

            $copyMe.find('textarea').val(copiableScript2);
            $copyMeAdvanced.find('textarea').val(copiableScript);

            var clip = new ZeroClipboard($("#copyButton, #copyButtonAdvanced"), {
                moviePath: "js/ZeroClipboard.swf"
            });

            clip.on("load", function(client) {
                client.on("complete", function(client, args) {
                    $(this).html("Script was copied!");
                    $(this).addClass("disabled");
                });
            });


        }, 'json');

        //TODO: nastylovat trosku ten clipboard
        //checkboxy nastylovat v gride
        // nahrat to na openshift a vytvorit databazu a nejake test web...
        //napriklad /test na rovnakej domene.


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



////////////////////////////GRID ///////////////////////////////

    $("#jqGridMails").jqGrid({
    url: "grid.php",
            datatype: "json",
            height: $(window).height() - 220,
            mtype: "GET",
            colNames: ["ID", "Date Create", "Message", "Read", "Flag", "Replied", "Action"],
            colModel: [
            {name: "id", width: 55},
            {name: "date_create", formatter: 'date', formatoptions: {srcformat: "d.m.Y H:i:s", newformat: "d.m.Y H:i:s"}, width: 200},
            {name: "message", width: 200,
                    formatter: function(v) {
                        return '<div class="mh50">' + v + '</div>';
                    }
            },
            {name: "read", width: 80, formatter: 'checkbox', align: "center"},
            {name: "flag", width: 80, formatter: 'checkbox', align: "center"},
            {name: "replied", width: 80, formatter: 'checkbox', align: "center"},
            {name: "action", widt: 40, formatter: reply_formatter, align: "center"}
            ],
            pager: "#pager",
            rowNum: 20,
            rowList: [10, 20, 30, 40, 50],
            sortname: "id",
            sortorder: "desc",
            viewrecords: true,
            gridview: true,
            autoencode: true,
            caption: "Received emails",
            onSelectRow: handleSelectedRow
    });

    $(window).bind('resize', function() {
        $("#jqGridMails").setGridWidth($('#mails').width(), true);
    }).trigger('resize');

    $("#notRegistered, #backToLogin").click(function(e){
       e.preventDefault();
       $("#formLogIn").slideToggle('slow');
       $("#formSignUp").slideToggle('slow');
    });

});

////////////////////////////////////////////////////////////////////////


function reply_formatter(cellvalue, options, rowObject) {
    return '<a href="reply.php?id=' + rowObject[0] + '">Reply</a>';
}

function handleSelectedRow(rowId, status, e) {
    var div = $("#" + rowId).children("td[aria-describedby=jqGridMails_message]").find("div");
    if (status) {
        div.removeClass("mh50");
    } else {
        div.addClass("mh50");
        $(this).jqGrid('resetSelection');
    }
}


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
