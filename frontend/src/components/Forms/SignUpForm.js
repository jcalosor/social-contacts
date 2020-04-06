import {Button, Col, Form, FormGroup, Input, InputGroup, InputGroupAddon, InputGroupText, Row} from "reactstrap";
import React from "react";
import camelcase from "camelcase";
import axios from 'axios';


class SignUpForm extends React.Component {


    constructor(props) {
        super(props);

        this.state = {
            firstName: '',
            lastName: '',
            address: '',
            city: '',
            zip: '',
            country: '',
            phone: '',
            email: '',
            password: '',
            privacyPolicy: true,
            // Validation state
            formErrors: {
                nameGroup: '',
                addressGroup: '',
                locationGroup: '',
                phoneGroup: '',
                emailGroup: '',
                passwordGroup: ''
            },
            // Data composition
            requestData: {}
        };

        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
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

            axios.post(this.props.endpoint + '/auth/sign-up', validatedData, axiosConfig)
                .then(response => {
                    console.log(response);
                    if (response.status === 201) {
                        localStorage.setItem('userId', response.data.data.id);
                        localStorage.setItem('loggedIn', 'true');
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
        }

    }

    handleInputChange(event) {
        const target = event.target;
        const value = target.name === 'privacy_policy' ? target.checked : target.value;
        const name = camelcase(target.name);
        const group = camelcase(target.getAttribute('group'));
        this.setState({
            [name]: value,
            [group]: ''
        });

    }


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

            case 'phone':
                fieldValidationErrors[group] = value.match(/^\d{10}$/) ? '' : 'has-danger';
                formValidation = fieldValidationErrors[group] === '';
                break;

            default:
                fieldValidationErrors[group] = value.length >= 2 ? '' : 'has-danger';
                formValidation = fieldValidationErrors[group] === '';
                break;
        }

        this.setState(
            {
                formErrors: fieldValidationErrors
            }
        );

        return formValidation;
    }

    render() {
        return (
            <Form role="form" onSubmit={this.handleSubmit}
                  method="POST">
                <FormGroup>
                    <InputGroup className={this.state.formErrors.nameGroup + ' input-group-alternative mb-3'}>
                        <InputGroupAddon addonType="prepend">
                            <InputGroupText>
                                <i className="ni ni-hat-3"/>
                            </InputGroupText>
                        </InputGroupAddon>
                        <Input
                            group='name_group'
                            onChange={this.handleInputChange}
                            name="first_name"
                            value={this.state.firstName}
                            placeholder="First name"
                            type="text"
                        />
                        <Input
                            group='name_group'
                            onChange={this.handleInputChange}
                            name="last_name"
                            value={this.state.lastName}
                            placeholder="Last name"
                            type="text"
                        />
                    </InputGroup>
                    <InputGroup className={this.state.formErrors.addressGroup + ' input-group-alternative mb-3'}>
                        <InputGroupAddon addonType="prepend">
                            <InputGroupText>
                                <i className="ni ni-pin-3"/>
                            </InputGroupText>
                        </InputGroupAddon>
                        <Input
                            group={'address_group'}
                            onChange={this.handleInputChange}
                            name="address"
                            value={this.state.address}
                            placeholder="Blk, Floor, Unit, Street, Village"
                            type="text"
                        />
                    </InputGroup>
                </FormGroup>
                <FormGroup>
                    <InputGroup className={this.state.formErrors.locationGroup + ' input-group-alternative mb-3'}>
                        <InputGroupAddon addonType="prepend">
                            <InputGroupText>
                                <i className="ni ni-planet"/>
                            </InputGroupText>
                        </InputGroupAddon>
                        <Input
                            group='location_group'
                            onChange={this.handleInputChange}
                            value={this.state.city}
                            name="city"
                            placeholder="City"
                            type="text"
                        />
                        <Input
                            group='location_group'
                            onChange={this.handleInputChange}
                            value={this.state.zip}
                            name="zip"
                            placeholder="Zip"
                            type="text"
                        />
                        <Input
                            group='location_group'
                            onChange={this.handleInputChange}
                            value={this.state.country}
                            name="country"
                            placeholder="Country"
                            type="text"
                        />
                    </InputGroup>
                </FormGroup>
                <FormGroup>
                    <InputGroup className={this.state.formErrors.phoneGroup + ' input-group-alternative mb-3'}>
                        <InputGroupAddon addonType="prepend">
                            <InputGroupText>
                                <i className="ni ni-mobile-button"/>
                            </InputGroupText>
                        </InputGroupAddon>
                        <Input
                            group='phone_group'
                            onChange={this.handleInputChange}
                            value={this.state.phone}
                            name="phone"
                            placeholder="Phone number"
                            type="text"
                        />
                    </InputGroup>
                </FormGroup>
                <FormGroup>
                    <InputGroup className={this.state.formErrors.emailGroup + ' input-group-alternative mb-3'}>
                        <InputGroupAddon addonType="prepend">
                            <InputGroupText>
                                <i className="ni ni-email-83"/>
                            </InputGroupText>
                        </InputGroupAddon>
                        <Input
                            group='email_group'
                            onChange={this.handleInputChange}
                            value={this.state.email}
                            name="email"
                            placeholder="Email"
                            type="email"
                        />
                    </InputGroup>
                </FormGroup>
                <FormGroup>
                    <InputGroup className={this.state.formErrors.passwordGroup + ' input-group-alternative'}>
                        <InputGroupAddon addonType="prepend">
                            <InputGroupText>
                                <i className="ni ni-lock-circle-open"/>
                            </InputGroupText>
                        </InputGroupAddon>
                        <Input
                            group='password_group'
                            onChange={this.handleInputChange}
                            value={this.state.password}
                            name="password"
                            placeholder="Password"
                            type="password"
                            autoComplete="off"
                        />
                    </InputGroup>
                </FormGroup>
                <div className="text-muted font-italic">
                    <small>
                        password strength:{" "}
                        <span className="text-success font-weight-700">
                            strong
                        </span>
                    </small>
                </div>
                <Row className="my-4">
                    <Col xs="12">
                        <div className="custom-control custom-control-alternative custom-checkbox">
                            <input
                                onChange={this.handleInputChange}
                                checked={this.state.privacyPolicy}
                                className="custom-control-input"
                                name="privacy_policy"
                                type="checkbox"
                            />
                            <label className="custom-control-label" htmlFor="customCheckRegister">
                                <span>
                                I agree with the{" "}
                                    <a href="#" onClick={e => e.preventDefault()}>Privacy Policy</a>
                                </span>
                            </label>
                        </div>
                    </Col>
                </Row>
                <div className="text-center">
                    <Button className="mt-4" color="primary" type="submit">
                        Create account
                    </Button>
                </div>
            </Form>
        )
    }
}


export default SignUpForm;