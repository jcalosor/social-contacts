import React from 'react';
import ReactDOM from 'react-dom';
import {Route, BrowserRouter as Router, Switch} from 'react-router-dom';

import './assets/vendor/nucleo/css/nucleo.css';
import './assets/vendor/font-awesome/css/font-awesome.min.css';
import './assets/css/argon-design-system-react.min.css';
import './index.css';

import SignIn from "./views/SignIn";
import SignUp from "./views/SignUp";

import * as serviceWorker from './serviceWorker';
import NavigationBar from "./components/Navbars/NavigationBar";
import Footer from "./components/Footers/Footer";

const endpoint = 'http://localhost:8080/api/v1';
const loggedIn = 'true' === localStorage.getItem('loggedIn');

const routes = (
    <Router>
        <NavigationBar loggedIn={loggedIn}/>
        <Switch>
            <Route path="/" exact render={(props) => <SignIn {...props} endpoint={endpoint} loggedIn={loggedIn}/>}/>
            <Route
                path="/sign-up"
                exact
                render={(props) => <SignUp {...props} endpoint={endpoint} loggedIn={loggedIn}/>}
            />
        </Switch>
        <Footer/>
    </Router>
);

ReactDOM.render(routes, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
