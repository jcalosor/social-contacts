import React from 'react';
import ReactDOM from 'react-dom';
import {Route, BrowserRouter as Router, Switch, Redirect} from 'react-router-dom';

import './assets/vendor/nucleo/css/nucleo.css';
import './assets/vendor/font-awesome/css/font-awesome.min.css';
import './assets/css/argon-design-system-react.min.css';
import './index.css';

import SignIn from "./views/SignIn";
import SignUp from "./views/SignUp";

import * as serviceWorker from './serviceWorker';
import NavigationBar from "./components/Navbars/NavigationBar";
import Footer from "./components/Footers/Footer";
import Profile from "./views/Profile";
import Forbidden from "./views/Forbidden";

const endpoint = 'http://localhost:8080/api/v1';
const loggedIn = 'true' === localStorage.getItem('loggedIn');
const user = localStorage.getItem('user') ?? null;
const axiosConfig = {
    headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
    }
};

const routes = (
    <Router>
        <NavigationBar loggedIn={loggedIn}/>
        <Switch>
            <Route
                path="/"
                exact
                render={(props) => (
                    loggedIn === true ?
                        <Redirect to={"/profile"}/> :
                        <SignIn {...props} axiosConfig={axiosConfig} endpoint={endpoint} loggedIn={loggedIn}/>)
                }
            />
            <Route
                path="/sign-up"
                exact
                render={(props) => (
                    loggedIn === true ?
                        <Redirect to={"/profile"}/> :
                        <SignUp {...props} axiosConfig={axiosConfig} endpoint={endpoint} loggedIn={loggedIn}/>)
                }
            />
            <Route
                path="/profile"
                exact
                render={(props) => (
                    loggedIn === true ?
                        <Profile {...props} user={user} endpoint={endpoint} loggedIn={loggedIn}/> :
                        <Redirect to={"/forbidden"}/>)
                }
            />
            <Route path="/forbidden" component={Forbidden}/>
        </Switch>
        <Footer/>
    </Router>
);

ReactDOM.render(routes, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
