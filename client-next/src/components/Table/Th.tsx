import { ChevronDownIcon } from '@heroicons/react/20/solid';

const Th = ({ name = '', isFirst = false, sortable = false, children }) => {
  return (
    <th className="com-table-header-cell com-table-header-cell-{name} {
      isFirst
        ? 'p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1'
        : 'px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6'
    }">
      {
        sortable
          ? (<button
              aria-label="Sort by Ascending"
              type="button"
              className="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start"
            >
              <span className="com-table-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">
                {children}
              </span>

              <ChevronDownIcon className="com-table-header-cell-sort-icon h-5 w-5 shrink-0 transition duration-75 text-gray-400 dark:text-gray-500 group-hover:text-gray-500 group-focus-visible:text-gray-500 dark:group-hover:text-gray-400 dark:group-focus-visible:text-gray-400" />
            </button>)
          : (
            <span className="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">
              <span className="com-table-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">{children}</span>
            </span>
          )
      }
    </th>
  );
}

export default Th;
