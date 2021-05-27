function eventTime(event) {
    if (!event.allDay) {
        let txt_start = event.start.toLocaleString({}, { timeStyle: "short" })
        let txt_end = event.end.toLocaleString({}, { timeStyle: "short" })
        return `${txt_start} - ${txt_end}`
    }
    return ""
}
function createTooltip(info) {
    let el = $(info.el)
    el.prop("title", info.event.title)
    let txt = `<p>${eventTime(info.event)}</p>`
    txt += `<b>${info.event.title}</b>`
    if (info.event.extendedProps.description !== null) {
        txt += `<hr><p>${info.event.extendedProps.description}</p>`
    }
    if (info.event.extendedProps.location !== null) {
        txt += `<p><i>${info.event.extendedProps.location}</i></p>`
    }

    el.data("powertip", txt)
    el.powerTip({
        smartPlacement: true
    });
}