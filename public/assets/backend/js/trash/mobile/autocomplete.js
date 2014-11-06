var app = {
    timer: null,
    init: function () {
        var instance = this;
        $(document).on('pageinit', '#list_page', function () {
            $('#searchBox').on('keyup', function () {
                var $searchBox = $(this);
                var searchFor = $.trim($searchBox.val() + "");
                if(instance.timer) {
                    clearTimeout(instance.timer);
                }
                var fn = function () {
                    instance.search(searchFor);
                };
                instance.timer = setTimeout(fn, 300);
            });
        });
        $(document).on("pagebeforechange", function (e, data) {
            // We only want to handle changePage() calls where the caller is
            // asking us to load a page by URL
            if(typeof data.toPage === "string") {
                // We are being asked to load a page by URL
                var u = $.mobile.path.parseUrl(data.toPage),
                    _re = "#contact";
                if(u.hash.search(_re) !== -1) {
                    var name = 'id';
                    var results = new RegExp('[\\?&]id=([^&#]*)').exec(data.toPage);
                    var id = results !== null ? results[1] || '' : '';
                    $.ajax({
                        type: "POST",
                        url: "detail.php?id=" + id
                    }).done(function (data) {
                        data = $.parseJSON(data);
                        instance.detailPage(data);
                    });
                    e.preventDefault();
                }
            }
        });
    },
    search: function (searchFor) {
        var instance = this;
        $.mobile.loading('show');
        console.log(instance);
        $.ajax({
            type: "POST",
            url: "search.php",
            data: {
                searchfor: encodeURI(searchFor)
            }
        }).done(function (data) {
            data = $.parseJSON(data);
            instance.renderUL(data);
        });
    },
    renderUL: function (result) {
        var tmpl = [],
            len = result.contacts.length;
        if(len > 0) {
            tmpl.push('<ul data-role="listview">');
            for(var i = 0; i < len; i++) {
                tmpl.push('<li><a href="#contact?id=' + result.contacts[i].id + '">' + result.contacts[i].name + '</a></li>');
            }
            tmpl.push('</ul>');
            $('#searchResults').empty();
            $('#searchResults').append(tmpl.join('')).trigger('create');
        } else {
            $('#searchResults').html('Sorry no results matching your query');
        }
        $.mobile.loading('hide');
    },
    detailPage: function (data) {
        var tmpl = [];
        tmpl.push('<div data-role="page" id="detail_page">');
        tmpl.push('<div data-role="header"><h1>Contact Details</h1><a href="#" data-rel="back" data-role="button">back</a></div>');
        tmpl.push('<div data-role="content">');
        tmpl.push('<div>' + data.contact[0].address + '</div>');
        tmpl.push('<div>' + data.contact[0].city + '</div>');
        tmpl.push('<div>' + data.contact[0].email + '</div>');
        tmpl.push('<div></div>');
        tmpl.push('<div><b>' + data.contact[0].company + '</b></div></p> </div>');
        tmpl.push('</div></div>');
        $.mobile.pageContainer.find('#detail_page').remove();
        $.mobile.pageContainer.append($(tmpl.join('')));
        $.mobile.navigate("#detail_page");
    }
};
app.init();