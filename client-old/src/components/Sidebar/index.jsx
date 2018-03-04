import React from 'react';
import { Link } from 'react-router-dom';
import classnames from 'classnames';
import Proptypes from 'prop-types';

// styles
import './Sidebar.css';

/**
 * @description Sidebar component represents the application Sidebar
 *
 * @param {object} props - Component props
 * @param {boolean} isLoggedOut - user authentication status
 *
 * @returns {<Sidebar />}
 */
const SidebarComponent = (props) => {
  const { isLoggedOut } = props;

  return (
    <div className={classnames('col-sm-3', 'col-md-2', 'sidebar', { hide: isLoggedOut })}>
      <ul className="nav nav-sidebar">
        <li className="nav-sidebar__logo">gscp</li>
        <li className="nav-sidebar__user">
          <span className="glyphicon glyphicon-user" />
          <strong>de__bug</strong>
          <span>jamie@kellyjg.com</span>
        </li>
        <li className="nav-sidebar__title">Navigation</li>
        <li><Link to="/"><i className="glyphicon glyphicon-home" /> Dashboard</Link></li>
        <li><Link to="/users"><i className="glyphicon glyphicon-user" /> Users</Link></li>
      </ul>
    </div>
  );
};

SidebarComponent.propTypes = {
  isLoggedOut: Proptypes.bool,
};

SidebarComponent.defaultProps = {
  isLoggedOut: true,
};

export default SidebarComponent;
