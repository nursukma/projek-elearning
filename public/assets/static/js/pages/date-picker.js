flatpickr('.flatpickr-no-config', {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
})
flatpickr('.flatpickr-always-open', {
    inline: false
})
flatpickr('.flatpickr-range', {
    dateFormat: "Y-m-d H:i:s",
    // dateFormat: "F j, Y",
    mode: 'range',
    enableTime: true,
    time_24hr: true,
    minDate: "today"
})
flatpickr('.flatpickr-range-preloaded', {
    dateFormat: "F j, Y",
    mode: 'range',
    defaultDate: ["2016-10-10T00:00:00Z", "2016-10-20T00:00:00Z"]
})
flatpickr('.flatpickr-time-picker-24h', {
    inline: false,
    enableTime: true,
    time_24hr: true,
    // noCalendar: true,
    dateFormat: "d-m-Y H:i",
    minDate: "today"
})