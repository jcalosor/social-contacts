/*!

=========================================================
* Argon Design System React - v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-design-system-react
* Copyright 2020 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-design-system-react/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
import React from "react";
import {Link} from "react-router-dom";
// nodejs library that concatenates classes
import classnames from "classnames";

// reactstrap components
import {
    Button,
    Card,
    CardHeader,
    CardBody,
    FormGroup,
    Form,
    Input,
    InputGroupAddon,
    InputGroupText,
    InputGroup,
    Container,
    Row,
    Col
} from "reactstrap";


class SignIn extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            loaded: false
        }
    }

    componentDidMount() {
        document.documentElement.scrollTop = 0;
        document.scrollingElement.scrollTop = 0;
        this.setState({
            loaded: true
        });
    }

    render() {

        if (this.state.loaded === false) {
            return null;
        }

        return (
            <>
                <main ref="main">
                    <section className="section section-lg section-shaped">
                        <div className="shape shape-style-1 shape-default">
                            <span/>
                        </div>
                        <Container className="py-md">
                            <Row className="row-grid justify-content-between align-items-center">
                                <Col lg="6">
                                    <h3 className="display-3 text-white">
                                        Social Contact System{" "}
                                        <span className="text-white">One contact at a time</span>
                                    </h3>
                                    <p className="lead text-white">
                                        Your social contacts is one message away!
                                        Connecting with your contacts socially has never been this easy!
                                    </p>
                                </Col>
                                <Col className="mb-lg-auto" lg="5">
                                    <div className="transform-perspective-right">
                                        <Card className="bg-secondary shadow border-0">
                                            <CardHeader className="bg-white pb-1">
                                                <div className="text-center mb-3">
                                                    <h4>User Sign-in</h4>
                                                </div>

                                            </CardHeader>
                                            <CardBody className="px-lg-5 py-lg-5">

                                                <Form role="form">
                                                    <FormGroup
                                                        className={classnames("mb-3", {
                                                            focused: this.state.emailFocused
                                                        })}
                                                    >
                                                        <InputGroup className="input-group-alternative">
                                                            <InputGroupAddon addonType="prepend">
                                                                <InputGroupText>
                                                                    <i className="ni ni-email-83"/>
                                                                </InputGroupText>
                                                            </InputGroupAddon>
                                                            <Input
                                                                placeholder="Email"
                                                                type="email"
                                                                onFocus={e =>
                                                                    this.setState({emailFocused: true})
                                                                }
                                                                onBlur={e =>
                                                                    this.setState({emailFocused: false})
                                                                }
                                                            />
                                                        </InputGroup>
                                                    </FormGroup>
                                                    <FormGroup
                                                        className={classnames({
                                                            focused: this.state.passwordFocused
                                                        })}
                                                    >
                                                        <InputGroup className="input-group-alternative">
                                                            <InputGroupAddon addonType="prepend">
                                                                <InputGroupText>
                                                                    <i className="ni ni-lock-circle-open"/>
                                                                </InputGroupText>
                                                            </InputGroupAddon>
                                                            <Input
                                                                placeholder="Password"
                                                                type="password"
                                                                autoComplete="off"
                                                                onFocus={e =>
                                                                    this.setState({passwordFocused: true})
                                                                }
                                                                onBlur={e =>
                                                                    this.setState({passwordFocused: false})
                                                                }
                                                            />
                                                        </InputGroup>
                                                    </FormGroup>
                                                    <div
                                                        className="custom-control custom-control-alternative custom-checkbox">
                                                        <input
                                                            className="custom-control-input"
                                                            id="signIn"
                                                            type="checkbox"
                                                        />
                                                        <label
                                                            className="custom-control-label"
                                                            htmlFor="signIn"
                                                        >
                                                            <span>Remember me</span>
                                                        </label>
                                                    </div>
                                                    <div className="text-center">
                                                        <Button
                                                            className="my-4"
                                                            color="primary"
                                                            type="button"
                                                        >
                                                            Sign in
                                                        </Button>
                                                    </div>
                                                </Form>
                                                <div className="text-center text-muted mb-4">
                                                    <small>Don't have an account yet? <a href='/sign-up' tag={Link}>Sign
                                                        up instead</a></small>
                                                </div>

                                            </CardBody>
                                        </Card>
                                    </div>
                                </Col>
                            </Row>
                        </Container>
                        {/* SVG separator */}
                        <div className="separator separator-bottom separator-skew">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                preserveAspectRatio="none"
                                version="1.1"
                                viewBox="0 0 2560 100"
                                x="0"
                                y="0"
                            >
                                <polygon className="fill-white" points="2560 0 2560 100 0 100"/>
                            </svg>
                        </div>
                    </section>
                </main>
            </>
        );
    }
}

export default SignIn;
