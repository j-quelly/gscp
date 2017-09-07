// dependencies
import React from 'react';

// components
import { Table, Row, Cell } from '../Tables';

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
  <Table>
    <Row>
      <Cell>
        Lorem
      </Cell>
      <Cell>
        Ipsum
      </Cell>
    </Row>
  </Table>
);
List.PropTypes = {

};
List.defaultProps = {

}

export default List;
