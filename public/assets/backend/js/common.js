/**
 *
 * @type {{filter: Function}}
 */
var Common = {

    language: (!this.language) ? 'en' : this.language,
    /**
     * Use for URI builder
     * @var request uri
     */
    uri: false,

    /**
     * filter : function(param) Filter redirect to date
     * @param param string
     * @return null
     */
    filter: function (param) {
        if (!param) {
            if (location.hash)
                var url = location.pathname + location.hash;
            else
                var url = location.pathname;

            window.location.reload(url);
        }
        else {
            // filter by status
            var recursiveDecoded = decodeURIComponent($.param(param)),
                hash = '';
            if (window.location.hash)
                hash = window.location.hash;

            window.location.assign(location.pathname + '?' + recursiveDecoded + hash);

        }
        return;
    },

    /**
     * alert : function(string) Alert dialog
     * @param string string Message
     * @return void
     */
    alert: function (string) {
        alertify.alert('<div class="box-content">' + string + '<div>');
    },

    /**
     * confirm : function(question, go) Confirm dialog
     * @param string question Message
     * @param string go location accept link
     * @return void
     */
    confirm: function (question, go) {
        var then = this;
        then.uri = go;

        alertify.confirm(question, function (e, go) {
            if (e) {

                if (then.uri) {
                    if (location.hash)
                        var url = location.pathname + then.uri + location.hash;
                    else
                        var url = then.uri;

                    window.location.assign(url);
                }
                else
                    return then.filter();
            }
            return;
        });
    },

    /**
     * prompt : function(label, go) Prompt dialog
     * @param string label
     * @param string go
     * @return void
     */
    prompt: function (label, go) {

        var then = this;
        then.uri = go;

        alertify.prompt(label, function (e) {
            if (e) {
                if (then.uri) {
                    var url = location.pathname + then.uri;
                    window.location.assign(url);
                }
                else
                    return then.filter();
            }
        }, label);
    },

    /**
     * doublePrompt : function(label1, label2, go) Double prompt dialog
     * @param string label1
     * @param string label2
     * @param string go
     * @return void
     */
    doublePrompt: function (label1, label2, go) {

        var then = this;
        then.uri = go;

        alertify.prompt(label1, function (e, key) {
            if (e) {
                alertify.prompt(label2, function (e, value) {
                    // value is the input text
                    if (e) {
                        if (then.uri) {
                            if (location.hash)
                                var url = location.pathname + then.uri + "?key=" + key + "&value=" + value + location.hash;
                            else
                                var url = location.pathname + then.uri + "?key=" + key + "&value=" + value;
                            window.location.assign(url);
                        }
                        else
                            return then.filter({
                                'key': key,
                                'value': value
                            });
                    }
                });
            }
        });
    },

    /**
     * clearUri : function(uri) Url without QS
     * @param string uri
     * @returns {*}
     */
    clearUri: function (uri) {
        return url.origin + url.pathname;
    },
};
