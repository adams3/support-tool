$("body").append('<div id="support-button" style="position: fixed;right: 0px;bottom: 100px"><a data-toggle="modal" href="#sp-modal"  class="btn btn-primary btn-lg">Contact Us</a></div>');$("body").append('<div class="modal fade" id="sp-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title">Message us</h4></div><div class="modal-body"><form role="form" action="http://local.support.cz/submit.php" id="sp-support-forms"><input id="domain" name="domain" type="hidden"><div id="alertMessage" class="alert" style="display:none;"></div><div class="form-group"><label for="">Meno</label><input required="required" class="form-control" id="" placeholder="Your name" name="name" type="text"></div><div class="form-group"><label for="">Priezvisko</label><input required="required" class="form-control" id="" placeholder="Your surname" name="surname" type="text"></div><div class="form-group"><label for="">Telefón</label><input class="form-control" id="" placeholder="Your phone no." name="number" type="text"></div><div class="form-group"><label for="">Email</label><input class="form-control" id="" placeholder="Your email" name="email" type="email"></div><div class="form-group"><label for="">Správa</label><textarea class="form-control" id="" placeholder="Your message" type="textarea" name="mess"></textarea></div><div class="btn-group btn-group-justified"><a class="btn-primary btn" type="skype" href="skype:adams">Skype: test</a><a class="btn-danger btn" type="submit" onclick="$(function(){ $(&quot;#submitNewForm&quot;).trigger(&quot;click&quot;); });">odoslat</a><a class="btn-default btn" type="submit" onclick="$(function(){ $(&quot;#submitNewForm&quot;).trigger(&quot;click&quot;); });">test</a><input style="display: none;" id="submitNewForm" type="submit"></div></form></div></div></div></div>');$("#domain").val(window.location.hostname);$('form#sp-support-forms').on('submit', function(e) { e.preventDefault();var parsed=null; $.post($(this).attr('action'), $(this).serializeArray(), function(data) { parsed = $.parseJSON(data.form); $('#alertMessage').addClass(data['class']); $('#alertMessage').show(); $('#alertMessage').html(data['alertMessage']);},'json'); });