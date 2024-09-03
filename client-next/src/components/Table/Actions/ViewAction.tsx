'use client';

import { useState } from 'react';
import { EyeIcon } from '@heroicons/react/24/solid';
import { SpinIconSvg } from '@/components/svg';

const ViewAction = ({ children }) => {
  const [loading, setLoading] = useState(false);

  const handleClick = (event) => {
    setLoading(true);

    setTimeout(() => {
      setLoading(false);
    }, 1000);
  }

  return (
    <button
      className="com-dropdown-list-item flex w-full items-center gap-2 whitespace-nowrap rounded-md p-2 text-sm transition-colors duration-75 outline-none disabled:pointer-events-none disabled:opacity-70 com-color-gray com-dropdown-list-item-color-gray hover:bg-gray-50 focus-visible:bg-gray-50 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 com-ac-action com-ac-grouped-action"
      type="button"
      onClick={handleClick}
    >
      {
        ! loading
          ? <EyeIcon className="com-dropdown-list-item-icon h-5 w-5 text-gray-400 dark:text-gray-500" />
          : <SpinIconSvg className="animate-spin com-dropdown-list-item-icon h-5 w-5 text-gray-400 dark:text-gray-500" />
      }

      <span className="com-dropdown-list-item-label flex-1 truncate text-start text-gray-700 dark:text-gray-200">
        {children ?? 'View' }
      </span>
    </button>
  );
}

export default ViewAction;
