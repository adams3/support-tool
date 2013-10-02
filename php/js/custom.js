$(function(){

    $('#addNew').click(function(e){
        e.preventDefault();
        $('form#supportForm #1').clone().appendTo('form#supportForm #rows');
    });

    $('form#supportForm').on('click','.btn-danger', function(e){
            e.preventDefault();
            var $parentRow = $(this).parent().parent();
            if( $parentRow.siblings().length > 0) {
                $parentRow.remove();
            }
    });

})
