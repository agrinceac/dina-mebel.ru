var feedback = function()
{

    this.errors = new errors({
            'form'	:	'.col_in',
            'submit'  : '.col_in button',
            'message' : '#message',
            'error'   : '.hint',
            'showMessage' : 'showMessage'
    });

    this.sendForm = function(object)
    {
	var handlerFeedback = (new feedbackHandler);
	var that = this;

	var data ={
	    'clientName':   $(handlerFeedback.sources.clientName).val(),
	    'phone'	:   $(handlerFeedback.sources.phone).val(),
	    'textToSend':   $(handlerFeedback.sources.textToSend).val()
	};
	$.ajax({
		before: handlerFeedback.ajaxLoader.setLoader(object),
		url: handlerFeedback.actions.sendMessage,
		type: 'POST',
		dataType: 'json',
		data: data,
		success: function(data){
		    handlerFeedback.ajaxLoader.getElement();
			if(data == 1){
				that.errors.reset();
				that.resetContactsFormBlock();
				$(handlerFeedback.sources.commentForm).hide();
				$(handlerFeedback.sources.writeButton).hide();
				$(handlerFeedback.sources.sendResult).show();
			} else {
				that.errors.show(data);
			}
		}
	});
    }

	this.resetContactsFormBlock = function(template)
	{
		var handlerFeedback = (new feedbackHandler);
		$(handlerFeedback.sources.clientName).val('');
		$(handlerFeedback.sources.phone).val('');
		$(handlerFeedback.sources.textToSend).val('');
	}
}


