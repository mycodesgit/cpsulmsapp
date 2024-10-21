$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {
            var defaultStartTime = moment('08:00:00', 'HH:mm:ss');
            var defaultEndTime = moment('17:00:00', 'HH:mm:ss');

            start.set({
                'hour': defaultStartTime.hour(),
                'minute': defaultStartTime.minute(),
                'second': defaultStartTime.second()
            });

            end.set({
                'hour': defaultEndTime.hour(),
                'minute': defaultEndTime.minute(),
                'second': defaultEndTime.second()
            });

            var adjustedEndDate = moment(end).subtract(1, 'day');

            $('#eventTitle').val('');
            $('#eventStartTime').val(start.format('YYYY-MM-DD HH:mm:ss'));
            $('#eventEndTime').val(adjustedEndDate.format('YYYY-MM-DD HH:mm:ss'));
            $('#eventModal').modal('show');
        },
        events: {
            //url: ,
            method: 'GET', 
            textColor: '#fff'
        },
        themeSystem: 'bootstrap',
        selectable: false,
        selectHelper: true,
        navLinks: false,
        displayEventTime: true,
        editable: true,
        eventClick: function(calEvent, jsEvent, view) {
            var startTime = calEvent.start.format('h:mm A');
            var endTime = calEvent.end.format('h:mm A');

            Swal.fire({
                title: calEvent.title,
                html: `
                    Start from: ${moment(calEvent.start).format("MMM. D, YYYY, h:mm a")}<br>
                    Ends on: ${moment(calEvent.end).format("MMM. D, YYYY, h:mm a")}`,
                icon: "success",
                confirmButtonText: "OK",
            });
        },
    });
});

$(document).ready(function() {
    $('.external-event').hover(
        function() {
            $(this).find('.fas.fa-pen').css('display', 'inline');
        },
        function() {
            $(this).find('.fas.fa-pen').css('display', 'none');
        }
    );
});

