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
import {Badge, Container, Row, Col} from "reactstrap";


class Forbidden extends React.Component {
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
                    <section className="section section-lg bg-gradient-default">
                        <Container>
                            <Row className="row-grid align-items-center">
                                <Col className="order-md-2" md="6">
                                    <img
                                        alt="..."
                                        className="img-fluid floating"
                                        src={require("../assets/img/theme/promo-1.png")}
                                    />
                                </Col>

                                <Col className="order-md-1 text-white" md="6">
                                    <div className="pr-md-5">
                                        <h1 className="float-left text-white mr-2"><b>Access Forbidden</b></h1>
                                        <div
                                            className="icon icon-lg icon-shape icon-shape-danger shadow rounded-circle mb-5 float-left">
                                            <i className="ni ni-ambulance"/>
                                        </div>
                                        <p>
                                            There could be gazillion reasons why your seeing this page,
                                            but we can give you a few ides ;)
                                        </p>
                                        <ul className="list-unstyled mt-5">
                                            <li className="py-2">
                                                <div className="d-flex align-items-center">
                                                    <div>
                                                        <Badge
                                                            className="badge-circle mr-3"
                                                            color="danger"
                                                        >
                                                            <i className="ni ni-html5"/>
                                                        </Badge>
                                                    </div>
                                                    <div>
                                                        <h6 className="mb-0 text-white">The page doesn't exists.</h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li className="py-2">
                                                <div className="d-flex align-items-center">
                                                    <div>
                                                        <Badge
                                                            className="badge-circle mr-3"
                                                            color="danger"
                                                        >
                                                            <i className="ni ni-settings-gear-65"/>
                                                        </Badge>
                                                    </div>
                                                    <div>
                                                        <h6 className="mb-0 text-white">
                                                            You might not have access privilege.
                                                        </h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li className="py-2">
                                                <div className="d-flex align-items-center">
                                                    <div>
                                                        <Badge
                                                            className="badge-circle mr-3"
                                                            color="danger"
                                                        >
                                                            <i className="ni ni-satisfied"/>
                                                        </Badge>
                                                    </div>
                                                    <div>
                                                        <h6 className="mb-0 text-white">
                                                            It might be just a simple user error.
                                                        </h6>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </Col>

                            </Row>
                        </Container>
                    </section>

                </main>
            </>
        );
    }
}

export default Forbidden;
