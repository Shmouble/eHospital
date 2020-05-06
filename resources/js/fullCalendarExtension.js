(function ($) {
    $.fn.fullCalendarExtension = function (options) {
        var calendar = $(this);
        var config = $.extend({}, {}, options);

        if (!config.eventsUrl) {
            console.log('add url with events json');
            return;
        }

        
        

        function renderEditButtons() {
            var calendarDays = calendar.find('.fc-bg tbody td.fc-widget-content');
            var currentDate = new Date();
            var afterTomorrowDate = new Date(currentDate);
            afterTomorrowDate.setDate(afterTomorrowDate.getDate() + 2);
            afterTomorrowDate.setHours(0, 0, 0, 0);
            $.each(calendarDays, function (key, event) {
                var cellDate = new Date($(event).data('date'));
                cellDate.setHours(0, 0, 0, 0);

                if (cellDate >= afterTomorrowDate) {
                    $(event).html(
                        '<a class="btn btn-outline-dark editBtn" href="#" role="button" data-toggle="modal" data-target="#addEventModal" data-date="' + $(event).data('date') + '">Edit</a>'
                    );
                }
            });
        }

        
        function groupEventsByDate(events) {
            var eventsFormatted = {};
            events.map(function (event) {
                var startArray = event.start.split(' ');
                var endArray = event.end.split(' ');
                var startDate = startArray[0];
                event.startTime = startArray[1].substr(0,5);
                event.endTime = endArray[1].substr(0,5);
                

                if (typeof eventsFormatted[eventsFormatted] === "undefined") {
                    eventsFormatted[startDate] = [];
                }

                eventsFormatted[startDate].push(event);
            });

            return eventsFormatted;
        }
        function renderEvents(calendar, events) {
            var eventsGrouped = groupEventsByDate(events);
            for (var date in eventsGrouped) {
                if (!eventsGrouped.hasOwnProperty(date)) continue;
                renderEvent(eventsGrouped[date], date);
            }
        }
        
        function renderEvent(events, date) {
            var eventsHtml = [];

            for (var i in events){
                var event = events[i];

                eventsHtml.push(
                    '<a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable">' +
                    '<div class="fc-content">' +
                    '<span class="fc-time">' + event.startTime + '-' + event.endTime + '</span>' +
                    '<span class="fc-title">' + '  Приемов:' + event.title +'</span>' +
                    '</div>' +
                    '</a>'
                )
            }

            $('[data-date="' + date +'"].fc-widget-content').html(eventsHtml.join(''));
        }
        $.get(config.eventsUrl)
            .then(function (result) {
                if (result !== null && result.length) {

                    renderEvents(calendar, result);
                }
            });
        renderEditButtons();
    }
})(jQuery);