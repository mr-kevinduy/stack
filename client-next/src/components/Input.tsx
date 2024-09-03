const Input = ({ disabled = false, className, ...props }) => (
  <div className="mt-1 rounded-md shadow-sm">
    <input
      disabled={disabled}
      className={`${className} appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5`}
      {...props}
    />
  </div>
);

export default Input;
