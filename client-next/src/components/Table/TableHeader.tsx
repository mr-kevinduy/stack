import Th from './Th';
import Checkboxes from './Checkboxes';

function TableHeader({ columns }) {
  return (
    <thead className="divide-y divide-gray-200 dark:divide-white/5">
      <tr className="bg-gray-50 dark:bg-white/5">
        <Th name="checkboxes" isFirst={true}>
          <Checkboxes />
        </Th>
        <Th name="indexes" />
        {
          columns?.map((column, index) => (
            <Th name={column.name} sortable={column?.sortable} key={index}>{column.label}</Th>
          ))
        }
        <Th className="w-1" />
      </tr>
    </thead>
  );
}

export default TableHeader;
