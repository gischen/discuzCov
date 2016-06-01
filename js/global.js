$(function () {

    // CSS tweaks
    $('#header #nav li:last').addClass('nobg');
    $('.block_head ul').each(function () {
        $('li:first', this).addClass('nobg');
    });



    // Web stats
    $('table.stats').each(function () {

        if ($(this).attr('rel')) {
            var statsType = $(this).attr('rel');
        } else {
            var statsType = 'area';
        }

        var chart_width = ($(this).parent('div').width()) - 60;


        if (statsType == 'line' || statsType == 'pie') {
            $(this).hide().visualize({
                type: statsType,
                // 'bar', 'area', 'pie', 'line'
                width: chart_width,
                height: '240px',
                colors: ['#6fb9e8', '#ec8526', '#9dc453', '#ddd74c'],

                lineDots: 'double',
                interaction: true,
                multiHover: 5,
                tooltip: true,
                tooltiphtml: function (data) {
                    var html = '';
                    for (var i = 0; i < data.point.length; i++) {
                        html += '<p class="chart_tooltip"><strong>' + data.point[i].value + '</strong> ' + data.point[i].yLabels[0] + '</p>';
                    }
                    return html;
                }
            });
        } else {
            $(this).hide().visualize({
                type: statsType,
                // 'bar', 'area', 'pie', 'line'
                width: chart_width,
                height: '240px',
                colors: ['#6fb9e8', '#ec8526', '#9dc453', '#ddd74c']
            });
        }
    });


    $('.block table tr th.header').css('cursor', 'pointer');



    // Check / uncheck all checkboxes
    $('.check_all').click(function () {
        $(this).parents('form').find('input:checkbox').attr('checked', $(this).is(':checked'));
    });


    // Messages
    $('.block .message').hide().append('<span class="close" title="Dismiss"></span>').fadeIn('slow');
    $('.block .message .close').hover(

    function () {
        $(this).addClass('hover');
    }, function () {
        $(this).removeClass('hover');
    });

    $('.block .message .close').click(function () {
        $(this).parent().fadeOut('slow', function () {
            $(this).remove();
        });
    });



    // Form select styling
    $("form select.styled").select_skin();



    // Tabs
    $(".tab_content").hide();
    $("ul.tabs li:first-child").addClass("active").show();
    $(".block").find(".tab_content:first").show();

    $("ul.tabs li").click(function () {
        $(this).parent().find('li').removeClass("active");
        $(this).addClass("active");
        $(this).parents('.block').find(".tab_content").hide();

        var activeTab = $(this).find("a").attr("href");
        $(activeTab).show();

        // refresh visualize for IE
        $(activeTab).find('.visualize').trigger('visualizeRefresh');

        return false;
    });



    // Sidebar Tabs
    $(".sidebar_content").hide();

    if (window.location.hash && window.location.hash.match('sb')) {

        $("ul.sidemenu li a[href=" + window.location.hash + "]").parent().addClass("active").show();
        $(".block .sidebar_content#" + window.location.hash).show();
    } else {

        $("ul.sidemenu li:first-child").addClass("active").show();
        $(".block .sidebar_content:first").show();
    }

    $("ul.sidemenu li").click(function () {

        var activeTab = $(this).find("a").attr("href");
        window.location.hash = activeTab;

        $(this).parent().find('li').removeClass("active");
        $(this).addClass("active");
        $(this).parents('.block').find(".sidebar_content").hide();
        $(activeTab).show();
        return false;
    });



    // Block search
    $('.block .block_head form .text').bind('click', function () {
        $(this).attr('value', '');
    });
});