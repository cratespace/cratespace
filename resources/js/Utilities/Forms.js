import Errors from './Errors';
import axios from 'axios';

export default class Forms {
    /**
     * Create new form class instance.
     *
     * @param  {Object} data
     */
    constructor(data) {
        this.originalData = JSON.parse(JSON.stringify(data));
        Object.assign(this, data);

        this.errors = new Errors();
        this.processing = false;
        this.successful = false;
        this.submitted = false;
    }

    /**
     * Get data assigned to object.
     *
     * @return {Object}
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
     * @param  {String} endpoint
     * @return {Object}
     */
    post(endpoint) {
        return this.submit(endpoint);
    }

    /**
     * Make PUT request to given endpoint with data assigned to object.
     *
     * @param  {String} endpoint
     * @return {Object}
     */
    put(endpoint) {
        return this.submit(endpoint, 'put');
    }

    /**
     * Make DELETE request to given endpoint with data assigned to object.
     *
     * @param  {String} endpoint
     * @return {Object}
     */
    delete(endpoint) {
        return this.submit(endpoint, 'delete');
    }

    /**
     * Make specified request type to given endpoint with data assigned to object.
     *
     * @param  {String} endpoint
     * @param  {String} requestType
     * @return {Object}
     */
    submit(endpoint, requestType = 'post') {
        this.processing = true;

        const response = this.makeRequest(endpoint, requestType)
            .catch(this.onFail.bind(this))
            .then(this.onSuccess.bind(this));

        this.processing = false;

        return response;
    }

    /**
     * Create request object and point to end point.
     *
     * @param  {String} endpoint
     * @param  {String} requestType
     * @return {Object}
     */
    makeRequest(endpoint, requestType = 'post') {
        if (requestType == 'delete') {
            return axios[requestType](endpoint, { data: this.data() });
        }

        return axios[requestType](endpoint, this.data());
    }

    /**
     * Set success status and return success response type.
     *
     * @param  {Object} response
     * @return {Object}
     */
    onSuccess(response) {
        if (! this.errors.any()) {
            this.successful = true;

            setTimeout(() => {
                this.successful = false;
            }, 3000);
        }

        return response;
    }

    /**
     * Set failed status and return error response type.
     *
     * @param  {Object} error
     * @return {Object}
     */
    onFail(error) {
        this.errors.record(error.response.data.errors);

        this.successful = false;
    }

    /**
     * Reset object data record.
     */
    reset() {
        Object.assign(this, this.originalData);
    }

    /**
     * Get error message of given form field.
     *
     * @param  {String} field
     * @return {String|null}
     */
    error(field) {
        if (this.errors.has(field)) {
            return this.errors.get(field);
        }

        return null;
    }

    /**
     * Clear given form field.
     *
     * @param  {String} field
     */
    clear(field) {
        this.errors.clear(field);
    }
}
