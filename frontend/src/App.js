import React from 'react';
import './App.css';


function App() {
    return (
        <div className="App container-fluid">
            <div className="row align-content-center">
                <div className="col-sm">
                </div>
                <div className="col-lg">
                    <header className="App-header">
                        <h1>Social Contacts</h1>
                    </header>
                    <body className="text-center">
                        <button type="button" className="btn btn-light">Sign in</button>

                        <button type="button" className="btn btn-info">Sign up</button>
                    </body>
                </div>
                <div className="col-sm">
                </div>

            </div>
        </div>
    );
}

export default App;
