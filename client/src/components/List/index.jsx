// dependencies
import React from 'react';

// styles
import './List.css';

/**
 * @description List component represents a list (table) of data
 *
 * @param {object} props - Component props
 *
 * @returns {<List />}
 */
const List = (props) => (
  <div className="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 className="page-header">GSCP</h1>

    <div className="row placeholders">
      <div className="col-xs-6 col-sm-3 placeholder">
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" className="img-responsive" alt="Generic placeholder thumbnail" />
        <h4>Label</h4>
        <span className="text-muted">Something else</span>
      </div>
      <div className="col-xs-6 col-sm-3 placeholder">
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" className="img-responsive" alt="Generic placeholder thumbnail" />
        <h4>Label</h4>
        <span className="text-muted">Something else</span>
      </div>
      <div className="col-xs-6 col-sm-3 placeholder">
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" className="img-responsive" alt="Generic placeholder thumbnail" />
        <h4>Label</h4>
        <span className="text-muted">Something else</span>
      </div>
      <div className="col-xs-6 col-sm-3 placeholder">
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" className="img-responsive" alt="Generic placeholder thumbnail" />
        <h4>Label</h4>
        <span className="text-muted">Something else</span>
      </div>
    </div>

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
List.PropTypes = {

};
List.defaultProps = {

}

export default List;
