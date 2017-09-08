// dependencies
import React from 'react';
import { Link } from 'react-router-dom'

// styles
import './Sidebar.css';

/**
 * @description Sidebar component represents the application Sidebar
 *
 * @param {object} props - Component props
 *
 * @returns {<Sidebar />}
 */
const SidebarComponent = (props) => (
  <div className="col-sm-3 col-md-2 sidebar">
    <ul className="nav nav-sidebar">
      <li className="nav-sidebar__logo">game server rental</li>
      <li className="nav-sidebar__user">
        <span className="glyphicon glyphicon-user"></span>
        <strong>de__bug</strong>
        <span>jamie@kellyjg.com</span>
      </li>
      <li className="nav-sidebar__title">Navigation</li>
      <li className="active"><Link to="/"><i className="glyphicon glyphicon-home"></i> Dashboard <span className="sr-only">(current)</span></Link></li>
      <li><Link to="/users"><i className="glyphicon glyphicon-user"></i> Users</Link></li>
    </ul>
  </div>
);

export default SidebarComponent;