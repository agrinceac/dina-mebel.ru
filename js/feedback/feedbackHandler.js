$(function(){
	(new feedbackHandler())
		.clickWriteButton()
		.clickSendButton();
});

var feedbackHandler = function()
{
	this.sources = {
		'writeButton' : '.wr_but',
		'commentForm' : '.comment_form',
		'sendButton'	:   '.send',
		'clientName'	:   'input[name=clientName]',
		'phone'		:   'input[name=phone]',
		'textToSend'	:   'textarea[name=textToSend]',
		'sendResult' : '.sendResult'
	 };

	this.ajaxLoader = new ajaxLoader();

	this.actions = {
		'sendMessage'	:   '/feedback/ajaxSendMessage/',
	};

	this.clickWriteButton = function()
	{
		var that = this;
		$(that.sources.writeButton).live('click',function(){
			$(that.sources.commentForm).toggle();
			(new feedback).errors.reset();
		});
		return that;
	}

	this.clickSendButton = function()
	{
		var that = this;
		$(that.sources.sendButton).live('click',function(){
			(new feedback).sendForm($(this));
		});
		return that;
	}
}