// dependencies
import React from 'react';
import { Link } from 'react-router-dom'
import classnames from 'classnames';

// styles
import './Header.css';

const HeaderComponent = (props) => {
  const { isLoggedOut } = props;

  return (
    <nav className={classnames('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 navbar navbar-fixed-top', { hide: isLoggedOut })}>
      <div className="container-fluid">
        <div className="navbar-header">
          <button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span className="sr-only">Toggle navigation</span>
            <span className="icon-bar"></span>
            <span className="icon-bar"></span>
            <span className="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" className="navbar-collapse collapse">
          <ul className="nav navbar-nav navbar-right">
            <li><Link to="/">Dashboard</Link></li>
            <li><Link to="/users">Users</Link></li>
            <li><Link to="/logout">Logout</Link></li>
          </ul>
        </div>
      </div>
    </nav>
  );
}

export default HeaderComponent;
