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
/*eslint-disable*/
import React from "react";
// reactstrap components
import {
    Button,
    NavItem,
    NavLink,
    Nav,
    Container,
    Row,
    Col,
    UncontrolledTooltip
} from "reactstrap";

class Footer extends React.Component {
    render() {
        return (
            <>
                <footer className="footer">
                    <Container>
                        <Row className=" row-grid align-items-center mb-5">
                            <Col lg="8">
                                <h3 className=" text-primary font-weight-light mb-2">
                                    A case study for ReactJS + Lumen
                                </h3>
                                <p>
                                    Lol this is not production ready,
                                    so a friendly advice, don't use it in production! ;P
                                </p>
                            </Col>
                            <Col className="text-lg-right btn-wrapper" lg="4">
                                <Button
                                    className="btn-icon-only rounded-circle ml-1"
                                    color="github"
                                    href="https://github.com/jcalosor/social-contacts"
                                    id="tooltip495507257"
                                    target="_blank"
                                >
                  <span className="btn-inner--icon">
                    <i className="fa fa-github"/>
                  </span>
                                </Button>
                                <UncontrolledTooltip delay={0} target="tooltip495507257">
                                    Star on Github
                                </UncontrolledTooltip>
                            </Col>
                        </Row>
                        <hr/>
                        <Row className=" align-items-center justify-content-md-between">
                            <Col md="6">
                                <div className=" copyright">
                                    Theme by: &nbsp;
                                    <a
                                        href="https://www.creative-tim.com?ref=adsr-footer"
                                        target="_blank"
                                    >
                                        Creative Tim
                                    </a>
                                    .
                                </div>
                            </Col>
                            <Col md="6">

                            </Col>
                        </Row>
                    </Container>
                </footer>
            </>
        );
    }
}

export default Footer;
