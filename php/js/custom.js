var numberOfRows = 0;
var lastRowNumber = 0;

$(function(){

    cloneRow(lastRowNumber + 1);

    $('#addNew').click(function(e){
        e.preventDefault();
        cloneRow(lastRowNumber + 1);
    });

    $('form#supportForm').on('click','.btn-danger', function(e){
        e.preventDefault();
        var $parentRow = $(this).parent().parent();
        if(numberOfRows > 1) {
            $parentRow.remove();
            numberOfRows--;
        }
    });


    $('form#supportForm').on('submit',function(e){

        e.preventDefault();
        var sendArray = $(this).serializeArray();
        var parsed = null;

        $.post('save-form.php', sendArray, function(data){
            parsed = $.parseJSON(data.form);

            var $exampleDiv = $('<div id="sp-modal" tabindex="-1" class="display-none" aria-labelledby="myModalLabel" aria-hidden="true"><button id="goBack" onclick="toggleBack()" class="btn btn-primary" type="button">Back to form config</button><div class="modal-dialog"><div class="modal-content"><div class="modal-header"></div><div class="modal-body"></div></div></div></div>');
            $('div.well-new').append($exampleDiv);

            var $header = $('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Message us</h4>');
            var $form = $('<form role="form" action="submit.php" id="sp-support-form">');

            $('div.modal-header').append($header);
            $('div.modal-body').append($form);


            for(var i = 1; i <= Object.keys(parsed).length; i++){
                var row = parsed[i];
                var $div = $('<div class="form-group"></div>');
                var $input = null;

                if(row['type'] == "textarea") {
                    $input = $(document.createElement('textarea'));
                } else {
                    $input = $(document.createElement('input'));
                }

                var $label = $(document.createElement('label'));


                $input.attr({
                    'name' : row['name'],
                    'type' : row['type'],
                    'placeholder': row['placeholder'],
                    'id' : row['id'],
                    'class' : row['class']
                });
                $input.addClass('form-control');

                $label.attr({
                    'for' : row['id']
                });
                $label.html(row['label']);

                $div.append($label);
                $div.append($input);

                $form.append($div);
        }



        }, 'json');

        var skype = "ahoj";
        var tel = "ahoj";



//        $('div.well-new').append('<div class="" id="sp-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Message us</h4></div><div class="modal-body"><form role="form" action="submit.php" id="sp-support-form"><input type="hidden" value="' + location.href + '" name="loc"><input type="hidden" name="nav" value="' + navigator.appName + '"><div class="form-group"><label for="sp-f-e">Email address</label><input type="email" class="form-control" id="sp-f-e" placeholder="Enter email" name="mail" required></div><div class="form-group"><label for="sp-f-m">Message</label><textarea id="sp-f-m" class="form-control" name="message" required></textarea></div><button type="submit" class="btn btn-lg btn-primary">Submit message</button> <a class="btn btn-lg btn-default" href="skype:' + skype + '?call">Call the Skype</a> <a href="tel:' + tel + '" class="btn btn-lg btn-default">Call ' + tel + '</a></form></div></div></div></div>');

            $('#supportForm').toggle('slow', function(){
                $('#sp-modal').toggle('slow');
            });

    });

})

function toggleBack () {
    $('#sp-modal').toggle('slow', function(){
        $('#supportForm').toggle('slow');
        $('#sp-modal').remove();
    });

}

function cloneRow (rowNumber) {
    var $clone = $('form#supportForm #0').clone();
    $clone.removeClass('display-none');
    $clone.attr('id',lastRowNumber + 1);
    $clone.find('input, select').each(function(){
        var newName = 'row' + '[' + rowNumber + ']' + '[' + $(this).attr('name') + ']';
        $(this).attr('name',newName);
    });
    $clone.appendTo('form#supportForm #rows');
    numberOfRows++;
    lastRowNumber++;
}
