document.addEventListener('alpine:init', () => {
    Alpine.data('passwordRules', () => ({
        password: '',
        passwordConfirmation: '',
        test(condition) {
            return  new RegExp(condition).test(this.password)
        }
    }));
});
