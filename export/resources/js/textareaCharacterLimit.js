document.addEventListener('alpine:init', () => {
    Alpine.data('textareaCharacterLimit', (handle, maxLength) => ({
        content: null,
        maxLength: maxLength,
        init() {
            this.$watch(handle, (newValue) => {
                this.content = newValue || '';
            });
        },
        get contentLength() {
            if(!this.content) {
                return `0/${this.maxLength} characters`;
            }

            let length = this.content.length;

            return `${length}/${this.maxLength} characters`;
        },
        get contentLengthValid() {
            if(!this.content) {
                return true;
            }

            if(this.content.length <= this.maxLength) {
                return true;
            }

            return false;
        },
    }));
});
