const Label = ({ className, children, ...props }) => (
  <label
    className={`${className} block text-sm font-medium text-gray-700 leading-5`}
    {...props}>
    {children}
  </label>
);

export default Label;
