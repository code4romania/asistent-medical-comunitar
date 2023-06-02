import.meta.glob([
    '../images/**'
]);

window.setEventContents = ({ event, timeText }) => {
    const html = `
        <div class="flex gap-2 justify-between items-center">
            <span class="fc-event-time">${timeText}</span>
            <span>Status</span>
        </div>

        <div class="fc-event-title text-ellipsis">
            ${event.extendedProps.description}
        </div>
    `;

    return { html };
};
