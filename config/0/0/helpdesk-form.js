   var $css = $("<link/>"); 
                $css.attr("href", "http://local.support.cz/stylesheets/css/bootstrap-prefixed.css");
                $css.attr("rel", "stylesheet");
                $("head").append($css); 
                if(!(typeof $().emulateTransitionEnd == "function")) { 
                    var js = document.createElement("script"); 
                    js.src = "//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js";
                    js.type = "text/javascript";
                    document.getElementsByTagName("body")[0].appendChild(js); 
            }
            $("body").append('<div id="support-button" class="bootstrap-styles" style="position: fixed;right: 0px;bottom: 100px"><a data-toggle="modal" href="#sp-modal"  class="btn btn-primary btn-lg">Contact Us</a></div>');$("body").append('<div class="bootstrap-styles"><div id="sp-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title">TESTE</h4></div><div class="modal-body"><form role="form" action="id=&quot;sp-support-forms&quot;"><input id="domain" name="domain" type="hidden"><div id="alertMessage" class="alert" style="display:none;"></div><input type="hidden" name="formId" value="0"><input type="hidden" name="userId" value="0"><div class="form-group"><label for=""></label><input name="" type="text" placeholder="" id="" class="form-control"></div></form></div></div></div></div></div>');$("#domain").val(window.location.hostname);$('form#sp-support-forms').on('submit', function(e) { e.preventDefault();var parsed=null; $.post($(this).attr('action'), $(this).serializeArray(), function(data) { $('#alertMessage').addClass(data['class']); $('#alertMessage').show(); $('#alertMessage').html(data['alertMessage']);},'json'); });