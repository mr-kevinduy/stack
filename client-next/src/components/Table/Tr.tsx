const Tr = ({ children }) => (
  <tr className="com-table-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75">
    {children}
  </tr>
);

export default Tr;
