// dependencies
import React from 'react';

// styles
import './Tables.css';

const Table = (props) => (
  <table className="table">
    {props.children}
  </table>
);

const TableHead = (props) => (
  <thead>
    {props.children}
  </thead>
);

const TableBody = (props) => (
  <tbody>
    {props.children}
  </tbody>
);

const Row = (props) => (
  <tr className="table__row">
    {props.children}
  </tr>
);

const Cell = (props) => (
  <td className="table__cell">
    {props.children}
  </td>
);

export { Table, TableHead, TableBody, Row, Cell };