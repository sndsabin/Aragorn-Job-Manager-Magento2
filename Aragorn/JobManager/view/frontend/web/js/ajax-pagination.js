define([
    "jquery"
], function($) {
    "use strict";
    $.widget('aragorn_jobmanager.joblist', {
        _create: function() {
            /*this.options contain all variables which you pass in it for
             use in your javascript code */
                var url = this.options.url;
                var load = $('#load-more');
                var page = parseInt(this.options.currentPage);
                var totalPages = parseInt(this.options.totalPages);
                load.click(function (e) {
                    e.preventDefault();
                    load.html('Loading');
                    if (page < totalPages) {
                        page++;

                        if (page === totalPages) {
                            load.attr("disabled", '');
                        }

                    } else {
                        return false;
                    }
                    $.ajax(
                        {
                            type: "get",
                            url: url + page,
                            success: function (data) {
                                load.html('Load More');
                                var result = $(data).find('table > tbody');
                                $('table').append(result);
                            }
                        });
                });
        }
    });
    return $.aragorn_jobmanager.joblist;
});