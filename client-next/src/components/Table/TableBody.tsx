import Tr from './Tr';
import Td from './Td';
import Text from './Text';
import Checkboxes from './Checkboxes';
import ViewAction from './Actions/ViewAction';

function TableBody({ rows, columns }) {
  const rowRender = (row) => columns?.map((column, index) => {
    let tdContent = null;

    if ('render' in column) {
      let record = {};

      if (! ('data' in column)) {
        // No
      } else if (column.data instanceof Array) {
        column.data?.map((value, index2) => {
          record[value] = value in row ? row[value] : undefined;
        });
      } else {
        record = { [data]: column.data in row ? row[column.data] : undefined }
      }

      tdContent = column.render(column, record);
    } else if (column.data instanceof Array) {
      tdContent = column.data?.map((value, index2) => (<Text key={index2}>{ value in row ? row[value] : null }</Text>));
    } else {
      tdContent = column.data in row ? <Text>{ row[column.data] }</Text> : <Text />;
    }

    return (
      <Td name={column.name} key={index}>
        {tdContent}
      </Td>
    );
  });

  return (
    <tbody className="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
      {
        rows?.map(row => (
          <Tr key={row.id}>
            <Td name="checkboxes">
              <Checkboxes />
            </Td>

            <Td name="indexes">
              <Text>1</Text>
            </Td>

            { rowRender(row) }

            <Td name="actions">
              <ViewAction />
            </Td>
          </Tr>
        ))
      }
    </tbody>
  );
}

export default TableBody;
