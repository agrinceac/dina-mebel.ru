$(function () {
    $('#domainAlias, #selectionAlias, #url').on('change', function () {
        (new loaderLight()).start();
        $('#formFilters').submit();
    });
    var sort = new groupSorting();
    sort.sortable();
});

var groupSorting = function (settings) {
    this.settings = $.extend({
        'element$' : $('.sortable'),
        'helper' : 'clone',
        'handle' : '.current',
        'containment' : $('.itemsContainer'),
        'distance': 1,
        'axys' : '',
        'start' : function() {},
        'update' : function() {},
        'method' : 'post'
    }, settings||{});

    this.action = '/admin/priority/update/?';

    this.sortable = function () {
        this.settings.element$.sortable({
            helper: this.settings.helper,
            containment: this.settings.containment,
            start: $.proxy(this.start, this),
            update: $.proxy(this.update, this)
        });

        return this;
    };

    this.start = function(event, ui) {
        $('.ui-sortable-placeholder').css({'height': $('.thumbnail').parent().height()-20 });
        return this;
    };

    this.update = function(event, ui) {
        var query = '';

        // working only with items that was changed by moving
        // this.settings.element$.children( "div" ).each(function (i){
        //     if ($(this).data('id') !== undefined && $(this).data('priority') !== undefined) {
        //         ++i;
        //         if ( parseInt($(this).find('.priority').text()) !== i ) {
        //             query += '&data['+$(this).data('id')+']='+i;
        //             $(this).find('.priority').text(i).addClass('pulsate');
        //         }
        //     }
        // });

        this.settings.element$.children( "div" ).each(function (i){
            if ($(this).data('id') !== undefined && $(this).data('priority') !== undefined) {
                i += 1;
                query += '&data['+$(this).data('id')+']='+i;
                $(this).find('.priority').text(i).addClass('pulsate');
            }
        });

        if ( $('#domainAlias').val() ) {
            query += '&domainAlias='+$('#domainAlias').val();
        }
        if ( $('#selectionAlias').val() ) {
            query += '&selectionAlias='+$('#selectionAlias').val();
        }
        if ( $('#url').val() ) {
            query += '&url='+$('#url').val();
        }
        if ( $('#objectConfig').val() ) {
            query += '&objectConfig='+$('#objectConfig').val();
        }

        this.savePriority(query);

        return this;
    };

    this.savePriority = function (query) {
        var that = this;
        $.ajax({
            beforeSend: $.proxy(that.before, that),
            error: $.proxy(that.error, that),
            url: that.action,
            type: that.method || 'post',
            data: query,
            dataType: 'json',
            success: $.proxy(that.success, that),
            complete: $.proxy(that.complete, that)
        });

        return this;
    };

    this.loader = new loaderLight();

    this.before = function () {
        this.loader.start();
    };

    this.success = function(data) {
        this.loader.stop();
        if(data == 1)
            setTimeout(function () {
                $('.pulsate').removeClass('pulsate');
            }, 1000);
        else
            alert('Ошибка при попытке изменения приоритета. Обратитесь к разработчикам.');
    };
};