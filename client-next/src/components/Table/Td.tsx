const Td = ({ name = '', children }) => (
  <td className="com-table-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 com-table-cell-{name}">
    <div className="com-table-col-wrp px-3 py-4">
      {children}
    </div>
  </td>
);

export default Td;
