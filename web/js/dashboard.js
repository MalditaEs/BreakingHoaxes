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
        lastBuloElement = buloElement.attr('data-date');

    $.ajax({
        url: window.location.href + "/bulo/" + lastBuloElement,
        success: function (data) {
            showBulosData(data);
        }
    });
}

function showData(data) {
    var parsedData = JSON.parse(data);

    $.each(parsedData, function (e) {

        var createdDiv = createDiv();
        $(createdDiv).attr('data-date', this['obtained_at']);
        $(createdDiv).attr('data-id', this['id']);
        $(createdDiv).attr('data-source-id', this['source']['id']);
        $(createdDiv).find('.info-image').attr('src', this['source']['image']);
        if (this['source']['type']['id'] === 2)
            $(createdDiv).find('.info-content').html(this['content']);
        else
            $(createdDiv).find('.info-content').html(this['title']);
        $(createdDiv).hide();
        $(createdDiv).prependTo("#data-displayer");
        if ($.inArray(this['source']['id'], ignored) === -1)
            $(createdDiv).slideDown();

    });
}

function showBulosData(data) {
    var parsedData = JSON.parse(data);

    $.each(parsedData, function (e) {

        var createdDiv = createDiv();
        $(createdDiv).attr('data-date', this['obtained_at']);
        $(createdDiv).attr('data-id', this['id']);
        $(createdDiv).find('.info-content').html(this['title']);
        $(createdDiv).hide();
        $(createdDiv).prependTo("#bulo-displayer");
        $(createdDiv).slideDown();
    });
}

function createDiv() {
    return $.parseHTML('<div class="info-element">\n' +
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

        $('.info-element').each(function (x) {
            if ($(this).attr('data-source-id') === $(source).attr('data-source-id')) {
                $(this).fadeOut();
            }
        });
    } else {
        ignored.splice(ignored.indexOf(parseInt($(source).attr('data-source-id'))), 1);

        $('.info-element').each(function (x) {
            if ($(this).attr('data-source-id') === $(source).attr('data-source-id')) {
                $(this).fadeIn();
            }
        });
    }
}

function infoActions() {

    $('#data-displayer').on('click', '.info-element', function (e) {
        $("#content-dialog").fadeIn();
    });

}

function dashboards() {

    var infoSelector = $(".info-selector");
    var buloSelector = $(".bulo-selector");

    $(".tab").click(function (x) {
        infoSelector.toggleClass('active-tab');
        buloSelector.toggleClass('active-tab');
        $("#information").toggleClass("bulo-tab", 0);
    });

    infoSelector.click(function (x) {
        $("#data-displayer").slideDown(100);
    });

    buloSelector.click(function (x) {
        $("#data-displayer").slideUp(100, function (anim) {
            $(".bulo-displayer").slideDown(100);
        });
    });

}