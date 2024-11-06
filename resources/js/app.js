import.meta.glob([
    '../images/**',
    '../svg/**',
]);

window.setEventContents = ({ event, timeText }) => {
    const html = `
        <div class="flex gap-2 justify-between items-center">
            <span class="fc-event-time font-bold">${timeText}</span>
        </div>

        <div class="fc-event-title text-ellipsis whitespace-nowrap">
            ${event.extendedProps.description}
        </div>
    `;

    return { html };
};

