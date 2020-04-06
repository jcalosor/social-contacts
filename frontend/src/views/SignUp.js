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

// reactstrap components
import {
    Card,
    CardHeader,
    CardBody,
    Container,
    Row,
    Col
} from "reactstrap";

// core components
import SignUpForm from "../components/Forms/SignUpForm";

class SignUp extends React.Component {

    componentDidMount() {
        document.documentElement.scrollTop = 0;
        document.scrollingElement.scrollTop = 0;
        this.refs.main.scrollTop = 0;
    }

    render() {
        return (
            <>
                <main ref="main">
                    <section className="section section-shaped section-lg">
                        <div className="shape shape-style-1 bg-gradient-default">
                            <span/>
                            <span/>
                            <span/>
                            <span/>
                            <span/>
                            <span/>
                            <span/>
                            <span/>
                        </div>
                        <Container className="pt-lg-12">
                            <Row className="justify-content-center">
                                <Col lg="6">
                                    <Card className="bg-secondary shadow border-0">
                                        <CardHeader className="bg-white pb-1">
                                            <div className="text-center mb-3">
                                                <h4>User Sign Up</h4>
                                                <span className="text-muted">
                                                  <small>Register social contacts account.</small>
                                                </span>
                                            </div>
                                        </CardHeader>
                                        <CardBody className="px-lg-5 py-lg-5">
                                            <SignUpForm endpoint={this.props.endpoint} />
                                        </CardBody>
                                    </Card>
                                </Col>
                            </Row>
                        </Container>
                    </section>
                </main>

            </>
        );
    }
}

export default SignUp;
