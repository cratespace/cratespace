import Errors from './Errors';

export default class Forms {
    /**
     * Create new form class instance.
     *
     * @param  {object} data
     */
    constructor(data) {
        this.originalData = JSON.parse(JSON.stringify(data));

        Object.assign(this, data);

        this.errors = new Errors();

        this.processing = false;

        this.submitted = false;
    }

    /**
     * Get data assigned to object.
     *
     * @return {object}
     */
    data() {
        return Object.keys(this.originalData).reduce((data, attribute) => {
            data[attribute] = this[attribute];

            return data;
        }, {});
    }

    /**
     * Make POST request to given endpoint with data assigned to object.
     *
     * @param  {string} endpoint
     * @return {object}
     */
    post(endpoint) {
        return this.submit(endpoint);
    }

    /**
     * Make PUT request to given endpoint with data assigned to object.
     *
     * @param  {string} endpoint
     * @return {object}
     */
    put(endpoint) {
        return this.submit(endpoint, 'put');
    }

    /**
     * Make DELETE request to given endpoint with data assigned to object.
     *
     * @param  {string} endpoint
     * @return {object}
     */
    delete(endpoint) {
        return this.submit(endpoint, 'delete');
    }

    /**
     * Make specified request type to given endpoint with data assigned to object.
     *
     * @param  {string} endpoint
     * @param  {string} requestType
     * @return {object}
     */
    submit(endpoint, requestType = 'post') {
        this.processing = true;

        const response = axios[requestType](endpoint, this.data())
            .catch(this.onFail.bind(this))
            .then(this.onSuccess.bind(this));

        setTimeout(() => {
            this.processing = false;
        }, 1000);

        return response;
    }

    /**
     * Set success status and return success response type.
     *
     * @param  {object} response
     * @return {object}
     */
    onSuccess(response) {
        this.successful = true;

        setTimeout(() => {
            this.successful = false;
        }, 3000);

        return response;
    }

    /**
     * Set failed status and return error response type.
     *
     * @param  {object} error
     * @return {object}
     */
    onFail(error) {
        this.errors.record(error.response.data.errors);

        this.successful = false;

        throw error;
    }

    /**
     * Reset object data record.
     */
    reset() {
        Object.assign(this, this.originalData);
    }

    error(field) {
        if (this.errors.has(field)) {
            return this.errors.get(field);
        }

        return null;
    }
}
