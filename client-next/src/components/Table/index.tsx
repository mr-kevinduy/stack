import TableHeader from './TableHeader';
import TableBody from './TableBody';
import TableFooter from './TableFooter';

function Table({ data, columns }) {

  return (
    <div className="com-table overflow-hidden rounded-xl bg-white ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
      {/*<div className="com-table-header-ctn divide-y divide-gray-200 dark:divide-white/10">
      </div>

      <div className="com-table-header-selection-indicator flex flex-col justify-between gap-y-1 bg-gray-50 px-3 py-2 dark:bg-white/5 sm:flex-row sm:items-center sm:px-6 sm:py-1.5">
      </div>*/}

      <div className="com-table-content divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10">
        <table className="com-table-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
          <TableHeader columns={columns} />
          <TableBody rows={data} columns={columns} />
          <TableFooter />
        </table>
      </div>
    </div>
  );
}

export default Table;
