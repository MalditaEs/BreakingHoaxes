var ignored = [];

$(document).ready(function () {

    commonActions();

    pullInfoData();
    setInterval(pullInfoData, 6000);

    pullBulosData();
    setInterval(pullBulosData, 12000);

    sourceActions();
    infoActions();

    dashboards();

});

function commonActions() {
    $("#close-dialog").click(function (f) {
        $("#content-dialog").fadeOut();
    });

    $(".action-official").click(function (f) {
        $(".sources-official").find('.image-source').each(function (x, u) {
            $(this).toggleClass('deactivated');
            source(this);
        });
    });

    $(".action-approved").click(function (f) {
        $(".sources-mb").find('.image-source').each(function (x, u) {
            $(this).toggleClass('deactivated');
            source(this);
        });
    });

    $(".action-ground").click(function (f) {
        $(".sources-newroom").find('.image-source').each(function (x, u) {
            $(this).toggleClass('deactivated');
            source(this);
        });
    });

    $('#search-form').submit(function (e) {
        e.preventDefault();
        performSearch($(".search-field").val());
    });

    var sources = $('#sources');

    sources.on('click', '.fa-caret-down', function (e) {
        $('.sources-wrap').slideDown();
        $(this).removeClass('fa-caret-down');
        $(this).addClass('fa-caret-up');
    });

    sources.on('click', '.fa-caret-up', function (e) {
        $('.sources-wrap').slideUp();
        $(this).removeClass('fa-caret-up');
        $(this).addClass('fa-caret-down');
    });

    $(".close-search").click(function () {
        $("#search-dialog").slideUp();
        $(".search-element").remove();
    });
}

function pullInfoData() {
    var lastElement = 0;

    var infoElement = $('.info-element');
    if (infoElement.length > 0)
        lastElement = infoElement.attr('data-date');

    $.ajax({
        url: window.location.href + "/data/" + lastElement,
        success: function (data) {
            showData(data);
        }
    });
}

function pullBulosData() {
    var lastBuloElement = 0;

    var buloElement = $('.bulo-element');

    if (buloElement.length > 0)
        lastBuloElement = buloElement.attr('data-id');

    $.ajax({
        url: window.location.href + "/bulo/" + (parseInt(lastBuloElement) + 1),
        success: function (data) {
            showBulosData(data);
        }
    });
}

function showData(data) {
    var parsedData = JSON.parse(data);

    $.each(parsedData, function (e) {

        var createdDiv = createInfoElementDiv();
        $(createdDiv).attr('data-date', this['obtained_at']);
        $(createdDiv).attr('data-id', this['id']);
        $(createdDiv).attr('data-type', this['source']['type']['id']);
        $(createdDiv).attr('data-source-id', this['source']['id']);
        $(createdDiv).find('.info-image').attr('src', this['source']['image']);
        if (this['source']['type']['id'] === 2)
            $(createdDiv).find('.information-content').text(this['content']);
        else
            $(createdDiv).find('.information-date').text(this['title']);

        $(createdDiv).find('.information-date').text(this['obtained_at']);

        $(createdDiv).hide();
        $(createdDiv).prependTo("#data-displayer");
        if ($.inArray(this['source']['id'], ignored) === -1)
            $(createdDiv).slideDown();

    });
}

function showBulosData(data) {
    var parsedData = JSON.parse(data);

    $.each(parsedData, function (e) {
        var createdDiv = createBuloElementDiv();
        $(createdDiv).attr('data-date', this['obtained_at']);
        $(createdDiv).attr('data-id', this['id']);
        $(createdDiv).find('.information-content').text(this['title']);
        $(createdDiv).find('.information-date').text(this['obtained_at']);
        $(createdDiv).hide();
        $(createdDiv).prependTo("#bulo-displayer");
        $(createdDiv).slideDown();

        notifications(this['title']);
    });

}

function createInfoElementDiv() {
    return $.parseHTML('<div class="info-element">\n' +
        '    <div class="info-image-wrap">\n' +
        '        <img class="info-image" src=""/>\n' +
        '    </div>\n' +
        '    <div class="info-content"> <p class="information-content"></p><p class="information-date"></p> </div>\n' +
        '</div>')
}


function createBuloElementDiv() {
    return $.parseHTML('<div class="bulo-element"><div class="info-content"> <p class="information-content"></p><p class="information-date"></p> </div>\n' +
        '</div>')
}

function searchElementDiv() {
    return $.parseHTML('<div class="search-element">\n' +
        '    <div class="info-image-wrap">\n' +
        '        <img class="info-image" src=""/>\n' +
        '    </div>\n' +
        '    <div class="info-content">\n' +
        '        \n' +
        '    </div>\n' +
        '</div>')
}

function sourceActions() {
    $(".image-source").click(function (t) {
        $(this).toggleClass('deactivated');
        source(this);
    })
}

