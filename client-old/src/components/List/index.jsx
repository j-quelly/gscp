// dependencies
import React from 'react';

// styles
import './List.css';

/**
 * @description List component represents a list (table) of data
 *
 * @returns {<List />}
 */
const List = () => (
  <div className="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 className="page-header">Users</h1>

    <h2 className="sub-header">Section title</h2>
    <div className="table-responsive">
      <table className="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Header</th>
            <th>Header</th>
            <th>Header</th>
            <th>Header</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1,006</td>
            <td>nibh</td>
            <td>elementum</td>
            <td>imperdiet</td>
            <td>Duis</td>
          </tr>
          <tr>
            <td>1,007</td>
            <td>sagittis</td>
            <td>ipsum</td>
            <td>Praesent</td>
            <td>mauris</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
);

export default List;
