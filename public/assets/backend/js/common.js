/**
 *
 * @type {{filter: Function}}
 */
var Common = {

    /**
	 * filter : function(param) Filter redirect to date
	 * @param param string
	 * @return null
	 */
	filter : function(param) {
		if(!param )
		{
			if(location.hash)
				var url = location.pathname + location.hash;
			else
				var url = location.pathname;

			window.location.reload(url);
		}
		else
		{
			// filter by status
			var recursiveDecoded = decodeURIComponent($.param(param));
			window.location.assign(location.pathname +'?' +recursiveDecoded);

		}
		return;
	},

	/**
	 * confirm : function(question, go)
	 * @param string question Message
	 * @param string go location accept link
	 */
	confirm : function(question, go)
	{
		alertify.confirm(question, function (e) {
			if(e && go)
				window.location.href = go;
			return;
		});
	}
};
