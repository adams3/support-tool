$(function() {
    var tel = "+15163000201";
    var skype = "jurosuro";
    var url = "http://support.sportpass.me/";
    
    $("body").append('<div id="support-button" style="position: fixed;right: 100px;bottom: 0px"><a data-toggle="modal" href="#sp-modal"  class="btn btn-primary btn-lg">Contact Us</a></div>');
    $("body").append('<div class="modal fade" id="sp-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Message us</h4></div><div class="modal-body"><form role="form" action="submit.php" id="sp-support-form"><input type="hidden" value="' + location.href + '" name="loc"><input type="hidden" name="nav" value="' + navigator.appName + '"><div class="form-group"><label for="sp-f-e">Email address</label><input type="email" class="form-control" id="sp-f-e" placeholder="Enter email" name="mail" required></div><div class="form-group"><label for="sp-f-m">Message</label><textarea id="sp-f-m" class="form-control" name="message" required></textarea></div><button type="submit" class="btn btn-lg btn-primary">Submit message</button> <a class="btn btn-lg btn-default" href="skype:' + skype + '?call">Call the Skype</a> <a href="tel:' + tel + '" class="btn btn-lg btn-default">Call ' + tel + '</a></form></div></div></div></div>');

    $("#sp-support-form").on("submit", function(event) {
        event.preventDefault();
        var sendArray = $(this).serializeArray();
        $.get(url + "submit.php", sendArray)
                .done(function(data) {
            alert("Message has been sent");
            document.getElementById("sp-support-form").reset();
            $('#sp-modal').modal('hide');
        });
    });
});