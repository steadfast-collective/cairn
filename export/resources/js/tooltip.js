import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css'; // optional for styling

document.addEventListener('alpine:init', () => {
    Alpine.data('tooltip', (content) => ({
        tooltip: null,
        tooltipOpen: false,
        init() {
            this.tooltip = tippy(this.$refs.trigger, {
                trigger: 'manual',
                content: content,
                theme: 'cairn',
                placement: 'top-start',
                offset: [-12, 8]
            })
        },
        openTooltip() {
            this.tooltip.show()
            this.tooltipOpen = true
        },

        closeTooltip() {
            this.tooltip.hide()
            this.tooltipOpen = false
        }
    }))
})
