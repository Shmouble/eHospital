(function ($) {
    $.fn.fullCalendarExtension = function (options) {
        var calendar = $(this);
        var config = $.extend({}, {}, options);
        var currentDate = new Date();
        var isRoot = false;
        var afterTomorrowDate = new Date(currentDate);
            afterTomorrowDate.setDate(afterTomorrowDate.getDate() + 2);
            afterTomorrowDate.setHours(0, 0, 0, 0);
        
        if (!config.eventsUrl) {
            console.log('add url with events json');
            return;
        }

        
        

        function renderEditButtons() {
            var calendarDays = calendar.find('.fc-bg tbody td.fc-widget-content');
           
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
        
        function renderFreeTickets(result) {
            var calendarDays = calendar.find('.fc-bg tbody td.fc-widget-content');

            $.each(calendarDays, function (key, event) {
                var cellDate = $(event).data('date');

                if (result.hasOwnProperty(cellDate)) {
                    
                    $('[data-date="' + cellDate +'"].fc-widget-content').html(
                        
                        '<a data-id=' + result[cellDate].id +' class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable freeTick" data-toggle="modal" data-target="#freeTickModal">' +
                        '<div class="fc-content">' +
                        '<span class="fc-time">' + result[cellDate].number + '</span>' +
                        '<span class="fc-title">' + ' свободных талонов' + '</span>' +
                        '</div>' +
                        '</a>'
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
            var eventDate = new Date(date);
            for (var i in events){
                var event = events[i];
                if (eventDate < afterTomorrowDate){
                   eventsHtml.push(
                        '<a id="' + event.id + '" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable disabled">' +
                        '<div class="fc-content">' +
                        '<span class="fc-time">' + event.startTime + '-' + event.endTime + '</span>' +
                        '<span class="fc-title">' + '  Приемов:' + event.title +'</span>' +
                        '</div>' +
                        '</a>'
                    )
                } else {
                    eventsHtml.push(
                        '<a id="' + event.id + '" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" data-toggle="modal" data-target="#addEventModal">' +
                        '<div class="fc-content">' +
                        '<span class="fc-time">' + event.startTime + '-' + event.endTime + '</span>' +
                        '<span class="fc-title">' + '  Приемов:' + event.title +'</span>' +
                        '</div>' +
                        '</a>'
                    )
                }
            }

            $('[data-date="' + date +'"].fc-widget-content').html(eventsHtml.join(''));
        }
        
            $.get(config.eventsUrl)
            .then(function (result) {
                renderFreeTickets(result);
                if (result !== null && result.length) {
//                    if(isRoot){
//                        renderEvents(calendar, result);
//                    } else {
                        
//                    }
                }
            });

        if(isRoot){
            renderEditButtons();
        }

        $(document).on('click','.fc-button', function () {
            if(isRoot){
                renderEditButtons();
            }
        })

    }
})(jQuery);