function source(source) {
    if ($(source).hasClass('deactivated')) {

        ignored.push(parseInt($(source).attr('data-source-id')));
        console.log("adding " + parseInt($(source).attr('data-source-id')));

        $('.info-element').each(function (x) {
            if ($(this).attr('data-source-id') === $(source).attr('data-source-id')) {
                $(this).fadeOut();
            }
        });
    } else {
        ignored.splice(ignored.indexOf(parseInt($(source).attr('data-source-id'))), 1);

        console.log("deleting " + parseInt($(source).attr('data-source-id')));

        $('.info-element').each(function (x) {
            if ($(this).attr('data-source-id') === $(source).attr('data-source-id')) {
                $(this).fadeIn();
            }
        });
    }

    ignored = ignored.filter(onlyUnique);

}

function infoActions() {

    $('#data-displayer').on('click', '.info-element', function (e) {

        var type = $(this).attr('data-type');

        if ($(this).attr('data-type') === 1) {

            var dataId = $(this).attr('data-id');
            $.ajax({
                url: window.location.href + "/data/information/" + dataId,
                success: function (data) {
                    data = JSON.parse(data);
                    var dialog = $("#content-dialog");
                    dialog.find('.dialog-title').text(data['title']);
                    dialog.find('.dialog-content').html(data['content']);
                    window.scrollTo(0, 0);
                    dialog.fadeIn();
                }
            });
        }
    });

    $('#search-dialog').on('click', '.search-element', function (e) {

        var type = $(this).attr('data-type');

        if (type == 1) {

            var dataId = $(this).attr('data-id');
            $.ajax({
                url: window.location.href + "/data/information/" + dataId,
                success: function (data) {
                    data = JSON.parse(data);
                    var dialog = $("#content-dialog");
                    dialog.find('.dialog-title').text(data['title']);
                    dialog.find('.dialog-content').html(data['content']);
                    window.scrollTo(0, 0);
                    dialog.fadeIn();
                }
            });
        }
    });

}

function dashboards() {

    var infoSelector = $(".info-selector");
    var buloSelector = $(".bulo-selector");
    var checkSelector = $(".verify-selector");

    $(".tab").click(function (x) {

        infoSelector.removeClass('active-tab');
        buloSelector.removeClass('active-tab');
        checkSelector.removeClass('active-tab');

        var className = $(this).attr('class').split(' ')[0];
        $("." + className).addClass('active-tab');

    });

    infoSelector.click(function (x) {
        $("#information").removeClass("bulo-tab");
        $("#bulo-displayer").slideUp(100);
        $("#check-displayer").slideUp(100);
        $("#data-displayer").slideDown(100);
    });

    buloSelector.click(function (x) {
        $("#information").addClass("bulo-tab");
        $("#check-displayer").slideUp(100);
        $("#data-displayer").slideUp(100);
        $("#bulo-displayer").slideDown(100);
    });

    checkSelector.click(function (x) {
        $("#information").removeClass("bulo-tab");
        $("#data-displayer").slideUp(100);
        $("#bulo-displayer").slideUp(100);
        $("#check-displayer").slideDown(100);
    });
}

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

function performSearch(query) {

    $(".search-element").remove();

    $.ajax({
        url: window.location.href + "/bulo/search/" + query,
        success: function (results) {

            results = JSON.parse(results);
            var dialog = $("#search-dialog");

            $.each(results, function (x) {

                var createdDiv = searchElementDiv('search-result');
                $(createdDiv).addClass("bulo-search-result");

                $(createdDiv).attr('data-date', this['obtained_at']);
                $(createdDiv).find('.info-content').html(this['title'] + " - " + this['content']);

                $(createdDiv).appendTo("#search-dialog");


                $.ajax({
                    url: window.location.href + "/data/search/" + query,
                    success: function (results) {

                        results = JSON.parse(results);
                        var dialog = $("#search-dialog");

                        $.each(results, function (x) {

                            var createdDiv = searchElementDiv('search-result');

                            $(createdDiv).attr('data-date', this['obtained_at']);
                            $(createdDiv).attr('data-id', this['id']);
                            $(createdDiv).attr('data-type', this['source']['type']['id']);
                            $(createdDiv).attr('data-source-id', this['source']['id']);
                            $(createdDiv).find('.info-image').attr('src', this['source']['image']);
                            if (this['source']['type']['id'] === 2)
                                $(createdDiv).find('.info-content').html(this['content']);
                            else
                                $(createdDiv).find('.info-content').html(this['title']);
                            $(createdDiv).hide();
                            $(createdDiv).appendTo("#search-dialog");
                            if ($.inArray(this['source']['id'], ignored) === -1)
                                $(createdDiv).slideDown();

                        });

                        dialog.slideDown();
                    }
                });

            });
        }
    });


}

function notifications(bulo) {

    Notification.requestPermission().then(function (permission) {

        if (permission === 'denied') {
            console.log('Permission wasn\'t granted. Allow a retry.');
            return;
        } else if (permission === 'default') {
            console.log('The permission request was dismissed.');
            return;
        }

        var notifOptions = {
            body: bulo,
            icon: "/images/logos/mblogo.jpg"
        };
        var notification = new Notification("NUEVO BULO", notifOptions);

    });

}