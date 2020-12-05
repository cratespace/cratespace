export default class Errors {
    /**
     * Create new form error handler instance.
     */
    constructor() {
        this.errors = {};
    }

    /**
     * Get error message of specified field.
     *
     * @param  {String} field
     * @return {String}
     */
    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    /**
     * Determine if the given field has error a message.
     *
     * @param  {String}  field
     * @return {Boolean}
     */
    has(field) {
        return Boolean(this.errors[field]);
    }

    /**
     * Save all error messages to instance.
     *
     * @param  {Object} errors
     */
    record(errors) {
        this.errors = errors;
    }
}
