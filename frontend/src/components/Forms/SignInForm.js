import {Button, Col, Form, FormGroup, Input, InputGroup, InputGroupAddon, InputGroupText, Row} from "reactstrap";
import React from "react";
import camelcase from "camelcase";
import axios from 'axios';

class SignInForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            email: '',
            password: ''
        }
    }

    /**
     * Handle form submission.
     *
     * @param event
     */
    handleSubmit(event) {
        event.preventDefault();
        const validatedData = this.__validateForm(event);
        const axiosConfig = {
            headers: {
                'Content-Type': 'application/json',
                'Access-Control-Allow-Origin': '*'
            }
        };

        if (validatedData !== null) {

            axios.post(this.props.endpoint + '/auth/sign-in', validatedData, axiosConfig)
                .then(response => {
                    if (response.status === 201) {
                        localStorage.setItem('user', JSON.stringify(response.data.data));
                        localStorage.setItem('loggedIn', 'true');
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
        }

    }

    /**
     * Handle the change events for individual input fields.
     *
     * @param {object} event
     */
    handleInputChange(event) {
        const target = event.target;
        const name = camelcase(target.name);
        const group = camelcase(target.getAttribute('group'));
        this.setState({
            [name]: target.value,
            [group]: ''
        });
    }


    // noinspection DuplicatedCode @todo: this should be moved to utils later
    /**
     *  Validate the form, return the validated data if valid, null if not.
     *
     * @param {object} event
     * @return {{}|null}
     * @private
     */
    __validateForm(event) {
        let ele, groupName;
        let data = {};
        let validation = false;

        for (ele in event.target.elements) {
            if (
                event.target.elements.hasOwnProperty(ele) &&
                typeof event.target[ele] === 'object' &&
                event.target[ele].name !== '' &&
                event.target[ele].getAttribute('group') !== null
            ) {
                data[event.target[ele].name] = event.target[ele].value;

                groupName = camelcase(event.target[ele].getAttribute('group'));

                validation = this.__validateField(event.target[ele].name, event.target[ele].value, groupName);
            }
        }


        return validation === true ? data : null;
    }

    /**
     * Validate the form fields with the specified rules,
     * then set error state of their respective form groups when there are error encountered.
     *
     * @param {string} fieldName
     * @param {object} value
     * @param {string} group
     *
     * @return boolean
     *
     * @private
     */
    __validateField(fieldName, value, group) {

        let fieldValidationErrors = this.state.formErrors;
        let formValidation;

        switch (fieldName) {
            case 'email':
                fieldValidationErrors[group] = value.match(/^([\w.%+-]+)@([\w-]+\.)+([\w]{2,})$/i) ? '' : 'has-danger';
                formValidation = fieldValidationErrors[group] === '';
                break;

            case 'password':
                fieldValidationErrors[group] = value.length >= 8 ? '' : 'has-danger';
                formValidation = fieldValidationErrors[group] === '';
                break;

            default:
                break;
        }

        this.setState(
            {
                formErrors: fieldValidationErrors
            }
        );

        return formValidation;
    }
}

export default SignInForm;